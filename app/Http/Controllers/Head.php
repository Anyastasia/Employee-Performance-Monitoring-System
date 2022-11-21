<?php 

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use App\Models\AssignedTask;
    use Inertia\Inertia;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;

    use App\Models\Employee;
    use App\Models\Division;


    use Illuminate\Support\Facades\Auth;
    use App\Models\Head as HeadModel;
    use App\Models\SubmittedTask;
use Inertia\Testing\Assert;

    class Head extends Controller {


        public function __construct()
        {
            $this->middleware('head');
        }

        public function home(Request $request) {

            $head = Auth::guard('head')->user();
            $division_id = $head['division_id'];

            return Inertia::render('Head/HeadHome', [
                'employees' => Employee::where('division_id', $division_id)->get(['id', 'first_name', 'last_name', 'email', 'division_id', 'position']),
                'divisions' => Division::where('id', $division_id)->get(['id', 'name'])[0],
                'head' => $head['id'],
            ]);
        }
        
        public function profile() {
            return view('layout.head.profile');
        }

        public function employee(Request $request, $id){
            return Inertia::render('Head/HeadEmployeeProfile', [
                "employee" => Employee::where('id', $id)->get(['id', 'first_name', 'last_name', 'email', 'avatar_path', 'division_id', 'position'])[0],
                "assigned_tasks" => AssignedTask::where('employee_id', $id)->get(),
            ]);
        }

        public function view_task(Request $request, $id) {
            return Inertia::render('Head/HeadViewTask', [
                "task" => AssignedTask::join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
                ->where('task_id', $id)
                ->get()[0],
            ]);
        }

        public function dashboard() {
            return Inertia::render('Head/HeadDashboard');
        }

        public function logout(Request $request) {

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return Redirect::route('login_head');
        }
    }

?>