<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/', 'AuthController@index')->middleware('guest')->name('landing');
Route::get('mitra', 'AgentCatalogueController@index');
Route::get('mitra-product', 'AgentCatalogueController@product');
Route::get('login', 'AuthController@index')->middleware('guest')->name('login');
Route::get('login-google', 'AuthController@login_google')->middleware('guest')->name('login_google');
Route::get('callback-google-oauth', 'AuthController@callback_google_oauth')->middleware('guest')->name('callback_google_oauth');
Route::get('register', 'AuthController@register')->middleware('guest')->name('register');
Route::post('register-form', 'AuthController@register_form')->middleware('guest')->name('register_form');
Route::get('register-form-agent', 'AuthController@register_form_agent')->middleware('guest')->name('register_form_agent');
Route::get('register-form-seller', 'AuthController@register_form_seller')->middleware('guest')->name('register_form_seller');
Route::get('register-otp/{app_id}', 'AuthController@register_otp')->middleware('guest')->name('register_otp');
Route::post('register-otp-process', 'AuthController@register_otp_process')->middleware('guest')->name('register_otp_process');
Route::post('register-agent', 'AuthController@register_agent')->middleware('guest')->name('register_agent');
Route::post('register-seller', 'AuthController@register_seller')->middleware('guest')->name('register_seller');
Route::get('register-seller-confirm/{app_id}', 'AuthController@register_seller_confirm')->middleware('guest')->name('register_seller_confirm');
Route::post('register-seller-confirm-submit', 'AuthController@register_seller_confirm_submit')->middleware('guest')->name('register_seller_confirm_submit');
Route::get('forgot-password', 'AuthController@forgot_password')->middleware('guest')->name('forgot_password');
Route::post('forgot-password-email', 'AuthController@forgot_password_email')->middleware('guest')->name('forgot_password_email');
Route::get('forgot-password-change', 'AuthController@forgot_password_change')->middleware('guest')->name('forgot_password_change');
Route::post('forgot-password-submit', 'AuthController@forgot_password_submit')->middleware('guest')->name('forgot_password_submit');
Route::get('account-verification', 'AuthController@account_verification')->middleware('guest')->name('account_verification');
Route::post('account-verification-email', 'AuthController@account_verification_email')->middleware('guest')->name('account_verification_email');
Route::get('gb-pricelist', 'AuthController@gb_pricelist')->middleware('guest')->name('gb_pricelist');
Route::get('roasted-pricelist', 'AuthController@roasted_pricelist')->middleware('guest')->name('roasted_pricelist');
Route::get('greenbeans', 'AuthController@gb_pricelist')->middleware('guest')->name('greenbeans');
Route::get('roastedbeans', 'AuthController@roasted_pricelist')->middleware('guest')->name('roastedbeans');

Route::post('auth-process', 'AuthController@auth_process');
Route::get('charity', 'CharityController@index')->middleware('guest');
Route::middleware(['auth:web'])->group(function(){
    //core
    Route::group(['prefix' => 'home'], function(){
        Route::get('/', 'HomeController@index')->name('home-index');
        Route::get('/product/list', 'HomeController@list_product')->name('home-list-product');
    });
    
    Route::get('news-detail/{app_id}', 'HomeController@news_detail')->name('home-news');
    Route::get('menu', 'HomeController@menu');
    Route::get('map-storage', 'HomeController@mapstorage');
    Route::get('menu-recipe', 'HomeController@menurecipe');
    Route::get('logout', 'AuthController@logout');
    Route::get('profile-reminder', 'ProfileController@reminder')->name('profile-reminder');
    Route::get('profile-agent-reminder', 'ProfileController@agent_reminder')->name('profile-agent-reminder');
    Route::get('profile', 'ProfileController@index')->name('profile-index');
    Route::get('profile-category', 'ProfileController@category')->name('profile-category');
    Route::get('profile-edit', 'ProfileController@edit')->name('profile-edit');
    Route::get('profile-edit-dealer', 'ProfileController@edit_dealer')->name('profile-edit-dealer');
    Route::post('profile-update-seller/{app_id}', 'ProfileController@update_seller')->name('profile-update-seller');
    Route::post('profile-update-dealer/{app_id}', 'ProfileController@update_dealer')->name('profile-update-dealer');
    Route::post('profile-update-agent/{app_id}', 'ProfileController@update_agent')->name('profile-update-agent');
    Route::get('profile-edit-password', 'ProfileController@edit_password')->name('profile-edit-password');
    Route::post('profile-update-password/{app_id}', 'ProfileController@update_password')->name('profile-update-password');
    Route::post('prodile/update-photo-profile', 'ProfileController@update_photo_profile')->name('profile-update-photo');

    Route::get('product-explore', 'ProductExploreController@list');
    Route::get('product-explore-search', 'ProductExploreController@search');
    Route::post('product-explore-search-result', 'ProductExploreController@search_result');
    Route::get('product-explore-detail/{app_id}', 'ProductExploreController@detail');
    Route::post('product-explore-etalase', 'ProductExploreController@etalase');
    Route::post('product-explore-unetalase', 'ProductExploreController@unetalase');


    Route::group(['prefix' => 'transaction'], function(){
        Route::get('/', 'TransactionVisitationController@list');
        Route::get('detail/waiting/{id}', 'TransactionVisitationController@detailWaiting');
        Route::get('detail/visitation/{id}', 'TransactionVisitationController@detailVisitation');
        Route::get('detail/done/{id}', 'TransactionVisitationController@detailDone');
        Route::get('checkout', 'TransactionVisitationController@checkout');
    });

    //Ref Customer
    Route::get('customer-list', 'CustomerController@list');
    Route::post('customer-combo', 'CustomerController@combo');
    Route::get('customer-add', 'CustomerController@add');
    Route::post('customer-create', 'CustomerController@create');
    Route::get('customer-detail/{app_id}', 'CustomerController@detail');
    Route::get('customer-edit/{app_id}', 'CustomerController@edit');
    Route::post('customer-update/{app_id}', 'CustomerController@update');
    Route::get('customer-delete/{app_id}', 'CustomerController@delete');

    //Ref Customer Store
    Route::get('customer-store-list', 'CustomerStoreController@list');
    Route::post('customer-store-combo', 'CustomerStoreController@combo');
    Route::get('customer-store-add', 'CustomerStoreController@add');
    Route::post('customer-store-create', 'CustomerStoreController@create');
    Route::get('customer-store-detail/{app_id}', 'CustomerStoreController@detail');
    Route::get('customer-store-edit/{app_id}', 'CustomerStoreController@edit');
    Route::post('customer-store-update/{app_id}', 'CustomerStoreController@update');
    Route::get('customer-store-delete/{app_id}', 'CustomerStoreController@delete');

    //Ref Vendor
    Route::get('vendor-list', 'VendorController@list');
    Route::post('vendor-combo', 'VendorController@combo');
    Route::get('vendor-add', 'VendorController@add');
    Route::post('vendor-create', 'VendorController@create');
    Route::get('vendor-detail/{app_id}', 'VendorController@detail');
    Route::get('vendor-edit/{app_id}', 'VendorController@edit');
    Route::post('vendor-update/{app_id}', 'VendorController@update');
    Route::get('vendor-delete/{app_id}', 'VendorController@delete');

    //Ref Investment
    Route::get('invest-list', 'InvestController@list');
    Route::post('invest-combo', 'InvestController@combo');
    Route::get('invest-add', 'InvestController@add');
    Route::post('invest-create', 'InvestController@create');
    Route::get('invest-detail/{app_id}', 'InvestController@detail');
    Route::get('invest-edit/{app_id}', 'InvestController@edit');
    Route::post('invest-update/{app_id}', 'InvestController@update');
    Route::get('invest-payment/{app_id}', 'InvestController@payment');
    Route::post('invest-pay/{app_id}', 'InvestController@pay');
    Route::get('invest-pay-delete', 'InvestController@payDelete');
    Route::get('invest-delete/{app_id}', 'InvestController@delete');

    //Ref Employee
    Route::get('employee-list', 'EmployeeController@list');
    Route::post('employee-combo', 'EmployeeController@combo');
    Route::post('employee-combo-owner', 'EmployeeController@comboOwner');
    Route::post('employee-combo-staff', 'EmployeeController@comboStaff');
    Route::get('employee-add', 'EmployeeController@add');
    Route::post('employee-create', 'EmployeeController@create');
    Route::get('employee-detail/{app_id}', 'EmployeeController@detail');
    Route::get('employee-edit/{app_id}', 'EmployeeController@edit');
    Route::post('employee-update/{app_id}', 'EmployeeController@update');
    Route::get('employee-delete/{app_id}', 'EmployeeController@delete');

    //Ref Vendor
    Route::get('periode-list', 'PeriodeController@list');
    Route::post('periode-combo', 'PeriodeController@combo');
    Route::get('periode-add', 'PeriodeController@add');
    Route::post('periode-create', 'PeriodeController@create');
    Route::get('periode-delete/{app_id}', 'PeriodeController@delete');

    // Share Profit
    Route::get('share-profit-list', 'ShareProfitController@list');
    Route::post('share-profit-combo', 'ShareProfitController@combo');
    Route::get('share-profit-add', 'ShareProfitController@add');
    Route::post('share-profit-create', 'ShareProfitController@create');
    Route::get('share-profit-detail/{app_id}', 'ShareProfitController@detail');
    Route::get('share-profit-edit/{app_id}', 'ShareProfitController@edit');
    Route::post('share-profit-update/{app_id}', 'ShareProfitController@update');
    Route::get('share-profit-delete/{app_id}', 'ShareProfitController@delete');
    Route::get('share-profit-share/{app_id}', 'ShareProfitController@share');
    Route::post('share-profit-share-create/{app_id}', 'ShareProfitController@shareCreate');
    Route::get('share-profit-share-delete/{app_id}', 'ShareProfitController@shareDelete');
    Route::get('share-profit-spending/{app_id}', 'ShareProfitController@spending');
    Route::post('share-profit-spending-combo', 'ShareProfitController@spendingcombo')->name('share-profit-spending-combo');
    Route::get('share-profit-spending-json', 'ShareProfitController@spendingjson')->name('share-profit-spending-json');
    Route::post('share-profit-spending-create/{app_id}', 'ShareProfitController@spendingCreate');
    Route::get('share-profit-calculate', 'ShareProfitController@calculate');
    Route::get('share-profit-emppart', 'ShareProfitController@emppart');
    Route::get('share-profit-publish/{app_id}', 'ShareProfitController@publish');

    // Fee Barista
    Route::get('barista-fee-list', 'BaristaFeeController@list');
    Route::post('barista-fee-combo', 'BaristaFeeController@combo');
    Route::post('barista-fee-comboperiod', 'BaristaFeeController@comboPeriod');
    Route::get('barista-fee-add', 'BaristaFeeController@add');
    Route::post('barista-fee-create', 'BaristaFeeController@create');
    Route::get('barista-fee-detail/{app_id}', 'BaristaFeeController@detail');
    Route::get('barista-fee-person/{app_id}', 'BaristaFeeController@person');
    Route::get('barista-fee-edit/{app_id}', 'BaristaFeeController@edit');
    Route::post('barista-fee-update/{app_id}', 'BaristaFeeController@update');
    Route::get('barista-fee-delete/{app_id}', 'BaristaFeeController@delete');
    Route::get('barista-fee-share/{app_id}', 'BaristaFeeController@share');
    Route::post('barista-fee-share-create/{app_id}', 'BaristaFeeController@shareCreate');
    Route::get('barista-fee-share-delete/{app_id}', 'BaristaFeeController@shareDelete');
    Route::get('barista-fee-total', 'BaristaFeeController@totalProfit');
    Route::get('barista-fee-calculate', 'BaristaFeeController@calculate');
    Route::get('barista-fee-publish/{app_id}', 'BaristaFeeController@publish');
    Route::get('barista-fee-printslip/{app_id}', 'BaristaFeeController@printslip');

    // store report
    Route::get('report-store', 'ReportStoreController@list');
    Route::get('report-store-add', 'ReportStoreController@add');
    Route::post('report-store-create', 'ReportStoreController@create');
    Route::get('report-store-detail/{app_id}', 'ReportStoreController@detail');
    Route::get('report-store-edit/{app_id}', 'ReportStoreController@edit');
    Route::post('report-store-update/{app_id}', 'ReportStoreController@update');
    Route::get('report-store-delete/{app_id}', 'ReportStoreController@delete');
    Route::get('report-store-spending-add/{app_id}', 'ReportStoreController@spendingAdd');
    Route::post('report-store-spending-create', 'ReportStoreController@spendingCreate');
    Route::get('report-store-spending-detail/{app_id}', 'ReportStoreController@spendingDetail');
    Route::post('report-store-update-final/{app_id}', 'ReportStoreController@updateFinal');
    Route::get('report-store-publish/{app_id}', 'ReportStoreController@publish');
    Route::get('report-store-verification/{app_id}', 'ReportStoreController@verification');
    Route::get('report-store-spending-delete/{app_id}', 'ReportStoreController@spendingDelete');

    //product type list
    Route::get('product-type-list', 'ProductTypeController@list');
    Route::post('product-type-combo', 'ProductTypeController@combo');
    Route::get('product-type-add', 'ProductTypeController@add');
    Route::post('product-type-create', 'ProductTypeController@create');
    Route::get('product-type-detail/{app_id}', 'ProductTypeController@detail');
    Route::get('product-type-edit/{app_id}', 'ProductTypeController@edit');
    Route::post('product-type-update/{app_id}', 'ProductTypeController@update');
    Route::get('product-type-delete/{app_id}', 'ProductTypeController@delete');

    //RefVariant
    Route::get('variant-list', 'RefVariantController@list');
    Route::post('variant-combo', 'RefVariantController@combo');
    Route::get('variant-add', 'RefVariantController@add');
    Route::post('variant-create', 'RefVariantController@create');
    Route::get('variant-detail/{app_id}', 'RefVariantController@detail');
    Route::get('variant-edit/{app_id}', 'RefVariantController@edit');
    Route::post('variant-update/{app_id}', 'RefVariantController@update');
    Route::get('variant-delete/{app_id}', 'RefVariantController@delete');

    Route::post('product-combo', 'ProductController@combo');
    Route::post('product-combo-gb', 'ProductController@combogb');
    Route::get('product-price-gb', 'ProductController@pricegb')->name('product-price-gb');
    Route::get('product-price-roasted', 'ProductController@priceroasted')->name('product-price-roasted');
    Route::get('product-search', 'ProductController@search')->name('product-search');
    Route::post('product-search-result', 'ProductController@search_result')->name('product-search-result');
    Route::get('product-list', 'ProductController@list')->name('product-list');
    Route::get('product-detail/{app_id}', 'ProductController@detail')->name('product-detail');
    Route::get('product-detail-json', 'ProductController@detail_json')->name('product-detail-json');
    Route::get('product-add', 'ProductController@add')->name('product-add');
    Route::post('product-create', 'ProductController@create')->name('product-create');
    Route::get('product-add-photo/{app_id}', 'ProductController@add_photo')->name('product-add-photo');
    Route::post('product-create-photo/{app_id}', 'ProductController@create_photo')->name('product-create-photo');
    Route::get('product-add-photo-interior/{app_id}', 'ProductController@add_photo_interior')->name('product-add-photo-interior');
    Route::post('product-create-photo-interior/{app_id}', 'ProductController@create_photo_interior')->name('product-create-photo-interior');
    Route::get('product-add-sales/{app_id}', 'ProductController@add_sales')->name('product-add-sales');
    Route::post('product-create-sales/{app_id}', 'ProductController@create_sales')->name('product-create-sales');
    Route::get('product-edit-category/{app_id}', 'ProductController@edit_category')->name('product-edit-category');
    Route::get('product-edit/{app_id}', 'ProductController@edit')->name('product-edit');
    Route::get('product-hpp-set/{app_id}', 'ProductController@hpp')->name('product-hpp');
    Route::get('product-stock-set/{app_id}', 'ProductController@stock')->name('product-stock');
    Route::get('product-edit-photo/{app_id}', 'ProductController@edit_photo')->name('product-edit-photo');
    Route::get('product-edit-photo-interior/{app_id}', 'ProductController@edit_photo_interior')->name('product-edit-photo-interior');
    Route::get('product-edit-sales/{app_id}', 'ProductController@edit_sales')->name('product-edit-sales');
    Route::post('product-update/{app_id}', 'ProductController@update')->name('product-update');
    Route::post('product-update-photo/{app_id}', 'ProductController@update_photo')->name('product-update-photo');
    Route::post('product-update-photo-interior/{app_id}', 'ProductController@update_photo_interior')->name('product-update-photo-interior');
    Route::post('product-update-sales/{app_id}', 'ProductController@update_sales')->name('product-update-sales');
    Route::post('product-hpp-update/{app_id}', 'ProductController@update_hpp')->name('product-update-hpp');
    Route::post('product-stock-update/{app_id}', 'ProductController@update_stock')->name('product-update-stock');
    Route::get('product-publish/{app_id}', 'ProductController@publish')->name('product-publish');
    Route::get('product-choosed/{app_id}', 'ProductController@choosed')->name('product-choosed');
    Route::get('product-sold/{app_id}', 'ProductController@sold')->name('product-sold');
    Route::get('product-print/{app_id}', 'ProductController@print');
    Route::get('product-delete/{app_id}', 'ProductController@delete')->name('product-delete');

    //body type
    Route::get('body-type-list', 'RefBodyTypeController@list');
    Route::get('body-type-add', 'RefBodyTypeController@add');
    Route::post('body-type-create', 'RefBodyTypeController@create');
    Route::get('body-type-detail/{app_id}', 'RefBodyTypeController@detail');
    Route::get('body-type-edit/{app_id}', 'RefBodyTypeController@edit');
    Route::post('body-type-update/{app_id}', 'RefBodyTypeController@update');
    Route::get('body-type-delete/{app_id}', 'RefBodyTypeController@delete');

    //etalase
    Route::get('etalase', 'EtalaseController@list');
    Route::get('etalase-detail/{app_id}', 'EtalaseController@detail');
    Route::get('share-catalogue', 'EtalaseController@share');
    Route::get('share-catalogue-product', 'EtalaseController@shareProduct');

    //visitation
    Route::get('visitasi/{app_id}', 'VisitationController@index');
    Route::post('submit-visitasi', 'VisitationController@submit');

    //visitation confirm
    Route::group(['prefix' => 'visitation-confirm'], function(){
        Route::get('/', 'VisitationConfirmController@list')->name('transeller-index');
        Route::get('waiting/{id}', 'VisitationConfirmController@detailWaiting')->name('transeller-detail');
        Route::get('approved/{id}', 'VisitationConfirmController@detailApproved');
        Route::get('rejected/{id}', 'VisitationConfirmController@detailRejected');
        Route::post('qrcode-visitation', 'VisitationConfirmController@qrCodeVisitation');
    });
    
    Route::post('visitation-confirm-update', 'VisitationConfirmController@update')->name('transeller-update');
    Route::get('visitation-approve/{id}', 'VisitationConfirmController@approve');
    Route::get('visitation-reject/{id}', 'VisitationConfirmController@reject');

    //region
    Route::post('region-combo', 'RefRegionController@combo');

    //district
    Route::post('district-combo', 'RefDistrictController@combo');

    //qrcode
    Route::prefix('qrcode-agent')->group(function () {
        Route::get('/', 'QrCodeController@qrCodeAgent');
        Route::get('finalize-visitation/{visitation_id}/{uniqid}', 'QrCodeController@confirmQrCodeVisitation');
    });

    Route::get('sales-list', 'SalesController@list')->name('sales-list');
    Route::get('sales-list-paid', 'SalesController@listPaid')->name('sales-list-paid');
    Route::post('sales-combo', 'SalesController@combo');
    Route::get('sales-add', 'SalesController@add');
    Route::post('sales-create', 'SalesController@create');
    Route::get('sales-detail/{app_id}', 'SalesController@detail');
    Route::get('sales-edit/{app_id}', 'SalesController@edit');
    Route::post('sales-update/{app_id}', 'SalesController@update');
    Route::post('sales-update-final/{app_id}', 'SalesController@updateFinal');
    Route::get('sales-publish/{app_id}', 'SalesController@publish');
    Route::get('sales-drafting/{app_id}', 'SalesController@drafting');
    Route::get('sales-print/{app_id}', 'SalesController@print');
    Route::get('sales-payment/{app_id}', 'SalesController@payment');
    Route::post('sales-pay/{app_id}', 'SalesController@pay');
    Route::get('sales-set/{app_id}', 'SalesController@set');
    Route::post('sales-setup/{app_id}', 'SalesController@setup');
    Route::get('sales-delete/{app_id}', 'SalesController@delete');

    Route::get('purchasing-list', 'PurchasingController@list')->name('sales-list');
    Route::post('purchasing-combo', 'PurchasingController@combo');
    Route::get('purchasing-add', 'PurchasingController@add');
    Route::post('purchasing-create', 'PurchasingController@create');
    Route::get('purchasing-item-add/{app_id}', 'PurchasingController@itemAdd');
    Route::post('purchasing-item-create', 'PurchasingController@itemCreate');
    Route::get('purchasing-detail/{app_id}', 'PurchasingController@detail');
    Route::get('purchasing-edit/{app_id}', 'PurchasingController@edit');
    Route::post('purchasing-update/{app_id}', 'PurchasingController@update');
    Route::post('purchasing-update-final/{app_id}', 'PurchasingController@updateFinal');
    Route::get('purchasing-publish/{app_id}', 'PurchasingController@publish');
    Route::get('purchasing-payment/{app_id}', 'PurchasingController@payment');
    Route::post('purchasing-pay/{app_id}', 'PurchasingController@pay');
    Route::get('purchasing-delete/{app_id}', 'PurchasingController@delete');

    Route::get('store-purchasing-list', 'StorePurchasingController@list')->name('sales-list');
    Route::post('store-purchasing-combo', 'StorePurchasingController@combo');
    Route::get('store-purchasing-add', 'StorePurchasingController@add');
    Route::post('store-purchasing-create', 'StorePurchasingController@create');
    Route::get('store-purchasing-item-add/{app_id}', 'StorePurchasingController@itemAdd');
    Route::post('store-purchasing-item-create', 'StorePurchasingController@itemCreate');
    Route::get('store-purchasing-item-detail/{app_id}', 'StorePurchasingController@itemDetail');
    Route::get('store-purchasing-item-delete/{app_id}', 'StorePurchasingController@itemDelete');
    Route::get('store-purchasing-detail/{app_id}', 'StorePurchasingController@detail');
    Route::get('store-purchasing-edit/{app_id}', 'StorePurchasingController@edit');
    Route::post('store-purchasing-update/{app_id}', 'StorePurchasingController@update');
    Route::post('store-purchasing-update-final/{app_id}', 'StorePurchasingController@updateFinal');
    Route::get('store-purchasing-publish/{app_id}', 'StorePurchasingController@publish');
    Route::get('store-purchasing-drafting/{app_id}', 'StorePurchasingController@drafting');
    Route::get('store-purchasing-payment/{app_id}', 'StorePurchasingController@payment');
    Route::post('store-purchasing-pay/{app_id}', 'StorePurchasingController@pay');
    Route::get('store-purchasing-delete/{app_id}', 'StorePurchasingController@delete');

    Route::get('logistic-list', 'LogisticController@list')->name('logistic-list');
    Route::post('logistic-combo', 'LogisticController@combo');
    Route::get('logistic-add', 'LogisticController@add');
    Route::post('logistic-create', 'LogisticController@create');
    Route::get('logistic-detail/{app_id}', 'LogisticController@detail');
    Route::get('logistic-edit/{app_id}', 'LogisticController@edit');
    Route::post('logistic-update/{app_id}', 'LogisticController@update');
    Route::get('logistic-delete/{app_id}', 'LogisticController@delete');

    Route::get('sales-item-list', 'SalesItemController@list')->name('sales-item-list');
    Route::post('sales-item-combo', 'SalesItemController@combo');
    Route::get('sales-item-add/{app_id}', 'SalesItemController@add');
    Route::post('sales-item-create', 'SalesItemController@create');
    Route::get('sales-item-detail/{app_id}', 'SalesItemController@detail');
    Route::get('sales-item-edit/{app_id}', 'SalesItemController@edit');
    Route::post('sales-item-update/{app_id}', 'SalesItemController@update');
    Route::get('sales-item-delete/{app_id}', 'SalesItemController@delete');

    Route::get('report', 'ReportController@index')->name('report-index');
    Route::get('report-bean-list', 'ReportController@beanList')->name('report-bean-list');
    
    Route::get('report-product-print', 'ReportController@productPrint');
    Route::get('report-store-income', 'ReportController@storeIncome')->name('report-store-income');
    Route::get('report-purchasing-list', 'ReportController@purchasingList')->name('report-purchasing-list');
    Route::get('report-store-income', 'ReportController@storeIncome')->name('report-store-income');
    Route::post('report-period', 'ReportController@setPeriod')->name('report-set-period');
    Route::get('report-summary', 'ReportController@summary')->name('report-summary');
    Route::get('report-store-recap', 'ReportController@recap');
    Route::get('report-profit-share', 'ReportController@profitShare');
    Route::get('report-statistic-bean', 'ReportController@statisticBean');
    Route::get('report-statistic-bean-json', 'ReportController@statisticBeanJson')->name('report-bean-json');
    Route::get('report-statistic-profit-json', 'ReportController@statisticProfitJson')->name('report-profit-json');

    Route::get('roasting-list', 'RoastingController@list')->name('roasting-list');
    Route::post('roasting-combo', 'RoastingController@combo');
    Route::get('roasting-add', 'RoastingController@add');
    Route::post('roasting-create', 'RoastingController@create');
    Route::get('roasting-detail/{app_id}', 'RoastingController@detail');
    Route::get('roasting-item-add/{app_id}', 'RoastingController@addItem');
    Route::post('roasting-item-create/{app_id}', 'RoastingController@createItem');
    Route::get('roasting-item-detail/{app_id}', 'RoastingController@detailItem');
    Route::get('roasting-item-delete/{app_id}', 'RoastingController@deleteItem');
    Route::get('roasting-edit/{app_id}', 'RoastingController@edit');
    Route::post('roasting-update/{app_id}', 'RoastingController@update');
    Route::post('roasting-update-final/{app_id}', 'RoastingController@updateFinal');
    Route::get('roasting-publish/{app_id}', 'RoastingController@publish');
    Route::get('roasting-drafting/{app_id}', 'RoastingController@drafting');
    Route::get('roasting-delete/{app_id}', 'RoastingController@delete');

    
    Route::get('gb-map-add/{app_id}', 'GbMapController@add');
    Route::post('gb-map-create/{app_id}', 'GbMapController@create');
    Route::get('gb-map-delete/{app_id}', 'GbMapController@delete');

    
    Route::post('product-parent-combo', 'ProductParentController@combo');
    Route::post('product-parent-combo-all', 'ProductParentController@comboall');
    Route::get('product-parent-list', 'ProductParentController@list');
    Route::get('product-parent-add', 'ProductParentController@add');
    Route::post('product-parent-create', 'ProductParentController@create');
    Route::get('product-parent-detail/{app_id}', 'ProductParentController@detail');
    Route::get('product-parent-edit/{app_id}', 'ProductParentController@edit');
    Route::post('product-parent-update/{app_id}', 'ProductParentController@update');
    Route::get('product-parent-delete/{app_id}', 'ProductParentController@delete');

    Route::get('store-operational-list', 'StoreOperationalController@list')->name('sales-list');
    Route::post('store-operational-combo', 'StoreOperationalController@combo');
    Route::get('store-operational-add', 'StoreOperationalController@add');
    Route::post('store-operational-create', 'StoreOperationalController@create');
    Route::get('store-operational-item-add/{app_id}', 'StoreOperationalController@itemAdd');
    Route::post('store-operational-item-create', 'StoreOperationalController@itemCreate');
    Route::get('store-operational-item-detail/{app_id}', 'StoreOperationalController@itemDetail');
    Route::get('store-operational-item-delete/{app_id}', 'StoreOperationalController@itemDelete');
    Route::get('store-operational-detail/{app_id}', 'StoreOperationalController@detail');
    Route::get('store-operational-edit/{app_id}', 'StoreOperationalController@edit');
    Route::post('store-operational-update/{app_id}', 'StoreOperationalController@update');
    Route::post('store-operational-update-final/{app_id}', 'StoreOperationalController@updateFinal');
    Route::get('store-operational-publish/{app_id}', 'StoreOperationalController@publish');
    Route::get('store-operational-drafting/{app_id}', 'StoreOperationalController@drafting');
    Route::get('store-operational-payment/{app_id}', 'StoreOperationalController@payment');
    Route::post('store-operational-pay/{app_id}', 'StoreOperationalController@pay');
    Route::get('store-operational-delete/{app_id}', 'StoreOperationalController@delete');

    // Bean Recap
    Route::get('bean-recap-list', 'BeanRecapController@list');
    Route::post('bean-recap-combo', 'BeanRecapController@combo');
    Route::get('bean-recap-add', 'BeanRecapController@add');
    Route::get('bean-recap-calculate', 'BeanRecapController@calculate');
    Route::post('bean-recap-create', 'BeanRecapController@create');
    Route::get('bean-recap-detail/{app_id}', 'BeanRecapController@detail');
    Route::get('bean-recap-edit/{app_id}', 'BeanRecapController@edit');
    Route::post('bean-recap-update/{app_id}', 'BeanRecapController@update');
    Route::get('bean-recap-spending/{app_id}', 'BeanRecapController@spending');
    Route::post('bean-recap-spending-create/{app_id}', 'BeanRecapController@spendingCreate');
    Route::get('bean-recap-spending-delete/{app_id}', 'BeanRecapController@SpendingDelete');
    Route::get('bean-recap-publish/{app_id}', 'BeanRecapController@publish');
    Route::get('bean-recap-delete/{app_id}', 'BeanRecapController@delete');

    // Store Recap
    Route::get('store-recap-list', 'StoreRecapController@list');
    Route::post('store-recap-combo', 'StoreRecapController@combo');
    Route::get('store-recap-add', 'StoreRecapController@add');
    Route::get('store-recap-calculate', 'StoreRecapController@calculate');
    Route::post('store-recap-create', 'StoreRecapController@create');
    Route::get('store-recap-detail/{app_id}', 'StoreRecapController@detail');
    Route::get('store-recap-edit/{app_id}', 'StoreRecapController@edit');
    Route::post('store-recap-update/{app_id}', 'StoreRecapController@update');
    Route::get('store-recap-publish/{app_id}', 'StoreRecapController@publish');
    Route::get('store-recap-delete/{app_id}', 'StoreRecapController@delete');
});
