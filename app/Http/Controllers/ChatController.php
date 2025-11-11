<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    //
    public function show($id)
    {
        $order = Order::with('chat.messages.sender')->findOrFail($id);

        if ($order->client_id !== Auth::id() && $order->service->freelance_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }


        if ($order->payment_status !== 'paid') {
            return redirect()->route('orders.index')->with('error', '🚫 لا يمكنك فتح الدردشة قبل إتمام الدفع.');
        }

        $chat = Chat::firstOrCreate(['order_id' => $order->id]);
        $messages = $chat->messages()->with('sender')->get();
        return view('chats.show', compact('order', 'chat', 'messages'));
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'nullable|string',
            'file' => 'file|nullable',
        ]);

        $chat = Chat::findOrFail($id);


        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
        }

        if (!$request->message && !$request->hasFile('file')) {
            return response()->json(['error' => 'You must type a message or attach a file.'], 422);
        }

        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'file_path' => $filePath,
        ]);

        
        $message->load('sender');

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'id' => $message->id,
            'sender' => [
                'id' => $message->sender->id,
                'name' => $message->sender->name,
            ],
            'message' => $message->message,
            'file_path' => $message->file_path,
            'created_at' => $message->created_at->diffForHumans(),
        ]);
    }
}
