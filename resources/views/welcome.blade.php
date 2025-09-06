<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Smart Note-Taking Platform</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1f2937;
            --light: #f8fafc;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background: var(--light);
        }

        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary) !important;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-primary) !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary) !important;
            background: rgba(99, 102, 241, 0.1);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 100px 0;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.1)" points="0,1000 1000,0 1000,1000"/></svg>');
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero .lead {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .btn-hero {
            padding: 0.875rem 2rem;
            font-weight: 600;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-hero-primary {
            background: white;
            color: var(--primary);
            border: 2px solid white;
        }

        .btn-hero-primary:hover {
            background: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .btn-hero-outline {
            background: transparent;
            color: white;
            border: 2px solid rgba(255,255,255,0.5);
        }

        .btn-hero-outline:hover {
            background: white;
            color: var(--primary);
            border-color: white;
            transform: translateY(-2px);
        }

        /* Feature Cards */
        .feature-card {
            background: white;
            border-radius: 1rem;
            padding: 2.5rem 2rem;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-color: var(--primary);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 1.5rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .feature-card p {
            color: var(--text-secondary);
            line-height: 1.7;
        }

        /* Stats Section */
        .stats-section {
            background: var(--dark);
            color: white;
            padding: 80px 0;
        }

        .stat-item {
            text-align: center;
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--accent);
            margin-bottom: 0.5rem;
            display: block;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.8;
            font-weight: 500;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--success) 0%, var(--accent) 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        /* Footer */
        .footer {
            background: var(--dark);
            color: white;
            padding: 60px 0 30px;
        }

        .footer h5 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: white;
        }

        .footer a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: var(--accent);
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero .lead {
                font-size: 1.1rem;
            }
            
            .feature-card {
                margin-bottom: 2rem;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
        }

        /* Animations */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in-up.aos-animate {
            opacity: 1;
            transform: translateY(0);
        }

        /* Login/Register buttons */
        .auth-buttons .btn {
            margin: 0 0.25rem;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-login {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-login:hover {
            background: var(--primary);
            color: white;
        }

        .btn-register {
            background: var(--primary);
            color: white;
            border: 2px solid var(--primary);
        }

        .btn-register:hover {
            background: var(--secondary);
            border-color: var(--secondary);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-sticky-note me-2"></i>{{ config('app.name') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <div class="auth-buttons ms-3">
                    <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-register">Get Started</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content" data-aos="fade-up">
                    <h1>Transform Your Note-Taking Experience</h1>
                    <p class="lead">Capture, organize, and collaborate on your ideas with our intelligent note-taking platform. Perfect for students, professionals, and teams.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('register') }}" class="btn-hero btn-hero-primary">
                            <i class="fas fa-rocket me-2"></i>Start Free Trial
                        </a>
                        <a href="#features" class="btn-hero btn-hero-outline">
                            <i class="fas fa-play me-2"></i>Watch Demo
                        </a>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="text-center">
                        <i class="fas fa-laptop-code" style="font-size: 15rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-5 fw-bold mb-3">Powerful Features for Modern Note-Taking</h2>
                <p class="lead text-muted">Everything you need to capture, organize, and share your ideas effectively</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <h3>Rich Text Editor</h3>
                        <p>Create beautiful notes with our advanced editor supporting markdown, code highlighting, tables, and multimedia content.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Team Collaboration</h3>
                        <p>Share notes with your team, collaborate in real-time, and manage permissions with granular access controls.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3>Smart Search</h3>
                        <p>Find any note instantly with our powerful search engine that indexes content, tags, and metadata.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h3>Smart Organization</h3>
                        <p>Organize notes with tags, categories, and folders. AI-powered suggestions help keep everything structured.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3>Cross-Platform Sync</h3>
                        <p>Access your notes anywhere, anytime. Seamless synchronization across all your devices and platforms.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Enterprise Security</h3>
                        <p>Bank-level encryption, secure backups, and compliance with industry standards keep your data safe.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number">50K+</span>
                        <div class="stat-label">Active Users</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number">2M+</span>
                        <div class="stat-label">Notes Created</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number">99.9%</span>
                        <div class="stat-label">Uptime</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number">500+</span>
                        <div class="stat-label">Companies</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" data-aos="fade-up">
        <div class="container">
            <h2>Ready to Transform Your Note-Taking?</h2>
            <p class="lead mb-4">Join thousands of users who have already revolutionized their productivity</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-user-plus me-2"></i>Start Free Trial
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </a>
            </div>
        </div>
    </section>

<!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5><i class="fas fa-sticky-note me-2"></i>{{ config('app.name') }}</h5>
                    <p class="text-light opacity-75 mb-4">The modern note-taking platform that adapts to your workflow. Capture ideas, collaborate with teams, and stay organized.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5>Product</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#features">Features</a></li>
                        <li class="mb-2"><a href="#pricing">Pricing</a></li>
                        <li class="mb-2"><a href="#">API</a></li>
                        <li class="mb-2"><a href="#">Integrations</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5>Company</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#about">About</a></li>
                        <li class="mb-2"><a href="#">Blog</a></li>
                        <li class="mb-2"><a href="#">Careers</a></li>
                        <li class="mb-2"><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5>Support</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Help Center</a></li>
                        <li class="mb-2"><a href="#">Documentation</a></li>
                        <li class="mb-2"><a href="#">Community</a></li>
                        <li class="mb-2"><a href="#">Status</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h5>Legal</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Privacy</a></li>
                        <li class="mb-2"><a href="#">Terms</a></li>
                        <li class="mb-2"><a href="#">Security</a></li>
                        <li class="mb-2"><a href="#">Cookies</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary mt-5 pt-4 text-center">
                <p class="text-light opacity-75 mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = 'none';
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Counter animation for stats
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                const target = parseInt(counter.textContent.replace(/[^\d]/g, ''));
                const suffix = counter.textContent.replace(/[\d]/g, '');
                let current = 0;
                const increment = target / 100;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    counter.textContent = Math.floor(current) + suffix;
                }, 20);
            });
        }

        // Trigger counter animation when stats section is visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        });

        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            observer.observe(statsSection);
        }
    </script>
</body>
</html>