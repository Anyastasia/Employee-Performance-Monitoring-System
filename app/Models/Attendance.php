<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $casts = [
        "shift_date" => "date",
        "time_in" => "time",
        "time_out" => "time",
    ];
    protected $fillable = [
        "employee_id",
        "shift_date",
        "time_in",
        "time_out",
    ];
}
