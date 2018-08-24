<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Options\Models\Options;

class InsertIntoOptionsValuesModulesTransactionsHttpControllersApiTransactionscontrollerStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $option = Options::firstOrCreate(['name' => 'Modules/Transactions/Http/Controllers/Api/TransactionsController@store']);
        $option->fill([
            'type' => 'boolean',
            'value' => 1,
        ])->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $option = Options::where('name', 'Modules/Transactions/Http/Controllers/Api/TransactionsController@store')->first();

        if ($option) {
            $option->delete();
        }
    }
}
