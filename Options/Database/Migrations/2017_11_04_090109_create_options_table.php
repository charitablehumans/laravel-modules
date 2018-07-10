<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Options\Models\Options;

class CreateOptionsTable extends Migration
{
    protected $model;

    public function __construct()
    {
        $this->model = new Options;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! \Schema::hasTable($this->model->getTable())) {
            \Schema::create($this->model->getTable(), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('type')->default('text');
                $table->string('name');
                $table->longText('value')->nullable();
                $table->timestamps();
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
        if (\Schema::hasTable($this->model->getTable())) {
            \Schema::dropIfExists((new Options)->getTable());
        }
    }
}
