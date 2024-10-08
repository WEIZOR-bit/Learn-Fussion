<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
        Permission::create(['guard_name' => 'admin', 'name' => 'create articles']);
        Permission::create(['guard_name' => 'admin', 'name' => 'edit articles']);
        Permission::create(['guard_name' => 'admin', 'name' => 'delete articles']);
        Permission::create(['guard_name' => 'admin', 'name' => 'view articles']);

        Permission::create(['guard_name' => 'user', 'name' => 'view articles']);
        Permission::create(['guard_name' => 'user', 'name' => 'take courses']);

        // create roles and assign existing permissions
        $role1 = Role::create(['guard_name' => 'user', 'name' => 'User']);
        $role1->givePermissionTo('view articles');
        $role1->givePermissionTo('take courses');

        $role2 = Role::create(['guard_name' => 'admin', 'name' => 'Teacher']);
        $role2->givePermissionTo('create articles');
        $role2->givePermissionTo('edit articles');
        $role2->givePermissionTo('delete articles');
        $role2->givePermissionTo('view articles');

        $role3 = Role::create(['guard_name' => 'admin', 'name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider


        $user = \App\Models\Admin::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123123123'),
        ]);
        $user->assignRole($role3);
    }
}
