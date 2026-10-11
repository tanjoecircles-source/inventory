<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('inv_shipping_type', 100)->nullable()->after('inv_expedition');
            $table->unsignedBigInteger('inv_ekspedisi_id')->nullable()->after('inv_shipping_type');
            $table->string('inv_resi', 150)->nullable()->after('inv_ekspedisi_id');

            $table->foreign('inv_ekspedisi_id')->references('id')->on('ekspedisi')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['inv_ekspedisi_id']);
            $table->dropColumn(['inv_shipping_type', 'inv_ekspedisi_id', 'inv_resi']);
        });
    }
};
