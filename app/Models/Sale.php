<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    protected $fillable = ['total', 'discount', 'vat', 'sd', 'payable', 'user_id', 'cus_id'];

    function customer():BelongsTo{
        return $this->belongsTo(Customer::class);
    }

    // function sale_detail():HasMany{
    //     return $this->hasMany(SaleDetail::class);
    // }
}
