<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SendMail as XMail;
use App\Models\AssignedTask;


class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xmail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $prio_tasks = AssignedTask::where('is_priority', true)->join('employees', 'assigned_tasks.employee_id', '=','employees.id')->get(['assigned_tasks.id', 'assigned_tasks.employee_id', 'employees.first_name']);

    }
}
