<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLableTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("lable_task", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("lable_id")
                ->constant("lables")
                ->onDelete("CASCADE");
            $table
                ->foreignId("task_id")
                ->constant("tasks")
                ->onDelete("CASCADE");
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
        Schema::dropIfExists("lable_task");
    }
}
