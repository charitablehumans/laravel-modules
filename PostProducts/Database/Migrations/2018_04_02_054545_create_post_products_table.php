<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\PostProducts\Models\PostProducts;

class CreatePostProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create((new PostProducts)->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('post_id');
            $table->string('status')->comment('{ always_available, limited_stock }');
            $table->bigInteger('stock');
            $table->bigInteger('sell_price');
            $table->tinyInteger('special_sell')->default(0)->nullable();
            $table->bigInteger('special_sell_price')->default(0)->nullable();
            $table->bigInteger('special_sell_price_discount')->default(0)->nullable()->comment('sell_price - special_sell_price');
            $table->bigInteger('special_sell_price_discount_percentage')->default(0)->nullable('special_sell_price / sell_price * 100');
            $table->bigInteger('weight')->comment('grams');
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
        \Schema::dropIfExists((new PostProducts)->getTable());
    }
}
