<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Carts\Models\Carts;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! \Schema::hasTable((new Carts)->getTable())) {
            \Schema::create((new Carts)->getTable(), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('user_id');
                $table->string('type')->comment('{ shopping }');
                $table->bigInteger('total_quantity');
                $table->bigInteger('total_price');
                $table->bigInteger('total_weight');
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
        \Schema::dropIfExists((new Carts)->getTable());
    }
}
