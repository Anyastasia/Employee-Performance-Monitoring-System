<?php

namespace App\Console\Commands;

use App\Models\AssignedTask;
use Illuminate\Console\Command;
use Carbon\Carbon;

class MakePriorityTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:priority';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flag a task to priority';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tasks = AssignedTask::where('status', 'active')->get();
        foreach ($tasks as $task) {
            $this->info($task->submission_due_date->isPast() && $task->cron_already_ran == false);            
            if ($task->submission_due_date->isPast() && $task->cron_already_ran == false) {
                $task->cron_already_ran = true;
                $task->is_priority = true;
                $task->save();
            } 
        }
    }
}
