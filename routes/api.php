<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReservationController;

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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/reservation', [ReservationController::class, 'getReservations'])->name('getReservation');
    Route::post('/saveReservation', [ReservationController::class, 'saveDatetime'])->name('saveReservation');
    Route::post('/deleteReservation', [ReservationController::class, 'deleteDatetime'])->name('deleteDatetime');
    Route::put('/updateReservation/{reservation}', [ReservationController::class, 'updateReservation'])->name('updateReservation');
    Route::get('/getUserInfoSendReciept', [ReservationController::class, 'getUserInfoSendReciept'])->name('getUserInfoSendReciept');
    Route::post('/sendReceipt', [ReservationController::class, 'sendReceipt'])->name('sendReceipt');

    Route::get('/users', [UserController::class, 'getUsers'])->name('users');
    Route::post('/sendEvaluation', [UserController::class, 'sendEvaluation'])->name('sendEvaluation');
});
