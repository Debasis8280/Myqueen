<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PvPoint;
use App\Models\Shipping;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class APIProfileController extends Controller
{
    public function profile_data()
    {
        $data = User::find(request()->user()->id);
        return response(
            $data,
            201
        );
    }

    public function get_pv_point()
    {
        $data = PvPoint::join('orders', 'orders.id', '=', 'pv_points.order_id')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('pv_points.*', 'orders.order_unique as order_unique_id', 'users.image')
            ->where('pv_points.user_id', request()->user()->id)
            ->get();
        return response(
            $data,
            201
        );
    }

    public function order_history()
    {
        $data = Order::select('orders.*')
            ->where('orders.user_id', request()->user()->id)
            ->orderBy('orders.id', 'desc')->get();
        foreach ($data as $item) {
            $status = OrderStatus::where('id', $item->status_id)->first();
            if ($status) {
                $status = $status->name;
            } else {
                $status = 'Self Pick';
            }
            $final[] = [
                'order_id' => $item->id,
                'order_unique' => $item->order_unique,
                'date' => $item->created_at,
                'price' => $item->total,
                'status' => $status,
                'ship_method' => $item->shipping_method
            ];
        }
        return response(
            $final,
            201
        );
    }

    public function wallet_history()
    {
        $data = Wallet::where('user_id', request()->user()->id)->get();

        return response($data, 201);
    }



    public function edit_profile(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
            'name' => 'required',
            'phone' => 'required|numeric',
        ]);

        User::where('id', $request->user()->id)->update($data);
        return response([
            'message' => 'Update Successfully'
        ], 201);
    }

    public function address()
    {
        $bill = Billing::where('user_id', request()->user()->id)->get();
        $ship = Shipping::where('user_id', request()->user()->id)->get();

        return response([
            'bill' => $bill,
            'ship' => $ship
        ], 201);
    }

    public function pending_payment()
    {
        $data = Order::where('user_id', request()->user()->id)
            ->where('payment_status', 0)->get();
        return response($data, 201);
    }
}