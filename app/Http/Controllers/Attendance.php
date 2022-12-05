<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Attendance as Model;
use Illuminate\Support\Facades\Auth;


class Attendance extends Controller
{
    //

    public function store(Request $request) {
        $user = ($request->input('type') === 'TYPE_EMPLOYEE') ? Auth::guard('employee')->id() : Auth::guard('head')->id();         
        
        $model = Model::create([
            "employee_id" => $user,
            "shift_date" => $request->input('shift_date'),
            "time_in" => $request->input('time_in'),
            "time_out" => $request->input('time_out'),
        ]);

        $model->save();
    }
}
