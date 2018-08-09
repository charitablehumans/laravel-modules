<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Modules\Options\Models\Options;

class InsertIntoOptionsValuesModulesAuthenticationHttpControllersApiAuthenticationcontrollerRegister extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $option = Options::firstOrCreate(['name' => 'Modules/Authentication/Http/Controllers/Api/AuthenticationController@register']);
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
        $option = Options::where('name', 'Modules/Authentication/Http/Controllers/Api/AuthenticationController@register')->first();

        if ($option) {
            $option->delete();
        }
    }
}
