<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuoteItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quote_id');
            $table->integer('product_id');
            $table->string('name')->nullable();
            $table->string('buffalo_product_code')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('factory_number')->nullable();
            $table->string('currency')->nullable();
            $table->float('factory_price')->nullable();
            $table->float('additional_cost')->nullable();
            $table->float('exchange_rate')->nullable();
            $table->integer('quantity')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('quote_items');
    }
}
