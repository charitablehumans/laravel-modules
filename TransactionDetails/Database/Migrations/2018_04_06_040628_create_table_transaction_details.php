<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\TransactionDetails\Models\TransactionDetails;

class CreateTableTransactionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create((new TransactionDetails)->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('transaction_id')->comment('transactions.id');
            $table->bigInteger('quantity');
            $table->bigInteger('product_id')->comment('post.id where type = \'product\'');
            $table->bigInteger('product_sell_price');

            $table->bigInteger('product_discount')->default(0)->nullable();
            $table->bigInteger('product_weight')->comment('grams');

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
        \Schema::dropIfExists((new TransactionDetails)->getTable());
    }
}
