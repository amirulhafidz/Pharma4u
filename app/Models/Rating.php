<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{

    use HasFactory;
    protected $guarded = [];
    // protected $fillable = ['user_id', 'unit_id', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function units()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
    
}
