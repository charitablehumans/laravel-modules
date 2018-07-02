<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\UserAddresses\Models\UserAddresses;

class AddAddressColumnAsInUserAddressesTable extends Migration
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
        if (! \Schema::hasColumn($this->model->getTable(), 'address_as')) {
            \Schema::table($this->model->getTable(), function (Blueprint $table) {
                $table->string('address_as')->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (\Schema::hasColumn($this->model->getTable(), 'address_as')) {
            \Schema::table($this->model->getTable(), function (Blueprint $table) {
                $table->dropColumn('address_as');
            });
        }
    }
}
