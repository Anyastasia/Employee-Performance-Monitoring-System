<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Models\EvaluationForm as Model;
class EvaluationForm extends Controller
{
    //

    public function store(Request $request) {
        $count = count($request->evaluation_form);
        // dd($request);
        if ($request->mode == 'selected') {
            for ($index = 0; $index < $count; $index++) {
                Model::updateOrCreate([
                    "id" => $request->evaluation_form[$index]['id'],
                ], [
                    "employee_id" => $request->employee_id,
                    "division_id" => $request->division_id,
                    "output" => $request->evaluation_form[$index]['output'],
                    "success_indicators" => $request->evaluation_form[$index]['success_indicators'],
                    "quality_indicators" => $request->evaluation_form[$index]['quality_indicators'],
                    "efficiency_indicators" => $request->evaluation_form[$index]['efficiency_indicators'],
                    "timeliness_indicators" => $request->evaluation_form[$index]['timeliness_indicators'],
                    "status" => $request->evaluation_form[$index]['status'],                
                ]);
            }
        } else {
            $employee_count = count($request->employees); 
                for ($eindex = 0; $eindex < $employee_count; $eindex++) {

                    for ($findex = 0; $findex < $count; $findex++) {
                        Model::create([
                            "employee_id" => $request->employees[$eindex]['id'],
                            "division_id" => $request->division_id,
                            "output" => $request->evaluation_form[$findex]['output'],
                            "success_indicators" => $request->evaluation_form[$findex]['success_indicators'],
                            "quality_indicators" => $request->evaluation_form[$findex]['quality_indicators'],
                            "efficiency_indicators" => $request->evaluation_form[$findex]['efficiency_indicators'],
                            "timeliness_indicators" => $request->evaluation_form[$findex]['timeliness_indicators'],
                        ]);
                    }
                }
        }


        return Redirect::route('head_employees')->with('info', 'Saved.');
    }

    public function delete($id) {
        $model = Model::where('id', $id)->get('status')->first();

        $model->status = 'inactive';

        $model->save();

        return Redirect::route('head_employees')->with('info', 'Saved.');
    }
}
