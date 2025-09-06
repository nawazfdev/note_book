# Spatie Laravel Permission Setup Guide

## Option 1: Current Simple Setup (Already Working)
- ✅ Simple role column in users table
- ✅ Basic middleware protection
- ✅ Good for small applications
- ❌ Limited scalability for complex permission systems

## Option 2: Spatie Laravel Permission (Recommended for SaaS)

### 1. Install Spatie Laravel Permission
```bash
composer require spatie/laravel-permission
```

### 2. Publish and Run Migrations
```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### 3. Update User Model
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    public function isNormalUser(): bool
    {
        return $this->hasRole('normal_user');
    }
}
```

### 4. Create Seeder for Roles and Permissions
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            'view_dashboard',
            'manage_users',
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'manage_settings',
            'view_reports',
            'manage_subscriptions',
            'view_analytics',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles and Assign Permissions
        $superAdminRole = Role::create(['name' => 'super_admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        $normalUserRole = Role::create(['name' => 'normal_user']);
        $normalUserRole->givePermissionTo(['view_dashboard']);

        // Assign roles to existing users
        $superAdmin = User::where('email', 'superadmin@example.com')->first();
        if ($superAdmin) {
            $superAdmin->assignRole('super_admin');
        }

        $normalUser = User::where('email', 'user@example.com')->first();
        if ($normalUser) {
            $normalUser->assignRole('normal_user');
        }
    }
}
```

### 5. Update Middleware
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->hasRole('super_admin')) {
            abort(403, 'Access denied. Super admin privileges required.');
        }

        return $next($request);
    }
}
```

### 6. Advanced Permission Checking in Views
```blade
@role('super_admin')
    <p>This is visible only to super admins</p>
@endrole

@permission('manage_users')
    <a href="{{ route('users.index') }}">Manage Users</a>
@endpermission

@hasanyrole('super_admin|admin')
    <p>This is visible to super admins and admins</p>
@endhasanyrole
```

### 7. Controller Permission Checking
```php
public function index()
{
    $this->authorize('view_users');
    // or
    if (!auth()->user()->can('view_users')) {
        abort(403);
    }
    
    return view('users.index');
}
```

## Option 3: Separate Admin Guard (Multi-Authentication)

### 1. Create Admin Model
```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
```

### 2. Update config/auth.php
```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
    'admins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],
],
```

### 3. Create Admin Migration
```php
Schema::create('admins', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});
```

## Recommendation for Your SaaS Project

For a subscription-based SaaS application, I recommend **Option 2 (Spatie Laravel Permission)** because:

1. **Scalability**: Easy to add new roles and permissions
2. **Flexibility**: Granular permission control
3. **Multi-tenancy Ready**: Can assign different permissions per tenant
4. **Standard**: Industry standard package used by many Laravel applications
5. **Future-proof**: Easy to extend for complex business logic

Would you like me to implement any of these options?
