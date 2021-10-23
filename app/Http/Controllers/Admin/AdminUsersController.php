<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = User::orderBy('id', 'desc')->get();
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
        // $validatedData = $request->validate([
        //     'firstname' => 'required|max:55',
        //     'lastname' => 'required',
        //     'password' => 'required',
        //     'email' => '',
        //     'phone' => '',

        // ]);

        // $data = User::create($validatedData);
        // return back()->with('msg', 'User Added successfully');
    }

    // delete users
    public function deleteUser()
    {
        User::where('id', request()->id)->delete();
        echo json_encode(['status' => 'success', 'message' => 'User Delete Successfully']);
    }


    // admin edit user details function logic
    public function updateUser(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required',
            'email'      => 'required|email:rfc,dns|unique:users,email,' . $request->id,
            'phone'      => 'required|numeric',
        ]);
        $data = User::where('id', $request->id)->update($data);
        echo json_encode(['status' => 'success', 'message' => 'User Update Successfully']);
    }

    public function getUserDetails(Request $request)
    {
        $user = User::find($request->id);
        echo json_encode($user);
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