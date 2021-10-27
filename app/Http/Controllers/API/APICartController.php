<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class APICartController extends Controller
{
    public function add_to_cart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quentity'   => 'required|numeric'
        ]);

        $chekc = Cart::where('product_id', $request->product_id)->where('user_id', $request->user()->id)->first();
        if ($chekc) {
            Cart::where('product_id', $request->product_id)->where('user_id', $request->user()->id)->update([
                'quentity' => $chekc->quentity + $request->quentity
            ]);
        } else {
            Cart::create([
                'user_id'       => $request->user()->id,
                'product_id'    => $request->product_id,
                'quentity'      => $request->quentity
            ]);
        }

        return response([
            'message' => 'Product Add Successfully'
        ], 201);
    }

    public function cart_count()
    {
        $data = Cart::where('user_id', request()->user()->id)->count();

        return response([
            'count' => $data
        ], 201);
    }
}