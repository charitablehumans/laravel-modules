<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\PostTranslations\Models\PostTranslations;

class CreatePostTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create((new PostTranslations)->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('post_id');
            $table->string('locale', 200);
            $table->text('title');
            $table->string('name', 200);
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
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
        \Schema::dropIfExists((new PostTranslations)->getTable());
    }
}
