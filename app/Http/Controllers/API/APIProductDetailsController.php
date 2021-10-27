<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;

class APIProductDetailsController extends Controller
{
    public function product_details($id)
    {
        $data = Product::find($id);
        if ($data) {
            return response([
                $data
            ], 201);
        } else {
            return response([
                'error' => 'Invalid Product Id'
            ], 401);
        }
    }

    public function get_all_review($id)
    {
        $data = Rating::join('users', 'users.id', '=', 'ratings.user_id')
            ->select('users.name as UserName', 'ratings.*')
            ->where('product_id', $id)->get();

        return response([
            $data
        ], 201);
    }
}