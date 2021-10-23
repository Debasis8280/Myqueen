<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflinePay extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_id',
        'screen_shot',
        'status',
    ];
}