<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComputedPriceFieldsToQuoteItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quote_items', function (Blueprint $table) {
            $table->float('total_cost')->nullable();
            $table->float('selling_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quote_items', function (Blueprint $table) {
            $table->dropColumn(['total_cost', 'selling_price']);
        });
    }
}
