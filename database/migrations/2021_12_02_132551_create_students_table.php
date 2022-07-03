<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->bigInteger('gender_id')->unsigned();
            
            $table->bigInteger('nationalitie_id')->unsigned();
            
            $table->bigInteger('blood_id')->unsigned();
            
            $table->date('Date_Birth');
            $table->bigInteger('Grade_id')->unsigned();
            
            $table->bigInteger('Classroom_id')->unsigned();
            
            $table->bigInteger('section_id')->unsigned();
            
            $table->bigInteger('parent_id')->unsigned();
            
            $table->string('academic_year');
            $table->softDeletes();
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
        Schema::dropIfExists('students');
    }
}
