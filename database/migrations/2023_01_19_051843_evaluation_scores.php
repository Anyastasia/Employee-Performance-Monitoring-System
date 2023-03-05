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
        //
        Schema::create('evaluation_scores', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('evaluation_form_id');
            $table->bigInteger('evaluation_id');
            $table->string('actual_accomplishments')->nullable();
            $table->string('remarks')->nullable();
            $table->float('quality_average')->nullable();
            $table->float('efficiency_average')->nullable();
            $table->float('timeliness_average')->nullable();
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
        Schema::dropIfExists('evaluation_scores');
    }
};
