<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class AdminWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Wallet::join('users', 'users.id', '=', 'wallets.user_id')
            ->select('wallets.*', 'users.name')
            ->orderBy('wallets.id', 'desc')
            ->get();
        echo  $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    public function show_details()
    {
        $data = Wallet::join('users', 'users.id', '=', 'wallets.user_id')
            ->select('wallets.*', 'users.name', 'users.email', 'users.phone')
            ->where('wallets.id', request()->id)->first();
        echo  json_encode($data);
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
            'id' => 'required|exists:wallets,id',
        ]);

        Wallet::where('id', $request->id)->update([
            'status' => 1
        ]);

        $data = Wallet::where('id', $request->id)->first();
        $user = User::where('id', $data->user_id)->first();

        User::where('id', $data->user_id)->update([
            'wallet' => $user->wallet + $data->amount
        ]);

        echo json_encode(['status' => 'success', 'message' => 'Approve successfully']);
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