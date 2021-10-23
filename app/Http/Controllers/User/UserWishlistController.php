<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class UserWishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('font.wishlist.index');
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
            $data = Wishlist::join('products', 'products.id', '=', 'wishlists.product_id')
                ->select(
                    ' products.productimagec as image',
                    'products.title',
                    'products.saleprice',
                    'products.size',
                    'products.id',
                    'wishlists.id as wish_id'
                )
                ->where('wishlists.user_id', Auth::user()->id)->get();
        } else {
            $data = Wishlist::join('products', 'products.id', '=', 'wishlists.product_id')
                ->select(
                    'products.productimagee as image',
                    'products.title',
                    'products.saleprice',
                    'products.size',
                    'products.id',
                    'wishlists.id as wish_id'
                )
                ->where('wishlists.user_id', Auth::user()->id)->get();
        }

        echo json_encode($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = Wishlist::where('product_id', $request->product_id)->where('user_id', Auth::user()->id)->first();
        if ($check) {
            Wishlist::where('product_id', $request->product_id)->where('user_id', Auth::user()->id)->delete();
            $data = ['status' => 'success', 'message' => 'Removed from your Wishlist', 'color' => ''];
        } else {
            Wishlist::create([
                'user_id'       => Auth::user()->id,
                'product_id'    => $request->product_id
            ]);
            $data = ['status' => 'success', 'message' => 'Added to your Wishlist', 'color' => 'red'];
        }
        echo json_encode($data);
    }

    // public function remove_wi

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