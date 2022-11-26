<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmittedTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'submitted_attachments',
        'notes',
        'submission_status',
    ];
}
