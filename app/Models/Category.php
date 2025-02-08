<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    use HasFactory;

    protected $guarded = [];

    public function units()
    {
        return $this->hasMany(Unit::class, 'category_id', 'id');
    }

}
