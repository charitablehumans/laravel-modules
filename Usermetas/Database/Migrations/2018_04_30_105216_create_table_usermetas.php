<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Usermetas\Models\Usermetas;

class CreateTableUsermetas extends Migration
{
    protected $model;

    public function __construct()
    {
        $this->model = new Usermetas;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! \Schema::hasTable($this->model->getTable())) {
            \Schema::create('usermetas', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('user_id')->comment('users.id');
                $table->string('key');
                $table->longText('value');

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
            \Schema::dropIfExists('usermetas');
        }
    }
}
