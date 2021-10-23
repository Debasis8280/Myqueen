<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Rack;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class AdminInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.inventory.index');
    }


    // add ware house
    public function addWarehouse(Request $request)
    {
        $data = $request->validate(
            [
                'name'      => 'required|unique:warehouses,name',
                'country'   => 'required',
                'detail'    => '',
                'status'    => 'required'
            ],
            [
                'name.required'     => 'Please Enter Warehouse Name',
                'country.required' => 'Please Select Country',
                'Detail.required'   => "Please Enter Details",
                'status.required'   => 'Please Select Status'
            ]
        );

        Warehouse::create($data);

        echo json_encode(['status' => 'success', 'message' => 'Warehouse Create Successfully']);
    }

    // show showWareHouse
    public function showWareHouse()
    {
        $list = Warehouse::orderBy('id', 'desc')->get();
        echo $list;
    }

    // add rack
    public function addRack(Request $request)
    {
        $data = $request->validate([
            'warehouses_id' => 'required',
            'name' => 'required|unique:racks,name'
        ], [
            'warehouses_id.required' => "Please Select Warehouse",
            'name.required' => 'Please Enter Rack Name'
        ]);
        $data['status'] = 1;
        Rack::create($data);
        echo json_encode(['status' => 'success', 'message' => 'Rack Create Successfully']);
    }

    // get rack with warehouse

    public function showRack()
    {
        $data = Rack::where('warehouses_id', request()->id)->get();
        echo $data;
    }

    // delete ware house
    public function delete_ware_house()
    {
        $data = Warehouse::where('id', request()->id)->first();
        Rack::where('warehouses_id', $data->id)->delete();
        Warehouse::where('id', request()->id)->delete();
        echo json_encode(['status' => 'success', 'message' => 'Delete Successfully']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Inventory::leftJoin('warehouses', 'warehouses.id', '=', 'inventories.warehouseid')
            ->leftJoin('racks', 'racks.id', '=', 'inventories.rackid')
            ->leftJoin('products', 'products.id', '=', 'inventories.productid')
            ->select('products.productimagee', 'products.title', 'inventories.*', 'warehouses.name as wname', 'racks.name as rname')->orderBy('inventories.id', 'desc')->get();
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
        $data = $request->validate([
            'productid'   => 'required',
            'warehouseid' => 'required',
            'rackid'      => Inventory::where('productid', $request->productid)->where('rackid', $request->rackid)->first() ? 'required|unique:inventories,rackid' : 'required',
            'stock'       => 'required|numeric',
        ], [
            'productid.required'   => 'Please Select Product',
            'warehouseid.required' => 'Please Select Warehouse',
            'rackid.required'      => 'Please Select Rack',
            'stock.required'       => 'Please Enter Stock',
            'rackid.unique'        => 'Product Already Present In This Rack! Please Edit '
        ]);
        Inventory::create($data);
        echo json_encode(['status' => 'success', 'message' => "Stock Add Successfully"]);
    }

    // get all Data
    public function getAllWarehouseDetails()
    {
        $warehouse = Warehouse::where('status', 1)->get();
        $product = Product::all();
        echo json_encode(['warehouse' => $warehouse, 'product' => $product]);
    }


    // edit inventory
    public function showeditinventoryData()
    {
        $data = Inventory::leftJoin('warehouses', 'warehouses.id', '=', 'inventories.warehouseid')
            ->leftJoin('racks', 'racks.id', '=', 'inventories.rackid')
            ->leftJoin('products', 'products.id', '=', 'inventories.productid')
            ->select('products.title', 'products.productimagee', 'inventories.*', 'warehouses.name as wname', 'racks.name as rname')
            ->where('inventories.id', request()->id)->first();
        $warehouse = Warehouse::where('status', 1)->get();
        $rack = Rack::get();
        echo json_encode(['data' => $data, 'warehouse' => $warehouse, 'rack' => $rack]);
    }

    // update inventory
    public function updateInventory(Request $request)
    {
        $data = $request->validate([
            'id'     => 'required',
            'warehouseid'   => 'required',
            'rackid'        => 'required',
            'stock'         => 'required|numeric',
        ], [
            'productid.required'   => 'Please Select Product',
            'warehouseid.required' => 'Please Select Warehouse',
            'rackid.required'      => 'Please Select Rack',
            'stock.required'       => 'Please Enter Stock'
        ]);

        Inventory::where('id', $request->id)->update($data);
        echo json_encode(['status' => 'success', 'message' => 'Stock Update Successfully']);
    }

    // delete
    public function deleteInventory()
    {
        Inventory::where('id', request()->id)->delete();
        echo json_encode(['status' => 'success', 'message' => "Stock Delete Successfully", 's' => request()->id]);
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