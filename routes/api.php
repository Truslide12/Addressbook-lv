<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiContactsController;

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

Route::prefix('contacts')->group(function () {
    Route::get('/', [ApiContactsController::class, 'getIndex']);
    Route::get('/{contact}', [ApiContactsController::class, 'getItem']);
    Route::put('/{contact}', [ApiContactsController::class, 'putItem']);
    Route::delete('/{contact}', [ApiContactsController::class, 'deleteItem']);
    Route::post('/', [ApiContactsController::class, 'postItem']);
});

Route::prefix('addresses')->group(function () {
    Route::get('/', [ApiContactsController::class, 'getAddressIndex']);
    Route::get('/{address}', [ApiContactsController::class, 'getAddressItem']);
    Route::put('/{address}', [ApiContactsController::class, 'putAddressItem']);
    Route::delete('/{address}', [ApiContactsController::class, 'deleteAddressItem']);
    Route::post('/', [ApiContactsController::class, 'postAddressItem']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
