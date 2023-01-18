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
        Schema::create('evaluation_forms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id');
            $table->bigInteger('division_id');
            $table->string('output');
            $table->string('success_indicators');
            $table->string('actual_accomplishments')->nullable();
            $table->string('quality_indicators')->nullable();
            $table->string('efficiency_indicators')->nullable();
            $table->string('timeliness_indicators')->nullable();
            $table->string('status')->default('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('evaluation_forms');
    }
};
