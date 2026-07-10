<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shift_schedules', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['employee_name', 'shift_type', 'start_time', 'end_time', 'notes',
                'long_employee', 'long_start', 'long_end', 'long_notes',
                'short_employee', 'short_start', 'short_end', 'short_notes']);
        });

        Schema::table('shift_schedules', function (Blueprint $table) {
            // Shift 1
            $table->string('shift1_employee')->nullable()->after('shift_date');
            $table->string('shift1_type')->nullable()->after('shift1_employee'); // Long / Short
            $table->time('shift1_start')->nullable()->after('shift1_type');
            $table->time('shift1_end')->nullable()->after('shift1_start');
            // Shift 2
            $table->string('shift2_employee')->nullable()->after('shift1_end');
            $table->string('shift2_type')->nullable()->after('shift2_employee'); // Long / Short
            $table->time('shift2_start')->nullable()->after('shift2_type');
            $table->time('shift2_end')->nullable()->after('shift2_start');
        });
    }

    public function down(): void
    {
        Schema::table('shift_schedules', function (Blueprint $table) {
            $table->dropColumn(['shift1_employee', 'shift1_type', 'shift1_start', 'shift1_end',
                'shift2_employee', 'shift2_type', 'shift2_start', 'shift2_end']);
        });
    }
};