<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    use HasFactory;
    protected $guarded = [];

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    // protected $fillable = ['name', 'category_id'];

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'unit_id');
    }
}
