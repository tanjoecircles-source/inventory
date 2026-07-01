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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->string('image_path', 255);
            $table->enum('is_primary', ['true', 'false'])->default('false');
            $table->integer('sort_order')->default(0);
            $table->bigInteger('author')->nullable()->unsigned();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('product')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('author')->references('id')->on('users')->onUpdate('cascade')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};