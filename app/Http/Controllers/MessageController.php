<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Message;
use Illuminate\Support\Facades\Mail;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;


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
}
