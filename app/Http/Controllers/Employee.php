<?php 

    namespace App\Http\Controllers;

    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\Controller;
    use App\Models\Employee as EmployeeModel;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;

    class Employee extends Controller {
        
        public function __construct()
        {
            $this->middleware('employee');
        }
 
        public function home() {
            return Inertia('Employee/EmployeeHome');
        }


        public function profile() {
            return Inertia('Employee/EmployeeProfile');
        }

        public function task() {
            return Inertia('Employee/EmployeeTask');
        }


        public function logout(Request $request) {

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return Redirect::route('login_employee');
        }
            
    }

?>