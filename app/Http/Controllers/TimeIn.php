<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TimeIn as Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TimeIn extends Controller
{
    //

    public function store(Request $request, $id) {
        // $user = ($request->input('type') === 'TYPE_EMPLOYEE') ? Auth::guard('employee')->id() : Auth::guard('head')->id();         
        // dd($id);
        $shift_date = new Carbon($request->input('date'));
        $time = new Carbon($request->input('date'));
        $model = Model::create([
            "employee_id" => $id,
            "shift_date" => $shift_date->toDateString(),
            "time_in" => $time->toTimeString() ,
        ]);

        if ($time->greaterThan('08:00:00')) {
            $model->isLate = true;
        }

        $model->save();
        // dd($model);
    }
}
