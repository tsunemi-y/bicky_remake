<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

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
    return view('pages.top');
})->name('top');

Route::get('greeting', function () {
    return view('pages.greeting');
})->name('greeting');

Route::get('access', function () {
    return view('pages.access');
})->name('access');

Route::get('fee', function () {
    return view('pages.fee');
})->name('fee');

Route::get('introduction', function () {
    return view('pages.introduction');
})->name('introduction');

Route::get('/reservation', [ReservationController::class, 'dispReservationTop'])->name('reservationTop');
Route::get('/reservationForm', [ReservationController::class, 'dispReservationForm'])->name('reservationForm');
Route::get('/reservationFormUsed', [ReservationController::class, 'dispReservationFormUsed'])->name('reservationFormUsed');

// キャンセルコード認証画面
Route::get('/dispCancelCodeVerify', [ReservationController::class, 'dispCancelCodeVerify'])->name('dispCancelCodeVerify');
Route::post('/VerifyCancelCode', [ReservationController::class, 'VerifyCancelCode'])->name('VerifyCancelCode');

// キャンセル画面
Route::get('/dispReservationCancel/{reservation}', [ReservationController::class, 'dispReservationCancel'])->name('dispReservationCancel');
Route::post('/cancelReservation/{reservation}', [ReservationController::class, 'cancelReservation'])->name('cancelReservation');

Route::post('/createReservation', [ReservationController::class, 'createReservation'])->name('createReservation');
Route::post('/reservation/sendmail', [ReservationController::class, 'sendMail'])->name('sendMail');
