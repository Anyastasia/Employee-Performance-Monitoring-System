<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssignedTask as Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;


class AssignedTask extends Controller
{
    //

    public function store(Request $request) {

    // dd($request);
    // $path = $request->file('attachments')[0]->store('public/images');
    $length = count($request->input('employee_id'));
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
    for ($index = 0; $index < $length; $index++) {
        $model = Model::create([
                'head_id' => $request->input('head_id'),
                'employee_id' => $request->input('employee_id')[$index],
                'task_title' => $request->input('task_title'),
                'task_description' => $request->input('task_description'),
                'attachments' => $file_name,
                'submission_start_date' => $request->input('submission_start_date'),
                'submission_start_time' => $request->input('submission_start_time'),
                'submission_due_date' => $request->input('submission_due_date'),
                'submission_due_time' => $request->input('submission_due_time'),
        ]);
    }

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

}
