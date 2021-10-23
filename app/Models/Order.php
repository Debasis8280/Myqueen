<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_unique',
        'user_id',
        'payment_method',
        'shipping_method',
        'user_ip',
        'order_currency',
        'billing_id',
        'shipping_id',
        'status_id',
        'quentity',
        'order_sum',
        'total_pv',
        'in_house_status',
        'coupon_code',
        'discount_amount',
        'how_may_discount',
        'discount_type',
        'after_discount_price',
        'shipping_charge',
        'payment_status',
        'total',

    ];
}