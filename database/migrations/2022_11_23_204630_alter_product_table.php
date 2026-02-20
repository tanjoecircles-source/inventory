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
            $table->bigInteger('seller_id')->after('code')->nullable(true)->unsigned();
            $table->foreign('seller_id')->references('id')->on('seller')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('variant')->after('type')->nullable(true)->unsigned();
            $table->foreign('variant')->references('id')->on('ref_variant')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('body_type')->after('variant')->nullable(true)->unsigned();
            $table->foreign('body_type')->references('id')->on('ref_body_type')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('vehicles_code')->after('body_type')->nullable(true)->unsigned();
            $table->foreign('vehicles_code')->references('id')->on('ref_vehicles_code')->onUpdate('cascade')->onDelete('cascade');
            $table->string('price', 100)->after('summary')->nullable();
            $table->string('sales_commission', 100)->after('price')->nullable();
            $table->enum('payment_type', ['cash','credit'])->after('sales_commission')->default('cash');
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
