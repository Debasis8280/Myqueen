<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\SelfPick;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPurchaseHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Order::select('orders.*')
            ->where('orders.user_id', Auth::user()->id)
            ->orderBy('orders.id', 'desc')->paginate(8);
        return view('font.purchase-history.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $check = SelfPick::where('order_id', $id)->first();
        $order_data = Order::find($id);
        $order_status = OrderStatus::where('id', $order_data->status_id)->first();
        if ($check) {
            $order_summary = [
                'order_no' => $order_data->order_unique,
                'order_date' => $order_data->created_at,
                'name'  => Auth::user()->name,
                'order_status' => 'Self Pick',
                'email' => Auth::user()->email,
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
                'payment_status' => $order_data->payment_status
            ];

            $branch = Branch::where('id', $order_data->in_house_status)->first();
            if ($branch) {
                $order_summary['branch_name'] = $branch->name;
                $order_summary['branch_address'] = $branch->address;
                $order_summary['branch_zip'] = $branch->pincode;
                $order_summary['branch_country'] = $branch->country;
            }
        } else {
            if ($order_data->is_bill_same_ship == 1) {
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
                'email' => Auth::user()->email,
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
                'payment_status' => $order_data->payment_status
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
            ->where('orders.id', $id)->get();
        return view('font.purchase-history.show_detials')->with(['order_summary' => $order_summary, 'order_details' => $order_details]);
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