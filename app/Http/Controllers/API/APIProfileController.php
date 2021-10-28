<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PvPoint;
use App\Models\User;
use Illuminate\Http\Request;

class APIProfileController extends Controller
{
    public function profile_data()
    {
        $data = User::find(request()->user()->id);
        return response([
            $data
        ], 201);
    }

    public function get_pv_point()
    {
        $data = PvPoint::join('orders', 'orders.id', '=', 'pv_points.order_id')
            ->select('pv_points.*', 'orders.order_unique as order_unique_id')
            ->where('pv_points.user_id', request()->user()->id)
            ->get();
        return response(
            $data,
            201
        );
    }
}