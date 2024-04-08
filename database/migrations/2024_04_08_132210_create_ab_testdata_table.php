<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ab_testdata', function (Blueprint $table) {
            $table->id();
            $table->string('ab_testname');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ab_testdata');
    }
};
