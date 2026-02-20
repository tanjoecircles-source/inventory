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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable(false)->unique();
            $table->enum('condition', ['Bekas','Baru'])->nullable(false)->default('Bekas');
            $table->bigInteger('owner')->nullable(true)->unsigned();
            $table->foreign('owner')->references('id')->on('ref_product_owner')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('brand')->nullable(true)->unsigned();
            $table->foreign('brand')->references('id')->on('ref_brand')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 150)->nullable(true);
            $table->bigInteger('type')->nullable(true)->unsigned();
            $table->foreign('type')->references('id')->on('ref_product_type')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('transmission', ['Manual','Automatic'])->nullable(false)->default('Manual');
            $table->year('production_year')->nullable(true);
            $table->string('machine_capacity', 100)->nullable(true);
            $table->enum('fuel', ['Bensin','Diesel', 'Electric'])->nullable(false)->default('Bensin');
            $table->date('end_of_tax')->nullable(true);
            $table->string('passanger_capacity', 150)->nullable(true);
            $table->string('mileage', 100)->nullable(true);
            $table->string('photo_exterior_front', 150)->nullable(true);
            $table->string('photo_exterior_back', 150)->nullable(true);
            $table->string('photo_exterior_left', 150)->nullable(true);
            $table->string('photo_exterior_right', 150)->nullable(true);
            $table->string('photo_interior_front', 150)->nullable(true);
            $table->string('photo_interior_center', 150)->nullable(true);
            $table->string('photo_interior_behind', 150)->nullable(true);
            $table->text('summary')->nullable(true);
            $table->enum('status', ['Active','Inactive'])->nullable(false)->default('Inactive');
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
        Schema::dropIfExists('product');
    }
};
