<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $timestamps = false;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etalase', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product')->nullable(true)->unsigned();
            $table->foreign('product')->references('id')->on('product')->onUpdate('cascade')->onDelete('SET NULL');
            $table->bigInteger('agent')->nullable(true)->unsigned();
            $table->foreign('agent')->references('id')->on('agent')->onUpdate('cascade')->onDelete('SET NULL');
            $table->enum('status', ['true','false'])->nullable(false)->default('true');
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
        Schema::dropIfExists('etalase');
    }
};
