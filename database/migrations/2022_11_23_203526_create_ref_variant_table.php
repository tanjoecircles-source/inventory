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
        Schema::create('ref_variant', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_type')->nullable(true)->unsigned();
            $table->foreign('product_type')->references('id')->on('ref_product_type')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 150)->nullable(true);
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
        Schema::dropIfExists('ref_variant');
    }
};
