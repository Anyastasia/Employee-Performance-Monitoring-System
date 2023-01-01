<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class LoginEmployee extends Controller
{
    //
    // get request from user
    // verify login credentials 
    // redirect to page

    public function create() {
        return Inertia('Login/EmployeeLogin');
    }

    public function store(Request $request) {

        $user = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $attempt =Auth::guard('employee')->attempt([
            "email" => $user['email'],
            "password" => $user['password'],
            "status" => 'active'
        ]);

        if ($attempt) {
            $request->session()->regenerate();

            return Redirect::intended('/home');
        }

        return back()->withErrors([
            'email' => 'Credentials do not match'
        ]);
       
    }
    
}
