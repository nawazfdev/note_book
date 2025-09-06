@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <div class="sidebar-header d-flex align-items-center mb-3">
                    <h5 class="mb-0">Super Admin Panel</h5>
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('super-admin.dashboard') }}">
                            <i class="bi bi-house me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('super-admin.users') }}">
                            <i class="bi bi-people me-2"></i>
                            Manage Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('super-admin.settings') }}">
                            <i class="bi bi-gear me-2"></i>
                            Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-danger border-0 w-100 text-start">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Super Admin Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <span class="badge bg-primary">Welcome, {{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>

            <!-- Dashboard Stats -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header">Total Users</div>
                        <div class="card-body">
                            <h4 class="card-title">{{ $totalUsers }}</h4>
                            <p class="card-text">All registered users in the system</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header">Super Admins</div>
                        <div class="card-body">
                            <h4 class="card-title">{{ $superAdmins }}</h4>
                            <p class="card-text">Users with super admin privileges</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header">Normal Users</div>
                        <div class="card-body">
                            <h4 class="card-title">{{ $normalUsers }}</h4>
                            <p class="card-text">Regular users in the system</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>System Overview</h5>
                        </div>
                        <div class="card-body">
                            <p>Welcome to the Super Admin Dashboard. You have full access to manage all users and system settings.</p>
                            <div class="alert alert-info">
                                <strong>Super Admin Privileges:</strong>
                                <ul class="mb-0">
                                    <li>Manage all users in the system</li>
                                    <li>View system analytics and reports</li>
                                    <li>Configure system settings</li>
                                    <li>Access all administrative functions</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
