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
            ['type' => 'text', 'name' => 'application_version', 'value' => '1', 'created_at' => date('Y-m-d H:i:s')],
        ];
        Options::insert($options);
    }
}
