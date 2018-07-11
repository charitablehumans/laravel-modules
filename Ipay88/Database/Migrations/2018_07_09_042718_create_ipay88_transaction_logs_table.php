<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Ipay88\Models\Ipay88TransactionLogs;

class CreateIpay88TransactionLogsTable extends Migration
{
    protected $model;

    public function __construct()
    {
        $this->model = new Ipay88TransactionLogs;
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
            $table->string('ip_address')->nullable();
            $table->string('type')->nullable();
            $table->string('MerchantCode', 20)->comment('The Merchant Code provided by iPay88 and use to uniquely identify the Merchant.');
            $table->string('PaymentId')->nullable()->comment('Refer to Appendix I.pdf file for IDR gateway.');

            $table->string('RefNo', 20)->comment('Unique merchant transaction number / Order ID');
            $table->bigInteger('Amount')->comment('The amount must not contain any decimal points, thousands separators or currency symbols. For example, Rp 1.278,00 is expressed as 127800.');
            $table->string('Currency', 5)->comment('Refer to Appendix I.pdf file for IDR gateway.');
            $table->string('Remark', 100)->nullable()->comment('Merchant remarks');
            $table->string('TransId', 30)->nullable()->comment('iPay88 OPSG Transaction ID');

            $table->string('AuthCode', 20)->nullable()->comment('Bank’s approval code');
            $table->string('Status', 1)->comment('Payment status: “1” – Success, “0” – Fail');
            $table->string('ErrDesc', 100)->nullable()->comment('Payment status description (Refer to Appendix I.pdf file)');
            $table->string('Signature', 100)->nullable()->comment('SHA1 signature (refer to 3.2)');
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
        \Schema::dropIfExists($this->model->getTable());
    }
}
