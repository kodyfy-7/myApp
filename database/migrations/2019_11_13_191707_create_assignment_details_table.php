<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->unsigned();  
            $table->integer('assignment_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('assignment_id')->references('id')->on('assignments');
            $table->integer('ascore')->nullable(); 
            $table->text('adfile')->nullable(); 
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
        Schema::dropIfExists('assignment_details');
    }
}
