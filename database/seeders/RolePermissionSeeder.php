<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Dashboard permissions
            'view_dashboard',
            'view_admin_dashboard',
            
            // User management permissions
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'manage_users',
            
            // Note management permissions
            'create_notes',
            'edit_notes',
            'delete_notes',
            'view_notes',
            'share_notes',
            
            // System permissions
            'manage_settings',
            'view_analytics',
            'manage_system',
            'view_reports',
            
            // Profile permissions
            'edit_profile',
            'view_profile',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Super Admin Role - has all permissions
        $superAdminRole = Role::create(['name' => 'super_admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Normal User Role - limited permissions
        $normalUserRole = Role::create(['name' => 'normal_user']);
        $normalUserRole->givePermissionTo([
            'view_dashboard',
            'create_notes',
            'edit_notes',
            'delete_notes',
            'view_notes',
            'share_notes',
            'edit_profile',
            'view_profile',
        ]);

        // Optional: Create additional roles for future use
        
        // Manager Role - moderate permissions
        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view_dashboard',
            'view_users',
            'create_notes',
            'edit_notes',
            'delete_notes',
            'view_notes',
            'share_notes',
            'edit_profile',
            'view_profile',
            'view_reports',
        ]);

        // Editor Role - content management permissions
        $editorRole = Role::create(['name' => 'editor']);
        $editorRole->givePermissionTo([
            'view_dashboard',
            'create_notes',
            'edit_notes',
            'delete_notes',
            'view_notes',
            'share_notes',
            'edit_profile',
            'view_profile',
        ]);

        echo "✅ Created " . Permission::count() . " permissions\n";
        echo "✅ Created " . Role::count() . " roles\n";
        echo "✅ Roles and permissions seeded successfully!\n";
    }
}
