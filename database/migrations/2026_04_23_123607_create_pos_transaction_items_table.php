<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosTransactionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_transaction_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name');
            $table->double('price', 15, 2)->default(0);
            $table->integer('qty')->default(1);
            $table->double('subtotal', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('pos_transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pos_transaction_items');
    }
}
