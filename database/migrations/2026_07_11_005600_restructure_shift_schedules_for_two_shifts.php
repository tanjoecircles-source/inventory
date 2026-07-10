<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shift_schedules', function (Blueprint $table) {
            // Add Long shift columns
            $table->string('long_employee')->nullable()->after('notes');
            $table->time('long_start')->nullable()->after('long_employee');
            $table->time('long_end')->nullable()->after('long_start');
            $table->text('long_notes')->nullable()->after('long_end');
            // Add Short shift columns
            $table->string('short_employee')->nullable()->after('long_notes');
            $table->time('short_start')->nullable()->after('short_employee');
            $table->time('short_end')->nullable()->after('short_start');
            $table->text('short_notes')->nullable()->after('short_end');
            
            // Make old columns nullable (they were required before)
            $table->string('employee_name')->nullable()->change();
            $table->string('shift_type')->nullable()->change();
            $table->time('start_time')->nullable()->change();
            $table->time('end_time')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('shift_schedules', function (Blueprint $table) {
            $table->dropColumn(['long_employee', 'long_start', 'long_end', 'long_notes', 'short_employee', 'short_start', 'short_end', 'short_notes']);
        });
    }
};