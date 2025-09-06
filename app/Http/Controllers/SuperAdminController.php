<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $superAdmins = User::role('super_admin')->count();
        $normalUsers = User::role('normal_user')->count();
        
        return view('super-admin.dashboard', compact('totalUsers', 'superAdmins', 'normalUsers'));
    }
    
    public function users()
    {
        $users = User::with('roles')->paginate(10);
        return view('super-admin.users', compact('users'));
    }
    
    public function settings()
    {
        return view('super-admin.settings');
    }
}
