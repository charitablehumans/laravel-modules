<?php

namespace Modules\Roles\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $role = Role::create(['name' => 'superadmin']);
        $role->givePermissionTo([
            'api rajaongkir',
            'backend categories',
            'backend cnr balances',
            'backend content',
            'backend custom links',
            'backend custom links delete',
            'backend custom links trash',
            'backend dashboard',
            'backend faqs',
            'backend faqs delete',
            'backend faqs trash',
            'backend geocodes',
            'backend locations',
            'backend locations delete',
            'backend locations trash',
            'backend main',
            'backend masters',
            'backend media',
            'backend media all',
            'backend media delete',
            'backend media role',
            'backend media trash',
            'backend medium categories',
            'backend menus',
            'backend options',
            'backend permissions',
            'backend pages',
            'backend pages delete',
            'backend pages trash',
            'backend posts',
            'backend posts delete',
            'backend posts trash',
            'backend products',
            'backend products delete',
            'backend products trash',
            'backend rajaongkir',
            'backend roles',
            'backend tags',
            'backend user addresses',
            'backend users',
        ]);
    }
}
