<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        "employee_id",
        "evaluation_form_id",
        "self_evaluation_id",
        "evaluated_by",
        "start_date",
        "end_date",
        "total_average_rating",
        "rating",
        'self',
        "adjectival_rating",
    ];
}
