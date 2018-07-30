<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\UsersGames\Models\UsersGames;

class CreateUsersGamesTable extends Migration
{
    protected $model;

    public function __construct()
    {
        $this->model = new UsersGames;
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
                $table->bigInteger('user_id');
                $table->bigInteger('token')->default(1);
                $table->bigInteger('finished')->default(0);
                $table->bigInteger('balance')->default(0);
                $table->string('signature')->nullable();
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
        \Schema::dropIfExists($this->model->getTable());
    }
}
