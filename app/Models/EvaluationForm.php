<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationForm extends Model
{
    use HasFactory;

    protected $fillable = [
        "employee_id",
        "division_id",
        "output",
        "success_indicators",
        "quality_indicators",
        "efficiency_indicators",
        "timeliness_indicators",
        "status",
    ];

    public $timestamps = false;
}
