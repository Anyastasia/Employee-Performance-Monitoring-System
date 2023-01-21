<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationScore extends Model
{
    use HasFactory;

    protected $fillable = [
        "evaluation_form_id",
        "evaluation_id",
        "quality_average",
        "efficiency_average",
        "timeliness_average",
    ];
    public $timestamps = false;
}
