<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDokuTransactionLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('doku_transaction_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip_address');
            $table->string('type');
            $table->string('TRANSIDMERCHANT', 14)->nullable()->comment('Invoice Numbering / Order Numbering from Merchant.');
            $table->string('STOREID', 8)->comment('Unque ID of Merchant.');

            $table->bigInteger('AMOUNT')->length(11)->nullable()->comment('Total amount of a transaction.');
            $table->string('WORDS', 300)->nullable()->comment('Hashed key combination encryption. Please see Protection section Hashed Key Value, WORDS 1.');
            $table->string('RESULT', 125)->nullable()->comment('Payment status of a transaction. If a transaction is approved, MYSHORTCART will send “Success”.');
            $table->string('STATUSCODE', 2)->nullable()->comment('Status code of a transaction. If a transaction is approved, MYSHORTCART will send “00”.');
            $table->date('TRANSDATE')->nullable()->comment('Transaction time ex : 2012-06-16.');

            $table->string('PTYPE', 20)->nullable()->comment('Payment mothod option ex : Creditcard, Dokupay etc.');
            $table->string('EXTRAINFO', 250)->nullable()->comment('Extra info that is sent by merchant. ex : xlk01.');
            $table->longText('data')->nullable();

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
        \Schema::dropIfExists('doku_transaction_logs');
    }
}
