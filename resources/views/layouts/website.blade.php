<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LectureNotes Pro - Smart Note-Taking for Students')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', 'Transform your lecture experience with LectureNotes Pro. Create, organize, and share rich notes with text, images, and diagrams. Perfect for students and educators.')">
    <meta name="keywords" content="lecture notes, note-taking, student app, education, study tools, digital notes, collaboration">
    <meta name="author" content="LectureNotes Pro">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'LectureNotes Pro - Smart Note-Taking Platform')">
    <meta property="og:description" content="@yield('og_description', 'The ultimate note-taking platform for students. Create rich, interactive notes with text, images, and diagrams.')">
    <meta property="og:image" content="@yield('og_image', asset('assets/images/og-image.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'LectureNotes Pro')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Smart note-taking platform for students')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('assets/images/twitter-image.jpg'))">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/apple-touch-icon.png') }}">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Additional Head Content -->
    @stack('head')
    
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'GA_MEASUREMENT_ID');
    </script>
</head>

<body class="@yield('body_class')">
    <!-- Loading Spinner -->
    <div id="page-loader" class="page-loader">
        <div class="loader-content">
            <div class="spinner"></div>
            <p>Loading...</p>
        </div>
    </div>

    <!-- Header -->
    @include('partials.seo.header')
    
    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('partials.seo.footer')
    
    <!-- Back to Top Button -->
    <button id="back-to-top" class="back-to-top" aria-label="Back to top">
        <i class="fas fa-chevron-up"></i>
    </button>
    
    <!-- Cookie Consent -->
    @include('partials.seo.cookie-consent')
    
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    
    <!-- Custom JavaScript -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/components.js') }}"></script>
    
    <!-- Page Specific Scripts -->
    @stack('scripts')
    
    <!-- Initialize AOS -->
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    </script>
</body>
</html>