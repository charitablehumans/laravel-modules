<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\PostsUsers\Models\PostsUsers;

class CreatePostsUsersTable extends Migration
{
    protected $model;

    public function __construct()
    {
        $this->model = new PostsUsers;
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
                $table->string('type')->nullable()->comment('{ wishlist_product }');
                $table->bigInteger('post_id')->comment('posts.id');
                $table->bigInteger('user_id')->comment('users.id');

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
            \Schema::dropIfExists($this->model->getTable());
        }
    }
}
