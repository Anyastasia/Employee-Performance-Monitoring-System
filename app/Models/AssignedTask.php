<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class AssignedTask extends Model
{
    use HasFactory;

    protected $casts = [
        'submission_start_date' => 'datetime',
        'submission_due_date' => 'datetime',
    ]; 

    protected $fillable = [
        'head_id',
        'employee_id',
        'task_title',
        'task_description',
        'attachments',
        'submission_start_date',
        'submission_due_date',
        'comment',
        'status',
        'cron_already_ran',
        'is_priority',
    ];

    

}
