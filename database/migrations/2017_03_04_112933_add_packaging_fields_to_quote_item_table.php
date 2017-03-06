<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPackagingFieldsToQuoteItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quote_items', function (Blueprint $table) {
            $table->string('package_type')->nullable();
            $table->string('package_unit')->nullable();
            $table->integer('package_inner')->unsigned()->nullable();
            $table->integer('package_outer')->unsigned()->nullable();
            $table->string('package_carton')->nullable();
            $table->float('net_weight')->nullable();
            $table->float('gross_weight')->nullable();
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
            //
        });
    }
}
