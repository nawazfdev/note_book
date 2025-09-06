<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assign roles to specific users by email
        $userRoleMapping = [
            'superadmin@example.com' => 'super_admin',
            'user@example.com' => 'normal_user',
            'john@example.com' => 'normal_user',
            'jane@example.com' => 'normal_user',
        ];

        foreach ($userRoleMapping as $email => $roleName) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->assignRole($roleName);
                echo "✅ Assigned '{$roleName}' role to {$user->name} ({$user->email})\n";
            }
        }

        // Create additional test users with specific roles
        
        // Create a manager test user
        $manager = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager User',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]
        );
        if (!$manager->hasAnyRole()) {
            $manager->assignRole('manager');
            echo "✅ Created manager user: {$manager->email}\n";
        }

        // Create an editor test user
        $editor = User::firstOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'Editor User',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]
        );
        if (!$editor->hasAnyRole()) {
            $editor->assignRole('editor');
            echo "✅ Created editor user: {$editor->email}\n";
        }

        echo "✅ User roles assigned successfully!\n";
        
        // Display final role assignments
        $users = User::with('roles')->get();
        echo "\n📋 Final Role Assignments:\n";
        echo "==========================\n";
        foreach ($users as $user) {
            $roles = $user->roles->pluck('name')->join(', ');
            echo "👤 {$user->name} ({$user->email}): {$roles}\n";
        }
    }
}
