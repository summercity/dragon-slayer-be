<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();

            $table->string('flight_number',12); 
            $table->string('destination',50);
            $table->string('equipment', 6);
            $table->string('terminal', 2);
            $table->string('ground_time', 10);
            $table->string('departure', 10);
            $table->string('repeated', 100);
            $table->string('repeated_json', 200);
            $table->date('scheduled_date');
            $table->date('start_date');
            $table->date('stop_date');
            $table->string('status',50);
            $table->boolean('recurring');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade'); 
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->default(0)->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
