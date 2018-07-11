<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Ipay88\Models\Ipay88Transactions;

class CreateIpay88TransactionsTable extends Migration
{
    protected $model;

    public function __construct()
    {
        $this->model = new Ipay88Transactions;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create($this->model->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('transaction_id')->comment('transactions.id');
            $table->string('MerchantCode', 20)->comment('The Merchant Code provided by iPay88 and use to uniquely identify the Merchant.');
            $table->integer('PaymentId')->nullable()->comment('Refer to Appendix I.pdf file for IDR gateway.');
            $table->string('RefNo', 20)->comment('Unique merchant transaction number / Order ID');

            $table->bigInteger('Amount')->comment('The amount must not contain any decimal points, thousands separators or currency symbols. For example, Rp 1.278,00 is expressed as 127800.');
            $table->string('Currency', 5)->comment('Refer to Appendix I.pdf file for IDR gateway.');
            $table->string('ProdDesc', 100)->comment('Product description');
            $table->string('UserName', 100)->comment('Customer name');
            $table->string('UserEmail', 100)->comment('Customer email for receiving receipt');

            $table->string('UserContact', 20)->comment('Customer contact number');
            $table->string('Remark', 100)->nullable()->comment('Merchant remarks');
            $table->string('Lang', 20)->nullable()->comment('Encoding type: “ISO-8859-1” – English, “UTF-8” – Unicode, “GB2312” – Chinese Simplified “GD18030” – Chinese Simplified, “BIG5” – Chinese Traditional');
            $table->string('Signature', 100)->comment('SHA1 signature (refer to 3.1)');
            $table->string('ResponseURL', 200)->comment('Payment response page');

            $table->string('BackendURL', 200)->comment('Backend response page URL (refer to 2.7)');

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
        \Schema::dropIfExists($this->model->getTable());
    }
}
