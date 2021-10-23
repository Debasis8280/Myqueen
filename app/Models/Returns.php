<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    use HasFactory;
    protected $fillable = ['productid', 'warehouseid', 'rackid', 'quantity', 'date', 'status'];
}