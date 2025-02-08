<?php

namespace App\Http\Controllers\Frontend;


use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;
use App\Models\Chat;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    function SendMessage(Request $request) {
        $request->validate([
            'message' => ['required', 'max:1000'],
            'receiver_id' => ['required','integer']
        ]);

        $chat = new Chat();
        $chat->sender_id = auth()->user()->id;
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->message;
        $chat->save();

    

        

        return response(['status'=>'success']);
        
    }

   // Controller update
public function GetConversation(string $senderId)
{
    $adminId = Auth::guard('admin')->id(); // Admin ID
    $receiverId = auth()->user()->id;

    // Fetch the admin's photo from the Admin model
    $admin = Admin::find($adminId);
    $adminPhoto = asset('upload/admin_images/' . $admin->photo);

    // Fetch all messages between the sender and the admin
    $messages = Chat::with(['sender', 'receiver'])
        ->where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                ->where('receiver_id', $receiverId);
        })
        ->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', $senderId);
        })
        ->orderBy('created_at', 'asc')
        ->get();

    // Return messages and admin ID
    return response()->json([
        'messages' => $messages,
        'adminId' => $adminId,   // Use the correct adminId
        'adminPhoto' => $adminPhoto // Admin's photo path
    ]);
}



    
}
