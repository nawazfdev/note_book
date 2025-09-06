<header class="header" id="header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="LectureNotes Pro" class="logo">
                <span class="brand-text">LectureNotes<span class="pro">Pro</span></span>
            </a>
            
            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Features</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('features.notes') }}">Smart Note-Taking</a></li>
                            <li><a class="dropdown-item" href="{{ route('features.collaboration') }}">Collaboration</a></li>
                            <li><a class="dropdown-item" href="{{ route('features.export') }}">Export & Share</a></li>
                            <li><a class="dropdown-item" href="{{ route('features.organization') }}">Organization</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pricing') }}">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog') }}">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
                
                <!-- User Actions -->
                <div class="navbar-actions">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                    @else
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle user-dropdown" href="#" data-bs-toggle="dropdown">
                                <img src="{{ auth()->user()->avatar ?? asset('assets/images/default-avatar.png') }}" 
                                     alt="User" class="user-avatar">
                                <span>{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('settings') }}">
                                    <i class="fas fa-cog me-2"></i>Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
</header>