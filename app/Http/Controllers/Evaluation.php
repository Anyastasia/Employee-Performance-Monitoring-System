<?php

namespace App\Http\Controllers;

use App\Http\Requests\Head\EvaluationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Evaluation as Model;
use App\Models\EvaluationScore;

class Evaluation extends Controller
{
    //
    public function store(EvaluationRequest $request) {
        // dd($request);

        // dd($request->scores->evaluation_id);
        if ($request->adjectivalRating == null) {
            return Redirect::back()->withErrors(["rating_required" => "Required."]);
        }

        
        $model = Model::create([
            "employee_id" => $request->employee_id,
            "self_evaluation_id" => $request->self_evaluation_id,
            "evaluated_by" => $request->evaluated_by,
            "start_date" => $request->start_date,
            "end_date" => $request->end_date,
            "total_average_rating" => $request->totalAverageRating,
            "rating" => $request->finalAverageRating,
            "adjectival_rating" => $request->adjectivalRating,
            "self" => $request->self                        ,
        ]);

        // $model->save();
        if ($request->self == true) {
            return Redirect::route('employee.evaluation')->with('success', 'Evaluation Successful');
        }

        for ($i=0; $i < count($request->scores); $i++) { 
            # code...
            EvaluationScore::create([
                "evaluation_id" => $model->id,
                "evaluation_form_id" => $request->scores[$i]['evaluation_form_id'],
                "quality_average" => $request->scores[$i]['quality_average'],
                "efficiency_average" => $request->scores[$i]['efficiency_average'],
                "timeliness_average" => $request->scores[$i]['timeliness_average'],
            ]);
        }
        // EvaluationScore::upsert(
        //     $request->scores, ["id"], ["evaluation_id", "evaluation_form_id", "quality_average", "efficiency_average", "timeliness_average",]
        // );
        return Redirect::route('head_employees', $request->employee_id)->with('success', 'Employee evaluated');
    }
}

