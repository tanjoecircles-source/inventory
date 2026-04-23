<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->string('receipt_no');
            $table->double('total_amount', 15, 2)->default(0);
            $table->string('payment_method')->default('cash'); // cash, qris, split
            $table->double('cash_amount', 15, 2)->default(0);
            $table->double('qris_amount', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('pos_sessions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pos_transactions');
    }
}
