<?php 

    namespace App\Http\Controllers;

    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\Controller;
    use App\Models\Employee as EmployeeModel;
    use App\Models\AssignedTask;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;

    class Employee extends Controller {
        
        public function __construct()
        {
            $this->middleware('employee');
        }
 
        public function home() {

            $id = Auth::guard('employee')->id();
            return Inertia('Employee/EmployeeHome', [
                "id" => $id,
                "items" => AssignedTask::where('employee_id', $id)->get(),
            ]);
        }


        public function profile() {
            return Inertia('Employee/EmployeeProfile');
        }

        public function task($task_id) {
            return Inertia('Employee/EmployeeTask', [
                "task" => AssignedTask::where('id', $task_id)->get()[0],
            ]);
        }


        public function logout(Request $request) {

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return Redirect::route('login_employee');
        }
            
    }

?>