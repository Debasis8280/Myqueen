<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;

class APIWelcomeController extends Controller
{
    public function all_products()
    {
        if (request()->lang == 'ch') {
            $data = Product::select('productimagec as image', 'title', 'saleprice', 'size', 'id')->get();
        } else {
            $data = Product::select('productimagee as image', 'title', 'saleprice', 'size', 'id')->get();
        }
        return response([
            'products' => $data,
        ], 201);
    }


    public function all_country()
    {
        $countries = new Countries();
        $all = $countries->all()->pluck('name.common')->toArray();
        return response([
            'countrys' => $all
        ], 201);
    }
}