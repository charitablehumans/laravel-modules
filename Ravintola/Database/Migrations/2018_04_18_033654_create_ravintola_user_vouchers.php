<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Ravintola\Models\RavintolaUserVouchers;

class CreateRavintolaUserVouchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create((new RavintolaUserVouchers)->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->comment('users.id');
            $table->string('uuid', 36);
            $table->string('pos_id', 20)->comment('Identifier / name for POS terminal');
            $table->string('outlet_code', 10)->comment('Outlet caller’s Branch ID');

            $table->string('verification_number', 12)->comment('Voucher code to be activated on POS; users.verification_code');
            $table->string('phone_number', 20)->comment('Member phone number');
            $table->bigInteger('transaction_amount')->comment('Total transaction amount in rupiah');
            $table->string('signature', 64)->comment('Signature = SHA256(secrey_key + pos_id + outlet_code + verification_number + phone_number + transaction_amount)');
            $table->date('expiry')->nullable();

            $table->bigInteger('value')->comment('users.balance');
            $table->datetime('used_time')->nullable();
            $table->string('used_outlet', 10)->nullable();
            $table->string('status')->default('new')->comment('{ expired, new, used }');
            $table->bigInteger('transaction_deductible')->comment('Real transaction amount in rupiah that is deductible by this voucher (this is the actual amount spent on voucher amount on the server)');

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
        \Schema::dropIfExists((new RavintolaUserVouchers)->getTable());
    }
}
