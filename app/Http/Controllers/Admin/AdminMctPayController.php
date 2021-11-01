<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\MCTPay;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\SelfPick;
use App\Models\User;
use Illuminate\Http\Request;

class AdminMctPayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = MCTPay::join('users', 'users.id', '=', 'm_c_t_pays.user_id')
            ->join('orders', 'orders.id', '=', 'm_c_t_pays.order_id')
            ->select('m_c_t_pays.*', 'users.name', 'orders.total', 'orders.payment_status as status')
            ->orderBy('m_c_t_pays.id', 'desc')
            ->get();
        echo $data;
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
            'id' => 'required|exists:m_c_t_pays,id'
        ]);
        $offline_pay = MCTPay::where('id', $request->id)->first();

        MCTPay::where('id', $request->id)->update([
            'status' => 1
        ]);

        Order::where('id', $offline_pay->order_id)->update([
            'payment_status' => 1
        ]);

        echo json_encode(['status' => 'success', 'message' => 'Payment Approve Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offline_pay = MCTPay::where('id', $id)->first();
        if ($offline_pay) {
            $check = SelfPick::where('order_id', $offline_pay->order_id)->first();
            $order_data = Order::find($offline_pay->order_id);
            $user = User::find($order_data->user_id);
            $order_status = OrderStatus::where('id', $order_data->status_id)->first();
            if ($check) {
                $order_summary = [
                    'order_no' => $order_data->order_unique,
                    'order_date' => $order_data->created_at,
                    'name'  => $user->name,
                    'order_status' => 'Self Pick',
                    'email' => $user->email,
                    'total_order_amount' => $order_data->total,
                    'shipping_address' => $check->country . ', ' . $check->state . ', ' . $check->zip,
                    'shipping_method' => $order_data->shipping_method,
                    'payment_method' => $order_data->payment_method,
                    'sub_total' => $order_data->order_sum,
                    'shipping_charge'   => $order_data->shipping_charge,
                    'coupon_discount'   => $order_data->how_may_discount . " " . $order_data->discount_type,
                    'total_amount' => $order_data->total,
                    'in_house_status' => $order_data->in_house_status,
                    'status_id' => $order_data->status_id,
                    'payment_status' => $order_data->payment_status,
                    'self_pick_order_status' => $order_data->self_pick_order_status,
                    'payment_date' => $offline_pay->created_at,
                    'payment_screen_shot' => $offline_pay->screen_shot
                ];

                $branch = Branch::where('id', $order_data->in_house_status)->first();
                if ($branch) {
                    $order_summary['branch_name'] = $branch->name;
                    $order_summary['branch_address'] = $branch->address;
                    $order_summary['branch_zip'] = $branch->pincode;
                    $order_summary['branch_country'] = $branch->country;
                }
            } else {
                if ($order_data->billing_id == $order_data->shipping_id) {
                    $ship_address = Order::join('billings', 'billings.id', '=', 'orders.billing_id')
                        ->select('billings.first_name as firstname', 'billings.address', 'billings.country', 'billings.state', 'billings.zip')
                        ->where('orders.id', $id)->first();
                } else {
                    $ship_address = Order::join('shippings', 'shippings.id', '=', 'orders.shipping_id')
                        ->select('shippings.first_name as firstname', 'shippings.address', 'shippings.country', 'shippings.state', 'shippings.zip')
                        ->where('orders.id', $id)->first();
                }


                $order_summary = [
                    'order_no' => $order_data->order_unique,
                    'order_date' => $order_data->created_at,
                    'name'  => $ship_address->firstname . ' ' . $ship_address->lastname,
                    'order_status' => $order_status->name,
                    'email' => $user->email,
                    'total_order_amount' => $order_data->total,
                    'shipping_address' => $ship_address->address . ", " . $ship_address->country . ', ' . $ship_address->state . ', ' . $ship_address->zip,
                    'shipping_method' => $order_data->shipping_method,
                    'payment_method' => $order_data->payment_method,
                    'sub_total' => $order_data->order_sum,
                    'shipping_charge'   => $order_data->shipping_charge,
                    'coupon_discount'   => $order_data->how_may_discount . " " . $order_data->discount_type,
                    'total_amount' => $order_data->total,
                    'in_house_status' => $order_data->in_house_status,
                    'status_id' => $order_data->status_id,
                    'payment_status' => $order_data->payment_status,
                    'self_pick_order_status' => $order_data->self_pick_order_status,
                    'payment_date' => $offline_pay->created_at,
                    'payment_screen_shot' => $offline_pay->screen_shot
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
                ->where('orders.id', $order_data->id)->get();
            return view('admin.payment.mct-pay.payment_details')->with(['order_summary' => $order_summary, 'order_details' => $order_details]);
        } else {
            return view('404.index');
        }
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