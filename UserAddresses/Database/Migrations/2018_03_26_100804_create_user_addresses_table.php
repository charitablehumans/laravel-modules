<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\UserAddresses\Models\UserAddresses;

class CreateUserAddressesTable extends Migration
{
    public $model;

    public function __construct()
    {
        $this->model = new UserAddresses;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->model->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('address_as');
            $table->bigInteger('user_id');
            $table->string('name');
            $table->string('phone_number', 20);
            $table->bigInteger('province_id')->comment('geocodes.id');
            $table->bigInteger('regency_id')->comment('geocodes.id');
            $table->bigInteger('district_id');
            $table->string('postal_code', 10);
            $table->text('address');
            $table->enum('primary', ['0', '1'])->default('0');
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
        Schema::dropIfExists($this->model->getTable());
    }
}
