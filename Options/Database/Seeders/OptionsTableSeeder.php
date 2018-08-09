<?php

namespace Modules\Options\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Options\Models\Options;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $options = [
            ['type' => 'APP_ENV', 'name' => 'API/Cnr/UsersGamesController@play', 'value' => 'production'],
            ['type' => 'APP_ENV', 'name' => 'APP_ENV', 'value' => 'local'],
            ['type' => 'APP_ENV', 'name' => 'APP_ENV_MOBILE_ANDROID', 'value' => 'local'],
            ['type' => 'APP_ENV', 'name' => 'APP_ENV_MOBILE_IOS', 'value' => 'local'],
            ['type' => 'url', 'name' => 'APP_URL', 'value' => 'https://laravel.com'],
            ['type' => 'text', 'name' => 'application_version', 'value' => '1'],
            ['type' => 'number', 'name' => 'cms.users.balance_default', 'value' => '0'],
            ['type' => 'page_id', 'name' => 'frontend_home_page', 'value' => ''],
            ['type' => 'page_id', 'name' => 'frontend_home_popup', 'value' => ''],
            ['type' => 'page_id', 'name' => 'frontend_home_popup_button_text', 'value' => ''],
            ['type' => 'page_id', 'name' => 'frontend_home_popup_button_url', 'value' => ''],
            ['type' => 'boolean', 'name' => 'Modules/Authentication/Http/Controllers/Api/AuthenticationController@register', 'value' => 1],
            ['type' => 'number', 'name' => 'Modules/Ravintola/Http/Controllers/Api/V1/Voucher/QueryVoucherController/ValueMax', 'value' => '0'],
            ['type' => 'number', 'name' => 'Modules/Transactions/Http/Controllers/Api/TransactionsController/Store/BalanceMax', 'value' => '0'],
            ['type' => 'number', 'name' => 'Modules/Users/Console/GameTokenAddEveryMonday', 'value' => '0'],
            ['type' => 'number', 'name' => 'Modules/Users/Console/GameTokenAddEverySunday', 'value' => '0'],
            ['type' => 'number', 'name' => 'Modules/Users/Models/Users/BalanceDefault', 'value' => '0'],
            ['type' => 'number', 'name' => 'Modules/Users/Models/Users/GameTokenDefault', 'value' => '10'],
            ['type' => 'number', 'name' => 'Modules/Users/Models/Users/GameTokenMultiple', 'value' => '1'],
        ];

        foreach ($options as $option) {
            $model = Options::firstOrCreate(['name' => $option['name']]);
            $model->fill($option)->save();
        }
    }
}
