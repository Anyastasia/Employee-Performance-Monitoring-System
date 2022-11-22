<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PhpParser\Node\Expr\Empty_;

class AssignedTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'head_id',
        'employee_id',
        'task_title',
        'task_description',
        'attachments',
        'submission_start_date',
        'submission_start_time',
        'submission_due_date',
        'submission_due_time',
    ];

}
