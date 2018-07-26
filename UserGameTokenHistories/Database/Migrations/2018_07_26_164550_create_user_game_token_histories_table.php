<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\UserGameTokenHistories\Models\UserGameTokenHistories;

class CreateUserGameTokenHistoriesTable extends Migration
{
    protected $model;

    public function __construct()
    {
        $this->model = new UserGameTokenHistories;
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
            $table->bigInteger('user_id')->comment('users.id');
            $table->string('type')->comment('{ transaction }');
            $table->bigInteger('reference_id');
            $table->bigInteger('game_token_start')->default(0)->nullable();

            $table->bigInteger('game_token')->default(0)->nullable();
            $table->bigInteger('game_token_end')->default(0)->nullable();
            $table->text('notes')->nullable();

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
