<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Branch;
use App\Models\DirectSponsor;
use App\Models\Inventory;
use App\Models\MatchingBonus;
use App\Models\MLMRegister;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\PvPoint;
use App\Models\SelfPick;
use App\Models\Shipping;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Order::select(
            'orders.id',
            'orders.order_unique',
            'orders.order_sum',
            'orders.discount_amount',
            'orders.shipping_charge',
            'orders.total',
            'orders.payment_status',
            'orders.status_id',
            'status.name as status',
            'user.name as customername',
            'orders.created_at as date'
        )
            ->leftjoin('order_statuses as status', 'orders.status_id', '=', 'status.id')
            ->leftjoin('users as user', 'orders.user_id', '=', 'user.id')
            ->OrderBy('id', 'desc')->get();
        echo $data;
    }



    public function show_order_details($id)
    {
        $order_status = OrderStatus::all();
        $branch = Branch::all();

        $check = SelfPick::where('order_id', $id)->first();
        $order_data = Order::find($id);
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
                        ->where('orders.id', $id)->first();
                    $billing_address = Order::join('billings', 'billings.id', '=', 'orders.billing_id')
                        ->select('billings.first_name as firstname', 'billings.address', 'billings.country', 'billings.state', 'billings.zip')
                        ->where('orders.id', $id)->first();
                } else {
                    $ship_address = Order::join('shippings', 'shippings.id', '=', 'orders.shipping_id')
                        ->select('shippings.first_name as firstname', 'shippings.address', 'shippings.country', 'shippings.state', 'shippings.zip')
                        ->where('orders.id', $id)->first();
                    $billing_address = Order::join('billings', 'billings.id', '=', 'orders.billing_id')
                        ->select('billings.first_name as firstname', 'billings.address', 'billings.country', 'billings.state', 'billings.zip')
                        ->where('orders.id', $id)->first();
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
                ->where('orders.id', $id)->get();

            return view('admin.orders.orderDetails')->with(
                ['order_status' => $order_status, 'branch' => $branch, 'order_summary' => $order_summary, 'order_details' => $order_details]
            );
        } else {
            return view('404.index');
        }
    }

    public function delete_Order()
    {
        request()->validate([
            'id' => 'required|exists:orders,id'
        ], [
            'id.required' => 'Something Wrong Please Refresh',
        ]);
        Order::find(request()->id)->delete();
        OrderItem::where('order_id', request()->id)->delete();
        echo json_encode(['status' => 'success', 'message' => 'Order Delete Successfully']);
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
            'order_id' => 'required|exists:orders,id',
        ]);

        $order =  Order::where('id', $request->order_id)->first();
        $user = User::find($order->user_id);

        if ($request->update_payment == 1) {
            Order::where('id', $request->order_id)->update([
                'payment_status' => $request->status_id
            ]);
        }
        if ($request->update_pick_point == 1) {
            Order::where('id', $request->order_id)->update([
                'in_house_status' => $request->status_id
            ]);
        }
        if ($request->update_self_pick_order_status == 1) {
            Order::where('id', $request->order_id)->update([
                'self_pick_order_status' => $request->status_id
            ]);

            if ($request->status_id == 5) {
                $this->remove_from_stock($request->order_id);
                $this->get_pv_point($request->order_id);
                if ($user->is_mlm_member == 1) {
                    $this->get_direct_sponser($request->order_id);
                    $this->get_matching_bonus($order->user_id, $request->order_id);
                }
            }
        }


        if ($request->update_order_status == 1) {
            Order::where('id', $request->order_id)->update([
                'status_id' => $request->status_id
            ]);

            // remove item from stock
            if ($request->status_id == 5) {
                $this->remove_from_stock($request->order_id);
                $this->get_pv_point($request->order_id);
                if ($user->is_mlm_member == 1) {
                    $this->get_direct_sponser($request->order_id);
                    $this->get_matching_bonus($order->user_id, $request->order_id);
                }
            }
        }

        echo json_encode(['status' => 'success', 'message' => 'Status Update Successfully']);
    }

    public function get_matching_bonus($user_id, $order_id)
    {
        $user = User::find($user_id);
        $order = Order::where('id', $order_id)->first();

        $parent = MLMRegister::where('member_id', $user->unique_id)->first();
        if ($parent) {
            $parent_user = User::where('unique_id', $parent->sponser_id)->first();
            if ($parent_user->left_id != null && $parent_user->right_id != null) {

                $left_user = User::where('unique_id', $parent_user->left_id)->first();
                $left_user_order = Order::where('user_id', $left_user->id)->where('status_for_matching_bonus', 0)->first();

                $right_user = User::where('unique_id', $parent_user->right_id)->first();
                $right_user_order = Order::where('user_id', $right_user->id)->where('status_for_matching_bonus', 0)->first();

                if ($left_user_order && $right_user_order) {

                    if ($left_user_order->status_for_matching_bonus == 0 && $right_user_order->status_for_matching_bonus == 0) {

                        if ($left_user_order->total_pv >= $right_user_order->total_pv) {
                            $matching_pv = $right_user_order->total_pv;
                        } else {
                            $matching_pv = $left_user_order->total_pv;
                        }

                        if ($parent_user->rank_id == 1) {
                            $per = 6;
                            $final_cal = ($per / 100) * $matching_pv;
                        } else if ($parent_user->rank_id == 2) {
                            $per = 8;
                            $final_cal = ($per / 100) * $matching_pv;
                        } else if ($parent_user->rank_id == 3) {
                            $per = 10;
                            $final_cal = ($per / 100) * $matching_pv;
                        } else {
                            $per = 12;
                            $final_cal = ($per / 100) * $matching_pv;
                        }
                        User::where('unique_id', $parent_user->unique_id)->update([
                            'total_matching_bonus' => $parent_user->total_matching_bonus + $final_cal
                        ]);

                        Order::where('id', $left_user_order->id)->update([
                            'status_for_matching_bonus' => 1
                        ]);

                        Order::where('id', $right_user_order->id)->update([
                            'status_for_matching_bonus' => 1
                        ]);

                        MatchingBonus::create([
                            'sponser_id' => $parent_user->unique_id,
                            'member_id' => $user->unique_id,
                            'member_name' => $user->name,
                            'point' => $final_cal,
                            'order_id' => $order_id,
                        ]);
                    }
                }
            }
        }
    }


    public function get_direct_sponser($order_id)
    {
        $order = Order::where('id', $order_id)->first();
        $user = User::find($order->user_id);

        $total_pv = $order->total_pv;
        if ($order->status_for_direct_bonus == 0) {
            $sponsors_id = MLMRegister::where('member_id', $user->unique_id)->first();
            if ($sponsors_id) {
                // add in DirectSponsor table
                $sponsors_user = User::where('unique_id', $sponsors_id->sponser_id)->first();

                if ($sponsors_user->rank_id == 1) {
                    $per = 10;
                    $direct_cal = ($per / 100) * $total_pv;
                } else if ($sponsors_user->rank_id == 2) {
                    $per = 15;
                    $direct_cal = ($per / 100) * $total_pv;
                } else if ($sponsors_user->rank_id == 3) {
                    $per = 20;
                    $direct_cal = ($per / 100) * $total_pv;
                } else {
                    $per = 25;
                    $direct_cal = ($per / 100) * $total_pv;
                }
                DirectSponsor::create([
                    'sponsors_id'   => $sponsors_id->sponser_id,
                    'member_id'     => $user->unique_id,
                    'member_name'   => $user->name,
                    'rank_id'       => $user->rank_id,
                    'point'         => $direct_cal,
                    'order_id'      => $order_id,
                ]);

                User::where('unique_id', $sponsors_id->sponser_id)->update([
                    'total_direct_dponsor' => $sponsors_user->total_direct_dponsor + $direct_cal
                ]);

                Order::where('id', $order_id)->update([
                    'status_for_direct_bonus' => 1
                ]);
            }
        }
    }

    public function get_pv_point($order_id)
    {
        $order = Order::where('id', $order_id)->first();
        $user = User::find($order->user_id);
        $check = PvPoint::where('order_id', $order_id)->where('user_id', $user->id)->first();
        if (!$check) {
            $data = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.id', $order_id)->get();

            $total_pv = $order->total_pv;
            foreach ($data as $item) {
                PvPoint::create([
                    'user_id'       => $item->user_id,
                    'product_id'    =>  $item->product_id,
                    'point'      => $item->pv * $item->quentity,
                    'order_id'      => $order_id
                ]);
            }

            User::where('id', $user->id)->update([
                'total_pv_point' => $user->total_pv_point + $total_pv
            ]);
        }
    }

    public function remove_from_stock($order_id)
    {
        $order = Order::join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.id', $order_id)->get();
        $check = SelfPick::where('order_id', $order_id)->first();
        foreach ($order as $item) {
            $country = null;
            if ($check) {
                $country = $check->country;
            } else {
                if ($item->billing_id == $item->shipping_id) {
                    $address = Billing::where('id', $item->billing_id)->first();
                    $country = $address->country;
                } else {
                    $address = Shipping::where('id', $item->shipping_id)->first();
                    $country = $address->country;
                }
            }
            $quentity = Inventory::join('warehouses', 'warehouses.id', '=', 'inventories.warehouseid')
                ->where('warehouses.country', $country)
                ->where('inventories.productid', $item->product_id)
                ->where('inventories.stock', '>', 0)
                ->first();

            if ($quentity) {
                Inventory::join('warehouses', 'warehouses.id', '=', 'inventories.warehouseid')
                    ->where('warehouses.country', $country)
                    ->where('inventories.productid', $item->product_id)
                    ->where('inventories.stock', '>', 0)
                    ->update([
                        'stock' => $quentity->stock - $item->quentity
                    ]);
            }
            // echo json_encode($country);
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