<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outputs extends Model
{
    use HasFactory;

    protected $fillable = [
        "employee_id",
        "output",
        "success_indicators"
    ];
    protected $casts = [
        "rating" => "array",
    ];
}
