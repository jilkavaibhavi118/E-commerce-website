<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'discount',
        'final_amount',
        'order_status',
        'address',
        'payment_status',
    ];

    public function customer()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function items()
{
    return $this->hasMany(OrderItem::class, 'order_id', 'id');
}


}
