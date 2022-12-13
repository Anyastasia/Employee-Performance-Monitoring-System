<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave as Model;
use Illuminate\Support\Facades\Redirect;

class Leave extends Controller
{
    //
    public function store(Request $request){
        $model = Model::create([
            "employee_id" => $request->employee_id,
            "leave_start_date" => $request->leave_date_start,
            "leave_due_date" => $request->leave_date_due,
            "reason" => $request->reason,
        ]);

        $model->save();

        return Redirect::route("employee.attendance");
    }
}
