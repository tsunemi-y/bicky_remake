<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Api\ReservationController as ApiReservationController;

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

// 認証不要のルート
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

// 認証が必要なルート
Route::middleware('auth:sanctum')->group(function () {
    // ユーザー情報
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // 予約関連
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::get('/reservations/{id}', [ReservationController::class, 'show']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::put('/reservations/{id}/cancel', [ReservationController::class, 'cancel']);
    
    // 空き状況確認
    Route::post('/availability', [ReservationController::class, 'checkAvailability']);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/reservation', [ReservationController::class, 'index'])->name('getReservation');
    Route::post('/saveReservation', [ReservationController::class, 'store'])->name('saveReservation');
    Route::post('/deleteReservation', [ReservationController::class, 'destroy'])->name('deleteDatetime');

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::put('/updateFee/{user}', [UserController::class, 'updateFee'])->name('updateFee');
    Route::post('/sendEvaluation', [UserController::class, 'sendEvaluation'])->name('sendEvaluation');
    Route::post('/sendReceipt', [UserController::class, 'sendReceipt'])->name('sendReceipt');
});

Route::middleware('api.key')->group(function () {
    Route::post('/reservation', [ApiReservationController::class, 'getTodayReservations'])->name('getTodayReservations');
});