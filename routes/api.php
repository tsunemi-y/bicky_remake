<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
    Route::put('/updateReservation/{reservation}', [ReservationController::class, 'updateReservation'])->name('updateReservation');
    Route::post('/sendReceipt', [ReservationController::class, 'sendReceipt'])->name('sendReceipt');
});
