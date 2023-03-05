<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Employee;
use App\Models\EvaluationForm;
use App\Models\Evaluation;
use App\Models\EvaluationScore;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

use PDF;
use Codedge\Fpdf\Fpdf\Fpdf;

class GenerateIPCR extends Controller
{
    //

   
    public function xpcr(){

        // dd('wew');        
        $pdf = new PDF;

        $pdf = PDF::loadHtml('Hello world!');

        return $pdf->download('xxx.pdf');
        // return response()->streamDownload(
        //     fn () => print($pdf), "xx.pdf"
        // );

        // $employee = Employee::where('id', $request->employee_id)->get(['first_name', 'last_name', 'position', 'division_id'])->first();
        // $head = Employee::where('id', $request->head_id)->get(['first_name', 'last_name', 'position',])->first();
        // $evaluationForm = EvaluationForm::where('status', 'active')->where('employee_id', $request->employee_id)->get();
        // $evaluation = Evaluation::where('id', $request->evaluation_id)->get()->first();
        // $evaluation_scores = EvaluationScore::where('evaluation_id', $request->evaluation_id)->get();
        // $division = Division::where('id', $employee['division_id'])->get()->first();
        // $data = [
        //     'employee' => $employee,
        //     'head' => $head,
        //     'division' => $division,
        //     'evaluationForm' => $evaluationForm,
        //     'evaluation' => $evaluation,
        //     'evaluationScores' => $evaluation_scores,
        // ];
        // dd($data);
        // return Inertia::render('Head/IPCR');
    }

    public function ipcr($employee_id, $head_id, $evaluation_id) {

        // dd('wew');
        $pdf = new PDF;
        $now = Carbon::now();
        $date = $now->toDateString();
        
        
        $employee = Employee::where('id', $employee_id)->get(['first_name', 'last_name', 'position', 'division_id'])->first();
        $head = Employee::where('id', $head_id)->get(['first_name', 'last_name', 'position',])->first();
        // $evaluationForm = EvaluationForm::where('status', 'active')->where('employee_id', $employee_id)->get();
        $evaluationForm = EvaluationScore::join('evaluation_forms', 'evaluation_forms.id', '=', 'evaluation_scores.evaluation_form_id')->where('evaluation_id', $evaluation_id)->where('evaluation_forms.employee_id', $employee_id)->get(['evaluation_forms.output', 'evaluation_forms.success_indicators', 'evaluation_forms.actual_accomplishments', 'evaluation_forms.quality_indicators', 'evaluation_forms.efficiency_indicators', 'evaluation_forms.timeliness_indicators']);
        $evaluation = Evaluation::where('id', $evaluation_id)->get()->first();
        $evaluation_scores = EvaluationScore::where('evaluation_id', $evaluation_id)->get();
        // $x = EvaluationScore::join('evaluation_forms', 'evaluation_forms.id', '=', 'evaluation_scores.evaluation_form_id')->where('evaluation_id', $evaluation_id)->where('evaluation_forms.employee_id', $employee_id)->get(['evaluation_forms.output', 'evaluation_forms.success_indicators', 'evaluation_forms.actual_accomplishments', 'evaluation_forms.quality_indicators', 'evaluation_forms.efficiency_indicators', 'evaluation_forms.timeliness_indicators']);
        $division = Division::where('id', $employee['division_id'])->get()->first();
        $data = [
            'employee' => $employee,
            'head' => $head,
            'division' => $division,
            'evaluationForm' => $evaluationForm,
            'evaluation' => $evaluation,
            'evaluationScores' => $evaluation_scores,
        ];

        // $pdf = new FPDF('L', 'pt', 'A4');
        // $pdf->addPage();
        // $pdf->SetAutoPageBreak(true);
        // $pdf->SetFont('Helvetica');
        // $pdf->Cell(0, 16, 'CITY GOVERNMENT OF MUNTINLUPA',0, 1,'C');
        // $pdf->Cell(0, 16, 'Strategic Performance Management System', 0,1,'C');
        // $pdf->Cell(0, 16, 'INDIVIDUAL PERFORMANCE COMMITTMENT AND REVIEW (ICPR)',0, 1,'C');
        // $pdf->MultiCell(0, 16, 'I, '.$employee->first_name.' '.$employee->last_name.','.$employee->position.', of the.'.$division->name.'DIVISION of the BUSINESS PERMITS AND LICENSING OFFICE commit to deliver and agree to be rated on the attainment of the following targets in accordance wioth the indicated measures for the period'.$evaluation->start_date.'to'.$evaluation->end_date,'C', false);


        // $pdf->Output();
        // exit;


        // return view('ipcr.index', $data);
        $pdf = PDF::loadView('ipcr.index', $data);
        $pdf->setPaper('A4', 'landscape');
        $filename = $employee->last_name.'_'.$date;
        return $pdf->download($filename);

        // exit;
    }
}
