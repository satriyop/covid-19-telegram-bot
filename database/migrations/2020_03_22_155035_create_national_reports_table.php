<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNationalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('national_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('total_cases');
            $table->unsignedInteger('total_death');
            $table->unsignedInteger('total_recovered');
            $table->unsignedInteger('total_treated');
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
        Schema::dropIfExists('national_reports');
    }
}
