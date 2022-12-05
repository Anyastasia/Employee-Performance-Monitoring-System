<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TimeIn extends Model
{
    use HasFactory;


    protected $fillable = [
        "employee_id",
        "shift_date",
        "time_in",
    ];

    public $timestamps = false;
}
