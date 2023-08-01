<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = ['user_id', 'cat_id', 'unit_id', 'name', 'price', 'img_url'];

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function unit():BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
