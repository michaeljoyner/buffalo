<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToQuoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->text('terms')->nullable();
            $table->text('shipment')->nullable();
            $table->text('quotation_remarks')->nullable();
            $table->float('base_profit')->nullable();
            $table->float('base_exchange_rate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn(['terms', 'shipment', 'quotation_remarks', 'base_profit', 'base_exchange_rate']);
        });
    }
}
