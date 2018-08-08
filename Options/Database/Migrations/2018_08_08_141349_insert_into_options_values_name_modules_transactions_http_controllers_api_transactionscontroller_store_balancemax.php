<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Options\Models\Options;

class InsertIntoOptionsValuesNameModulesTransactionsHttpControllersApiTransactionscontrollerStoreBalancemax extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $option = Options::firstOrCreate(['name' => 'Modules/Transactions/Http/Controllers/Api/TransactionsController/Store/BalanceMax']);
        $option->fill([
            'type' => 'number',
            'value' => 0,
        ])->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $option = Options::where('name', 'Modules/Transactions/Http/Controllers/Api/TransactionsController/Store/BalanceMax')->first();

        if ($option) {
            $option->delete();
        }
    }
}
