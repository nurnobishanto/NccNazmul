<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/migrate', function () {
    // Run migrations
    Artisan::call('migrate');
    // Return a response
    return 'Migrations successfully executed!';
});
Route::post( 'uddoktapay/webhook', [\App\Http\Controllers\Payment\UddoktaPayController::class, 'webhook'] )->name( 'uddoktapay.webhook' );

Route::get('/optimize', function () {
    // Run migrations
    Artisan::call('optimize:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    // Return a response
    return Artisan::output();
});