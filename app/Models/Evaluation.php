<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        "employee_id",
        "task_id",
        "efficiency",
        "quality",
        "timeliness",
    ];
}
