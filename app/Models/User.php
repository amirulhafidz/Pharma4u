<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // public function sentMessages()
    // {
    //     return $this->hasMany(Message::class, 'sender_id');
    // }

    // public function receivedMessages()
    // {
    //     return $this->hasMany(Message::class, 'receiver_id');
    // }

    // public function chats()
    // {
    //     return $this->hasMany(Chat::class, 'sender_id', 'id')
    //         ->orWhere(function ($query) {
    //             $query->where('receiver_id', $this->id);
    //         });
    // }

    function chats()
    {
        return $this->hasMany(Chat::class, 'sender_id', 'id')
            ->orWhere('receiver_id', $this->id);
    }


    // public function sentChats()
    // {
    //     return $this->hasMany(Chat::class, 'sender_id', 'id');
    // }

    // public function receivedChats()
    // {
    //     return $this->hasMany(Chat::class, 'receiver_id', 'id');
    // }

    // public function chats()
    // {
    //     return Chat::where('sender_id', $this->id)
    //         ->orWhere('receiver_id', $this->id);
    // }




}
