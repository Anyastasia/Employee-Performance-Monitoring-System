<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigned_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('head_id');
            $table->string('task_title');
            $table->string('task_description')->nullable();
            $table->string('attachments')->nullable();
            $table->dateTime('submission_start_date');
            $table->dateTime('submission_due_date');
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('returned_at')->nullable();
            $table->string('comment')->nullable();
            $table->string('status')->default('active');
            $table->boolean('is_priority')->default(false);
            $table->boolean('cron_already_ran')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assigned_tasks');
    }
};
