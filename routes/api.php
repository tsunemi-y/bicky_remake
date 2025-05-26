<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ReservationController;
use App\Http\Controllers\CourseController;
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

Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/users/login', [UserController::class, 'login'])->name('users.login');

// 認証が必要なルート
Route::middleware('auth:api')->group(function () {

// 予約関連
// CSRFトークン検証をスキップするためにミドルウェアを指定

    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/users/me/children', [UserController::class, 'getChildren'])->name('users.getChildren');
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    // Route::get('/reservations/{id}', [ReservationController::class, 'show']);
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
//     Route::put('/reservations/{id}/cancel', [ReservationController::class, 'cancel']);
    
//     // 空き状況確認
//     Route::post('/availability', [ReservationController::class, 'checkAvailability']);
});

// Route::prefix('admin')->name('admin.')->group(function () {
//     Route::get('/reservation', [ReservationController::class, 'index'])->name('getReservation');
//     Route::post('/saveReservation', [ReservationController::class, 'store'])->name('saveReservation');
//     Route::post('/deleteReservation', [ReservationController::class, 'destroy'])->name('deleteDatetime');

//     Route::get('/users', [UserController::class, 'index'])->name('users');
//     Route::put('/updateFee/{user}', [UserController::class, 'updateFee'])->name('updateFee');
//     Route::post('/sendEvaluation', [UserController::class, 'sendEvaluation'])->name('sendEvaluation');
//     Route::post('/sendReceipt', [UserController::class, 'sendReceipt'])->name('sendReceipt');
// });

// Route::middleware('api.key')->group(function () {
//     Route::post('/reservation', [ApiReservationController::class, 'getTodayReservations'])->name('getTodayReservations');
// });