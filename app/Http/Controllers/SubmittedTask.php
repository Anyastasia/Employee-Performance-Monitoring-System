<?php

namespace App\Http\Controllers;


use App\Models\AssignedTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\SubmittedTask as Model;

class SubmittedTask extends Controller
{
    //

    public function store(Request $request) {
        
        $file_name = '';
        $request->validate([
            "task_id" => ['required'],
            "submitted_attachments" => ['nullable'],
            "notes" => ['nullable'],
        ]);

        if ($request->hasFile('attachments')) {
            $file_name = $request->file('attachments')->store('uploads');
        }

        Model::create([
            "task_id" => $request->input('task_id'),
            "submitted_attachments" => $file_name,
            "notes" => $request->input('notes'),
            "status" => 'submitted',
        ]);
    }

    public function update(Request $request){
        $model = Model::find($request->input('id'));
        $model->status = $request->input('status');
        $model->save();
    }
    
    public function resubmit(Request $request){
        $model = Model::find($request->input('id'));

        $request->validate([
            "submitted_attachments" => ['nullable'],
            "notes" => ['nullable'],
        ]);

        if ($request->hasFile('attachments')) {
            $file_name = $request->file('attachments')->store('uploads');
            $model->submitted_attachments = $file_name;
        }

        $model->notes = $request->input('notes');
        $model->status = $request->input('status');

        $model->save();
    }

}
