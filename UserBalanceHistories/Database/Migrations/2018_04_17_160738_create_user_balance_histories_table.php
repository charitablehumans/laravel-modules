<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\UserBalanceHistories\Models\UserBalanceHistories;

class CreateUserBalanceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create((new UserBalanceHistories)->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->comment('users.id');
            $table->string('type')->comment('{ transaction }');
            $table->bigInteger('reference_id');
            $table->bigInteger('balance_start');

            $table->bigInteger('balance');
            $table->bigInteger('balance_end');
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
        \Schema::dropIfExists((new UserBalanceHistories)->getTable());
    }
}
