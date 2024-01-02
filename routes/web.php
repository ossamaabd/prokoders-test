<?php

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

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Filecontroller;
use App\Http\Controllers\PagePopupController;
use App\Http\Controllers\PopupController;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\web\NotificationController;
use App\Http\Controllers\web\ShopController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

Auth::routes();

// Route::get('/login', function () {
//     return view('pages.user-pages.login');
// })->name('login');

// Route::post('login', [LoginController::class,'login']);

// Route::get('loginUser', function () {
//     return view('pages.user-pages.loginUser');
// })->name('loginUser');
// Route::post('loginUser', [LoginController::class,'loginUser']);



Route::group(['middleware' => ['auth:user']], function() {
    Route::get('/', function () {
        return view('dashboard');
    });



Route::prefix('popups')->name('popups.')->group(function(){
    Route::get('index', [PopupController::class , 'index'])->name('index');
    Route::get('ViewAddPopup', [PopupController::class , 'ViewAddPopup'])->name('ViewAddPopup');
    Route::get('ViewEditPopup/{popupId}', [PopupController::class , 'ViewEditPopup'])->name('ViewEditPopup');
    Route::post('create', [PopupController::class , 'create'])->name('create');
    Route::get('getPopupById', [PopupController::class , 'getPopupById'])->name('getPopupById');
    Route::post('update/{Popup}', [PopupController::class , 'update'])->name('update');



});

Route::prefix('popup_pages')->name('popup_pages.')->group(function(){

Route::get('/index/{popupId}', [PagePopupController::class , 'index'])->name('index');
Route::get('/assignPopupToPage/{popup_id}/{page_id}', [PagePopupController::class , 'assignPopupToPage'])->name('assignPopupToPage');
Route::get('/delete/{popup_id}/{page_id}', [PagePopupController::class , 'delete'])->name('delete');
});



Route::get('files/index', [Usercontroller::class , 'allUserFiles']);
Route::get('files/ViewAddFile', [Usercontroller::class , 'ViewAddFile']);
Route::post('files/upload', [Filecontroller::class , 'upload']);
Route::get('files/changeReserved/{file_id}', [Filecontroller::class , 'changeReserved']);

// Route::get('users/addCaptain', [UserController::class , 'addCaptain']);


Route::get('reports/index', [ShopController::class , 'getAllReports']);



});
Route::get('notifications', function () {
    return view('pages.notifications.index');
});

Route::group(['prefix' => 'icons'], function(){
    Route::get('material', function () { return view('pages.icons.material'); });
    Route::get('flag-icons', function () { return view('pages.icons.flag-icons'); });
    Route::get('font-awesome', function () { return view('pages.icons.font-awesome'); });
    Route::get('simple-line-icons', function () { return view('pages.icons.simple-line-icons'); });
    Route::get('themify', function () { return view('pages.icons.themify'); });
});

Route::group(['prefix' => 'maps'], function(){
    Route::get('vector-map', function () { return view('pages.maps.vector-map'); });
    Route::get('mapael', function () { return view('pages.maps.mapael'); });
    Route::get('google-maps', function () { return view('pages.maps.google-maps'); });
});
// Route::get('admin/login', function () { return view('pages.user-pages.login'); });

Route::group(['prefix' => 'user-pages'], function(){
    Route::get('login-2', function () { return view('pages.user-pages.login-2'); });
    Route::get('multi-step-login', function () { return view('pages.user-pages.multi-step-login'); });
    Route::get('register', function () { return view('pages.user-pages.register'); });
    Route::get('register-2', function () { return view('pages.user-pages.register-2'); });
    Route::get('lock-screen', function () { return view('pages.user-pages.lock-screen'); });
});

// Route::group(['prefix' => 'error-pages'], function(){
//     Route::get('error-404', function () { return view('pages.error-pages.error-404'); });
//     Route::get('error-500', function () { return view('pages.error-pages.error-500'); });
// });

Route::group(['prefix' => 'general-pages'], function(){
    Route::get('blank-page', function () { return view('pages.general-pages.blank-page'); });
    Route::get('landing-page', function () { return view('pages.general-pages.landing-page'); });
    Route::get('profile', function () { return view('pages.general-pages.profile'); });
    Route::get('email-templates', function () { return view('pages.general-pages.email-templates'); });
    Route::get('faq', function () { return view('pages.general-pages.faq'); });
    Route::get('faq-2', function () { return view('pages.general-pages.faq-2'); });
    Route::get('news-grid', function () { return view('pages.general-pages.news-grid'); });
    Route::get('timeline', function () { return view('pages.general-pages.timeline'); });
    Route::get('search-results', function () { return view('pages.general-pages.search-results'); });
    Route::get('portfolio', function () { return view('pages.general-pages.portfolio'); });
    Route::get('user-listing', function () { return view('pages.general-pages.user-listing'); });
});

Route::group(['prefix' => 'ecommerce'], function(){
    Route::get('invoice', function () { return view('pages.ecommerce.invoice'); });
    Route::get('invoice-2', function () { return view('pages.ecommerce.invoice-2'); });
    Route::get('pricing', function () { return view('pages.ecommerce.pricing'); });
    Route::get('product-catalogue', function () { return view('pages.ecommerce.product-catalogue'); });
    Route::get('project-list', function () { return view('pages.ecommerce.project-list'); });
    Route::get('orders', function () { return view('pages.ecommerce.orders'); });
});

// For Clear cache
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

// 404 for undefined routes
// Route::any('/{page?}',function(){
//     return View::make('pages.error-pages.error-404');
// })->where('page','.*');
