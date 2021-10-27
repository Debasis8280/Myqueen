<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
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

    public function check_coupon(Request $request)
    {
        $request->validate([
            'coupon' => 'required|exists:coupons,number'
        ], [
            'coupon.required'  => 'Please Enter Coupon Code',
            'coupon.exists'    => 'Invalid Coupon Code'
        ]);

        $coupon = Coupon::where('number', $request->coupon)->first();
        $cart = Cart::where('user_id', $request->user()->id)->get();
        $exit = Order::where('user_id', $request->user()->id)->where('coupon_code', $request->coupon)->first();
        $order_sum = 0;
        foreach ($cart as $item) {
            $product = Product::find($item->product_id);

            $order_sum = $order_sum + ($product->saleprice * $item->quentity);
        }



        if ($order_sum > $coupon->discount_number && !$exit) {
            $after_discount_amount = 0;
            if ($coupon->discount_type == 'Fixed') {
                $after_discount_amount = $order_sum - $coupon->discount_number;
            } else {
                $per_cal = ($coupon->discount_number / 100) * $order_sum;
                $after_discount_amount =  $order_sum - $per_cal;
            }
            $type = $coupon->discount_type == "Fixed" ? 'fixed' : '%';
            return response([
                'status' => 'success',
                'type' => $type,
                'discount_amount'       => $coupon->discount_number,
            ]);
        } else {
            return response(['status' => 'Faild', 'message' => 'Invalid Coupon']);
        }
    }
}