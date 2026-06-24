<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_submission_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('submission_id')->unsigned();
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->string('product_name', 255)->nullable();
            $table->integer('quantity')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('submission_id')->references('id')->on('stock_submissions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('product')->onUpdate('cascade')->onDelete('SET NULL');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_submission_items');
    }
};