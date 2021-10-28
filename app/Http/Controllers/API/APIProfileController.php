<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class APIProfileController extends Controller
{
    public function profile_data()
    {
        $data = User::find(request()->user()->id);
        return response([
            $data
        ], 201);
    }
}