<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TimeOut as Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TimeOut extends Controller
{
    //

    public function store(Request $request) {
        $user = ($request->input('type') === 'TYPE_EMPLOYEE') ? Auth::guard('employee')->id() : Auth::guard('head')->id();         
        $shift_date = new Carbon($request->input('date'));
        $time = new Carbon($request->input('date'));

        $model = Model::create([
            "employee_id" => $user,
            "shift_date" => $shift_date->toDateString(),
            "time_out" => $time->toTimeString(),
        ]);

        $model->save();
    }
}
