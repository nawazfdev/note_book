<footer class="footer">
    <div class="footer-main">
        <div class="container">
            <div class="row">
                <!-- Company Info -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-section">
                        <a href="{{ route('home') }}" class="footer-logo">
                            <img src="{{ asset('assets/images/logo-white.svg') }}" alt="LectureNotes Pro">
                            <span>LectureNotes<span class="pro">Pro</span></span>
                        </a>
                        <p class="footer-description">
                            Transform your learning experience with our intelligent note-taking platform. 
                            Create, organize, and share rich content seamlessly.
                        </p>
                        <div class="social-links">
                            <a href="#" class="social-link" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-section">
                        <h5 class="footer-title">Product</h5>
                        <ul class="footer-links">
                            <li><a href="{{ route('features') }}">Features</a></li>
                            <li><a href="{{ route('pricing') }}">Pricing</a></li>
                            <li><a href="{{ route('demo') }}">Live Demo</a></li>
                            <li><a href="{{ route('integrations') }}">Integrations</a></li>
                            <li><a href="{{ route('api') }}">API</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Resources -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-section">
                        <h5 class="footer-title">Resources</h5>
                        <ul class="footer-links">
                            <li><a href="{{ route('blog') }}">Blog</a></li>
                            <li><a href="{{ route('help') }}">Help Center</a></li>
                            <li><a href="{{ route('tutorials') }}">Tutorials</a></li>
                            <li><a href="{{ route('templates') }}">Templates</a></li>
                            <li><a href="{{ route('community') }}">Community</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Company -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-section">
                        <h5 class="footer-title">Company</h5>
                        <ul class="footer-links">
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('careers') }}">Careers</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                            <li><a href="{{ route('press') }}">Press Kit</a></li>
                            <li><a href="{{ route('partners') }}">Partners</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Newsletter -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-section">
                        <h5 class="footer-title">Stay Updated</h5>
                        <p class="newsletter-text">Get the latest updates and tips delivered to your inbox.</p>
                        <form class="newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="email" name="email" class="form-control" placeholder="Your email" required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="copyright">
                        &copy; {{ date('Y') }} LectureNotes Pro. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6">
                    <ul class="footer-legal">
                        <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}">Terms of Service</a></li>
                        <li><a href="{{ route('cookies') }}">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>