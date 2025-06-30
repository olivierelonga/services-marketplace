<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $unreadCount = Message::where('receiver_id', $user->id)->where('is_read', false)->count();

        return view('dashboard.index', compact('user', 'unreadCount'));
    }
}
