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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id');
            $table->bigInteger('evaluated_by');
            $table->bigInteger('self_evaluation_id')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->float('total_average_rating')->default(0);
            $table->float('rating')->default(0);
            $table->boolean('self')->default(false);
            $table->string('adjectival_rating');
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
        Schema::dropIfExists('evaluations');
    }
};
