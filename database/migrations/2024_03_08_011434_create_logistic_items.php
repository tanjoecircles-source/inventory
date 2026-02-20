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
        Schema::create('logistic_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('itm_inv_id')->nullable(true)->unsigned();
            $table->foreign('itm_inv_id')->references('id')->on('logistic_invoice')->onUpdate('cascade')->onDelete('cascade');
            
            $table->string('itm_name', 150)->nullable(true);
            $table->string('itm_price', 150)->nullable(true);
            $table->string('itm_qty', 150)->nullable(true);
            $table->string('itm_total', 150)->nullable(true);
            $table->enum('itm_status', ['Good','Not Good'])->nullable(false)->default('Good');
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
        Schema::dropIfExists('logistic_items');
    }
};
