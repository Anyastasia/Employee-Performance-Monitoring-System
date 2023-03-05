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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthday');
            $table->foreignId('division_id')->constrained('divisions');
            $table->string('position');
            $table->string('employee_status');
            $table->string('password');
            $table->string('avatar_path')->nullable();
            $table->string('status')->default('active');
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_division_head')->default(false);
            $table->boolean('new_task_given')->default(false);
            $table->boolean('priority_task_given')->default(false);
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
        Schema::dropIfExists('employees');
    }
};
