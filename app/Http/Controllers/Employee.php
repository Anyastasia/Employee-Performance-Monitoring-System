<?php 

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;


    class Employee extends Controller {
        
        public function login() {
            return view('layout.employee.login');
        }

        public function home() {
            return view('layout.employee.home2');
        }

        public function profile() {
            return view('layout.employee.profile2');
        }

        public function task() {

            $xdata = [
                "header" => "header1",
                "description" => "lorem dolor lmao",
                "date" => "october 17 2022"
            ];
            return view('layout.employee.task', $xdata);
        }

        public function notifications() {
            return view('layout.employee.notifications');
        }
        

        
    }

?>