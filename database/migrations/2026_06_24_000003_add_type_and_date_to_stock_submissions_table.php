<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_submissions', function (Blueprint $table) {
            $table->enum('type', ['Roasted Filter', 'Roasted Espresso', 'Bahan Lainnya'])->nullable()->after('author');
            $table->date('date')->nullable()->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('stock_submissions', function (Blueprint $table) {
            $table->dropColumn(['type', 'date']);
        });
    }
};