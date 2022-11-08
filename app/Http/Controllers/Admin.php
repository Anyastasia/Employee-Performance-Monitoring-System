<?php

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use App\Models\Employee;
    use App\Models\Division;
    use App\Models\Head;
    
    use Inertia\Inertia;

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

        public function divisions() {
            return Inertia('Admin/AdminDivision', ['divisions' => Division::all()]);
        }

        public function heads() {
            return Inertia('Admin/AdminHead', ['heads' => Head::all(), 'divisions' => Division::all()]);
        }

        public function employees() {
            return Inertia('Admin/AdminEmployee', ['employees' => Employee::all(), 'divisions' => Division::all()]);
        }
    }

?>