<?php

namespace Modules\Permissions\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        Permission::create(['name' => 'api rajaongkir']);

        Permission::create(['name' => 'backend categories']);
        Permission::create(['name' => 'backend cnr balances']);
        Permission::create(['name' => 'backend content']);
        Permission::create(['name' => 'backend custom links']);
        Permission::create(['name' => 'backend custom links delete']);
        Permission::create(['name' => 'backend custom links trash']);
        Permission::create(['name' => 'backend dashboard']);
        Permission::create(['name' => 'backend doku myshortcart payment methods']);
        Permission::create(['name' => 'backend faqs']);
        Permission::create(['name' => 'backend faqs delete']);
        Permission::create(['name' => 'backend faqs trash']);
        Permission::create(['name' => 'backend geocodes']);
        Permission::create(['name' => 'backend locations']);
        Permission::create(['name' => 'backend locations delete']);
        Permission::create(['name' => 'backend locations trash']);
        Permission::create(['name' => 'backend main']);
        Permission::create(['name' => 'backend masters']);
        Permission::create(['name' => 'backend media']);
        Permission::create(['name' => 'backend media all']);
        Permission::create(['name' => 'backend media delete']);
        Permission::create(['name' => 'backend media trash']);
        Permission::create(['name' => 'backend media role']);
        Permission::create(['name' => 'backend medium categories']);
        Permission::create(['name' => 'backend menus']);
        Permission::create(['name' => 'backend options']);
        Permission::create(['name' => 'backend permissions']);
        Permission::create(['name' => 'backend pages']);
        Permission::create(['name' => 'backend pages delete']);
        Permission::create(['name' => 'backend pages trash']);
        Permission::create(['name' => 'backend posts']);
        Permission::create(['name' => 'backend posts delete']);
        Permission::create(['name' => 'backend posts trash']);
        Permission::create(['name' => 'backend posts users']);
        Permission::create(['name' => 'backend product categories']);
        Permission::create(['name' => 'backend product testimonials']);
        Permission::create(['name' => 'backend product testimonials all']);
        Permission::create(['name' => 'backend product testimonials delete']);
        Permission::create(['name' => 'backend product testimonials trash']);
        Permission::create(['name' => 'backend products']);
        Permission::create(['name' => 'backend products all']);
        Permission::create(['name' => 'backend products delete']);
        Permission::create(['name' => 'backend products trash']);
        Permission::create(['name' => 'backend products wishlist']);
        Permission::create(['name' => 'backend rajaongkir']);
        Permission::create(['name' => 'backend roles']);
        Permission::create(['name' => 'backend tags']);
        Permission::create(['name' => 'backend theme']);
        Permission::create(['name' => 'backend transactions']);
        Permission::create(['name' => 'backend transactions purchases']);
        Permission::create(['name' => 'backend transactions purchases all']);
        Permission::create(['name' => 'backend transactions sales']);
        Permission::create(['name' => 'backend transactions sales all']);
        Permission::create(['name' => 'backend user addresses']);
        Permission::create(['name' => 'backend user balance histories']);
        Permission::create(['name' => 'backend user socialites']);
        Permission::create(['name' => 'backend users']);
        Permission::create(['name' => 'backend users store all']);
    }
}
