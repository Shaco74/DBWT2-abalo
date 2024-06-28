<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void {
        Schema::table('ab_article', function (Blueprint $table) {
            // Add new column
            $table->decimal('ab_discount', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::table('ab_article', function (Blueprint $table) {
            // Drop the column if rolling back
            $table->dropColumn('ab_discount');
        });
    }
};
