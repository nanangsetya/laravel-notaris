<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    function index()
    {
        return view('login');
    }

    function signin(Request $r)
    {
        $r->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $r->username, 'password' => $r->password, 'active' => 1])) {
            if (Auth::user()->role_id == 1) {
                return redirect()->route('user.index');
            }
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('failed', 'Login gagal!');
        }
    }

    function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->to('/');
    }
}
