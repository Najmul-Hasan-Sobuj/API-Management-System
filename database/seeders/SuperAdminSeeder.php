<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create super-admin role if it doesn't exist
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);

        // Create all permissions
        $permissions = [
            // Groups
            ['name' => 'view groups', 'group_name' => 'Groups'],
            ['name' => 'create groups', 'group_name' => 'Groups'],
            ['name' => 'edit groups', 'group_name' => 'Groups'],
            ['name' => 'delete groups', 'group_name' => 'Groups'],

            // Collections
            ['name' => 'view collections', 'group_name' => 'Collections'],
            ['name' => 'create collections', 'group_name' => 'Collections'],
            ['name' => 'edit collections', 'group_name' => 'Collections'],
            ['name' => 'delete collections', 'group_name' => 'Collections'],

            // Endpoints
            ['name' => 'view endpoints', 'group_name' => 'Endpoints'],
            ['name' => 'create endpoints', 'group_name' => 'Endpoints'],
            ['name' => 'edit endpoints', 'group_name' => 'Endpoints'],
            ['name' => 'delete endpoints', 'group_name' => 'Endpoints'],

            // Headers
            ['name' => 'view headers', 'group_name' => 'Headers'],
            ['name' => 'create headers', 'group_name' => 'Headers'],
            ['name' => 'edit headers', 'group_name' => 'Headers'],
            ['name' => 'delete headers', 'group_name' => 'Headers'],

            // Payloads
            ['name' => 'view payloads', 'group_name' => 'Payloads'],
            ['name' => 'create payloads', 'group_name' => 'Payloads'],
            ['name' => 'edit payloads', 'group_name' => 'Payloads'],
            ['name' => 'delete payloads', 'group_name' => 'Payloads'],

            // API Documentation
            ['name' => 'view api documentation', 'group_name' => 'API Documentation'],
            ['name' => 'create api documentation', 'group_name' => 'API Documentation'],
            ['name' => 'edit api documentation', 'group_name' => 'API Documentation'],
            ['name' => 'delete api documentation', 'group_name' => 'API Documentation'],

            // User Management
            ['name' => 'view users', 'group_name' => 'User Management'],
            ['name' => 'create users', 'group_name' => 'User Management'],
            ['name' => 'edit users', 'group_name' => 'User Management'],
            ['name' => 'delete users', 'group_name' => 'User Management'],

            // Role Management
            ['name' => 'view roles', 'group_name' => 'Role Management'],
            ['name' => 'create roles', 'group_name' => 'Role Management'],
            ['name' => 'edit roles', 'group_name' => 'Role Management'],
            ['name' => 'delete roles', 'group_name' => 'Role Management'],

            // Permission Management
            ['name' => 'view permissions', 'group_name' => 'Permission Management'],
            ['name' => 'create permissions', 'group_name' => 'Permission Management'],
            ['name' => 'edit permissions', 'group_name' => 'Permission Management'],
            ['name' => 'delete permissions', 'group_name' => 'Permission Management'],
        ];

        // Create permissions one by one
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                [
                    'group_name' => $permission['group_name'],
                    'guard_name' => 'web'
                ]
            );
        }

        // Assign all permissions to super-admin role
        $superAdminRole->syncPermissions(Permission::all());

        // Create super-admin user if it doesn't exist
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Assign super-admin role to the user
        $superAdmin->syncRoles(['super-admin']);
    }
} 