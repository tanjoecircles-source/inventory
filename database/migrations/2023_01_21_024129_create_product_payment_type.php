<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_payment_type', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product')->nullable(true)->unsigned();
            $table->foreign('product')->references('id')->on('product')->onUpdate('cascade')->onDelete('SET NULL');
            $table->enum('type', ['cash','credit'])->nullable(false)->default('cash');
            $table->bigInteger('author')->nullable(true)->unsigned();
            $table->foreign('author')->references('id')->on('users')->onUpdate('cascade')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_payment_type');
    }
};
