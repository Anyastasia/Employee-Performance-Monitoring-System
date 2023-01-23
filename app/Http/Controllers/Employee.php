<?php 

    namespace App\Http\Controllers;


    
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\Controller;
    use App\Models\Employee as Model;
    use App\Models\Division;
    use App\Models\AssignedTask;
use App\Models\Employee as ModelsEmployee;
use App\Models\SubmittedTask;
    use App\Models\TimeIn;
    use App\Models\TimeOut;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;

    use App\Http\Controllers\SendMail;
use App\Models\Evaluation;
use App\Models\EvaluationForm;
use Inertia\inertia;
    use Carbon\Carbon;
    class Employee extends Controller {
        
        public function __construct()
        {
            $this->middleware('employee');
        }
 
        public function home() {

            $employee = Auth::guard('employee')->user();
            // dd($employee);
            return Inertia('Employee/EmployeeHome', [
                // "employee" => $employee,
                "items" => AssignedTask::where('employee_id', $employee['id'])->get(),
            ]);
        }


        public function profile() {
            $id = Auth::guard('employee')->id();
            return Inertia('Employee/EmployeeProfile', [
                // "employee" => Model::where('id', $id)->get(['first_name', 'last_name', 'email', 'position', 'is_admin', 'is_division_head'])->first(),
            ]);
        }

        public function task($task_id) {

            $user = Model::where('id', Auth::guard('employee')->id())->get(['first_name', 'last_name', 'email', 'position', 'is_admin', 'is_division_head'])->first();
            $submitted_task = SubmittedTask::where('task_id', $task_id)->get(['id', 'task_id', 'submitted_attachments', 'notes', 'submission_status']);
            if (count($submitted_task) == 0) {
                $task = AssignedTask::where('id', $task_id)->get()->first();
                $task['submission_status'] = 'active';
                
                return Inertia('Employee/EmployeeTask', ["task" => $task]);
            }
            else {
                return Inertia('Employee/EmployeeTask', [
                    // "task" => AssignedTask::where('id', $task_id)->get()[0],
                    "task" => AssignedTask::join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
                    ->where('assigned_tasks.id', $task_id)
                    ->get()->first(), 

                    // "employee" => $user
                ]);
            }

            // return Inertia('Employee/EmployeeTask', [
            //     "task" => AssignedTask::join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
            //     ->where('assigned_tasks.id', $task_id)
            //     ->get()[0],
            // ]);
        }

        // public function view_task($id) {
        //     return Inertia::render('Head/HeadViewTask', [
        //         "task" => AssignedTask::join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
        //         ->where('task_id', $id)
        //         ->get()->first(),
        //         "employee" => Auth::guard('employee')->user()
        //     ]);
        // }


        public function employee_list() {

            $user = Model::where('id', Auth::guard('employee')->id())->get(['first_name', 'last_name', 'email', 'position', 'is_admin', 'is_division_head'])->first();
            $division_id = $user['division_id'];

            return Inertia::render('Head/HeadHome', [
                'employees' => Model::where('division_id', $division_id)
                ->where('status', 'active')
                ->where('is_admin', false)
                ->where('is_division_head', false)
                ->get(['id', 'first_name', 'last_name', 'email', 'division_id', 'position']),
                'divisions' => Division::where('id', $division_id)->get(['id', 'name'])->first(),
                // 'employee' => $user,
            ]);
        }

        public function get_employee_by_division($id) {
            return Inertia::render('Admin/AdminEmployee', [
                // 'employees' => Model::where('division_id', $id)->get()
            ]); 
        }

        public function employee_list_admin($id) {
            if ($id == 0) {
                return Inertia('Admin/AdminEmployee', [
                    'employees' => Model::where('status', 'active')->get(), 
                    'divisions' => Division::where('status', 'active')->get(),
                    // 'employee' => Model::where('id', Auth::guard('employee')->id())->get(['first_name', 'last_name', 'email', 'position', 'is_admin', 'is_division_head'])->first(),
                    "division_id" => $id,
                    "showAlertDeleteEmployee" => Inertia::lazy(fn () => true),
                ]);
            } else {
                return Inertia('Admin/AdminEmployee', [
                    'employees' => Model::where('status', 'active')
                    ->where('division_id', $id)->get(), 
                    'divisions' => Division::where('status', 'active')->get(),
                    // 'employee' => Model::where('id', Auth::guard('employee')->id())->get(['first_name', 'last_name', 'email', 'position', 'is_admin', 'is_division_head'])->first(),
                    "division_id" => $id,
                    "showAlertDeleteEmployee" => Inertia::lazy(fn () => true)
                ]);
            }
        }

        public function division_list_admin() {
            return Inertia('Admin/AdminDivision', [
                'divisions' => Division::where('status', 'active')->get(),
                // 'employee' => Model::where('id', Auth::guard('employee')->id())->get(['first_name', 'last_name', 'email', 'position', 'is_admin', 'is_division_head'])->first(),
            ]);
        }

        // public function dashboard() {
        //     $head = Model::find(Auth::guard('employee')->id());
        //     return Inertia::render('Head/HeadDashboard', [
        //         "employee" => $head,
        //         "employees" => Model::where('division_id', $head->division_id)->where('status', 'active')->get(),
        //         "division" => Division::find($head->division_id)->get('name')->first(),
        //     ]);
        // }

        // public function employee($id){
        //     return Inertia::render('Head/HeadEmployeeProfile', [
        //         "user" => Auth::guard('employee')->user(),
        //         'employee' => Model::where('id', $id)->get()->first(),
        //         "assigned_tasks" => AssignedTask::where('employee_id', $id)->get(),
        //     ]);
        // }
        // )->where('is_admin', false)->where('is_division_head', false)->
        public function completed() {
            $id = Auth::guard('employee')->id();
            $submitted_task = AssignedTask::join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
            ->where('employee_id',$id)
            ->where('status', 'complete')
            ->orWhere('status', 'evaluated')
            ->get();

            return Inertia('Employee/EmployeeHome', [
                "items" => $submitted_task,
            ]);
        }

        public function active(Request $request) {

            $current_date = Carbon::now('UTC');
            $id = Auth::guard('employee')->id();
            $employee = Model::where('id', $id)->get(['id','first_name','priority_task_given', 'new_task_given'])->first();
            $submitted_task = AssignedTask::
            // join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
            where('employee_id',$id)->
            where('status', 'active')->orWhere('status', 'revise')->
            // ->where('assigned_tasks.status', 'active')
            get();
            // dd($employee);
            foreach($submitted_task as $task) {
                
                $task_date = Carbon::parse($task->submission_due_date, 'UTC');
                $model = AssignedTask::find($task->id);
                if ($current_date->greaterThan($task_date)) {
                    $model->is_priority = true;
                    $task->is_priority = true;
                    $employee->priority_task_given = true;
                    $model->save();
                } else {
                    $model->is_priority = false;
                    $task->is_priority = false;
                    $employee->priority_task_given = false;
                    $model->save();
                }
            }

            if ($request->has('new_task_given')) {
                $employee->new_task_given = $request->new_task_given;
            }

            $employee->save();
            // dd($request->new_task_given);
            return Inertia('Employee/EmployeeHome', [
                "items" => $submitted_task,
            ]);
        }

        public function priority(Request $request) {
            $employee = Model::find(Auth::guard('employee')->id())->get('id','priority_task_given')->first();
            $employee->priority_task_given = $request->input('priority_task_given');
            $employee->save();

            return Inertia('Employee/EmployeeHome', [
                "items" => AssignedTask::where('employee_id', Auth::guard('employee')->id())
                ->where('is_priority', true)->get(),
            ]);
        }

        public function evaluation(Request $request) {
            $evaluationForm = EvaluationForm::where('employee_id', Auth::guard('employee')->id())->where('status', 'active')->get();
            $evaluations = Evaluation::where('employee_id', Auth::guard('employee')->id())->where('self', true)->get();
            $xevaluation = [
                "self_evaluation" => Evaluation::where('id', $request->self_evaluation_id)->get()->first(),
                "division_head" => Evaluation::where('self_evaluation_id', $request->self_evaluation_id)->get(['rating', 'adjectival_rating'])->first(),
            ];
            // dd($xevaluation);
            if (!$xevaluation['division_head']){
                $xevaluation['division_head']['rating'] = 0;
                $xevaluation['division_head']['adjectival_rating'] = "N/A";
            }

            if (!$xevaluation['self_evaluation']){
                $xevaluation['self_evaluation']['rating'] = 0;
                $xevaluation['self_evaluation']['adjectival_rating'] = "N/A";
            }
            
            return Inertia('Employee/EmployeeSelfEvaluation', [
                'xevaluationForm' => $evaluationForm,
                "evaluations" => $evaluations,
                "xevaluation" => Inertia::lazy(fn () => $xevaluation),
            ]);
        }

        public function attendance() {
            $user = Auth::guard('employee')->id();

            return Inertia('Employee/EmployeeAttendance', [
                "attendance" => TimeIn::join('time_outs', 'time_ins.id', '=', 'time_outs.time_in_id')->where('time_ins.employee_id', $user)->get(),
                "time_ins" => TimeIn::where('employee_id', $user)->get()->last(),
                "employees" => Model::where('division_id', $user)->where('is_admin', true)->orWhere('is_admin', false)
                ->get(['id', 'first_name', 'last_name']),
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