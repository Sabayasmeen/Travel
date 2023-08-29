<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\TravelPackageController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;


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

// Route::get('/', function () {
//     return view('welcome');
// });



Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/detail/{slug}', [DetailController::class, 'index'])->name('detail');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('user-dashboard');

    Route::get('/dashboard/detail/{id}', [UserDashboardController::class, 'show'])
        ->name('detail-order');

    Route::get('dashboard/edit/{id}', [ProfileController::class, 'edit'])
        ->name('edit');

    Route::post('dashboard/edit/{id}', [ProfileController::class, 'update'])
        ->name('update');

});

Route::post('/checkout/{id}', [CheckoutController::class, 'process'])
    ->name('checkout_process')
    ->middleware(['auth','verified']);

Route::get('/checkout/{id}', [CheckoutController::class, 'index'])
    ->name('checkout')
    ->middleware(['auth','verified']);

Route::post('/checkout/create/{detail_id}', [CheckoutController::class, 'create'])
    ->name('checkout_create')
    ->middleware(['auth','verified']);

Route::get('/checkout/remove/{detail_id}', [CheckoutController::class, 'remove'])
    ->name('checkout_remove')
    ->middleware(['auth','verified']);

Route::get('/checkout/confirm/{id}', [CheckoutController::class, 'success'])
    ->name('checkout_success')
    ->middleware(['auth','verified']);

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth','admin'])
    ->group(function(){
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('travel-package', 'TravelPackageController');
        Route::resource('gallery', 'GalleryController');
        Route::resource('transaction', 'TransactionController');
    });



    Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
