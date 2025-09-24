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
            'email_address' => 'email',
            'timeline' => 'required',
            'message' => 'required|min:5',
            'phone_number' => 'required:phone',
            'receiver_id' => 'required|exists:users,id',
            'service_interest' => 'nullable|string',
            'budget_range' => 'nullable|string',
            'has_voice_memo' => 'nullable|boolean',
            'voice_memo' => 'nullable|file|mimes:webm,ogg,mp3,wav|max:10240', // 10MB max
        ]);

        $voiceMemoPath = null;
        
        // Handle voice memo upload if present
        if ($request->hasFile('voice_memo')) {
            try {
                $file = $request->file('voice_memo');
                $filename = 'voice_memo_' . time() . '_' . auth()->id() . '.webm';
                $voiceMemoPath = $file->storeAs('voice-memos', $filename, 'public');
            } catch (\Exception $e) {
                \Log::error('Voice memo upload failed: ' . $e->getMessage());
                // Continue without voice memo rather than failing entirely
            }
        }
        
        $message = new Message();
        $message->sender_id = auth()->id();
        $message->receiver_id = $validated['receiver_id'];
        $message->body = $validated['message'];
        $message->subject = 'New contact inquiry'; // You might want to make this dynamic
        $message->voice_memo_path = $voiceMemoPath;
        
        // Store additional contact form data as JSON or separate fields
        $message->email_address = $validated['email_address'];
        $message->timeline = $validated['timeline'];
        $message->phone_number = $validated['phone_number'] ?? null;
        $message->service_interest = $validated['service_interest'];
        $message->budget_range = $validated['budget_range'];

        
        $message->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully!'
            ]);
        }

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
