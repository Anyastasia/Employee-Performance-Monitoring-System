<?php

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    class Admin extends Controller {

        public function login() {
            return view('layout.admin.login');
        }

        
        public function x(Request $request) {
            $username = $request->input('username');
            $password = $request->input('password');

            return response($username."@".$password);
        }

        public function dashboard() {
            return view('layout.admin.dashboard');
        }

        public function departments() {
            return view('layout.admin.departments');
        }

        public function heads() {
            return view('layout.admin.heads');
        }

        public function employees() {
            return view('layout.admin.employees');
        }
    }

?>