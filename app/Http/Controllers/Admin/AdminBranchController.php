<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class AdminBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Branch::join('warehouses', 'warehouses.id', '=', 'branches.ware_house_id')
            ->select('branches.*', 'warehouses.name as wname')
            ->get();
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
        $data = $request->validate(
            [
                'ware_house_id' => 'required|exists:warehouses,id',
                'name'     => 'required|unique:branches',
                'detail'   => 'required',
                'address'  => 'required',
                'pincode'  => 'required|numeric',
                'country'  => 'required',

            ],
            [
                'ware_house_id.required' => "Please Select Warehouse",
                'name.required'     => 'Please Enter  Name',
                'detail.required'   => 'Please Enter detail',
                'address.required'  => 'Please Enter Address',
                'pincode.required'  => 'Please Enter Pincode',
                'country.required'  => 'Please Enter country',

            ]
        );

        Branch::create($data);
        echo json_encode(['status' => 'success', 'message' => 'Branche Create Successfully']);
    }

    // edit branch
    public function showEditData()
    {
        $data = Branch::where('id', request()->id)->first();
        echo $data;
    }

    // update branch
    public function updateBranch(Request $request)
    {
        $data = $request->validate(
            [
                'ware_house_id' => 'required|exists:warehouses,id',
                'name'     => 'required|unique:branches,name,' . $request->id,
                'detail'   => 'required',
                'address'  => 'required',
                'pincode'  => 'required|numeric',
                'country'  => 'required',

            ],
            [
                'ware_house_id.required' => "Please Select Warehouse",
                'name.required'     => 'Please Enter  Name',
                'detail.required'   => 'Please Enter detail',
                'address.required'  => 'Please Enter Address',
                'pincode.required'  => 'Please Enter Pincode',
                'country.required'  => 'Please Enter country',

            ]
        );

        Branch::where('id', $request->id)->update($data);
        echo json_encode(['status' => 'success', 'message' => 'Branche Create Successfully']);
    }

    // delete branch
    public function deleteBranch()
    {
        Branch::where('id', request()->id)->delete();
        echo json_encode(['status' => 'success', 'message' => 'Branch Delete Successfully']);
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