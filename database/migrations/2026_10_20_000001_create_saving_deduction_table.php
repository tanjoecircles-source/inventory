<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saving_deduction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sp_id');
            $table->string('name');
            $table->date('date')->nullable();
            $table->bigInteger('amount')->default(0);
            $table->unsignedBigInteger('author')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saving_deduction');
    }
};
