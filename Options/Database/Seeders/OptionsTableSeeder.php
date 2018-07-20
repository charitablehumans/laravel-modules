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
            ['type' => 'text', 'name' => 'application_version', 'value' => '1'],
            ['type' => 'number', 'name' => 'cms.users.balance_default', 'value' => '0'],
            ['type' => 'page_id', 'name' => 'frontend_home_page', 'value' => ''],
            ['type' => 'page_id', 'name' => 'frontend_home_popup', 'value' => ''],
            ['type' => 'page_id', 'name' => 'frontend_home_popup_button_text', 'value' => ''],
            ['type' => 'page_id', 'name' => 'frontend_home_popup_button_url', 'value' => ''],
            ['type' => 'number', 'name' => 'Modules/Users/Console/GameTokenAddEverySunday', 'value' => '1'],
        ];

        foreach ($options as $option) {
            Options::create($option);
        }
    }
}
