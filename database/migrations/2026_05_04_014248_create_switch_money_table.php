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
        Schema::create('switch_money', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('from_bank_id');
            $table->unsignedBigInteger('to_bank_id');
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2)->default(0);
            $table->decimal('total', 15, 2);
            $table->enum('status', ['Draft', 'Published'])->default('Draft');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('author');
            $table->unsignedBigInteger('editor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('switch_money');
    }
};
