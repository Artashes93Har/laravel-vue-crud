<?php

use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
    Route::post('/change-status', [App\Http\Controllers\Admin\DashboardController::class, 'changeStatus']);
    Route::get('post-products', [\App\Http\Controllers\Admin\DashboardController::class, 'postProducts'])->name('post.products');

});
Route::middleware('user')->group(function () {
    Route::get('get-categories', [\App\Http\Controllers\User\DashboardController::class, 'getCategories'])->name('get.categories');
    Route::get('get-products', [\App\Http\Controllers\User\DashboardController::class, 'getProducts'])->name('get.products');
    Route::get('get-category-list', [\App\Http\Controllers\User\DashboardController::class, 'getCategoryList'])->name('get.category.list');
    Route::get('/user/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index']);
    Route::get('/auth/facebook',[App\Http\Controllers\SocialController::class,'facebookRedirect'])->name('auth.facebook');
    Route::get('/auth/facebook/callback',[App\Http\Controllers\SocialController::class,'loginWithFacebook']);
    Route::post('/save-categories',[App\Http\Controllers\User\DashboardController::class,'addCategory']);
    Route::post('/save-products',[App\Http\Controllers\User\DashboardController::class,'addProduct']);
    Route::post('/delete-product', [App\Http\Controllers\User\DashboardController::class, 'deleteProduct']);
    Route::post('/delete-category', [App\Http\Controllers\User\DashboardController::class, 'deleteCategory']);
    Route::post('/edit-category', [App\Http\Controllers\User\DashboardController::class, 'updateCategory']);
    Route::post('/edit-product', [App\Http\Controllers\User\DashboardController::class, 'updateProduct']);
});



