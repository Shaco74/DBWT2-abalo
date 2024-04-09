<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(Blueprint $table): void
    {

        Schema::create('ab_testdata', function (Blueprint $table){
        $table->id()->primary();

        $table->string('ab_name',80);
        $table->integer('ab_price');
        $table->string('ab_description',1000);
        $table->unsignedBigInteger('ab_creator_id');
        $table->addColumn('timestamp', 'ab_createdate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('ab_testdata');

    }
};
