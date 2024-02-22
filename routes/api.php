<?php

use App\Http\Controllers\BiddingController;
use App\Http\Controllers\DisplayOrderController;
use App\Http\Controllers\LoginScreenController;
use App\Http\Controllers\TermsOfUseController;
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

Route::get('login/custom', [LoginScreenController::class, 'showLogin']);

Route::group(['middleware' => ['web']], function () {
    Route::post('/aceitar-termos', [TermsOfUseController::class, 'aceitar'])->name('termos.aceitar');
    Route::post('/bidding-notices', [BiddingController::class, 'addNotices']);
    Route::resource('/change-order', DisplayOrderController::class);
});
