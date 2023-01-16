<?php 

    namespace App\Http\Controllers;

use App\Http\Controllers\Attendance as ControllersAttendance;
use App\Http\Controllers\Controller;
    use App\Models\AssignedTask;
use App\Models\Attendance;

use Inertia\Inertia;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Redirect;
    use Carbon\Carbon;

    use App\Models\Employee as Model;
    use App\Models\Division;
use App\Models\Employee;
use App\Models\Evaluation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SendMail;
use App\Models\EvaluationForm;
use App\Models\Head as HeadModel;
use App\Models\Leave;
use App\Models\SubmittedTask;
use App\Models\TimeIn;
use Illuminate\Support\Facades\Auth;

    class Head extends Controller {


        // public function __construct()
        // {
        //     // $this->middleware('head');
        //     $this->evaluateAssignedTask();
        // }


        public function employees(Request $request) {

            $user = Model::where('id', Auth::guard('employee')->id())->get(['division_id'])->first();
            $division_id = $user['division_id'];

            $employees = Model::where('division_id', $division_id)
            ->where('status', 'active')
            ->where('is_admin', false)
            ->where('is_division_head', false)
            ->get(['id', 'first_name', 'last_name', 'email', 'division_id', 'position']);
            
            return Inertia::render('Head/HeadHome', [
                'employees' => $employees,
                'divisions' => Division::where('id', $division_id)->get(['id', 'name'])->first(),
                "xevaluationForm" => EvaluationForm::where('status', 'active')->get(),
            ]);
        }

        public function employee($id){
            $user = Model::where('id', Auth::guard('employee')->id())->get(['first_name', 'last_name', 'email', 'position', 'is_admin', 'is_division_head'])->first();
            return Inertia::render('Head/HeadEmployeeProfile', [
                "user" => $user,
                'employee' => Model::where('id', $id)->get()->first(),
                "assigned_tasks" => AssignedTask::where('employee_id', $id)->get(),
            ]);
        }

        public function view_task($id, Request $request) {
            return Inertia::render('Head/HeadViewTask', [
                "task" => AssignedTask::join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
                ->where('task_id', $id)
                ->get()->first(),  
                // "employee" => Model::where('id', Auth::guard('employee')->id())->get(['first_name', 'last_name', 'email', 'position', 'is_admin', 'is_division_head'])->first(),
            ]);
        }

        public function tasks() {
            return Inertia::render('Head/HeadTask', [
                "tasks" => AssignedTask::where('head_id', Auth::guard('employee')->id())->get(),
            ]);
        }

        public function task($id) {
            return Inertia::render('Head/HeadViewTask', [
                "task" => AssignedTask::where('id', $id)
                ->get()->first(),
            ]);
        }

        private function evaluateAssignedTask($employee) {
            $current_date = Carbon::now('UTC');
            $id = $employee;
            $submitted_task = AssignedTask::
            // join('submitted_tasks', 'assigned_tasks.id', '=', 'submitted_tasks.task_id')
            where('employee_id',$id)->
            where('status', 'active')->orWhere('status', 'revise')->
            // ->where('assigned_tasks.status', 'active')
            get();

            foreach($submitted_task as $task) {
                $task_date = Carbon::parse($task->submission_due_date, 'UTC');
                $model = AssignedTask::find($task->id);
                if ($current_date->greaterThan($task_date)) {
                    $model->is_priority = true;
                    $task->is_priority = true;
                    $model->save();                
                } else {
                    $model->is_priority = false;
                    $task->is_priority = false;
                    $model->save();
                }
            }
        }

        public function dashboard(Request $request) {
            // by default, only return first employee
            
            $head = Model::find(Auth::guard('employee')->id());
            $id = null;
            $employee = null;

            $employees = Model::where('division_id', $head->division_id)->where('status', 'active')
            ->where('is_division_head', false)
            ->where('is_admin', false)
            ->get(['id', 'first_name', 'last_name']);

            

            if (!$request->has(['id'])) {
                $id = Model::where('division_id', $head->division_id)->where('status', 'active')
                ->where('is_division_head', false)
                ->where('is_admin', false)
                ->get('id')->first();
                $employee = $id->id;
            } else {
                $employee = $request->id;
            }

            $this->evaluateAssignedTask($employee);

            if (!$request->has(['year'])) {
                $request->year = Carbon::now('utc')->year;
            }

         
            $performance = Evaluation::where('employee_id', $employee)->get(['rating', 'adjectival_rating']);
            $attendance = [];
            // $request->month = $request->month + 1;
            // if ($request->mode == 1) {
            //     // $performance = [
            //     //     // "efficiency" =>  Evaluation::where('employee_id', $employee->id)->groupBy(DB::raw('MONTH(created_at)', 'YEAR(created_at)'))->avg('efficiency'),
            //     //     "efficiency" => Evaluation::select(DB::raw('avg(efficiency) as average, month(created_at) as month, year(created_at) as year'))->groupBy(DB::raw('MONTH(created_at), YEAR(created_at)'))->get(),
            //     //      "quality" => Evaluation::select(DB::raw('avg(quality) as average, month(created_at) as month, year(created_at) as year'))->groupBy(DB::raw('MONTH(created_at), YEAR(created_at)'))->get(),
            //     //      "timeliness" => Evaluation::select(DB::raw('avg(timeliness) as average, month(created_at) as month, year(created_at) as year'))->groupBy(DB::raw('MONTH(created_at), YEAR(created_at)'))->get(),                        
            //     // ];

            //     $performance = [
            //         // "efficiency" =>  Evaluation::where('employee_id', $employee->id)->groupBy(DB::raw('MONTH(created_at)', 'YEAR(created_at)'))->avg('efficiency'),
            //         // "efficiency" => Evaluation::where('employee_id', $employee)->whereMonth('created_at', '=', $request->month)->whereYear('created_at', '=', $request->year)->avg('efficiency'),
            //         //  "quality" => Evaluation::where('employee_id', $employee)->whereMonth('created_at', '=', $request->month)->whereYear('created_at', '=', $request->year)->avg('quality'),
            //         //  "timeliness" => Evaluation::where('employee_id', $employee)->whereMonth('created_at', '=', $request->month)->whereYear('created_at', '=', $request->year)->avg('timeliness'),                        
            //         "efficiency" => 4,
            //         "quality" => 5,
            //         "timeliness" => 5,
            //     ];
            // } else if ($request->mode == 2) {
            //     $performance = [
            //         // "efficiency" =>  Evaluation::where('employee_id', $employee->id)->groupBy(DB::raw('MONTH(created_at)', 'YEAR(created_at)'))->avg('efficiency'),
            //         "efficiency" => Evaluation::where('employee_id', $employee)->whereYear('created_at', '=', $request->year)->avg('efficiency'),
            //          "quality" => Evaluation::where('employee_id', $employee)->whereYear('created_at', '=', $request->year)->avg('quality'),
            //          "timeliness" => Evaluation::where('employee_id', $employee)->whereYear('created_at', '=', $request->year)->avg('timeliness'),                        
            //     ];
            // }
            // else if ($request->mode == 3) {
            //     $performance = [
            //         // "efficiency" =>  Evaluation::where('employee_id', $employee->id)->groupBy(DB::raw('MONTH(created_at)', 'YEAR(created_at)'))->avg('efficiency'),
            //         "efficiency" => Evaluation::where('employee_id', $employee)->whereYear('created_at', '=', $request->year)->whereBetween(DB::raw('month(created_at)'), [1,6])->avg('efficiency'),
            //         // "efficiency" => Evaluation::where('employee_id', $employee)->selectRaw('avg(efficiency as efficiency')->whereRaw('month(created_at) between 1 and 6')->get(),
            //         "quality" => Evaluation::where('employee_id', $employee)->whereYear('created_at', '=', $request->year)->whereBetween(DB::raw('month(created_at)'), [1,6])->avg('quality'),
            //          "timeliness" => Evaluation::where('employee_id', $employee)->whereYear('created_at', '=', $request->year)->whereBetween(DB::raw('month(created_at)'), [1,6])->avg('timeliness'),                        
            //     ];
            // }
            // else if ($request->mode == 4) {
            //     $performance = [
            //         "efficiency" => Evaluation::where('employee_id', $employee)->whereYear('created_at', $request->year)->whereBetween(DB::raw('month(created_at)'), [7,12])->avg('efficiency'),
            //         "quality" => Evaluation::where('employee_id', $employee)->whereYear('created_at', $request->year)->whereBetween(DB::raw('month(created_at)'), [7,12])->avg('quality'),
            //          "timeliness" => Evaluation::where('employee_id', $employee)->whereYear('created_at', $request->year)->whereBetween(DB::raw('month(created_at)'), [7,12])->avg('timeliness'),                        
            //     ];
            // } else if ($request->mode == 0) {
            //     $performance = [
            //         "efficiency" =>  Evaluation::where('employee_id', $employee)->avg('efficiency'),
            //         "quality" =>  Evaluation::where('employee_id', $employee)->avg('quality'),
            //         "timeliness" =>  Evaluation::where('employee_id', $employee)->avg('timeliness'),
            //     ];
            // }
            
            // attendanmce 

            //$attendance = [
                // "present" => TimeIn::where('employee_id', $employee)->get(['id', 'employee_id', 'shift_date'])->map(function ($attendance) {
                //     return [
                //         "total_hours" => TimeIn::join('time_outs', 'time_ins.shift_date, time_ins.employee_id', '=', 'time_outs.shift_date, time_outs.employee_id')->
                //         // join('time_outs as B', 'time_ins.employee_id', '=', 'B.employee_id')->
                //         where('time_ins.employee_id', $attendance->employee_id)->
                //         selectRaw('time_ins.shift_date, timediff(time_in, time_outs.time_out)')->
                //         get(),
                //     ];
                // }),
                // "present" => [
                //     "total_hours" => DB::raw('select time_ins.employee_id, time_ins.shift_date, timediff(time_ins.time_in, time_outs.time_out), time_ins.time_in, time_outs.time_out from time_ins inner join time_outs
                //     on time_ins.employee_id = time_outs.employee_id and time_ins.shift_date = time_outs.shift_date where time.ins_employee_id = 3')
                // ]
                // "present" => TimeIn::join('time_outs as A', 'time_ins.id', '=', 'A.time_in_id')->
                // join('time_outs as B', 'time_ins.employee_id', '=', 'B.employee_id')->
                //where('time_ins.employee_id', $employee)->
                //selectRaw('time_ins.id, time_ins.time_in, A.time_out, time_ins.shift_date, abs(timediff(time_in, A.time_out)) as working_hours')->
                //get(),
                // "leave" => Leave::where('employee_id', $employee)->get('shift_date'),
           // ];
            
           $attendance = ControllersAttendance::getAttendanceReportMonthly($employee);
            // $employees = Model::where('division_id', $head->division_id)->where('status', 'active')
            // ->where('is_division_head', false)g
            // ->where('is_admin', false)
            // ->get(['id', 'first_name', 'last_name', 'position']);
            // dd($employees);
            // $data = [];

            // foreach($employees as $employee) {

                
            //         // $completed_task = AssignedTask::where('head_id', $head->id)->where('employee_id', $employee->id)
            //         // ->where('status', 'complete')->orWhere('status', 'evaluated')->count();
                    
            //         // $active_task =  AssignedTask::where('head_id', $head->id)->where('employee_id', $employee->id)
            //         // ->where('status', 'active')->count();
                    
            //         // $priority_task =  AssignedTask::where('head_id', $head->id)->where('employee_id', $employee->id)
            //         // ->where('status', 'active')->where('is_priority', true)->count();
                    
            //         // $data[0] =
            //         //     [ 
            //         //     "id" => $employee->id,    
            //         //     "first_name" =>$employee->first_name, 
            //         //     "last_name" => $employee->last_name, 
            //         //     "email" => $employee->email, 
            //         //     "position" => $employee->position, 
            //         //     "completed_task" => $completed_task, 
            //         //     "active_task" => $active_task, 
            //         //     "priority_task" => $priority_task
            //         //     ];
            //         // array_push($data, $xdata);
                

            //     // array_push($data, [                    $employee->id => [ 
            //     //     "first_name" =>$employee->first_name, 
            //     //     "last_name" => $employee->last_name, 
            //     //     "email" => $employee->email, 
            //     //     "position" => $employee->position, 
            //     //     "completed_task" => $completed_task, 
            //     //     "active_task" => $active_task, 
            //     //     "priority_task" => $priority_task
            //     //     ]]);
            // }

            $completed_task = AssignedTask::where('employee_id', $employee)
            ->where(function ($query){
                $query->where('status', 'complete')->orWhere('status', 'evaluated');
            })->count();
            

            $active_task =  AssignedTask::where('employee_id', $employee)
            ->where('status', 'active')->count();
            
            $priority_task =  AssignedTask::where('employee_id', $employee)
            ->where('status', 'active')->where('is_priority', true)->count();
            
            $tasks = [
                "completed" => $completed_task,
                "active" => $active_task,
                "priority" => $priority_task,
            ];

            return Inertia::render('Head/HeadDashboard', [
                "employees" => $employees,
                "xemployee" => fn () => Model::where('division_id', $head->division_id)->where('status', 'active')
                ->where('id', $employee)
                ->where('is_division_head', false)
                ->where('is_admin', false)
                ->get(['id', 'first_name', 'last_name', 'position', 'email'])
                ->map(function ($employee) {
                    $completed_task = AssignedTask::where('employee_id', $employee->id)
                    ->where('status', 'complete')->orWhere('status', 'evaluated')->count();
                    
                    $months = Evaluation::where('employee_id', $employee->id)->select(DB::raw('MONTH(created_at) as month'))->pluck('month')->unique()->values()->all();
                    $years = Evaluation::where('employee_id', $employee->id)->select(DB::raw('YEAR(created_at) as year'))->pluck('year')->unique()->values()->all();

                    $active_task =  AssignedTask::where('employee_id', $employee->id)
                    ->where('status', 'active')->count();
                    
                    $priority_task =  AssignedTask::where('employee_id', $employee->id)
                    ->where('status', 'active')->where('is_priority', true)->count();
                    
                    return [
                        "id" => $employee->id,    
                        "first_name" =>$employee->first_name, 
                        "last_name" => $employee->last_name, 
                        "email" => $employee->email, 
                        "position" => $employee->position,
                        "completed_task" => $completed_task, 
                        "active_task" => $active_task, 
                        "priority_task" => $priority_task,
                        "months" => Evaluation::where('employee_id', $employee->id)->select(DB::raw('MONTH(created_at) as month'))->pluck('month')->unique()->values()->all(),
                        "years" => Evaluation::where('employee_id', $employee->id)->select(DB::raw('YEAR(created_at) as year'))->pluck('year')->unique()->values()->all(),
                        // "performance" => [
                        //    "efficiency" =>  Evaluation::where('employee_id', $employee->id)->avg('efficiency'),
                        //     "quality" => Evaluation::where('employee_id', $employee->id)->avg('quality'),
                        //     "timeliness" =>Evaluation::where('employee_id', $employee->id)->avg('timeliness')    
                        // ],
                        // "performanceMonthly" => [
                        //     "efficiency" =>  Evaluation::where('employee_id', $employee->id)->groupBy(DB::raw('MONTH(created_at)', 'YEAR(created_at)'))->avg('efficiency'),
                        //     "efficiency" => Evaluation::select(DB::raw('avg(efficiency) as average, month(created_at) as month, year(created_at) as year'))->groupBy(DB::raw('MONTH(created_at), YEAR(created_at)'))->get(),
                        //      "quality" => Evaluation::select(DB::raw('avg(quality) as average, month(created_at) as month, year(created_at) as year'))->groupBy(DB::raw('MONTH(created_at), YEAR(created_at)'))->get(),
                        //      "timeliness" => Evaluation::select(DB::raw('avg(timeliness) as average, month(created_at) as month, year(created_at) as year'))->groupBy(DB::raw('MONTH(created_at), YEAR(created_at)'))->get(),                        
                        //     ],
                        // Evaluation::where('employee_id', $employee->id)->groupBy(DB::raw('MONTH(created_at)'))->get(),                        
                        // "performanceYearly" => [
                        //     "efficiency" =>  Evaluation::where('employee_id', $employee->id)->groupBy(DB::raw('YEAR(created_at)'))->avg('efficiency'),
                        //     "efficiency" => Evaluation::select(DB::raw('avg(efficiency) as average, year(created_at) as year'))->groupBy(DB::raw('YEAR(created_at)'))->get(), 
                        //     "quality" => Evaluation::select(DB::raw('avg(quality) as average, year(created_at) as year'))->groupBy(DB::raw('YEAR(created_at)'))->get(), 
                        //      "timeliness" => Evaluation::select(DB::raw('avg(timeliness) as average, year(created_at) as year'))->groupBy(DB::raw('YEAR(created_at)'))->get(),     
                        //  ]
                    ];
                })->first(),
                "division" => Division::find($head->division_id)->get('name')->first(),
                "tasks" => fn () => $tasks,
                "performance" => fn () => $performance,
                "options" => fn () => [
                    "index" => $employee,
                    "mode" => $request->mode,
                    "year" => $request->year,
                    "month" => $request->month,
                ],
                "attendance" => fn () => $attendance,
                "attendanceMonthly" => fn() => ControllersAttendance::getAttendanceReportMonthly($employee),
                "attendanceWeekly" => ControllersAttendance::getAttendanceReportWeekly($employee),
                "leaves" => ControllersAttendance::getLeave($employee),
                // "data" => Inertia::lazy(fn () => $data),
                // "tasks" => AssignedTask::where('head_id', $head->id)->get(),
            ]);
        }
    }

?>

