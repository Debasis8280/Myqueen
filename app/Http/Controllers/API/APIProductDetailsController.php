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

        return response(
            $data,
            201
        );
    }


    public function add_review(Request $request)
    {
        $check = Rating::where('user_id', $request->user()->id)->where('product_id', $request->product_id)->first();
        if (!$check) {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'message'    => 'required',
                'rating'     => 'required|numeric'
            ], [
                'product_id.required' => 'Product Id Required',
                'message.required'    => 'Please Type Some Message'
            ]);
            Rating::create([
                'user_id'       => $request->user()->id,
                'product_id'    => $request->product_id,
                'message'       => $request->message,
                'rating'        => $request->rating
            ]);
            $data = ['status' => 'success', 'message' => 'Rating Add Successfully'];
        } else {
            $data = ['status' => 'faild', 'message' => 'You Already Rating This Product'];
        }

        return response([
            $data
        ], 201);
    }
}