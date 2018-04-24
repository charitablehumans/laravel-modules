<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('{ store_id, user_id }');
            $table->string('name')->comment('profile');
            $table->string('email')->comment('profile')->unique();
            $table->string('phone_number', 20)->comment('profile');
            $table->string('password')->comment('profile');
            $table->rememberToken();
            $table->string('access_token')->nullable();
            $table->boolean('verified')->default(false);
            $table->string('verification_code', 6);
            $table->date('date_of_birth')->comment('profile');
            $table->longText('address')->comment('profile');
            $table->bigInteger('store_id')->default(0)->nullable()->comment('store.user.id');
            $table->bigInteger('balance')->default(0)->comment('store.balance');
            $table->bigInteger('game_token')->default(0)->comment('game');
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
        Schema::dropIfExists('users');
    }
}
