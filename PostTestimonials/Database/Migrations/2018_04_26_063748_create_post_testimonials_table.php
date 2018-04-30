<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\PostTestimonials\Models\PostTestimonials;

class CreatePostTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create((new PostTestimonials)->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('post_id')->comment('posts.id');
            $table->bigInteger('rating')->default(0)->nullable();
            $table->bigInteger('rating_total')->default(0)->nullable();
            $table->bigInteger('rating_count')->default(0)->nullable();

            $table->decimal('rating_average', 20, 2)->default(0)->nullable();

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
        \Schema::dropIfExists((new PostTestimonials)->getTable());
    }
}
