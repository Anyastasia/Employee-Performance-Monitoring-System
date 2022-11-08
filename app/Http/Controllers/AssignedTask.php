<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssignedTask as Model;
class AssignedTask extends Controller
{
    //

    public function store(Request $request) {

        // $data = $request->validate([
        //     'employee_id' => ['required'],
        //     'head_id' => ['required'],
        //     'task_title' => ['required'],
        //     'task_attachments' => ['file'],
        // ]);

        // Model::create([
        //     'employee_id' => $request->input('employee_id'),
        //     'head_id' => $request->input('head_id'),
        //     'task_title' => $request->input('task_title'),
        //     'task_description' => $request->input('task_description'),
        //     'attachments' => $request->input('attachments'),
        //     'submission_due' => $request->input('submission_start_date'),
        //     'submission_due' => $request->input('submission_start_time'),
        //     'submission_due' => $request->input('submission_due_date'),
        //     'submission_due' => $request->input('submission_due_time'),
        // ]);

        dd($request);
    }
}
