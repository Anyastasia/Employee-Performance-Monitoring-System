<?php

namespace App\Http\Controllers;


use App\Models\AssignedTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SubmittedTask as Model;

class SubmittedTask extends Controller
{
    //

    public function store(Request $request) {
        
        // $rules = array(
        //     'task_id' => 'required',
        //     'submitted_attachments' => 'nullable',
        //     'notes' => 'nullable',
        // );
        // $validation = Validator::validate($request, $rules);
        // dd($request);
        // $request->validate([
        //     "task_id" => ['required'],
        //     "submitted_attachments" => ['nullable'],
        //     "notes" => ['nullable'],
        // ]);

        dd($request);
        // Model::create([
        //     "task_id" => $request->input('task_id'),
        //     "submitted_attachments" => $request->file('attachments')->store('images'),
        //     "notes" => $request->input('notes'),
        //     "status" => 'submitted',
        // ]);
    }

    public function update(Request $request){
        $model = Model::find($request->input('id'));
        $model->status = $request->input('status');
        $model->save();
    }
    
    public function resubmit(Request $request){
        $model = Model::find($request->input('id'));
        dd($model);
        // $model->submitted_attachments = $request->file('attachments')->store('images');
        // $model->notes = $request->input('notes');
        // $model->status = $request->input('status');

        // $model->save();
    }
}