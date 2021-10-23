<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectSponsor extends Model
{
    use HasFactory;
    protected $fillable = [
        'sponsors_id',
        'member_id',
        'member_name',
        'rank_id',
        'point',
        'order_id'
    ];
}