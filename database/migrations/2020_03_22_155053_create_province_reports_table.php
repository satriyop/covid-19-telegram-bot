<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvinceReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('province_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->unsignedInteger('national_report_id');
            $table->unsignedInteger('total_cases');
            $table->unsignedInteger('total_death');
            $table->unsignedInteger('total_recovered');
            $table->string('url')->nullable();
            $table->timestamps();
            $table->foreign('national_report_id')->references('id')->on('national_reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('province_reports');
    }
}
