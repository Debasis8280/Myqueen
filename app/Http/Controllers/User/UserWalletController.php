<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserWalletController extends Controller
{
    public function show_royalty_page()
    {
        return view('font.wallet.index');
    }
}