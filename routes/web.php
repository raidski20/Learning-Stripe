<?php

use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\StripLaravelController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('checkout', [StripeController::class,'overview'])->name('payment.checkout');
Route::post('checkout', [StripeController::class,'checkout'])->name('payment.checkout');
Route::get('success', [StripeController::class,'success'])->name('payment.success');
Route::get('cancel', [StripeController::class,'cancel'])->name('payment.cancel');
