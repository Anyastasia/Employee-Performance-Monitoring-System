<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssignedTask as Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mail as XMail;
use App\Http\Requests\Head\AssignTaskRequest;
use App\Models\Employee;
use Carbon\Carbon;

class AssignedTask extends Controller
{
    //

    public function store(AssignTaskRequest $request) {

    // dd($request);
    // $path = $request->file('attachments')[0]->store('public/images');
    // $length = count($request->input('employee_id'));
    // $employee = array();
    // for ($index = 0; $index < $length; $index++) {  
    //     array_push($employee, ["employee_id" => $request->input('employee_id')[$index]]);
    //     // array_push($employee, $request->input('employee_id')[$index]);
    // }
   
    // $employee = array_fill_keys($keys, $request->input('employee_id'));
    // $model = Model::create([
    //     'head_id' => $request->input('head_id'),
    //     'task_title' => $request->input('task_title'),
    //     'task_description' => $request->input('task_description'),
    //     'attachments' => $request->input('attachments')[0]->store('images'),
    //     'submission_start_date' => $request->input('submission_start_date'),
    //     'submission_start_time' => $request->input('submission_start_time'),
    //     'submission_due_date' => $request->input('submission_due_date'),
    //     'submission_due_time' => $request->input('submission_due_time'),
    // ]);
    $file_name = '';
    if ($request->hasFile('attachments')) {
        $file_name = Storage::putFile('uploads', $request->attachments[0]);
    }
    // $model->employees()->createMany($employee);
    // for ($index = 0; $index < $length; $index++) {
        $model = Model::create([
                'head_id' => $request->input('head_id'),
                'employee_id' => $request->input('employee_id'),
                'task_title' => $request->input('task_title'),
                // 'output' => $request->input('title'),
                'task_description' => $request->input('task_description'),
                'attachments' => $file_name,
                'submission_start_date' => Carbon::parse($request->input('submission_start_date'))->tz('UTC'),
                'submission_due_date' => Carbon::parse($request->input('submission_due_date'))->tz('UTC'),
                "comment" => "",
        ]);

        $employee_model = Employee::where('id', $request->input('employee_id'))->get(['id','email', 'first_name', 'new_task_given'])->first();
        $employee_model->new_task_given = true;
        $employee_model->save();
    // }
    
    $due_date = Carbon::create($model->submission_due_date)->setTimezone('Asia/Hong_Kong');
    $email = [
        "subject" => "New Task Assigned",
        "body" => "A new task has been assigned to you. Please finish the task in time.",
        "first_name" => $employee_model->first_name,
        "task_title" => $model->task_title,
        "task_description" => $model->task_description,
        "due_date" => $due_date->toDayDateTimeString(),
    ];

    Mail::to($employee_model->email)->send(new XMail($email));

    return Redirect::route('head_employees')->with('info', 'Task assigned.');
    // $model->saveMany($request->input('employee_id'));
    // $length = count($request->input('employee_id'));

    // for ($index = 0; $index < $length; $index++) {
    //     $model = Model::create([
    //         'employee_id' => $request->input('employee_id')[$index],
    //         'head_id' => $request->input('head_id'),
    //         'task_title' => $request->input('task_title'),
    //         'task_description' => $request->input('task_description'),
    //         'attachments' => $request->input('attachments'),
    //         'submission_start_date' => $request->input('submission_start_date'),
    //         'submission_start_time' => $request->input('submission_start_time'),
    //         'submission_due_date' => $request->input('submission_due_date'),
    //         'submission_due_time' => $request->input('submission_due_time'),
    //     ]);
    // }
    // foreach($request->input('employee_id') as $employee) {
    //     Model::create([
    //         'employee_id' => $employee,
    //         'head_id' => $request->input('head_id'),
    //         'task_title' => $request->input('task_title'),
    //         'task_description' => $request->input('task_description'),
    //         'attachments' => $request->input('attachments'),
    //         'submission_start_date' => $request->input('submission_start_date'),
    //         'submission_start_time' => $request->input('submission_start_time'),
    //         'submission_due_date' => $request->input('submission_due_date'),
    //         'submission_due_time' => $request->input('submission_due_time'),
    //     ]);
    // }

    }

    public function update(Request $request) {
        $model = Model::find($request->id);

        $model->task_title = $request->task_title;
        $model->task_description = $request->task_description;
        $model->attachments = $request->attachments;
        $model->submission_start_date = Carbon::parse($request->submission_start_date)->tz('UTC');
        $model->submission_due_date = Carbon::parse($request->submission_due_date)->tz('UTC');

        $model->save();

        return Redirect::route('head.tasks')->with('success', 'Task Details changed');
    }
    
    public function update_status(Request $request, $id) {
        $model = Model::find($id);
        $model->status = $request->input('status');
        $model->comment = $request->input('comment');
        $model->save();
        return Redirect::back();
    }
}
