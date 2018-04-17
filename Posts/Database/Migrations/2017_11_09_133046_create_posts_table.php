<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Posts\Models\Posts;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create((new Posts)->getTable(), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('author_id');
            $table->string('type')->comment('{ attachment, custom_link, doku_myshortcart_payment_method, faq, location, page, post, product }');
            $table->string('mime_type', 100);
            $table->enum('status', ['draft', 'publish', 'trash'])->default('publish');
            $table->enum('comment_status', ['closed', 'open'])->default('open');
            $table->bigInteger('comment_count')->default('0');
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
        \Schema::dropIfExists((new Posts)->getTable());
    }
}
