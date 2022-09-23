<?php 

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;


    class Head extends Controller {

        public function login() {
            return view('layout.head.login');
        }

        public function home() {
            return view('layout.head.home');
        }

        public function profile() {
            return view('layout.head.profile');
        }
    }

?>