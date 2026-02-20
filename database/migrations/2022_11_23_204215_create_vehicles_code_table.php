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
        Schema::create('ref_vehicles_code', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('region')->nullable(true)->unsigned();
            $table->foreign('region')->references('id')->on('region')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('vehicles_code');
    }
};
