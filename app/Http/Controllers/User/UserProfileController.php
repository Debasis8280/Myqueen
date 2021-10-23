<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PvPoint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('font.profile.index');
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
        $data = $request->validate([
            'name' => 'required',
            'email' => 'email|unique:users,email,' . Auth::user()->id,
            'phone' => 'required|numeric',
            'image' => 'nullable|image',
        ], [
            'name.required' => 'Please Enter Name',
            'email.required' => 'Please Enter Email',
            'phone.required' => 'Please Enter Phone Number',
        ]);

        if ($request->hasFile('image')) {
            File::delete(Auth::user()->image);
            $path = $request->image->storeAs('Profile/', Auth::user()->unique_id . date('d_m_y') . "." . $request->image->extension());
            $data['image'] = $path;
        }

        User::where('id', Auth::user()->id)->update($data);
        echo json_encode(['status' => 'success', 'message' => 'Profile Update Successfully']);
    }


    public function get_pv_point_history()
    {
        $data = PvPoint::join('orders', 'orders.id', '=', 'pv_points.order_id')
            ->select('orders.order_unique', 'pv_points.created_at as date', 'pv_points.point')
            ->where('pv_points.user_id', Auth::user()->id)->get();
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