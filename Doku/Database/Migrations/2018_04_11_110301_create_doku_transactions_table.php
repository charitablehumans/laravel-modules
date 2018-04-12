<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Doku\Models\DokuTransactions;

class CreateDokuTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create((new DokuTransactions)->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('transaction_id')->comment('transactions.id');
            $table->string('BASKET', 250)->comment('Show transaction description. It uses separation for fields and other descriptions. Sample below *');
            $table->string('STOREID', 8)->comment('Unique ID of merchant/store *');
            $table->string('TRANSIDMERCHANT', 14)->comment('Invoice Numbering / Order Numbering from Merchant *');

            $table->bigInteger('AMOUNT')->length(11)->comment('Total amount of a transaction *');
            $table->string('URL', 250)->comment('Url of merchant’s website *');
            $table->string('WORDS', 300)->comment('Hashed key combination encryption. Please see Protection section Hashed Key Value, WORDS 1. *');
            $table->string('CNAME', 250)->comment('Customer name *');
            $table->string('CEMAIL', 250)->comment('Customer email *');

            $table->bigInteger('CWPHONE')->length(14)->comment('Customer office phone number *');
            $table->bigInteger('CHPHONE')->length(14)->comment('Customer home phone number *');
            $table->bigInteger('CMPHONE')->length(14)->comment('Customer mobile phone number *');
            $table->string('CCAPHONE')->nullable();
            $table->string('CADDRESS', 500)->nullable()->comment('Customer address');

            $table->bigInteger('CZIPCODE')->length(8)->nullable()->comment('Customer zip code of location');
            $table->string('SADDRESS', 500)->nullable()->comment('Shipping Information Address');
            $table->string('SZIPCODE', 10)->nullable()->comment('Shipping Information Zipcode');
            $table->string('SCITY', 60)->nullable()->comment('Shipping Information City');
            $table->string('SSTATE', 60)->nullable()->comment('Shipping Information State');

            $table->string('SCOUNTRY', 4)->nullable()->comment('Shipping Information Country');
            $table->date('BIRTHDATE')->nullable()->comment('Customer birthdate');

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
        \Schema::dropIfExists((new DokuTransactions)->getTable());
    }
}
