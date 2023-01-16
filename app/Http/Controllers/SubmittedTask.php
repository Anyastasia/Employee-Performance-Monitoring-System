<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\SubmittedTask as Model;
use App\Models\AssignedTask;
use Illuminate\Support\Facades\Redirect;


class SubmittedTask extends Controller
{
    //

    public function store(Request $request) {
        
        $file_name = '';
        $request->validate([
            "task_id" => ['required'],
            "submitted_attachments" => ['nullable'],
            "notes" => ['required'],
        ]);

        if ($request->hasFile('attachments')) {
            $file_name = $request->file('attachments')->store('uploads');
        }

        if($request->notes == null) {
            return Redirect::back()->withErrors(["notes_requuired" => "Required."]);
        }

        $model = Model::create([
            "task_id" => $request->input('task_id'),
            "submitted_attachments" => $file_name,
            "notes" => $request->input('notes'),
            "submission_status" => "submitted"
        ]);

        $assigned_task = AssignedTask::find($model->task_id);
        $assigned_task->status = 'submitted';
        $assigned_task->save();
        // return Redirect::route('employee.task', ["id" => $model->id]);
        return redirect('/active');
    }

    public function update(Request $request){
        $model = Model::find($request->input('id'));
        $assigned_task = AssignedTask::find($model->task_id);
        $model->submission_status = 'resubmit';
        $assigned_task->status = "active";
        $assigned_task->save();
        $model->save();
        return Redirect::route('employee.task', ["id" => $model->task_id]);
    }
    
    public function resubmit(Request $request){
        $model = Model::find($request->input('id'));
        $assigned_task = AssignedTask::find($model->task_id);
        

        $request->validate([
            "submitted_attachments" => ['nullable'],
            "notes" => ['nullable'],
        ]);

        if ($request->hasFile('attachments')) {
            $file_name = $request->file('attachments')->store('uploads');
            $model->submitted_attachments = $file_name;
        }

        $model->notes = $request->input('notes');
        $model->submission_status = 'submitted';
        $assigned_task->status = 'submitted';
        
        $model->save();
        $assigned_task->save();
        return Redirect::back();
    }

}
