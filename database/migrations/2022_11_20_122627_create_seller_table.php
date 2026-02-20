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
        Schema::create('seller', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user')->nullable(true)->unsigned();
            $table->foreign('user')->references('id')->on('users')->onUpdate('cascade')->onDelete('SET NULL');
            $table->string('code', 150)->nullable(false)->unique();
            $table->string('identity_photo', 150)->nullable(true);
            $table->string('name', 150)->nullable(true);
            $table->enum('gender', ['Laki-laki','Perempuan'])->nullable(false)->default('Laki-laki');
            $table->string('place_of_birth', 150)->nullable(true);
            $table->date('date_of_birth')->nullable(true);
            $table->string('dealer_name', 150)->nullable(true);
            $table->string('dealer_position', 150)->nullable(true);
            $table->string('dealer_photo_ouside', 150)->nullable(true);
            $table->string('dealer_photo_inside', 150)->nullable(true);
            $table->string('dealer_photo_other', 150)->nullable(true);
            $table->string('dealer_phone', 20)->nullable(false)->unique();
            $table->enum('dealer_status', ['Aktif','Tidak Aktif'])->nullable(false)->default('Aktif');
            $table->text('address')->nullable(true);
            $table->bigInteger('district')->nullable(true)->unsigned();
            $table->foreign('district')->references('id')->on('district')->onUpdate('cascade')->onDelete('set null');
            $table->bigInteger('region')->nullable(true)->unsigned();
            $table->foreign('region')->references('id')->on('region')->onUpdate('cascade')->onDelete('set null');
            $table->string('post_code', 20)->nullable(true);
            $table->bigInteger('author')->nullable(true)->unsigned();
            $table->foreign('author')->references('id')->on('users')->onUpdate('cascade')->onDelete('SET NULL');
            $table->bigInteger('editor')->nullable(true)->unsigned();
            $table->foreign('editor')->references('id')->on('users')->onUpdate('cascade')->onDelete('SET NULL');
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
        Schema::dropIfExists('seller');
    }
};
