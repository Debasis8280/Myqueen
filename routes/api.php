<?php

use App\Http\Controllers\API\APIAuthController;
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

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [APIAuthController::class, 'logout']);

    Route::post('/d', function () {
        echo "ads";
    });
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });