<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ShopController;
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


// Admin routes
Route::post('approveShopByAdmin', 'App\Http\Controllers\AdminController@approveShopByAdmin');
Route::post('blockShopByAdmin', 'App\Http\Controllers\AdminController@blockShopByAdmin');
Route::get('getAddShopRequests', 'App\Http\Controllers\AdminController@getAddShopRequests');

Route::get('getAllCaptains', 'App\Http\Controllers\AdminController@getAllCaptains');
Route::get('getAllCustomers', 'App\Http\Controllers\AdminController@getAllCustomers');
Route::get('getAllDeliveries', 'App\Http\Controllers\AdminController@getAllDeliveries');
Route::get('getAllVendors', 'App\Http\Controllers\AdminController@getAllVendors');

Route::get('getAllShops', 'App\Http\Controllers\AdminController@getAllShops');


Route::delete('deleteCaptain/{id}', 'App\Http\Controllers\AdminController@deleteCaptain');
Route::delete('deleteCustomer/{id}', 'App\Http\Controllers\AdminController@deleteCustomer');
Route::delete('deleteDelivery/{id}', 'App\Http\Controllers\AdminController@deleteDelivery');
Route::delete('deleteVendor/{id}', 'App\Http\Controllers\AdminController@deleteVendor');


// Brand routes
Route::post('addBrand', 'App\Http\Controllers\BrandController@addBrand');
Route::delete('deleteBrand/{id}', 'App\Http\Controllers\BrandController@deleteBrand');
Route::get('getBrandsByType/{type}', 'App\Http\Controllers\BrandController@getBrandsByType');


// Captain routes
Route::post('createCaptainAccount', 'App\Http\Controllers\CaptainController@createCaptainAccount');
Route::post('approveOrderByCaptain', 'App\Http\Controllers\CaptainController@approveOrderByCaptain');
Route::get('getCaptainDeliveries/{captain_id}', 'App\Http\Controllers\CaptainController@getCaptainDeliveries');
Route::post('rejectOrderByCaptain', 'App\Http\Controllers\CaptainController@rejectOrderByCaptain');
Route::get('getCaptainCityOrders/{captain_id}', 'App\Http\Controllers\CaptainController@getCaptainCityOrders');
Route::get('getDeliveredOrders/{captain_id}', 'App\Http\Controllers\CaptainController@getDeliveredOrders');




// routes for CategoryController
Route::post('addCategory', 'App\Http\Controllers\CategoryController@addCategory');
Route::put('updateCategory', 'App\Http\Controllers\CategoryController@updateCategory');
Route::delete('deleteCategory/{categoryId}', 'App\Http\Controllers\CategoryController@deleteCategory');
Route::get('getAllCategories', 'App\Http\Controllers\CategoryController@getAllCategories');

// routes for ColorController
Route::post('addColor', 'App\Http\Controllers\ColorController@addColor');
Route::delete('deleteColor/{colorId}', 'App\Http\Controllers\ColorController@deleteColor');
Route::get('getAllColors', 'App\Http\Controllers\ColorController@getAllColors');




// routes for customersController
Route::post('addCustomer', 'App\Http\Controllers\CustomerController@addCustomer');
Route::put('updateCustomer', 'App\Http\Controllers\CustomerController@updateCustomer');


// routes for CustomerOrderProductController
Route::post('addProductToCart', 'App\Http\Controllers\CustomerOrderProductController@addProductToCart');
Route::delete('removeProductFromCart', 'App\Http\Controllers\CustomerOrderProductController@removeProductFromCart');
Route::delete('clearCart', 'App\Http\Controllers\CustomerOrderProductController@clearCart');
Route::get('viewCart/{customer_id}', 'App\Http\Controllers\CustomerOrderProductController@viewCart');
Route::put('confirmCart/{customer_id}', 'App\Http\Controllers\CustomerOrderProductController@confirmCart');


// routes for DeliveryController
Route::post('createDeliveryAccount', 'App\Http\Controllers\DeliveryController@createDeliveryAccount');
Route::put('updateDeliveryAccount', 'App\Http\Controllers\DeliveryController@updateDeliveryAccount');
Route::get('viewApprovedOrdersToDelivery/{delivery_id}', 'App\Http\Controllers\DeliveryController@viewApprovedOrdersToDelivery');
Route::put('startDelivery', 'App\Http\Controllers\DeliveryController@startDelivery');
Route::put('ConfirmDelivery', 'App\Http\Controllers\DeliveryController@ConfirmDelivery');

Route::get('getDeliveryinfo/{delivery_id}', 'App\Http\Controllers\DeliveryController@getDeliveryinfo');



// routes for DeliveryEvaluationController
Route::post('addDeliveryEvaluation', 'App\Http\Controllers\DeliveryEvaluationController@addDeliveryEvaluation');
Route::delete('deleteDeliveryEvaluation', 'App\Http\Controllers\DeliveryEvaluationController@deleteDeliveryEvaluation');


// routes for LocationController
Route::post('addLocation', 'App\Http\Controllers\LocationController@addLocation');
Route::get('getLocationById/{location_id}', 'App\Http\Controllers\LocationController@getLocationById');




// routes for OrderController
Route::get('viewOrderDetails/{order_id}', 'App\Http\Controllers\OrderController@viewOrderDetails');


// routes for ProductController
Route::post('addProduct', 'App\Http\Controllers\ProductController@addProduct');
Route::post('updateProduct', 'App\Http\Controllers\ProductController@updateProduct');
Route::delete('deleteProduct/{product_id}', 'App\Http\Controllers\ProductController@deleteProduct');
Route::get('getProductInfo/{product_id}', 'App\Http\Controllers\ProductController@getProductInfo');
Route::get('getProductsByShop/{shop_id}', 'App\Http\Controllers\ProductController@getProductsByShop');
Route::get('searchproduct/{search}', 'App\Http\Controllers\ProductController@searchproduct');
Route::get('getProductsByCategory/{category_id}', 'App\Http\Controllers\ProductController@getProductsByCategory');



// routes for ProductEvaluationsController
Route::post('addProductEvaluation/{customerId}/{productId}/{stars}', 'App\Http\Controllers\ProductEvaluationsController@addProductEvaluation');




// routes for ProductFavoriteController
Route::post('addProductToFavorite/{customer_id}/{product_id}', 'App\Http\Controllers\ProductFavoriteController@addProductToFavorite');
//Route::delete('deleteProductFromFavorite/{customer_id}/{product_id}', 'App\Http\Controllers\ProductFavoriteController@deleteProductFromFavorite');
Route::get('getFavoriteProducts/{customer_id}', 'App\Http\Controllers\ProductFavoriteController@getFavoriteProducts');


// routes for ReportController
Route::post('addReport', 'App\Http\Controllers\ReportController@addReport');
Route::get('getAllReports', 'App\Http\Controllers\ReportController@getAllReports');



// routes for ShopController
Route::post('addShopWithLocation', 'App\Http\Controllers\ShopController@addShopWithLocation');
Route::post('updateShopWithLocation', [ShopController::class,'updateShopWithLocation']);
Route::get('getShopsByCategory/{category_id}', 'App\Http\Controllers\ShopController@getShopsByCategory');
Route::get('getVendorShops/{vendor_id}', 'App\Http\Controllers\ShopController@getVendorShops');
Route::delete('deleteShop/{shop_id}', 'App\Http\Controllers\ShopController@deleteShop');
Route::get('getshopinfo/{shop_id}', 'App\Http\Controllers\ShopController@getshopinfo');
Route::get('searchShop/{search}', 'App\Http\Controllers\ShopController@searchShop');
Route::post('open_closeShop', 'App\Http\Controllers\ShopController@open_closeShop');

// routes for OfferController
Route::post('addProductDiscount', 'App\Http\Controllers\OfferController@addProductDiscount');
Route::delete('removeDiscountFromProduct/{product_id}', 'App\Http\Controllers\OfferController@removeDiscountFromProduct');


// routes for ShopEvaluationController
Route::post('addEshopEvaluation/{customerId}/{shopId}/{stars}', 'App\Http\Controllers\ShopEvaluationController@addEshopEvaluation');



// routes for ShopFavoriteController
Route::post('addShopToFavorite/{customer_id}/{shop_id}', 'App\Http\Controllers\ShopFavoriteController@addShopToFavorite');
//Route::delete('deleteShopFromFavorite/{customer_id}/{shop_id}', 'App\Http\Controllers\ShopFavoriteController@deleteShopFromFavorite');
Route::get('getFavoriteShops/{customer_id}', 'App\Http\Controllers\ShopFavoriteController@getFavoriteShops');



// routes for VendorController
Route::post('addVendor', 'App\Http\Controllers\VendorController@addVendor');
Route::post('createVendorAccount', 'App\Http\Controllers\VendorController@createVendorAccount');


Route::post('signup', [AuthController::class , 'signup']);
Route::post('login', [AuthController::class , 'login']);






Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
