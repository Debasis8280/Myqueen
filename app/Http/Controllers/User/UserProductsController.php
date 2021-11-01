<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class UserProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo json_encode(URL::signedRoute('users.product_details.show', ['id' => request()->id]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lang = Config::get('app.locale');
        if ($lang == 'ch-s' || $lang == 'ch-t') {
            $product    = Product::where('id', request()->id)
                ->select(
                    'productimagec as image',
                    'title',
                    'saleprice',
                    'size',
                    'galleryimagec as gallery_image',
                    'main_components_image_chn as maindesc',
                    'description',
                    'features as effect',
                    'effects_image_chn as effect_img',
                    'usemethod as use_method',
                    'method_image_chn as method_img'

                )->first();
        } else {
            $product    = Product::where('id', request()->id)
                ->select(
                    'productimagee as image',
                    'title',
                    'saleprice',
                    'size',
                    'galleryimagee as gallery_image',
                    'main_components_image_eng as maindesc',
                    'description',
                    'features as effect',
                    'effects_image_eng as effect_img',
                    'usemethod as use_method',
                    'method_image_eng as method_img'
                )->first();
        }

        echo json_encode($product);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = Rating::where('user_id', Auth::user()->id)->where('product_id', $request->product_id)->first();
        if (!$check) {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'message'    => 'required',
            ], [
                'product_id.required' => 'Please Refresh Somthing Wrong',
                'message.required'    => 'Please Type Some Message'
            ]);
            Rating::create([
                'user_id'       => Auth::user()->id,
                'product_id'    => $request->product_id,
                'message'       => $request->message,
                'rating'        => $request->rating_point
            ]);
            $data = ['status' => 'success', 'message' => 'Rating Add Successfully'];
        } else {
            $data = ['status' => 'faild', 'message' => 'You Already Rating This Product'];
        }
        echo json_encode($data);
    }

    public function show_product_rating()
    {
        $data = Rating::join('users', 'users.id', 'ratings.user_id')
            ->where('ratings.product_id', request()->product_id)
            ->select('users.name', 'ratings.created_at as date', 'ratings.message', 'ratings.rating')
            ->get();
        echo json_encode($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('font.product-details.index');
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