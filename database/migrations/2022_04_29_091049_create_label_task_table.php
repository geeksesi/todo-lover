<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("label_task", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("label_id")
                ->constant("labels")
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
        Schema::dropIfExists("label_task");
    }
}
