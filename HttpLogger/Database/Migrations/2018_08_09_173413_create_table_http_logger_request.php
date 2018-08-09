<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\HttpLogger\Models\HttpLoggerRequest;

class CreateTableHttpLoggerRequest extends Migration
{
    protected $model;

    public function __construct()
    {
        $this->model = new HttpLoggerRequest;
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
            $table->longText('input')->nullable();
            $table->longText('query')->nullable();
            $table->longText('server')->nullable();

            $table->longText('files')->nullable();
            $table->longText('cookies')->nullable();
            $table->longText('headers')->nullable();

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
