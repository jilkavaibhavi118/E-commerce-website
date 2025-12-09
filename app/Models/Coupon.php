<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code','type','value','min_cart_value',
        'max_uses','max_uses_user',
        'start_date','end_date','status'
    ];
}
