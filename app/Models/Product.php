<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    protected $fillable = ['user_id', 'cat_id', 'unit_id', 'name', 'price', 'img_url'];

    function category(){
        return $this->belongsTo(Category::class);
    }

    function unit(){
        return $this->belongsTo(Unit::class);
    }
}
