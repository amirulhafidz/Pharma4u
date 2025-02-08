<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;
use App\Models\Chat;
use Illuminate\Support\Facades\DB;


class AdminChatController extends Controller
{
    public function ChatIndex()
    {
        $adminId = Auth::guard('admin')->id(); // Admin ID

        // Get all distinct sender_id and receiver_id from chats
        $latestChats = DB::table('chats')
            ->selectRaw('MAX(created_at) as last_chat_at, sender_id')
            ->groupBy('sender_id')
            ->union(
                DB::table('chats')
                    ->selectRaw('MAX(created_at) as last_chat_at, receiver_id as sender_id')
                    ->groupBy('receiver_id')
            )
            ->distinct();

        // Get users who have chats and join them with the most recent chat info
        
        $chatUsers = User::whereIn('id', function ($query) use ($latestChats) {
            $query->select('sender_id')
                ->from($latestChats);
        })
            ->joinSub($latestChats, 'latest_chats', function ($join) {
                $join->on('users.id', '=', 'latest_chats.sender_id');
            })
            ->orderByDesc('latest_chats.last_chat_at') // Order by most recent chat
            ->get();

        $chatUsers = $chatUsers->unique('id');

        return view('admin.chat.index', compact('chatUsers', 'adminId'));
    }

    public function GetConversation(string $senderId)
    {
        $receiverId = Auth::guard('admin')->id(); // Admin ID

        // Fetch the admin's photo from the Admin model
        $admin = Admin::find($receiverId);
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
            'adminId' => $receiverId,   // Pass the admin's ID dynamically
            'adminPhoto' => $adminPhoto // Admin's photo path
        ]);
    }



    function SendMessage(Request $request)
    {
        
       

        $request->validate([
            'message' => ['required', 'max:1000'],
            'receiver_id' => ['required', 'integer']
        ]);

        $chat = new Chat();
        $chat->sender_id = Auth::guard(name: 'admin')->id();
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->message;
        $chat->save();

        // Get admin's photo
        $admin = Auth::guard('admin')->user();
        $adminPhoto = $admin->photo ? url('upload/admin_images/' . $admin->photo) : url('upload/no_image.jpg');


        return response(['status' => 'success', 'adminPhoto' => $adminPhoto]);
    }



}


//  public function ChatIndex()
//     {
//         $userId = auth()->user()->id;
//         $chatUsers = User::where('id', '!=', $userId)
//             ->whereHas('chats', function ($query) use ($userId) {
//                 $query->where(function ($subQuery) use ($userId) {
//                     $subQuery->where('sender_id', $userId)
//                         ->orWhere('receiver_id', $userId);
//                 });
//             })
//             ->orderByDesc('created_at')
//             ->get();

//         dd($chatUsers);
//         return view('admin.chat.index');
//     }
