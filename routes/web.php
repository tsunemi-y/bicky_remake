<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

// ログイン機能
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ConfirmPasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\LineMessengerController;


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


// LINE メッセージ送信用
Route::get('/line/sendReservation', [LineMessengerController::class, 'sendReservationListMessage'])->name('line.sendReservation');

// ===============ユーザー画面　ここから============

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

// ===============ユーザー画面　ここまで============

// Auth::routes();
Route::get('/pdf', function () {
    return view('admin.emails.receiptPdf', ['name' => '田中太郎', 'reservation_date' => '2021/09/30', 'fee' => 6600]);
});

// ===============管理画面画面　ここから============

Route::prefix('admin')->name('admin.')->group(function () {

    // ルーティング
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/{any}', function () {
        if (!empty(session('_token'))) {
            return view('admin.app');
        } else {
            return redirect(url('admin/login'));
        }
    })->where('any', '^(?!login).+$')->name('top');
});
