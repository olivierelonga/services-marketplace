<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Message;
use Illuminate\Support\Facades\Mail;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;


class MessageController extends Controller
{
    //
    protected $userId;

    public function __construct()
    {
        if (Auth::guest()) {
            redirect()->route('login')->send();
        }
        $this->userId = Auth::user()->id;
    }

    public function index(Request $request)
    {
        $userId = auth()->id();
        $perPage = 10;
        $page = $request->get('page', 1);
        // $offset = ($page - 1) * $perPage;   
        $userId = auth()->id();

        $sql = <<<SQL
            SELECT 
                m.id,
                m.body, 
                CONCAT(u.first_name, ' ', u.last_name) AS sender_name, 
                u.email,
                u.phone,
                u.is_premium,
                m.created_at,
                m.subject
            FROM messages m
            INNER JOIN users u ON m.sender_id = u.id
            WHERE m.receiver_id = ?
            ORDER BY m.created_at DESC
    SQL;

        $messages = DB::select($sql, [$userId]);

        // Get total count
        $total = DB::table('messages')->where('receiver_id', $userId)->count();

        // Create paginator
        $paginator = new LengthAwarePaginator(
            $messages,
            $total,
            $perPage,
            $page,
            ['path' => url()->current()]
        );

        $unreadCount = Message::where('receiver_id', $userId)->where('is_read', false)->count();

        return view('messages.index', ['messages' => $paginator, 'unreadCount' => $unreadCount]);
    }

    public function reply($id)
    {
        #get full_name and from users table where id sender_id = $ 
        $message = Message::findOrFail($id);

        if (!$message->is_read) {
            $message->is_read = true;
            $message->save();
        }

        return view('messages.reply', compact('message'));
    }

    public function sendReply(Request $request, $id)
    {
        $request->validate([
            'reply_body' => 'required|string',
        ]);

        $original = Message::findOrFail($id);

        // Send mail
        Mail::raw($request->reply_body, function ($mail) use ($original) {
            $mail->to($original->email)
                ->subject('Re: Your message to us');
        });

        return redirect()->route('messages.index')->with('success', 'Reply sent successfully.');
    }

    public function store(Request $request, User $user)
    {
        // Validate incoming request
        $validated = $request->validate([
            'contact_method' => 'required|in:email,phone',
            'timeline' => 'required',
            'message' => 'required|min:5',
            'phone_number' => 'required_if:contact_method,phone',
            'receiver_id' => 'required|exists:users,id',
            'voice_memo_path' => 'nullable|string',
            'transcript' => 'nullable|string',
        ]);
        
        $message = new Message();
        $message->sender_id = auth()->id();
        $message->receiver_id = $validated['receiver_id'];
        $message->contact_method = $validated['contact_method'];
        $message->timeline = $validated['timeline'];
        $message->body = $validated['message'];
        $message->phone_number = $validated['phone_number'] ?? null;
        $message->voice_memo_path = $validated['voice_memo_path'] ?? null;
        $message->transcript = $validated['transcript'] ?? null;
        $message->save();

        return redirect()->back()->with('success', 'Your message has been sent successfully! ' . $user->first_name . ' will get back to you soon.');
    }

    public function uploadVoiceMemo(Request $request)
    {
        $request->validate([
            'voice_memo' => 'required|mimes:ogg,mp3,wav',
        ]);

        $path = $request->file('voice_memo')->store('voice-memos', 'public');

        return response()->json(['path' => $path]);
    }

    public function show($id)
    {
        $messages = Message::where('id', $id)->orWhere('sender_id', $id)->orWhere('receiver_id', $id)->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }
}
