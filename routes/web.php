<?php

use App\Http\Controllers\Admin\CartController as AdminCartController;
use App\Http\Controllers\Admin\MainAdminController;
use App\Http\Controllers\MainController;

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\Users\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController as HomeMenuController;
use App\Http\Controllers\ProductController as HomeProductController;
use App\Http\Controllers\SearchController;
use App\Http\Services\Upload\UploadService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/admin/users/login', [LoginController::class, 'index'])-> name('login');
Route::post('/admin/users/login/store', [LoginController::class, 'store']);


Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')-> group(function () {
        Route::get('', [MainAdminController::class, 'index']) -> name('admin');
        Route::get('main', [MainAdminController::class, 'index']);

        # Order
        Route::get('customers', [AdminCartController::class, 'index']);
        Route::get('customers/view/{customer}', [AdminCartController::class, 'show']);
        # Menu
        Route::prefix('menus')->group(function () {
            Route::get('add', [MenuController::class, 'create']);
            Route::get('list', [MenuController::class, 'index']);
            Route::post('add', [MenuController::class,'store']);
            Route::get('edit/{menu}', [MenuController::class,'show']);
            Route::post('edit/{menu}', [MenuController::class,'update']);

            Route::delete('destroy',[MenuController::class, 'destroy']);
        });

        # Product
        Route::prefix('products')->group(function(){
            Route::get('add', [ProductController::class, 'create']);
            Route::post('add', [ProductController::class, 'store']);
            Route::get('list', [ProductController::class, 'index']);
            Route::get('edit/{product}', [ProductController::class,'show']);
            Route::post('edit/{product}', [ProductController::class,'update']);
            Route::delete('destroy',[ProductController::class, 'destroy']);
        });

        # Upload
        Route::post('upload/services',[UploadController::class, 'store']);

        # Slider
        Route::prefix('sliders')->group(function(){
            Route::get('add', [SliderController::class, 'create']);
            Route::post('add', [SliderController::class, 'store']);
            Route::get('list', [SliderController::class, 'index']);
            Route::get('edit/{slider}', [SliderController::class,'show']);
            Route::post('edit/{slider}', [SliderController::class,'update']);
            Route::delete('destroy',[SliderController::class, 'destroy']);
        });

    });
});

Route::get('/',[MainController::class,'index']);
Route::post('services/load-product',[MainController::class,'loadProduct']);

Route::get('/category/{id}-{slug}.html',[HomeMenuController::class,'index']);
Route::get('/product/{id}-{slug}.html',[HomeProductController::class,'index']);
Route::post('/add-cart',[CartController::class,'index']);
Route::get('/cart',[CartController::class,'show']);
Route::post('/update-cart', [CartController::class, 'update']);
Route::get('/cart/delete/{id}',[CartController::class,'remove']);
Route::post('/cart',[CartController::class,'checkout']);
Route::get('/search',[SearchController::class,'search'])->name('search');
Route::get('/find',[SearchController::class,'find']);



