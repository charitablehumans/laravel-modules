<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Terms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('terms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('taxonomy', 100);
            $table->bigInteger('parent_id')->nullable()->default('0');
            $table->bigInteger('count')->default('0');
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
        \Schema::dropIfExists('terms');
    }
}
