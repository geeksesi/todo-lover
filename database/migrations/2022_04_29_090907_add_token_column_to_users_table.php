<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTokenColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn("users", "token")) {
            return;
        }

        Schema::table("users", function (Blueprint $table) {
            $table->string("token")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn("users", "token")) {
            return;
        }

        Schema::table("users", function (Blueprint $table) {
            $table->dropColumn("token");
        });
    }
}
