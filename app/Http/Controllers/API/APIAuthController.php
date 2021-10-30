<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class APIAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ], [
            'email.required' => 'Please Enter Email',
            'password.required' => 'Please Enter Password'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Your username or password is incorrect'
            ], 401);
        }

        $token = $user->createToken($user->name)->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ], 201);
    }


    public function register(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required',
            'email'         => 'required|email:rfc,dns|unique:users,email',
            'password'      => 'required',
            'phone'         => 'required',
            'country_code'  => 'required',
        ], [
            'name.requried'         => 'Please Enter Name',
            'email.required'        => 'Please Enter Email',
            'password.required'     => 'Please Enter Password',
            'phone.required'        => 'Please Enter Phone Number',
            'country_code.required' => 'Please Select Country Code'
        ]);

        $unique_id = User::orderBy('id', 'desc')->first();
        $number = str_replace('MQU', '', $unique_id ? $unique_id->unique_id  : 0);
        if ($number == 0) {
            $number = 'MQU0000001';
        } else {
            $number = "MQU" . sprintf("%07d", $number + 1);
        }


        $data['unique_id'] = $number;
        $data['password']  = Hash::make($request->password);
        $user = User::create($data);
        $token = $user->createToken($user->name)->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ], 201);
    }


    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'Logout'
        ], 201);
    }
}