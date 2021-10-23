<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forcast;
use Illuminate\Http\Request;

class AdminForcastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Forcast::leftJoin('orderitems', 'orderitems.order_id', '=', 'forcasts.orderid')
            ->leftJoin('orders', 'orders.id', '=', 'orderitems.order_id')
            ->leftJoin('products', 'products.id', '=', 'orderitems.product_id')
            ->leftjoin('orderstatus as status', 'orders.statusid', '=', 'status.id')
            ->select('forcasts.id', 'products.productimagee as image', 'products.title as productname', 'orderitems.quantity', 'orders.statusid', 'status.name as orderststus', 'forcasts.created_at as cdate')
            ->where('orders.statusid', '=', 1)
            ->orWhere('orders.statusid', '=', 2)->get();

        echo $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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