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


    public function cart_list()
    {
        if (request()->lang == 'ch') {
            $data = Cart::join('products', 'products.id', '=', 'carts.product_id')
                ->select('products.productimagec as image', 'products.title', 'carts.quentity', 'products.saleprice', 'products.id as product_id', 'carts.id as cart_id')
                ->where('carts.user_id', request()->user()->id)->get();
        } else {
            $data = Cart::join('products', 'products.id', '=', 'carts.product_id')
                ->select('products.productimagee as image', 'products.title', 'carts.quentity', 'products.saleprice', 'products.id as product_id', 'carts.id as cart_id')
                ->where('carts.user_id', request()->user()->id)->get();
        }
        return response([
            'list' => $data
        ], 201);
    }


    public function update_cart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'cart_id'    => 'required|exists:carts,id',
            'quentity'   =>  'required'
        ], [
            'product_id.required' => 'Invalid Product Id',
            'cart_id.required'    => 'Invalid Cart Id',
            'quentity.required'   => 'Please Add Quentity'
        ]);


        Cart::where('id', $request->cart_id)->where('product_id', $request->product_id)->where('user_id', $request->user()->id)->update([
            'quentity' => $request->quentity
        ]);

        $show =  Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->select('products.title', 'carts.quentity')
            ->where('carts.id', $request->cart_id)
            ->where('carts.product_id', $request->product_id)
            ->where('carts.user_id', $request->user()->id)->first();

        return response([
            'status' => 'success',
            'message' => "You changed '" . $show->title . "' QUANTITY to '" . $show->quentity . "'"
        ]);
    }

    public function delete_from_cart(Request $request)
    {
        $request->validate([
            'product_id'    => 'required|exists:products,id',
            'cart_id'       => 'required|exists:carts,id'
        ], [
            'product_id.required' => 'Please Refresh Something Wrong',
            'cart_id.required'    => 'Please Refresh Something Wrong',
        ]);

        Cart::where('id', $request->cart_id)->where('product_id', $request->product_id)
            ->where('user_id', $request->user()->id)->delete();

        return response(['status' => 'success', 'message' => 'Successfully removed']);
    }
}