<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->bigIncrements('payment_id');
            $table->unsignedBigInteger('officer_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('tuition_id');
            $table->date('payment_date');
            $table->integer('tuition_month');
            $table->integer('tuition_year');
            $table->timestamps();

            $table->foreign('tuition_id')->references('tuition_id')->on('tuition');
            $table->foreign('officer_id')->references('officer_id')->on('officer');
            $table->foreign('student_id')->references('student_id')->on('student');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment');
    }
}
