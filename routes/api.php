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
Route::post('register-seller-independent', 'UsersController@create_seller_independent');
Route::post('register-seller-dealer', 'UsersController@create_seller_dealer');
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
    //District
    Route::post('district-list', 'DistrictController@list');
    Route::post('district-create', 'DistrictController@create');
    Route::post('district-update', 'DistrictController@update');
    Route::delete('district-delete', 'DistrictController@delete');
    //Region
    Route::post('region-list', 'RegionController@list');
    Route::post('region-create', 'RegionController@create');
    Route::post('region-update', 'RegionController@update');
    Route::delete('region-delete', 'RegionController@delete');
    //RefProductOwner
    Route::post('product-owner-list', 'RefProductOwnerController@list');
    Route::post('product-owner-create', 'RefProductOwnerController@create');
    Route::post('product-owner-update', 'RefProductOwnerController@update');
    Route::delete('product-owner-delete', 'RefProductOwnerController@delete');
    //RefBodyType
    Route::post('body-type-list', 'RefBodyTypeController@list');
    Route::post('body-type-create', 'RefBodyTypeController@create');
    Route::post('body-type-update', 'RefBodyTypeController@update');
    Route::delete('body-type-delete', 'RefBodyTypeController@delete');
    //RefVehiclesCode
    Route::post('vehicles-code-list', 'RefVehiclesCodeController@list');
    Route::post('vehicles-code-create', 'RefVehiclesCodeController@create');
    Route::post('vehicles-code-update', 'RefVehiclesCodeController@update');
    Route::delete('vehicles-code-delete', 'RefVehiclesCodeController@delete');

    //RefMachineCapacity
    Route::post('machine-capacity-list', 'RefMachineCapacityController@list');
    Route::post('machine-capacity-create', 'RefMachineCapacityController@create');
    Route::post('machine-capacity-update', 'RefMachineCapacityController@update');
    Route::delete('machine-capacity-delete', 'RefMachineCapacityController@delete');

    //RefColor
    Route::post('color-list', 'RefColorController@list');
    Route::post('color-create', 'RefColorController@create');
    Route::post('color-update', 'RefColorController@update');
    Route::delete('color-delete', 'RefColorController@delete');

    //RefMilage
    Route::post('mileage-list', 'RefMileageController@list');
    Route::post('mileage-create', 'RefMileageController@create');
    Route::post('mileage-update', 'RefMileageController@update');
    Route::delete('mileage-delete', 'RefMileageController@delete');

    //RefVariant
    Route::post('variant-list', 'RefVariantController@list');
    Route::post('variant-create', 'RefVariantController@create');
    Route::post('variant-update', 'RefVariantController@update');
    Route::delete('variant-delete', 'RefVariantController@delete');
    //agent product explore
    Route::post('product-explore', 'ProductExploreController@list');
    Route::get('product-explore-detail/{app_id}', 'ProductExploreController@detail');
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
    //Etalase
    Route::post('etalase-list', 'EtalaseController@list');
});
