<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class AdminCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $coupon = Coupon::all();
        echo $coupon;
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
            'coupon_number'     => 'required|unique:coupons,number',
            'coupon_select'     => 'required',
            'coupon_discount'   => 'required|numeric'
        ], [
            'coupon_number.required'     => 'Please Generate Coupon Number',
            'coupon_select.required'     => 'Please Select Discount Type',
            'coupon_discount.required'   => 'Please Enter Number'
        ]);

        Coupon::create([
            'number'            => $request->coupon_number,
            'discount_type'     => $request->coupon_select,
            'discount_number'   => $request->coupon_discount
        ]);
        echo json_encode(['status' => 'success', 'message' => 'Coupon Generate Successfully']);
    }

    public function deleteCoupon()
    {
        Coupon::where('id', request()->id)->delete();
        echo json_encode(['status' => 'success', 'message' => 'Coupon Delete Successfully']);
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