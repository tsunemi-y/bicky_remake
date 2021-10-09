<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $email = $request->email;
        $pass = $request->password;

        if ($email == 'hattatsu@shien.co.jp' && $pass == "adminadmin") {

            session()->put('loginSession', 'login');
            return redirect(url('admin/top'));
        } else {
            return redirect(url('admin/login'));
        }
    }
}
