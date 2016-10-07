<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('subcategory_id')->unsigned()->nullable();
            $table->integer('product_group_id')->unsigned()->nullable();
            $table->string('product_code')->unique()->index();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->text('writeup')->nullable();
            $table->string('original_image')->nullable();
            $table->boolean('available')->default(0);
            $table->boolean('promote')->default(0);
            $table->softDeletes();
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
        Schema::drop('products');
    }
}
