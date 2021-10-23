<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MLMRegister extends Model
{
    use HasFactory;
    protected $fillable = [
        'ranking',
        'branch_id',
        'member_id',
        'member_name',
        'postcode',
        'nationality',
        'sponser_id',
        'placement_id',
        'placement',
        'street_address',
        'office_contact_no',
        'home_contact_no',
        'nick_name',
        'birthday',
        'email',
        'contact_address',
        'account_holder',
        'bank_name',
        'payment_information',
        'branch',
        'account_no',
        'status'
    ];
}