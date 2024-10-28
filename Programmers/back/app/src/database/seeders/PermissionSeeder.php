<?php

namespace Database\Seeders;

use App\Models\Admin;
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
        Permission::firstOrCreate(['guard_name' => 'admin', 'name' => 'create articles']);
        Permission::firstOrCreate(['guard_name' => 'admin', 'name' => 'edit articles']);
        Permission::firstOrCreate(['guard_name' => 'admin', 'name' => 'delete articles']);
        Permission::firstOrCreate(['guard_name' => 'admin', 'name' => 'view articles']);

        Permission::firstOrCreate(['guard_name' => 'user', 'name' => 'view articles']);
        Permission::firstOrCreate(['guard_name' => 'user', 'name' => 'take courses']);

        // create roles and assign existing permissions
        $role1 = Role::firstOrCreate(['guard_name' => 'user', 'name' => 'User']);
        $role1->givePermissionTo('view articles');
        $role1->givePermissionTo('take courses');

        $role2 = Role::firstOrCreate(['guard_name' => 'admin', 'name' => 'Teacher']);
        $role2->givePermissionTo('create articles');
        $role2->givePermissionTo('edit articles');
        $role2->givePermissionTo('delete articles');
        $role2->givePermissionTo('view articles');

        $role3 = Role::firstOrCreate(['guard_name' => 'admin', 'name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider


        $user = Admin::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123123123'),
        ]);
        $user->assignRole($role3);

        $user2 = \App\Models\User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'password' => Hash::make('123123123123'),
            'mastery_level' => 3,
            'hearts' => '5',
            'mastery_tag' => 'super',

        ]);
        $user2->assignRole($role1);


        $user3 = \App\Models\User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@gmail.com',
            'password' => Hash::make('123123123123'),
            'mastery_level' => 3,
            'hearts' => '5',
            'mastery_tag' => 'elite',

        ]);
        $user3->assignRole($role1);

        $user4 = \App\Models\User::factory()->create([
            'name' => 'Capibara',
            'email' => 'capibara@gmail.com',
            'password' => Hash::make('123123123123'),
            'mastery_level' => 3,
            'hearts' => '5',
            'mastery_tag' => 'silver',

        ]);
        $user4->assignRole($role1);
    }
}
