<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();


        $chats = Chat::with([
            'messages' => function ($q) {
                $q->latest()->limit(1);
            },
            'order:id,amount,payment_status'
        ])
            ->whereHas('order', function ($q) use ($user) {
                $q->where('client_id', $user->id)
                    ->orWhere('freelance_id', $user->id);
            })
            ->latest()
            ->get();

        if ($chats->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No chats found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'count' => $chats->count(),
            'chats' => $chats,
        ], 200);
    }

    public function show($id)
    {

        $chat = Chat::with('messages')->findOrFail($id);

        $userId = Auth::id();


        if ($chat->order->client_id !== $userId && $chat->order->freelance_id !== $userId && Auth::user()->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to view this chat',
            ], 403);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Chat retrieved successfully',
            'data' => [
                'chat_id' => $chat->id,
                'order_id' => $chat->order_id,
                'messages' => $chat->messages->map(function ($msg) {
                    return [
                        'id' => $msg->id,
                        'message' => $msg->message,
                        'file_path' => $msg->file_path,
                        'sender_id' => $msg->sender_id,
                        'created_at' => $msg->created_at,
                    ];
                }),
            ],
        ], 200);
    }

    public function store(Request $request, $chatId)
    {
        $user = Auth::user();


        $chat = Chat::with('order')->findOrFail($chatId);


        if ($chat->order->client_id !== $user->id && $chat->order->freelance_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to send messages in this chat',
            ], 403);
        }


        $validator = Validator::make($request->all(), [
            'message' => 'nullable|string',
            'file' => 'nullable|file|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => $validator->errors(),
            ], 422);
        }


        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads/chat_files', 'public');
        }


        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'message' => $request->message,
            'file_path' => $filePath,
        ]);


        return response()->json([
            'status' => 'success',
            'message' => 'Message sent successfully',
            'data' => [
                'id' => $message->id,
                'message' => $message->message,
                'file_path' => $message->file_path,
                'sender_id' => $message->sender_id,
                'created_at' => $message->created_at,
            ],
        ], 201);
    }
}
