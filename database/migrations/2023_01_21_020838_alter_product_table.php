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
        Schema::table('product', function($table) {
            $table->bigInteger('color')->after('condition')->nullable(true)->unsigned();
            $table->foreign('color')->references('id')->on('ref_color')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('machine_capacity')->nullable(true)->unsigned()->change();
            $table->foreign('machine_capacity')->references('id')->on('ref_machine_capacity')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('mileage')->nullable(true)->unsigned()->change();
            $table->foreign('mileage')->references('id')->on('ref_mileage')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
