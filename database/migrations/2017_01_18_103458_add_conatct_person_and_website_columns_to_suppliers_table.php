<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConatctPersonAndWebsiteColumnsToSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('website')->nullable();
            $table->string('contact_person')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn(['website', 'contact_person']);
        });
    }
}
