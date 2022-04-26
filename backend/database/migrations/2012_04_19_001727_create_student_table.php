<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->bigIncrements('student_id');
            $table->char('nisn', 10);
            $table->char('nis', 8);
            $table->string('name', 35);
            $table->unsignedBigInteger('grade_id');
            $table->string('address', 100);
            $table->char('phone', 13);
            $table->integer('bill');
            $table->timestamps();

            $table->foreign('grade_id')->references('grade_id')->on('grade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
}
