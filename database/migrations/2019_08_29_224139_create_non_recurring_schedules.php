<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNonRecurringSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_recurring_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();

            $table->string('flight_number',12); 
            $table->string('equipment', 6);
            $table->string('terminal', 2);
            $table->string('ground_time', 10);
            $table->string('departure', 10);
            $table->string('customer_name', 50);
            $table->string('company_name', 50);
            $table->date('start_date');
            $table->date('stop_date');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');  
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('non_recurring_schedules');
    }
}
