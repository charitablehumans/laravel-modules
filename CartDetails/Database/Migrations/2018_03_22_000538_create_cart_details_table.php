<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\CartDetails\Models\CartDetails;

class CreateCartDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! \Schema::hasTable((new CartDetails)->getTable())) {
            \Schema::create((new CartDetails)->getTable(), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('cart_id');
                $table->bigInteger('seller_id');
                $table->bigInteger('post_id');
                $table->bigInteger('quantity');
                $table->bigInteger('price');
                $table->bigInteger('weight');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::dropIfExists((new CartDetails)->getTable());
    }
}
