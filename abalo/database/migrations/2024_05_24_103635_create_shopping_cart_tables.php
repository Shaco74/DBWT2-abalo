<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * P3: Task 10
 * */
class CreateShoppingCartTables extends Migration
{
public function up()
{
Schema::create('ab_shoppingcart', function (Blueprint $table) {
$table->id();
$table->unsignedBigInteger('ab_creator_id');
$table->timestamp('ab_createdate')->useCurrent();
$table->foreign('ab_creator_id')->references('id')->on('users')->onDelete('cascade');
});

Schema::create('ab_shoppingcart_item', function (Blueprint $table) {
$table->id();
$table->unsignedBigInteger('ab_shoppingcart_id');
$table->unsignedBigInteger('ab_article_id');
$table->timestamp('ab_createdate')->useCurrent();
$table->foreign('ab_shoppingcart_id')->references('id')->on('ab_shoppingcart')->onDelete('cascade');
$table->foreign('ab_article_id')->references('id')->on('ab_article');
});
}

public function down()
{
Schema::dropIfExists('ab_shoppingcart_item');
Schema::dropIfExists('ab_shoppingcart');
}
}
