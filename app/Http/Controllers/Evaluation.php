<?php

namespace App\Http\Controllers;

use App\Http\Requests\Head\EvaluationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Evaluation as Model;

class Evaluation extends Controller
{
    //
    public function store(EvaluationRequest $request) {
        // dd($request);

        if ($request->adjectivalRating == null) {
            return Redirect::back()->withErrors(["rating_required" => "Required."]);
        }

        Model::create([
            "employee_id" => $request->employee_id,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "rating" => $request->finalAverageRating,
            "adjectival_rating" => $request->adjectivalRating,
            "self" => $request->self                        ,
        ]);

        // $model->save();

        if ($request->self == true) {
            return Redirect::route('employee.evaluation')->with('success', 'Evaluation Successful');
        }
        return Redirect::route('head_employees', $request->employee_id)->with('success', 'Employee evaluated');
    }
}
