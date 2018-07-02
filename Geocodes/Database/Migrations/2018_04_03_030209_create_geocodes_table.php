<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Geocodes\Models\Geocodes;

class CreateGeocodesTable extends Migration
{
    public $model;

    public function __construct()
    {
        $this->model = new Geocodes;
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
            $table->string('type')->comment('{ country, district, province, regency }');
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('postal_code', 10)->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->bigInteger('rajaongkir_id')->nullable();
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
