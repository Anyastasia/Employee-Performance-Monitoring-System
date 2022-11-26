<?php

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    use App\Models\Employee;
    use App\Models\Division;
    use App\Models\Head;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Auth;

    class Admin extends Controller {

        public function login() {
            return view('layout.admin.login');
        }

        public function dashboard() {
            return view('layout.admin.dashboard');
        }

        public function divisions() {
            return Inertia('Admin/AdminDivision', ['divisions' => Division::where('status', 'active')->get()]);
        }

        public function heads() {
            return Inertia('Admin/AdminHead', ['heads' => Head::where('status', 'active')->get(), 'divisions' => Division::where('status', 'active')->get()]);
        }

        public function employees() {
            return Inertia('Admin/AdminEmployee', ['employees' => Employee::where('status', 'active')->get(), 'divisions' => Division::where('status', 'active')->get()]);
        }

        public function deactivate_division($id) {
            $model = Division::where('id', $id)->get()->first();
            $model->status = 'inactive';
            $model->save();
        }

        public function deactivate_employee($id) {
            $model = Employee::where('id', $id)->get()->first();
            $model->status = 'inactive';
            $model->save();
        }

        public function deactivate_head($id) {
            $model = Head::where('id', $id)->get()->first();
            $model->status = 'inactive';
            $model->save();
        }

        public function logout(Request $request) {

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return Redirect::route('login_admin');
        }
    }

?>