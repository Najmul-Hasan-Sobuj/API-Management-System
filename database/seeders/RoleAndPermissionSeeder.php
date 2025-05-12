<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
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

        // First, create all unique group names
        $uniqueGroups = collect($permissions)->pluck('group_name')->unique();
        foreach ($uniqueGroups as $groupName) {
            Permission::firstOrCreate(
                ['name' => $groupName],
                [
                    'group_name' => $groupName,
                    'guard_name' => 'web'
                ]
            );
        }

        // Then create all permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                [
                    'group_name' => $permission['group_name'],
                    'guard_name' => 'web'
                ]
            );
        }

        // Create roles and assign permissions
        $roles = [
            'super-admin' => Permission::all(),
            'admin' => Permission::whereIn('group_name', [
                'Groups',
                'Collections',
                'Endpoints',
                'Headers',
                'Payloads',
                'API Documentation'
            ])->get(),
            'user' => Permission::whereIn('group_name', [
                'Groups',
                'Collections',
                'Endpoints'
            ])->get(),
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($permissions);
        }
    }
} 