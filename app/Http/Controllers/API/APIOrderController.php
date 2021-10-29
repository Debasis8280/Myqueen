<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\OfflinePay;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\SelfPick;
use App\Models\Shipping;
use App\Models\ShippingCharge;
use App\Models\User;
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
        return response($response, 201);
    }


    public function store_order(Request $request)
    {
        if ($request->payment_method == 'Pay Now') {
            $request->validate([
                'offline_pay_screen_shot' => 'required|image'
            ], [
                'offline_pay_screen_shot.required' => 'Please Upload Payment Screenshot'
            ], [
                'offline_pay_screen_shot' => 'Screenshot'
            ]);
        }

        $ordernumber = Order::orderBy('id', 'desc')->first();
        if ($ordernumber == null) {
            $number = 'MQO0000001';
        } else {
            $number = str_replace('MQO', '', $ordernumber->order_unique);
            $number =  "MQO" . sprintf("%07d", $number + 1);
        }

        $quentity = Cart::where('user_id', $request->user()->id)->sum('quentity');
        $cart = Cart::where('user_id', $request->user()->id)->get();
        $order_sum = 0;
        $total = 0;
        $total_pv = 0;
        foreach ($cart as $item) {
            $product = Product::find($item->product_id);

            $order_sum = $order_sum + ($product->saleprice * $item->quentity);

            $total_pv = $total_pv + ($product->pv * $item->quentity);
        }
        $total = $order_sum;

        $coupon = Coupon::where('number', $request->coupon)->first();
        $discount_type = null;
        $after_discount_amount = 0;
        $discount_amount = 0;
        $how_may_discount = 0;
        $coupon_code = null;
        if ($coupon) {
            if ($order_sum > $coupon->discount_number) {
                if ($coupon->discount_type == 'Fixed') {
                    $after_discount_amount = $total - $coupon->discount_number;
                    $discount_type = 'Fixed';
                    $discount_amount = $coupon->discount_number;
                    $how_may_discount = $coupon->discount_number;
                } else {
                    $per_cal = ($coupon->discount_number / 100) * $total;
                    $after_discount_amount =  $total - $per_cal;
                    $discount_type = '%';
                    $discount_amount = $per_cal;
                    $how_may_discount = $coupon->discount_number;
                }
                $coupon_code = $request->coupon;
            }
        }


        $order_unique = $number;
        $user_id = $request->user()->id;
        $payment_method = $request->payment_method;
        $user_ip = $request->ip();
        $order_currency = "$";
        $bill_id = 0;
        $ship_id = 0;

        $is_bill_same_ship = 0;

        if ($request->is_self_pickup_selected == 'true') {
            $shipping_method = 'Self Pick';
            $status_id = 0;
        } else {
            $shipping_method = 'Home Delivery';
            $status_id = 1;
        }

        if ($request->is_self_pickup_selected == 'false') {
            $check = ShippingCharge::where('country', $request->country)->first();
            if ($check) {
                $total = $total + $check->amount;
                $delivery_charge = $check->amount;
            } else {
                $delivery_charge = 0;
                $total = $total;
            }
        } else {
            $delivery_charge = 0;
            $total = $total;
        }

        if ($request->is_self_pickup_selected == 'false' && $request->is_ship_same_to_bill == 'true') {
            $bill_id = Billing::insertGetId([
                'user_id'       => $request->user()->id,
                'first_name'    => $request->first_name,
                'lastname'      => $request->lastname,
                'country'       => $request->country,
                'address'       => $request->address,
                'city'          => $request->city,
                'state'         => $request->state,
                'zip'           => $request->zip,
                'Phone'         => $request->phone,
                'created_at'    => now(),
                'updated_at'    => now()
            ]);
            $ship_id = $bill_id;
            $is_bill_same_ship = 1;
        }

        if ($request->is_self_pickup_selected == 'false' && $request->is_ship_same_to_bill == 'false') {
            $bill_id = Billing::insertGetId([
                'user_id'       => $request->user()->id,
                'first_name'    => $request->first_name,
                'lastname'      => $request->lastname,
                'country'       => $request->country,
                'address'       => $request->address,
                'city'          => $request->city,
                'state'         => $request->state,
                'zip'           => $request->zip,
                'Phone'         => $request->phone,
                'created_at'    => now(),
                'updated_at'    => now()
            ]);
            $ship_id = Shipping::insertGetId([
                'user_id'       => $request->user()->id,
                'first_name'    => $request->first_name_ship,
                'lastname'      => $request->lastname_ship,
                'country'       => $request->country_ship,
                'address'       => $request->address_ship,
                'city'          => $request->city_ship,
                'state'         => $request->state_ship,
                'zip'           => $request->zip_ship,
                'Phone'         => $request->phone_ship,
                'created_at'    => now(),
                'updated_at'    => now()
            ]);
            $is_bill_same_ship = 0;
        }


        $order_id = Order::insertGetId([
            'order_unique' => $number,
            'user_id' => $request->user()->id,
            'payment_method' => $payment_method,
            'shipping_method' => $shipping_method,
            'user_ip' => $request->ip(),
            'order_currency' => '$',
            'is_bill_same_ship' => $is_bill_same_ship,
            'billing_id' => $bill_id,
            'shipping_id' => $ship_id,
            'status_id' => $status_id,
            'quentity' => $quentity,
            'order_sum' => $order_sum,
            'total_pv' => $total_pv,
            'in_house_status' => null,
            'coupon_code' => $coupon_code,
            'discount_amount' => $discount_amount,
            'how_may_discount'  => $how_may_discount,
            'discount_type' => $discount_type,
            'after_discount_price' => $after_discount_amount,
            'shipping_charge' => $delivery_charge,
            'payment_status' => 0,
            'total' => $after_discount_amount != null ? $after_discount_amount + $delivery_charge : $order_sum + $delivery_charge,
            'created_at'    => now(),
            'updated_at'    => now()
        ]);

        if ($request->is_self_pickup_selected == 'true') {
            SelfPick::create([
                'user_id' => $request->user()->id,
                'order_id' => $order_id,
                'country'   => $request->country_self,
                'state'     => $request->state_self,
                'zip'       => $request->zip_self
            ]);
        }


        // add to order item
        foreach ($cart as $item) {
            $product = Product::find($item->product_id);
            OrderItem::create([
                'user_id' => $request->user()->id,
                'order_id'   => $order_id,
                'product_id' => $product->id,
                'price'      => $product->saleprice,
                'pv'         => $product->pv,
                'quentity'   => $item->quentity
            ]);

            // Cart::where('id', $item->id)->delete();
        }

        // add payment screenshot image 
        if ($payment_method == 'Pay Now') {
            $screen_shot = $request->offline_pay_screen_shot->storeAs('Offline_pay', "order_id_" . $order_id . "." . $request->offline_pay_screen_shot->extension());
            OfflinePay::create([
                'user_id' => $request->user()->id,
                'order_id' => $order_id,
                'screen_shot' => $screen_shot,
                'status'    => 0
            ]);
        }

        return response([
            'status' => 'success',
            'message' => 'Just wanted to say thank you for your purchase. We’re so lucky to have customers like you',
            'order_id' => $order_id
        ]);
    }


    public function redirect_thanks(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);
        $check = SelfPick::where('order_id', $request->order_id)->first();
        $order_data = Order::find($request->order_id);
        if ($check) {
            $order_summary = [
                'order_no' => $order_data->order_unique,
                'order_date' => $order_data->created_at,
                'name'  => $request->user()->name,
                'order_status' => 'Processing',
                'email' => $request->user()->email,
                'total_order_amount' => $order_data->total,
                'shipping_address' => $check->country . ', ' . $check->state . ', ' . $check->zip,
                'shipping' => $order_data->shipping_method,
                'payment_method' => $order_data->payment_method,
                'sub_total' => $order_data->order_sum,
                'shipping_charge'   => $order_data->shipping_charge,
                'coupon_discount'   => $order_data->how_may_discount . " " . $order_data->discount_type,
                'total_amount' => $order_data->total
            ];
        } else {
            if ($order_data->is_bill_same_ship == 1) {
                $ship_address = Order::join('billings', 'billings.id', '=', 'orders.billing_id')
                    ->where('orders.id', $request->order_id)->first();
            } else {
                $ship_address = Order::join('shippings', 'shippings.id', '=', 'orders.shipping_id')
                    ->where('orders.id', $request->order_id)->first();
            }


            $order_summary = [
                'order_no' => $order_data->order_unique,
                'order_date' => $order_data->created_at,
                'name'  => $ship_address->first_name . ' ' . $ship_address->lastname,
                'order_status' => 'Processing',
                'email' => $request->user()->email,
                'total_order_amount' => $order_data->total,
                'shipping_address' => $ship_address->address . ", " . $ship_address->country . ', ' . $ship_address->state . ', ' . $ship_address->zip,
                'shipping' => $order_data->shipping_method,
                'payment_method' => $order_data->payment_method,
                'sub_total' => $order_data->order_sum,
                'shipping_charge'   => $order_data->shipping_charge,
                'coupon_discount'   => $order_data->how_may_discount . " " . $order_data->discount_type,
                'total_amount' => $order_data->total
            ];
        }

        $order_details = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select(
                'products.title',
                'products.productimagee as image',
                'order_items.quentity as qun',
                'orders.shipping_method',
                'products.saleprice'
            )
            ->where('orders.id', $request->order_id)->get();

        return response(['order_summary' => $order_summary, 'order_details' => $order_details], 201);
    }

    public function order_history_details(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);


        $check = SelfPick::where('order_id', $request->order_id)->first();
        $order_data = Order::find($request->order_id);
        if ($order_data) {
            $user = User::find($order_data->user_id);
            if ($check) {
                $order_summary = [
                    'order_id' => $order_data->id,
                    'order_no' => $order_data->order_unique,
                    'order_date' => $order_data->created_at,
                    'name'  => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'total_order_amount' => $order_data->total,
                    'shipping_address' => $check->country . ', ' . $check->state . ', ' . $check->zip,
                    'billing_address' => $check->country . ', ' . $check->state . ', ' . $check->zip,
                    'shipping_method' => $order_data->shipping_method,
                    'payment_method' => $order_data->payment_method,
                    'sub_total' => $order_data->order_sum,
                    'shipping_charge'   => $order_data->shipping_charge,
                    'coupon_discount'   => $order_data->how_may_discount . " " . $order_data->discount_type,
                    'total_amount' => $order_data->total,
                    'in_house_status' => $order_data->in_house_status,
                    'status_id' => $order_data->status_id,
                    'payment_status' => $order_data->payment_status,
                    'self_pick_order_status' => $order_data->self_pick_order_status
                ];
            } else {
                if ($order_data->is_bill_same_ship == 1) {
                    $ship_address = Order::join('billings', 'billings.id', '=', 'orders.billing_id')
                        ->select('billings.first_name as firstname', 'billings.address', 'billings.country', 'billings.state', 'billings.zip')
                        ->where('orders.id', $request->order_id)->first();
                    $billing_address = Order::join('billings', 'billings.id', '=', 'orders.billing_id')
                        ->select('billings.first_name as firstname', 'billings.address', 'billings.country', 'billings.state', 'billings.zip')
                        ->where('orders.id', $request->order_id)->first();
                } else {
                    $ship_address = Order::join('shippings', 'shippings.id', '=', 'orders.shipping_id')
                        ->select('shippings.first_name as firstname', 'shippings.address', 'shippings.country', 'shippings.state', 'shippings.zip')
                        ->where('orders.id', $request->order_id)->first();
                    $billing_address = Order::join('billings', 'billings.id', '=', 'orders.billing_id')
                        ->select('billings.first_name as firstname', 'billings.address', 'billings.country', 'billings.state', 'billings.zip')
                        ->where('orders.id', $request->order_id)->first();
                }


                $order_summary = [
                    'order_id' => $order_data->id,
                    'order_no' => $order_data->order_unique,
                    'order_date' => $order_data->created_at,
                    'name'  => $ship_address->firstname . ' ' . $ship_address->lastname,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'total_order_amount' => $order_data->total,
                    'shipping_address' => $ship_address->address . ", " . $ship_address->country . ', ' . $ship_address->state . ', ' . $ship_address->zip,
                    'billing_address' => $billing_address->address . ', ' . $billing_address->country . ', ' . $billing_address->state . ', ' . $billing_address->zip,
                    'shipping_method' => $order_data->shipping_method,
                    'payment_method' => $order_data->payment_method,
                    'sub_total' => $order_data->order_sum,
                    'shipping_charge'   => $order_data->shipping_charge,
                    'coupon_discount'   => $order_data->how_may_discount . " " . $order_data->discount_type,
                    'total_amount' => $order_data->total,
                    'in_house_status' => $order_data->in_house_status,
                    'status_id' => $order_data->status_id,
                    'payment_status' => $order_data->payment_status,
                    'self_pick_order_status' => $order_data->self_pick_order_status
                ];
            }

            $order_details = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'products.id', '=', 'order_items.product_id')
                ->select(
                    'products.title',
                    'products.productimagee as image',
                    'order_items.quentity as qun',
                    'orders.shipping_method',
                    'products.saleprice'
                )
                ->where('orders.id', $request->order_id)->get();
            return response(['order_summary' => $order_summary, 'order_details' => $order_details], 201);
        }
    }
}