<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Attendance as Model;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;
use App\Models\TimeIn;
use App\Models\TimeOut;
use Carbon\Carbon;


class Attendance extends Controller
{
    //

    public static function getAttendanceReport($employee) {

            $WORKING_HOURS_DAILY = 8;

            $working_hours_total = 0;
            $hours_data = TimeIn::join('time_outs as A', 'time_ins.id', '=', 'A.time_in_id')->
            where('time_ins.employee_id', $employee)->
            selectRaw('time_ins.id, time_ins.time_in, A.time_out, time_ins.shift_date, abs(time_to_sec(timediff(time_in, A.time_out))) / 60 as working_hours')->
            get()->map(function ($xemployee){
                $xworking_hours_total = 0;
                if ($xemployee->working_hours <= 240 && $xemployee->working_hours >= 0) {
                    $temp = $xemployee->working_hours;
                    $xworking_hours_total += $temp;
                } elseif($xemployee->working_hours <= 300 && $xemployee->working_hours >= 241) {
                    $xworking_hours_total += 240;
                } elseif ($xemployee->working_hours >= 301 && $xemployee->working_hours <= 540) {
                    $temp = $xemployee->working_hours - 60;
                    $xworking_hours_total += $temp;
                } else {
                    $xworking_hours_total += 480;
                }

                return [
                    "shift_date" => $xemployee->shift_date,
                    "time_in" => $xemployee->time_in,
                    "time_out" => $xemployee->time_out,
                    "time_diff" => $xemployee->working_hours,
                    "working_hours" => $xworking_hours_total,
                ];
            });

            // dd($hours_data);
    }

    public static function getAttendanceReportWeekly($employee){
        

        $WORKING_HOURS_DAILY = 480;
        $now = Carbon::now();
        // dd($now->startOfWeek());
        $working_hours_weekly_total = 0;
        $hours_data = TimeIn::join('time_outs as A', 'time_ins.id', '=', 'A.time_in_id')->
        where('time_ins.employee_id', $employee)->
        whereBetween('time_ins.shift_date', [
            $now->startOfWeek(Carbon::MONDAY)->toDateString(),
            $now->endOfWeek(Carbon::FRIDAY)->toDateString(),
        ])->
        // where('time_ins.time_in', '>', Carbon::now()->startOfWeek(Carbon::MONDAY))->
        // where('time_ins.time_in', '<', Carbon::now()->endOfWeek(Carbon::FRIDAY))->
        selectRaw('time_ins.id, time_ins.time_in, A.time_out, time_ins.shift_date, abs(time_to_sec(timediff(time_in, A.time_out))) / 60 as working_hours')->
        get()->map(function ($xemployee){
            $xworking_hours_total = 0;
            if ($xemployee->working_hours <= 240 && $xemployee->working_hours >= 0) {
                $temp = $xemployee->working_hours;
                $xworking_hours_total += $temp;
            } elseif($xemployee->working_hours <= 300 && $xemployee->working_hours >= 241) {
                $xworking_hours_total += 240;
            } elseif ($xemployee->working_hours >= 301 && $xemployee->working_hours <= 540) {
                $temp = $xemployee->working_hours - 60;
                $xworking_hours_total += $temp;
            } else {
                $xworking_hours_total += 480;
            }

            return [
                "shift_date" => $xemployee->shift_date,
                "time_in" => $xemployee->time_in,
                "time_out" => $xemployee->time_out,
                "time_diff" => $xemployee->working_hours,
                "working_hours" => $xworking_hours_total,
            ];
        });


        foreach ($hours_data as $data) {
            $working_hours_weekly_total += $data['working_hours'];
        }

        
        return $working_hours_weekly_total;
    }

    public static function x($employee) {

    }

    public static function getAttendanceReportMonthly($employee){
        $now = Carbon::now();

        $working_hours_monthly_total = 0;
        $actual_hours_monthly_total = 0;
        $hours_data = TimeIn::join('time_outs as A', 'time_ins.id', '=', 'A.time_in_id')->
        where('time_ins.employee_id', $employee)->
        whereBetween('time_ins.shift_date', [
            $now->startOfMonth()->toDateString(),
            $now->endOfMonth()->toDateString(),
        ])->
        // where('time_ins.time_in', '>', Carbon::now()->startOfWeek(Carbon::MONDAY))->
        // where('time_ins.time_in', '<', Carbon::now()->endOfWeek(Carbon::FRIDAY))->
        selectRaw('time_ins.id, time_ins.time_in, A.time_out, time_ins.shift_date, abs(time_to_sec(timediff(time_in, A.time_out))) / 60 as working_hours')->
        get()->map(function ($xemployee){
            $xworking_hours_total = 0;
            if ($xemployee->working_hours <= 240 && $xemployee->working_hours >= 0) {
                $temp = $xemployee->working_hours;
                $xworking_hours_total += $temp;
            } elseif($xemployee->working_hours <= 300 && $xemployee->working_hours >= 241) {
                $xworking_hours_total += 240;
            } elseif ($xemployee->working_hours >= 301 && $xemployee->working_hours <= 540) {
                $temp = $xemployee->working_hours - 60;
                $xworking_hours_total += $temp;
            } else {
                $xworking_hours_total += 480;
            }

            return [
                "shift_date" => $xemployee->shift_date,
                "time_in" => $xemployee->time_in,
                "time_out" => $xemployee->time_out,
                "time_diff" => $xemployee->working_hours,
                "working_hours" => $xworking_hours_total,
            ];
        });


        // dd($hours_data);
 
        foreach ($hours_data as $data) {
            $actual_hours_monthly_total += 480;
            $working_hours_monthly_total += $data['working_hours'];
        }
        
        
        if ($actual_hours_monthly_total === 0) {
            $actual_hours_monthly_total = 100;
        }
        $attendance_percentage = floor(($working_hours_monthly_total / $actual_hours_monthly_total) * 100);
        // dd($actual_hours_monthly_total, $working_hours_monthly_total);
        // dd(($working_hours_monthly_total / $actual_hours_monthly_total) * 100);
        // return ($actual_hours_monthly_total == 0) ? 100 : $attendance_percentage;
        return floor(($working_hours_monthly_total / $actual_hours_monthly_total) * 100);
    }

    public static function getLeave($employee) {
        $now = Carbon:: now();

        $totalLeaves= 0;
        $xleaves = Leave::selectRaw('datediff(leave_start_date, leave_due_date) as count')->where('employee_id', $employee)->whereDate('leave_due_date', '>=', $now)->get(['id', 'leave_start_date', 'leave_due_date', 'reason', 'count']);

        foreach($xleaves as $leave) {
            $totalLeaves += $leave->count;
        }

        $leaves = [
            "leaves" => $xleaves,
            "totalLeaves" => $totalLeaves,
        ];

        return $leaves;
     }
}
