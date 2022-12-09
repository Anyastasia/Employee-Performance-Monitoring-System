<?php

namespace App\Http\Controllers\Change\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employee;
class EmployeeDetails extends Controller
{
    //

    public function update(Request $request){
        $model = Employee::where('id', $request->id)->get()->first();

        $model->first_name = $request->first_name;

        $model->first_name = $request->first_name;
        $model->last_name = $request->last_name;
        $model->position = $request->position;
        $model->is_division_head = $request->is_division_head;
        
        $model->save();
    }
}
