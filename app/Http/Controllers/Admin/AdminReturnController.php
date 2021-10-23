<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rack;
use App\Models\Returns;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class AdminReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Returns::leftJoin('warehouses', 'warehouses.id', '=', 'returns.warehouseid')
            ->leftJoin('racks', 'racks.id', '=', 'returns.rackid')
            ->leftJoin('products', 'products.id', '=', 'returns.productid')
            ->select('products.title', 'products.productimagee', 'returns.*', 'warehouses.name as wname', 'racks.name as rname')->orderBy('returns.id', 'desc')->get();
        echo json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $warehouse = Warehouse::where('status', 1)->get();
        $product = Product::all();
        echo json_encode(['warehouse' => $warehouse, 'product' => $product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'productid'     => 'required',
            'warehouseid'   => 'required',
            'rackid'        => 'required',
            'quantity'      => 'required',
            'date'          => 'required',
            'status'        => 'required',
        ], [
            'productid.required' => 'Please Select Product',
            'warehouseid.required'   => 'Please Select Warehouse',
            'rackid.required'        => 'Please Select Rack',
            'quantity.required'      => 'Please Enter Quantity',
            'date.required'          => 'Please Select Return Date',
            'status.required'        => 'Please Select Status',
        ]);

        Returns::create($data);
        echo json_encode(['status' => 'success', 'message' => "Return Add Successfully"]);
    }

    // show return data
    public function showReturnDataById()
    {
        $data = Returns::leftJoin('warehouses', 'warehouses.id', '=', 'returns.warehouseid')
            ->leftJoin('racks', 'racks.id', '=', 'returns.rackid')
            ->leftJoin('products', 'products.id', '=', 'returns.productid')
            ->select('products.title', 'products.productimagee', 'returns.*', 'warehouses.name as wname', 'racks.name as rname')
            ->where('returns.id', request()->id)->first();
        $warehouse = Warehouse::where('status', 1)->get();
        $rack = Rack::get();
        echo json_encode(['data' => $data, 'warehouse' => $warehouse, 'rack' => $rack]);
    }

    // update retutn

    public function updateReturn(Request $request)
    {
        $data = $request->validate([
            'id'     => 'required',
            'warehouseid'   => 'required',
            'rackid'        => 'required',
            'quantity'      => 'required',
            'date'          => 'required',
            'status'        => 'required',
        ], [
            'id.required' => 'Please Select Product',
            'warehouseid.required'   => 'Please Select Warehouse',
            'rackid.required'        => 'Please Select Rack',
            'quantity.required'      => 'Please Enter Quantity',
            'date.required'          => 'Please Select Return Date',
            'status.required'        => 'Please Select Status',
        ]);

        Returns::where('id', $request->id)->update($data);
        echo json_encode(['status' => 'success', 'message' => "Return Update Successfully"]);
    }


    // delete return
    public function deleteReturn()
    {
        Returns::where('id', request()->id)->delete();
        echo json_encode(['status' => 'success', 'message' => 'Return Delete Successfully']);
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