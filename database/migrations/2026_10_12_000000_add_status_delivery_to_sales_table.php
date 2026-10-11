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
        // Kolom inv_status_delivery digunakan untuk menandai pesanan sudah
        // "Dikirim & Diterima". Guard hasColumn membuat migrasi aman dijalankan
        // pada database yang sudah memiliki kolom ini (idempotent).
        if (!Schema::hasColumn('sales', 'inv_status_delivery')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->string('inv_status_delivery', 20)->nullable()->after('inv_status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('sales', 'inv_status_delivery')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->dropColumn('inv_status_delivery');
            });
        }
    }
};
