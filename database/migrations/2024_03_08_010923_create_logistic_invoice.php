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
        Schema::create('logistic_invoice', function (Blueprint $table) {
            $table->id();
            $table->string('inv_code', 150)->unique();
            $table->date('inv_date')->nullable(true);
            $table->string('inv_source', 150)->nullable(true);
            $table->string('inv_total', 150)->nullable(true);
            $table->enum('inv_status_payment', ['credit','paid'])->nullable(false)->default('paid');
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
        Schema::dropIfExists('logistic_invoice');
    }
};
