<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->rawIndex('name(100)', 'idx_product_name');
            $table->index('status', 'idx_product_status');
            $table->index('is_recomended', 'idx_product_is_recomended');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropIndex('idx_product_name');
            $table->dropIndex('idx_product_status');
            $table->dropIndex('idx_product_is_recomended');
        });
    }
};
