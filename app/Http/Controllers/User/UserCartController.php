<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class UserCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('font.cart.index');
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
            $data = Cart::join('products', 'products.id', '=', 'carts.product_id')
                ->select('products.productimagec as image', 'products.title', 'carts.quentity', 'products.saleprice', 'products.id as product_id', 'carts.id as cart_id')
                ->where('carts.user_id', Auth::user()->id)->get();
        } else {
            $data = Cart::join('products', 'products.id', '=', 'carts.product_id')
                ->select('products.productimagee as image', 'products.title', 'carts.quentity', 'products.saleprice', 'products.id as product_id', 'carts.id as cart_id')
                ->where('carts.user_id', Auth::user()->id)->get();
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
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ], [
            'product_id.required'  => "Please Refresh Somthing Wrong"
        ]);

        $chekc = Cart::where('product_id', $request->product_id)->where('user_id', Auth::user()->id)->first();
        if ($chekc) {
            Cart::where('product_id', $request->product_id)->where('user_id', Auth::user()->id)->update([
                'quentity' => $chekc->quentity + $request->quentity
            ]);
        } else {
            Cart::create([
                'user_id'       => Auth::user()->id,
                'product_id'    => $request->product_id,
                'quentity'      => $request->quentity
            ]);
        }

        echo json_encode(['status' => 'success', 'message' => 'Product Add Successfully']);
    }

    public function update_cart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'cart_id'    => 'required|exists:carts,id',
            'quentity'   =>  'required'
        ], [
            'product_id.required' => 'Please Refresh Something Wrong',
            'cart_id.required'    => 'Please Refresh Something Wrong',
            'quentity.required'   => 'Please Add Quentity'
        ]);


        Cart::where('id', $request->cart_id)->where('product_id', $request->product_id)->where('user_id', Auth::user()->id)->update([
            'quentity' => $request->quentity
        ]);

        $show =  Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->select('products.title', 'carts.quentity')
            ->where('carts.id', $request->cart_id)
            ->where('carts.product_id', $request->product_id)
            ->where('carts.user_id', Auth::user()->id)->first();

        echo json_encode(['status' => 'success', 'message' => "You changed '" . $show->title . "' QUANTITY to '" . $show->quentity . "'"]);
    }

    public function delete_from_cart(Request $request)
    {
        $request->validate([
            'product_id'    => 'required|exists:products,id',
            'cart_id'       => 'required|exists:carts,id'
        ], [
            'product_id.required' => 'Please Refresh Something Wrong',
            'cart_id.required'    => 'Please Refresh Something Wrong',
        ]);

        Cart::where('id', $request->cart_id)->where('product_id', $request->product_id)->where('user_id', Auth::user()->id)->delete();

        echo json_encode(['status' => 'success', 'message' => 'Successfully removed']);
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