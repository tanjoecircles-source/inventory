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
        if (!Schema::hasTable('oauth_google')) {
            Schema::create('oauth_google', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->String('access_token', 3000);
                $table->String('refresh_token', 3000)->nullable(true);
                $table->String('id_token', 3000);
                $table->timestamps();
                $table->foreign('user_id', 'fk_oauth_google_user_id')->references('id')->on('users');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oauth_google');
    }
};
