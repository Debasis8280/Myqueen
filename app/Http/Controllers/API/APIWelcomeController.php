<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Country;
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


    public function get_country_code()
    {
        $data = Country::get();
        foreach ($data as $item) {
            $code[] = ['code' => $item->name . '(' . $item->phonecode . ')'];
        }
        return response(
            $code
        );
    }


    public function search()
    {
        $product = Product::where('title', 'Like', '%' . request()->term . '%')->get();
        if ($product->count() > 0) {
            foreach ($product as $item) {
                $data[] = ['id' => $item->id, 'image' => $item->productimagee, 'saleprice' => $item->saleprice, 'size' => $item->size, 'title' => $item->title];
            }
        } else {
            $data[] = ['label' => 'Not Found', 'id' => 0];
        }
        return response($data, 201);
    }
}