<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class TimeOut extends Model
{
    use HasFactory;


    protected $fillable = [
        "employee_id",
        "time_in_id",
        "shift_date",
        "time_out",
    ];

    public $timestamps = false;
}
