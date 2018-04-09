<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\TransactionBillingAddress\Models\TransactionBillingAddress;

class CreateTransactionBillingAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create((new TransactionBillingAddress)->getTable(), function (Blueprint $table) {
            $table->bigincrements('id');
            $table->bigInteger('transaction_id')->comment('transactions.id');
            $table->string('name');
            $table->string('phone_number', 20);
            $table->bigInteger('province_id')->comment('geocodes.id');

            $table->bigInteger('regency_id')->comment('geocodes.id');
            $table->bigInteger('district_id');
            $table->string('postal_code', 10);
            $table->text('address');
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
        \Schema::dropIfExists((new TransactionBillingAddress)->getTable());
    }
}
