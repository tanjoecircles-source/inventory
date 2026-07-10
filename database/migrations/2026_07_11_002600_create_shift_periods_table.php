<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shift_periods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('month'); // Januari, Februari, etc
            $table->string('week'); // Minggu 1, Minggu 2, etc
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shift_periods');
    }
};