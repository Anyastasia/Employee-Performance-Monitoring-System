<?php

namespace App\Http\Controllers\Change\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employee;
use Illuminate\Support\Facades\Redirect;
class EmployeeDetails extends Controller
{
    //

    public function update(Request $request){
        $model = Employee::where('id', $request->id)->get()->first();

        $model->first_name = $request->first_name;

        $model->first_name = $request->first_name;
        $model->last_name = $request->last_name;
        
        
        if ($request->is_division_head == true) {
            $division_heads = Employee::where('is_division_head', true)->where('status', 'active')->get();
            foreach($division_heads as $head) {
                $head->is_division_head = false;
                $head->position = 'Agent';
                $head->save();
            }
            
            $model->position = "Division Head";

            $model->is_division_head = $request->is_division_head;
        
            $model->save();
        }
        else {
            $model->position = $request->position;
        }
        $model->save();
        return Redirect::route('admin.employees', $model->division_id)->with('info', 'Employee details updated.');
    }
}
