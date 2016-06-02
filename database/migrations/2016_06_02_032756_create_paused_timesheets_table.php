<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePausedTimesheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paused_timesheets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->unsigned()->index();
            $table->foreign('account_id')->references('id')->on('accounts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('employee_id')->unsigned()->index();
            $table->foreign('employee_id')->references('id')->on('employees')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('job_shift_id')->unsigned()->index();
            $table->foreign('job_shift_id')->references('id')->on('job_shifts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::drop('paused_timesheets');
    }
}
