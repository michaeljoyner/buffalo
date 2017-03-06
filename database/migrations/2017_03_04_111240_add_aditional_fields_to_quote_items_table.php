<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAditionalFieldsToQuoteItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quote_items', function (Blueprint $table) {
            $table->float('package_price')->nullable();
            $table->string('additional_cost_memo')->nullable();
            $table->float('profit')->nullable();
            $table->integer('moq')->unsigned()->nullable();
            $table->text('remark')->nullable();
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
            $table->dropColumn(['package_price', 'additional_cost_memo', 'profit', 'moq', 'remark']);
        });
    }
}
