<?php 

    namespace App\Http\Controllers;

    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\Controller;
    use App\Models\Employee as Model;
    use App\Models\Division;
    use App\Models\AssignedTask;
    use App\Models\SubmittedTask;
    use App\Models\TimeIn;
    use App\Models\TimeOut;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;

    use Inertia\inertia;
    class Employee extends Controller {
        
        public function __construct()
        {
            $this->middleware('employee');
        }
 
        public function home() {

            $employee = Auth::guard('employee')->user();
            // dd($employee);
            return Inertia('Employee/EmployeeHome', [
                "employee" => $employee,
                "items" => AssignedTask::where('employee_id', $employee['id'])->get(),
            ]);
        }


        public function profile() {
            $id = Auth::guard('employee')->id();
            return Inertia('Employee/EmployeeProfile', [
                "employee" => Model::where('id', $id)->get(['first_name', 'last_name', 'email', 'position', 'is_admin', 'is_division_head'])->first(),
            ]);
        }

        public function task($task_id) {

            $user = Auth::guard('employee')->user();
            $submitted_task = SubmittedTask::where('task_id', $task_id)->get(['id', 'task_id', 'submitted_attachments', 'notes', 'submission_status']);
            if (count($submitted_task) == 0) {
                $task = AssignedTask::where('id', $task_id)->get()->first();
                $task['submission_status'] = 'active';
                // dd($task);
                return Inertia('Employee/EmployeeTask', ["task" => $task, 'employee' => $user]);
            }
            else {
                return Inertia('Employee/EmployeeTask', [
                    // "task" => AssignedTask::where('id', $task_id)->get()[0],
                    "task" => AssignedTask::join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
                    ->where('assigned_tasks.id', $task_id)
                    ->get()->first(), 

                    "employee" => $user
                ]);
            }

            // return Inertia('Employee/EmployeeTask', [
            //     "task" => AssignedTask::join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
            //     ->where('assigned_tasks.id', $task_id)
            //     ->get()[0],
            // ]);
        }

        public function view_task($id) {
            return Inertia::render('Head/HeadViewTask', [
                "task" => AssignedTask::join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
                ->where('task_id', $id)
                ->get()->first(),
                "employee" => Auth::guard('employee')->user()
            ]);
        }


        public function employee_list() {

            $user = Auth::guard('employee')->user();
            $division_id = $user['division_id'];

            return Inertia::render('Head/HeadHome', [
                'employees' => Model::where('division_id', $division_id)
                ->where('status', 'active')
                ->where('is_admin', false)
                ->where('is_division_head', false)
                ->get(['id', 'first_name', 'last_name', 'email', 'division_id', 'position']),
                'divisions' => Division::where('id', $division_id)->get(['id', 'name'])->first(),
                'employee' => $user,
            ]);
        }

        public function get_employee_by_division($id) {
            return Inertia::render('Admin/AdminEmployee', [
                'employees' => Model::where('division_id', $id)->get()
            ]); 
        }

        public function employee_list_admin($id) {
            if ($id == 0) {
                return Inertia('Admin/AdminEmployee', [
                    'employees' => Model::where('status', 'active')->get(), 
                    'divisions' => Division::where('status', 'active')->get(),
                    'employee' => Auth::guard('employee')->user(),
                    "division_id" => $id,
                    "showAlertDeleteEmployee" => Inertia::lazy(fn () => true),
                ]);
            } else {
                return Inertia('Admin/AdminEmployee', [
                    'employees' => Model::where('status', 'active')
                    ->where('division_id', $id)->get(), 
                    'divisions' => Division::where('status', 'active')->get(),
                    'employee' => Auth::guard('employee')->user(),
                    "division_id" => $id,
                    "showAlertDeleteEmployee" => Inertia::lazy(fn () => true)
                ]);
            }
        }

        public function division_list_admin() {
            return Inertia('Admin/AdminDivision', [
                'divisions' => Division::where('status', 'active')->get(),
                'employee' => Auth::guard('employee')->user(),
            ]);
        }

        public function dashboard() {
            $head = Model::find(Auth::guard('employee')->id());
            return Inertia::render('Head/HeadDashboard', [
                "employee" => $head,
                "employees" => Model::where('division_id', $head->division_id)->where('status', 'active')->get(),
                "division" => Division::find($head->division_id)->get('name')->first(),
            ]);
        }

        public function employee($id){
            return Inertia::render('Head/HeadEmployeeProfile', [
                "user" => Auth::guard('employee')->user(),
                'employee' => Model::where('id', $id)->get()->first(),
                "assigned_tasks" => AssignedTask::where('employee_id', $id)->get(),
            ]);
        }
        // )->where('is_admin', false)->where('is_division_head', false)->
        public function completed() {
            $id = Auth::guard('employee')->id();
            $submitted_task = AssignedTask::join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
            ->where('employee_id',$id)
            ->where('status', 'complete')
            ->get();

            return Inertia('Employee/EmployeeHome', [
                "items" => $submitted_task,
                "employee" => Auth::guard('employee')->user(),
            ]);
        }

        public function active() {
            $id = Auth::guard('employee')->id();
            $submitted_task = AssignedTask::
            // join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
            where('employee_id',$id)->
            where('status', 'active')->orWhere('status', 'revise')->
            // ->where('assigned_tasks.status', 'active')
            get();

   
            return Inertia('Employee/EmployeeHome', [
                "items" => $submitted_task,
                "employee" => Auth::guard('employee')->user()
            ]);
        }

        public function priority() {

            $user = Auth::guard('employee')->user();
            return Inertia('Employee/EmployeeHome', [
                "items" => AssignedTask::where('employee_id', $user['id'])
                ->where('is_priority', true)->get(),
                "employee" => $user
            ]);
        }

        public function attendance() {
            $user = Auth::guard('employee')->user();
            return Inertia('Employee/EmployeeAttendance', [
                "employee" => $user,
                "attendance" => TimeIn::join('time_outs', 'time_ins.shift_date', '=', 'time_outs.shift_date')->where('time_ins.employee_id', $user->id)->get(),
                "employees" => Model::where('division_id', $user->division_id)->get(),
            ]);
        }

        public function deactivate_division($id) {
            $model = Division::where('id', $id)->get()->first();
            $model->status = 'inactive';
            $model->save();
        }

        public function deactivate_employee(Request $request, $id) {
            $model = Model::where('id', $id)->get()->first();
            $model->status = 'inactive';
            $model->save();

        }

        public function x() {

            $id = Auth::guard('employee')->id();
            // return Inertia('Employee/EmployeeHome', [
            //     "id" => $id,
            //     "items" => AssignedTask::where('employee_id', $id)
            //     ->where('is_priority', true)->get(),

                
            // ]);
            dd(AssignedTask::where('employee_id', $id)
            ->where('is_priority', true)->get());
        }
     
        public function logout(Request $request) {

            
            Auth::logout();

            $request->session()->invalidate();
 
            $request->session()->regenerateToken();
 
            return Redirect::route('employee.login');
        }
            
    }

?>