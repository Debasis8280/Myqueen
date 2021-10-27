<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;

class APIOrderController extends Controller
{
    public function delivery_charge(Request $request)
    {
        $request->validate([
            'country' => 'required'
        ], [
            'country.required' => 'Please Select Country'
        ]);
        $charge = ShippingCharge::where('country', $request->country)->first();
        $amount = 0;
        if ($charge) {
            $amount = $charge->amount;
        }
        return response($amount, 201);
    }
}