<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Transactions\Models\Transactions;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create((new Transactions)->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->default('sales')->nullable()->comment('{ purchase, sales }');
            $table->bigInteger('sender_id');
            $table->bigInteger('receiver_id');
            $table->string('number')->nullable();

            $table->string('status')->default('pending')->comment('{ pending, new, processed, sent, received, finished, returned }');
            $table->string('receipt_number')->nullable();
            $table->datetime('due_date')->nullable();
            $table->string('payment')->nullable();
            $table->string('payment_status')->nullable();

            $table->datetime('payment_date')->nullable();
            $table->bigInteger('total_sell_price');
            $table->bigInteger('total_discount');
            $table->bigInteger('total_weight');
            $table->bigInteger('total_shipping_cost')->comment('round(total_weight) * transactions_shipments.cost * transactions_shipments.distance');

            $table->bigInteger('grand_total')->comment('total_price - total_discount + total_shipping_cost');
            $table->text('notes')->nullable();

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
        \Schema::dropIfExists((new Transactions)->getTable());
    }
}
