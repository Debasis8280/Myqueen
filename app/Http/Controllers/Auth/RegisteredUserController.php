<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required'],
            'phone'         => ['required', 'numeric'],
            'code'          => 'required',
            'policy'        => 'required'
        ], [
            'name.required'     => 'Please Enter Full Name',
            'email.required'    => 'Please Enter Email',
            'password.required' => 'Please Enter Password',
            'code.required'     => 'Please Select Country Code',
            'phone.required'    => 'Please Enter Phone Number',
            'policy.required'    => 'Please Select Policy'
        ]);
        $unique_id = User::orderBy('id', 'desc')->first();
        $number = str_replace('MQU', '', $unique_id ? $unique_id->unique_id  : 0);
        if ($number == 0) {
            $number = 'MQU0000001';
        } else {
            $number = "MQU" . sprintf("%07d", $number + 1);
        }

        $user = User::create([
            'unique_id' => $number,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'country_code' => $request->code,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);

        echo json_encode(['status' => 'success', 'message' => 'Register Successfully']);
    }
}