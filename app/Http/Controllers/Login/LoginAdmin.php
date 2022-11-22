<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class LoginAdmin extends Controller
{
    //
    public function create() {
        return Inertia('Login/AdminLogin');
    }

    public function store(Request $request) {

        $user = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $attempt =Auth::guard('admin')->attempt($user);

        if ($attempt) {
            $request->session()->regenerate();
            return Redirect::intended('/admin/employees');
        }
        
        return back()->withErrors([
            'username' => 'Credentials do not match'
        ]);
       
    }
}
