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
            ['type' => 'APP_ENV', 'name' => 'APP_ENV', 'value' => 'local'],
            ['type' => 'url', 'name' => 'APP_URL', 'value' => 'https://laravel.com'],
            ['type' => 'text', 'name' => 'application_version', 'value' => '1'],
            ['type' => 'number', 'name' => 'cms.users.balance_default', 'value' => '0'],
            ['type' => 'page_id', 'name' => 'frontend_home_page', 'value' => ''],
            ['type' => 'page_id', 'name' => 'frontend_home_popup', 'value' => ''],
            ['type' => 'page_id', 'name' => 'frontend_home_popup_button_text', 'value' => ''],
            ['type' => 'page_id', 'name' => 'frontend_home_popup_button_url', 'value' => ''],
            ['type' => 'number', 'name' => 'Modules/Users/Console/GameTokenAddEveryMonday', 'value' => '0'],
            ['type' => 'number', 'name' => 'Modules/Users/Console/GameTokenAddEverySunday', 'value' => '0'],
            ['type' => 'number', 'name' => 'Modules/Users/Models/Users/GameTokenDefault', 'value' => '10'],
            ['type' => 'number', 'name' => 'Modules/Users/Models/Users/GameTokenMultiple', 'value' => '1'],
        ];

        foreach ($options as $option) {
            Options::create($option);
        }
    }
}
