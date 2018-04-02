<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('post_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('post_id');
            $table->string('status')->comment('{ always_available, limited_stock }');
            $table->bigInteger('stock');
            $table->bigInteger('sell_price');
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
        \Schema::dropIfExists('post_products');
    }
}
