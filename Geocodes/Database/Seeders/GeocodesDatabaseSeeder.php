<?php

namespace Modules\Geocodes\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Geocodes\Models\Geocodes;

class GeocodesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $model = new Geocodes;
        $model->sync();
    }
}
