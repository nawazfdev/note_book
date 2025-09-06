@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <div class="sidebar-header d-flex align-items-center mb-3">
                    <i class="fas fa-graduation-cap text-primary me-2 fs-4"></i>
                    <h5 class="mb-0">EduNotes</h5>
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('normal-user.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('courses.index') }}">
                            <i class="fas fa-book me-2"></i>
                            My Courses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('notes.index') }}">
                            <i class="fas fa-sticky-note me-2"></i>
                            Recent Notes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('documents.index') }}">
                            <i class="fas fa-folder me-2"></i>
                            Documents
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('notes.index', ['search' => '']) }}">
                            <i class="fas fa-search me-2"></i>
                            Search
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('normal-user.profile') }}">
                            <i class="fas fa-user me-2"></i>
                            Profile
                        </a>
                    </li>
                    <li class="nav-item mt-3 pt-3 border-top">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-danger border-0 w-100 text-start">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Coming Soon Message -->
            <div class="text-center py-5">
                <i class="fas fa-sticky-note text-muted mb-4" style="font-size: 5rem; opacity: 0.3;"></i>
                <h3 class="text-muted mb-3">Note View Coming Soon</h3>
                <p class="text-muted mb-4">The detailed note view is being developed. You can still create and manage notes!</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('notes.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Notes
                    </a>
                    <a href="{{ route('notes.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i>Create New Note
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
.sidebar {
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.nav-link:hover {
    background-color: rgba(13, 110, 253, 0.1);
}

.nav-link.active {
    background-color: #0d6efd;
    color: white !important;
}
</style>
@endsection
