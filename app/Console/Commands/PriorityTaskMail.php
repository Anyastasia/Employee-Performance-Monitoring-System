<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mail as XMail;
use App\Models\AssignedTask;

class PriorityTaskMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pmail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email for priority tasks';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
     
        $prio_tasks = AssignedTask::where('is_priority', true)->join('employees', 'assigned_tasks.employee_id', '=','employees.id')->
        get(['assigned_tasks.id', 'assigned_tasks.employee_id', 'employees.first_name', 'employees.email', 'task_title', 'task_description', 'submission_due_date']);


        foreach ($prio_tasks as $task) {
            $email = [
                "subject" => "Priority Task",
                "body" => "Please be informed that you have priority task(s) that needs to be finished.",
                "first_name" => $task->first_name,
                "task_title" => $task->task_title,
                "task_description" => $task->task_description,
                "due_date" => $task->submission_due_date,
            ];

            Mail::to($task->email)->send(new XMail($email));
        }
    }
}
