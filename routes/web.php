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

Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation');
Route::post('/reservation/sendmail', [ReservationController::class, 'sendMail'])->name('reservation.sendMail');
