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
        Schema::create('visitation', function (Blueprint $table) {
            $table->id();
            $table->string('code', 150)->nullable(false)->unique();
            $table->bigInteger('product')->nullable(true)->unsigned();
            $table->foreign('product')->references('id')->on('product')->onUpdate('cascade')->onDelete('SET NULL');
            $table->bigInteger('agent')->nullable(true)->unsigned();
            $table->foreign('agent')->references('id')->on('agent')->onUpdate('cascade')->onDelete('SET NULL');
            $table->date('date')->nullable(true);
            $table->time('time')->nullable(true);
            $table->text('location')->nullable(true);
            $table->string('customer_name', 150)->nullable(true);
            $table->text('customer_address')->nullable(true);
            $table->text('request')->nullable(true);
            $table->enum('status', ['Menunggu Konfirmasi','Disetujui', 'Ditolak'])->nullable(false)->default('Menunggu Konfirmasi');
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
        Schema::dropIfExists('visitation');
    }
};
