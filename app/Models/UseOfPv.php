<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UseOfPv extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'use_pv_point',
        'description',
    ];
}