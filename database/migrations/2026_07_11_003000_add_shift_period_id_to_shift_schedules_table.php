<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shift_schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('shift_period_id')->nullable()->after('id');
            $table->foreign('shift_period_id')->references('id')->on('shift_periods')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('shift_schedules', function (Blueprint $table) {
            $table->dropForeign(['shift_period_id']);
            $table->dropColumn('shift_period_id');
        });
    }
};