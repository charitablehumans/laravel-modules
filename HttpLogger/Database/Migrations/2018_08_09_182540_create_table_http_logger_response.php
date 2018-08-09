<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\HttpLogger\Models\HttpLoggerResponse;

class CreateTableHttpLoggerResponse extends Migration
{
    protected $model;

    public function __construct()
    {
        $this->model = new HttpLoggerResponse;
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
            $table->string('uuid', 36);
            $table->longText('headers')->nullable();
            $table->longText('content')->nullable();
            $table->longText('statusCode')->nullable();

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
