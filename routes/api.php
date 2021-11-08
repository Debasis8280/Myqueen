<?php

use App\Http\Controllers\API\APIAuthController;
use App\Http\Controllers\API\APICartController;
use App\Http\Controllers\API\APIOrderController;
use App\Http\Controllers\API\APIProductDetailsController;
use App\Http\Controllers\API\APIProfileController;
use App\Http\Controllers\API\APIWelcomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('v1/login', [APIAuthController::class, 'login']);
Route::post('v1/register', [APIAuthController::class, 'register']);
Route::get('v1/all_products', [APIWelcomeController::class, 'all_products']);
Route::get('v1/product_details/{id}', [APIProductDetailsController::class, 'product_details']);
Route::get('v1/get_all_review/{id}', [APIProductDetailsController::class, 'get_all_review']);
Route::get('v1/all_country', [APIWelcomeController::class, 'all_country']);
Route::get('v1/phone_code', [APIWelcomeController::class, 'get_country_code']);
Route::post('v1/search', [APIWelcomeController::class, 'search']);

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [APIAuthController::class, 'logout']);

    Route::post('add_to_cart', [APICartController::class, 'add_to_cart']);
    Route::get('cart_count', [APICartController::class, 'cart_count']);
    Route::post('add_review', [APIProductDetailsController::class, 'add_review']);
    Route::get('cart_list', [APICartController::class, 'cart_list']);
    Route::post('update_cart', [APICartController::class, 'update_cart']);
    Route::post('delete_from_cart', [APICartController::class, 'delete_from_cart']);
    Route::post('delivery_charge', [APIOrderController::class, 'delivery_charge']);
    Route::post('coupon', [APIOrderController::class, 'check_coupon']);
    Route::post('payment_qrcode', [APIOrderController::class, 'payment_qrcode']);
    Route::post('order_store', [APIOrderController::class, 'store_order']);
    Route::get('redirect_thanks', [APIOrderController::class, 'redirect_thanks']);



    Route::get('profile_data', [APIProfileController::class, 'profile_data']);
    Route::get('get_pv_point', [APIProfileController::class, 'get_pv_point']);
    Route::get('order_history', [APIProfileController::class, 'order_history']);
    Route::get('wallet_history', [APIProfileController::class, 'wallet_history']);
    Route::get('order_history_details', [APIOrderController::class, 'order_history_details']);
    Route::post('edit_profile', [APIProfileController::class, 'edit_profile']);
    Route::get('address', [APIProfileController::class, 'address']);
    Route::get('pending_payment', [APIProfileController::class, 'pending_payment']);
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });