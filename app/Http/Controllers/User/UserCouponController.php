<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'coupon' => 'required|exists:coupons,number'
        ], [
            'coupon.required'  => 'Please Enter Coupon Code',
            'coupon.exists'    => 'Invalid Coupon Code'
        ]);

        $coupon = Coupon::where('number', $request->coupon)->first();
        $cart = cart::where('user_id', Auth::user()->id)->get();
        $exit = Order::where('user_id', Auth::user()->id)->where('coupon_code', $request->coupon)->first();
        $order_sum = 0;
        foreach ($cart as $item) {
            $product = Product::find($item->product_id);

            $order_sum = $order_sum + ($product->saleprice * $item->quentity);
        }



        if ($request->home_delivery_select == 1) {
            $check = ShippingCharge::where('country', $request->country)->first();
            if ($check) {
                $total = $order_sum + $check->amount;
                $delivery_charge = $check->amount;
            } else {
                $delivery_charge = 0;
                $total = $order_sum;
            }
        } else {
            $delivery_charge = 0;
            $total = $order_sum;
        }

        if ($order_sum > $coupon->discount_number && !$exit) {
            $after_discount_amount = 0;
            if ($coupon->discount_type == 'Fixed') {
                $after_discount_amount = $total - $coupon->discount_number;
            } else {
                $per_cal = ($coupon->discount_number / 100) * $total;
                $after_discount_amount =  $total - $per_cal;
            }
            $type = $coupon->discount_type == "Fixed" ? 'fixed' : '%';
            echo json_encode([
                'status' => 'success',
                'after_discount_amount' => $after_discount_amount,
                'type' => $type,
                'discount_amount'       => $coupon->discount_number,
                $order_sum
            ]);
        } else {
            echo json_encode(['status' => 'Faild', 'message' => 'Invalid Coupon']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}