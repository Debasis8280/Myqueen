<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserWalletController extends Controller
{
    public function show_royalty_page()
    {
        return view('font.wallet.index');
    }


    public function get_qr_code_for_wallet()
    {
        request()->validate([
            'amount' => 'required|numeric'
        ], [
            'amount.required' => 'Please Enter Amount'
        ]);
        $postArray = array();
        $postArray['user_id'] = 'S111417';
        $postArray["user_password"] = md5('S111417' . '4ba2e90ba890799fb708e9f0bca9a648');
        $postArray['amount'] = request()->amount;
        $postArray['notify_url'] = 'd';
        $sign_string = md5($postArray['user_id'] . $postArray["user_password"] . $postArray['amount'] . $postArray['notify_url'] . '4ba2e90ba890799fb708e9f0bca9a648');
        $postArray["sign_string"] = $sign_string;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://mctpayment.com/dci/api_v2/get_fixed_amount_qrcode');
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postArray);
        $response = curl_exec($ch);
        echo $response;
    }


    public function store_wallet_payment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric'
        ], [
            'amount.required' => 'Please Enter Amount'
        ]);

        if ($request->mct_pay == null && $request->pay_now == null) {
            $request->validate([
                'select_one' => 'required'
            ], [
                'select_one.required' => 'Please Select One Payment Option'
            ]);
        }
        $image = null;

        if ($request->mct_pay != null) {
            $payment_type = "MCT Pay";
        }
        if ($request->pay_now != null) {
            $request->validate([
                'payment_screen_shot' => 'required|image'
            ], [
                'payment_screen_shot.required' => 'Please Upload Payment Screenshot'
            ]);
            $payment_type = "Pay Now";
            $image = $request->payment_screen_shot->storeAs('wallet/paynow', time() . "_" . $request->amount . '.' . $request->payment_screen_shot->extension());
        }

        Wallet::create([
            'user_id' => Auth::user()->id,
            'amount' => $request->amount,
            'screen_shot' => $image,
            'payment_type' => $payment_type,
        ]);

        echo json_encode(['status' => 'success', 'message' => 'Payment Successfully']);
    }


    public function get_all_payment()
    {
        $data = Wallet::join('users', 'users.id', '=', 'wallets.user_id')
            ->select('users.name', 'wallets.*')
            ->where('wallets.user_id', Auth::user()->id)->get();
        echo json_encode($data);
    }
}