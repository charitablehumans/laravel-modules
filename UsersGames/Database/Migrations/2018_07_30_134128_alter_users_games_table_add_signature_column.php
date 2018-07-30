<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\UsersGames\Models\UsersGames;

class AlterUsersGamesTableAddSignatureColumn extends Migration
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
        if (! \Schema::hasColumn($this->model->getTable(), 'signature')) {
            \Schema::table($this->model->getTable(), function($table) {
                $table->string('signature')->nullable()->after('balance');
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
        if (\Schema::hasColumn($this->model->getTable(), 'signature')) {
            \Schema::table($this->model->getTable(), function($table) {
                $table->dropColumn('signature');
            });
        }
    }
}
