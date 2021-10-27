<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
}