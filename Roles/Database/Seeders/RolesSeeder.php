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
            'backend doku myshortcart payment methods',
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
            'backend posts users',
            'backend product categories',
            'backend product testimonials',
            'backend product testimonials all',
            'backend product testimonials delete',
            'backend product testimonials trash',
            'backend products',
            'backend products all',
            'backend products delete',
            'backend products trash',
            'backend products wishlist',
            'backend rajaongkir',
            'backend roles',
            'backend tags',
            'backend theme',
            'backend transactions',
            'backend transactions purchases',
            'backend transactions purchases all',
            'backend transactions sales',
            'backend transactions sales all',
            'backend user addresses',
            'backend user balance histories',
            'backend user socialites',
            'backend users',
            'backend users store all',
        ]);
    }
}
