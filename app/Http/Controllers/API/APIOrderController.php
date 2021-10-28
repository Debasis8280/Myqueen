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


    public function payment_qrcode()
    {
        $postArray = array();
        $postArray['user_id'] = 'S111417';
        $postArray["user_password"] = md5('S111417' . '4ba2e90ba890799fb708e9f0bca9a648');
        $postArray['amount'] = request()->total;
        $postArray['notify_url'] = 'd';
        $sign_string = md5($postArray['user_id'] . $postArray["user_password"] . $postArray['amount'] . $postArray['notify_url'] . '4ba2e90ba890799fb708e9f0bca9a648');
        $postArray["sign_string"] = $sign_string;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://mctpayment.com/dci/api_v2/get_fixed_amount_qrcode');
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postArray);
        $response = curl_exec($ch);
        echo $response;
    }


    public function store_order()
    {
    }
}