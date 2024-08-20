<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view articles']);
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'create articles']);
        Permission::create(['name' => 'delete articles']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'User']);
        $role1->givePermissionTo('view articles');

        $role2 = Role::create(['name' => 'Teacher']);
        $role2->givePermissionTo('create articles');
        $role2->givePermissionTo('edit articles');
        $role2->givePermissionTo('delete articles');
        $role2->givePermissionTo('view articles');

        $role3 = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider
    }
}
