<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Evaluation as Model;
use App\Models\AssignedTask;
class Evaluation extends Controller
{
    //
    public function store(Request $request) {
        $model = Model::create([
            "employee_id" => $request->employee_id,
            "task_id" => $request->task_id,
            "efficiency" => $request->efficiency,
            "quality" => $request->quality,
            "timeliness" => $request->timeliness,
        ]);

        $assigned_task = AssignedTask::find($request->task_id);
        $assigned_task->status = "evaluated";
        
        $assigned_task->save();
        $model->save();
        return Redirect::route('employee.view', $request->employee_id);
    }
}
