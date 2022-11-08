<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class LoginHead extends Controller
{
    public function create() {
        return Inertia('Login/HeadLogin');
    }

    public function store(Request $request) {

        $user = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('head')->attempt($user)) {
            $request->session()->regenerate();

            return Redirect::intended('/head/home');
        }
        
        return back()->withErrors([
            'email' => 'Credentials do not match.'
        ]);
       

    }
}
