<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTokenSerializedToFacebookUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facebook_users', function (Blueprint $table) {
            $table->text('token_serialized');
            $table->dropColumn('token_string');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facebook_users', function (Blueprint $table) {
            $table->dropColumn('token_string');
            $table->string('token_string');
        });
    }
}
