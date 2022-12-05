<?php 

    namespace App\Http\Controllers;

    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\Controller;
    use App\Models\Employee as Model;
    use App\Models\AssignedTask;
    use App\Models\SubmittedTask;
    use App\Models\TimeIn;
    use App\Models\TimeOut;
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
            $id = Auth::guard('employee')->id();
            return Inertia('Employee/EmployeeProfile', [
                "employee" => Model::where('id', $id)->get(['first_name', 'last_name', 'email', 'position'])[0],
            ]);
        }

        public function task($task_id) {

            $submitted_task = SubmittedTask::where('task_id', $task_id)->get(['id', 'task_id', 'submitted_attachments', 'notes', 'submission_status']);
            if (count($submitted_task) == 0) {
                $task = AssignedTask::where('id', $task_id)->get()->first();
                $task['submission_status'] = 'active';
                // dd($task);
                return Inertia('Employee/EmployeeTask', ["task" => $task]);
            }
            else {
                return Inertia('Employee/EmployeeTask', [
                    // "task" => AssignedTask::where('id', $task_id)->get()[0],
                    "task" => AssignedTask::join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
                    ->where('assigned_tasks.id', $task_id)
                    ->get()->first(), 
                ]);
            }

            // return Inertia('Employee/EmployeeTask', [
            //     "task" => AssignedTask::join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
            //     ->where('assigned_tasks.id', $task_id)
            //     ->get()[0],
            // ]);
        }

        public function completed() {
            $id = Auth::guard('employee')->id();
            $submitted_task = AssignedTask::join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
            ->where('employee_id',$id)
            ->where('status', 'complete')
            ->get();

            return Inertia('Employee/EmployeeHome', [
                "items" => $submitted_task
            ]);
        }

        public function active() {
            $id = Auth::guard('employee')->id();
            $submitted_task = AssignedTask::join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
            ->where('employee_id',$id)
            ->where('assigned_tasks.status', 'active')
            ->get();

            return Inertia('Employee/EmployeeHome', [
                "items" => $submitted_task
            ]);
        }

        public function priority() {

            $id = Auth::guard('employee')->id();
            return Inertia('Employee/EmployeeHome', [
                "id" => $id,
                "items" => AssignedTask::where('employee_id', $id)
                ->where('is_priority', true)->get(),
            ]);
        }


        public function attendance() {
            $id = Auth::guard('employee')->id();
            return Inertia('Employee/EmployeeAttendance', [
                "id" => $id,
                "attendance" => TimeIn::join('time_outs', 'time_ins.shift_date', '=', 'time_outs.shift_date')->where('time_ins.employee_id', $id)->get(),
            ]);
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

            return Redirect::route('login_employee');
        }
            
    }

?>