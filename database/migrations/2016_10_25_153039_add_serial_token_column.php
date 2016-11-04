<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSerialTokenColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('google_plus_users', function (Blueprint $table) {
            $table->text('token_serialized')->default('');
            $table->dropColumn(['token', 'refresh_token', 'token_expires']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('google_plus_users', function (Blueprint $table) {
//            $table->dropColumn('token_serialized');
//            $table->string('token');
//            $table->string('refresh_token');
//            $table->bigInteger('token_expires');
        });
    }
}
