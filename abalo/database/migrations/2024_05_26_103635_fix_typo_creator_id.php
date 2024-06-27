<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * P3: Task 10
 * */

return new class extends Migration
{
    public function up()
    {
        Schema::table('ab_shoppingcart', function (Blueprint $table) {
            $table->dropForeign(['ab_creator_id']);
            $table->foreign('ab_creator_id')->references('id')->on('ab_user')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('ab_shoppingcart', function (Blueprint $table) {
            $table->dropForeign(['ab_creator_id']);
            $table->foreign('ab_creator_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
