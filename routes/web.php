<?php

// Namespace App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AddressController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Contact Routes
    Route::get('/app/index', 'App\Http\Controllers\ContactController@index'); //->name('index');
    Route::post('/app/createContact', 'App\Http\Controllers\ContactController@createContact'); //->name('createContact');
    Route::post('/app/Contacts/editContact', 'App\Http\Controllers\ContactController@editContact')->name('editContact');
    Route::post('/app/Contacts/deleteContact', 'App\Http\Controllers\ContactController@deleteContact')->name('deleteContact');

// Addresses Routes
    Route::get('/Addresses/details', 'App\Http\Controllers\ContactController@details')->name('details');
    Route::post('/Addresses/createAddress', 'App\Http\Controllers\ContactController@createAddress')->name('createAddress');
    Route::post('/Addresses/editAddress', 'App\Http\Controllers\ContactController@editAddress')->name('editAddress');
    Route::post('/Addresses/deleteAddress', 'App\Http\Controllers\ContactController@deleteAddress')->name('deleteAddress');

// ue Spa
Route::any('{slug}', function(){
    return view('welcome');
});
