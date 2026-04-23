<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_sessions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('employee_id');
            $table->string('shift_id');
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->double('total_cash', 15, 2)->default(0);
            $table->double('total_qris', 15, 2)->default(0);
            $table->unsignedBigInteger('report_store_id')->nullable();
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
        Schema::dropIfExists('pos_sessions');
    }
}
