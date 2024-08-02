<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $messages = Message::where('sender_id', $user->ownerId)
            ->orWhere('receiver_id', $user->ownerId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,ownerId',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => $request->user()->ownerId,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json($message, 201);
    }

    public function chatList(Request $request)
    {
        $userId = $request->user()->ownerId;

        $chats = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->get()
            ->groupBy(function ($message) use ($userId) {
                return $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
            });

        $chatList = $chats->map(function ($messages, $chatUserId) {
            return [
                'user_id' => $chatUserId,
                'last_message' => $messages->last()->message,
                'last_message_time' => $messages->last()->created_at,
            ];
        })->values();

        return response()->json($chatList);
    }
}
