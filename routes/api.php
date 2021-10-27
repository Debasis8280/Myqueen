<?php

use App\Http\Controllers\API\APIAuthController;
use App\Http\Controllers\API\APICartController;
use App\Http\Controllers\API\APIProductDetailsController;
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

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [APIAuthController::class, 'logout']);

    Route::post('add_to_cart', [APICartController::class, 'add_to_cart']);
    Route::get('cart_count', [APICartController::class, 'cart_count']);
    Route::post('add_review', [APIProductDetailsController::class, 'add_review']);
    Route::get('cart_list', [APICartController::class, 'cart_list']);
    Route::post('update_cart', [APICartController::class, 'update_cart']);
    Route::post('delete_from_cart', [APICartController::class, 'delete_from_cart']);
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });