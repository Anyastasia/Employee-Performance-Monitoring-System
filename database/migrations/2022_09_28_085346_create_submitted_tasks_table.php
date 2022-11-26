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
        Schema::create('submitted_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('assigned_tasks');
            $table->string('submitted_attachments')->nullable();
            $table->string('notes')->nullable();
            $table->string('submission_status')->default('active');
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
        Schema::dropIfExists('submitted_tasks');
    }
};
