<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', 'UsersController@create');
Route::post('otp_verification', 'UsersController@otp_verification');
Route::post('login', 'UsersController@login');
Route::middleware(['auth:api'])->group(function(){
    //core
    Route::get('profile', 'UsersController@profile');
    Route::post('logout', 'UsersController@logout');
    Route::post('user-list', 'UsersController@list');
    //seller product
    Route::post('product-list', 'ProductController@list');
    Route::get('product-detail/{app_id}', 'ProductController@detail');
    Route::post('product-create', 'ProductController@create');
    Route::post('product-update-sales','ProductController@update_sales');
    Route::post('product-update-photo','ProductController@update_photo');
    Route::post('product-publish','ProductController@publish');
    //seller info
    Route::get('seller-info', 'SellerController@info');
    Route::post('seller-update', 'SellerController@update');
    Route::post('seller-update-dealer', 'SellerController@update_dealer');
    //agent info
    Route::get('agent-info', 'AgentController@info');
    Route::post('agent-update', 'AgentController@update');
    //Ref Brand
    Route::post('brand-list', 'RefBrandController@list');
    Route::post('brand-create', 'RefBrandController@create');
    Route::post('brand-update', 'RefBrandController@update');
    Route::delete('brand-delete', 'RefBrandController@delete');
    //product type list
    Route::post('product-type-list', 'ProductTypeController@list');
    Route::post('product-type-create', 'ProductTypeController@create');
    Route::post('product-type-update', 'ProductTypeController@update');
    Route::delete('product-type-delete', 'ProductTypeController@delete');
    //agent product explore
    Route::post('product-explore', 'ProductExploreController@list');
    //slider info
    Route::get('slider-list', 'SliderInfoController@list');
    Route::post('slider-create', 'SliderInfoController@create');
    Route::post('slider-update', 'SliderInfoController@update');
    Route::delete('slider-delete', 'SliderInfoController@delete');
    //news
    Route::get('news-list', 'NewsController@list');
    Route::post('news-create', 'NewsController@create');
    Route::post('news-update', 'NewsController@update');
    Route::delete('news-delete', 'NewsController@delete');
});
