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
use Illuminate\Support\Facades\Validator;


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

        // Get all messages involving the current user
        $allMessages = Message::where('sender_id', $userId)
                            ->orWhere('receiver_id', $userId)
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Group messages by the other participant
        $conversations = $allMessages->groupBy(function ($message) use ($userId) {
            return $message->sender_id == $userId ? $message->receiver_id : $message->sender_id;
        });

        // Get the most recent message from each conversation
        $latestMessages = $conversations->map(function ($group) {
            return $group->first();
        });

        $unreadCount = Message::where('receiver_id', $userId)->where('is_read', false)->count();

        // Load relationships and construct sender_name for the view
        $latestMessages->load('sender', 'receiver');
        foreach ($latestMessages as $message) {
            if ($message->sender_id == $userId) {
                $otherUser = $message->receiver;
                $message->body = 'You: ' . $message->body;
            } else {
                $otherUser = $message->sender;
            }
            $message->sender_name = $otherUser->first_name . ' ' . $otherUser->last_name;
        }

        return view('messages.index', [
            'messages' => $latestMessages, 
            'unreadCount' => $unreadCount
        ]);
    }

    public function reply(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'reply_body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $originalMessage = Message::findOrFail($id);

        $reply = new Message();
        $reply->sender_id = auth()->id();
        $reply->receiver_id = $originalMessage->sender_id;
        $reply->body = $request->input('reply_body');
        $reply->subject = 'Re: ' . $originalMessage->subject;
        $reply->email_address = auth()->user()->email;
        $reply->timeline = $originalMessage->timeline;
        $reply->save();

        return response()->json($reply);
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
        $message = Message::findOrFail($id);

        $user1 = $message->sender_id;
        $user2 = $message->receiver_id;

        $messages = Message::where(function ($query) use ($user1, $user2) {
            $query->where('sender_id', $user1)
                  ->where('receiver_id', $user2);
        })->orWhere(function ($query) use ($user1, $user2) {
            $query->where('sender_id', $user2)
                  ->where('receiver_id', $user1);
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }
}