<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDeliveryChargeController extends Controller
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
        $delivery_charge = 0;
        $cart = cart::where('user_id', Auth::user()->id)->get();
        $order_sum = 0;
        foreach ($cart as $item) {
            $product = Product::find($item->product_id);

            $order_sum = $order_sum + ($product->saleprice * $item->quentity);

            $all_product_sum = $order_sum;
        }

        $coupon = Coupon::where('number', $request->coupon)->first();

        if ($coupon) {
            if ($order_sum > $coupon->discount_number) {
                if ($coupon->discount_type == 'Fixed') {
                    $order_sum = $order_sum - $coupon->discount_number;
                } else {
                    $per_cal = ($coupon->discount_number / 100) * $order_sum;
                    $order_sum =  $order_sum - $per_cal;
                }
            }
        }

        if ($request->home_delivery_select == 1) {
            $country = $request->country;
            $check = ShippingCharge::where('country', $country)->first();
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

        $data = ['status' => 'success', 'delivery_charge' => $delivery_charge, 'total' => $total, 'order_sum' => $all_product_sum];

        echo json_encode($data);
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