<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\TransactionShipment\Models\TransactionShipment;

class CreateTransactionShipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create((new TransactionShipment)->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('transaction_id')->comment('transactions.id');
            $table->string('code')->comment('{ jne, pos, tiki }');
            $table->string('name');
            $table->string('service')->comment('{ OKE, ONS, Paket Kilat Khusus, REG }');

            $table->string('description')->nullable();
            $table->bigInteger('distance')->default(1)->nullable()->comment('km');
            $table->bigInteger('cost');

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
        \Schema::dropIfExists((new TransactionShipment)->getTable());
    }
}
