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
        Schema::table('users', function($table) {
            $table->string('phone', 15)->after('remember_token')->nullable();
            $table->enum('type', ['seller','agent', 'admin'])->after('phone')->default('agent');
            $table->enum('ifseller', ['independent','dealer'])->after('type')->default('independent');
            $table->enum('term', ['true','false'])->after('ifseller')->default('false');
            $table->string('otp', 150)->after('term')->nullable();
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
