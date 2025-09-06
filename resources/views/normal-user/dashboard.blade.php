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
                        <a class="nav-link active" href="{{ route('normal-user.dashboard') }}">
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
                        <a class="nav-link" href="{{ route('notes.index') }}">
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
            <!-- Welcome Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                <div>
                    <h1 class="h2 mb-1">Welcome back, {{ $user->name }}! 👋</h1>
                    <p class="text-muted mb-0">Ready to organize your learning journey?</p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn btn-primary me-2">
                        <i class="fas fa-plus me-1"></i>
                        New Course
                    </button>
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-sticky-note me-1"></i>
                        Quick Note
                    </button>
                </div>
            </div>

            <!-- Quick Start Guide -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-rocket me-2"></i>
                                Quick Start Guide
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <p class="small mb-0">Create your first course</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                            <span class="fw-bold">2</span>
                                        </div>
                                        <p class="small mb-0">Add your first lecture notes</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                            <span class="fw-bold">3</span>
                                        </div>
                                        <p class="small mb-0">Try the drawing tools</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                            <span class="fw-bold">4</span>
                                        </div>
                                        <p class="small mb-0">Export your first study guide</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Dashboard Content -->
            <div class="row">
                <!-- My Courses -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-book me-2"></i>
                                My Courses ({{ $totalCourses }})
                            </h5>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createCourseModal">
                                <i class="fas fa-plus me-1"></i>
                                Create New Course
                            </button>
                        </div>
                        <div class="card-body">
                            @if($courses->count() > 0)
                                <div class="row">
                                    @foreach($courses as $course)
                                        <div class="col-md-6 mb-3">
                                            <div class="card course-mini-card" style="border-left: 4px solid {{ $course->color_theme }};">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h6 class="card-title mb-1">{{ $course->title }}</h6>
                                                            @if($course->course_code)
                                                                <small class="text-muted">{{ $course->course_code }}</small>
                                                            @endif
                                                        </div>
                                                        <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-arrow-right"></i>
                                                        </a>
                                                    </div>
                                                    <div class="row text-center mt-3">
                                                        <div class="col-4">
                                                            <small class="text-muted">{{ $course->notes_count ?? 0 }} Notes</small>
                                                        </div>
                                                        <div class="col-4">
                                                            <small class="text-muted">{{ $course->progress ?? 0 }}% Done</small>
                                                        </div>
                                                        <div class="col-4">
                                                            <small class="text-muted">Week {{ $course->total_weeks ?? 16 }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="progress mt-2" style="height: 4px;">
                                                        <div class="progress-bar" style="width: {{ $course->progress ?? 0 }}%; background-color: {{ $course->color_theme }};"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('courses.index') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-eye me-2"></i>View All Courses
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-book-open text-muted mb-3" style="font-size: 4rem; opacity: 0.3;"></i>
                                    <h4 class="text-muted">No courses yet</h4>
                                    <p class="text-muted mb-4">Start your learning journey by creating your first course</p>
                                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#createCourseModal">
                                        <i class="fas fa-plus me-2"></i>
                                        Create Your First Course
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-clock me-2"></i>
                                Recent Activity
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($recentNotes->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($recentNotes as $note)
                                        <div class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="d-flex align-items-center mb-1">
                                                    <h6 class="mb-0 me-2">{{ $note->title }}</h6>
                                                    @if($note->is_important)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @endif
                                                </div>
                                                <p class="mb-1 text-muted small">{{ $note->course->title }}</p>
                                                <small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div>
                                                <span class="badge bg-primary">{{ ucfirst($note->note_type) }}</span>
                                                <a href="{{ route('notes.show', $note) }}" class="btn btn-sm btn-outline-primary ms-2">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="text-center mt-3">
                                    <a href="{{ route('notes.index') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>View All Notes
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-history text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                    <p class="text-muted mb-0">No activity yet - start by creating a course!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Stats & Quick Actions -->
                <div class="col-lg-4">
                    <!-- Study Statistics -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-line me-2"></i>
                                Study Statistics
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h3 class="text-primary mb-0">{{ $totalCourses }}</h3>
                                        <small class="text-muted">Courses</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h3 class="text-success mb-0">{{ $totalNotes }}</h3>
                                    <small class="text-muted">Notes</small>
                                </div>
                            </div>
                            <hr>
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h3 class="text-warning mb-0">{{ $totalCourses * 2 }}</h3>
                                        <small class="text-muted">Study Hours</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h3 class="text-info mb-0">{{ $totalDocuments }}</h3>
                                    <small class="text-muted">Documents</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-bolt me-2"></i>
                                Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createCourseModal">
                                    <i class="fas fa-book me-2"></i>
                                    Create Course
                                </button>
                                <button class="btn btn-outline-success">
                                    <i class="fas fa-sticky-note me-2"></i>
                                    Quick Note
                                </button>
                                <button class="btn btn-outline-info">
                                    <i class="fas fa-upload me-2"></i>
                                    Upload Document
                                </button>
                                <button class="btn btn-outline-warning">
                                    <i class="fas fa-search me-2"></i>
                                    Search Notes
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tips & Tricks -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-lightbulb me-2"></i>
                                Pro Tips
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <small>
                                    <strong>💡 Tip:</strong> Use tags like #important, #exam, #review to organize your notes better!
                                </small>
                            </div>
                            <div class="alert alert-success">
                                <small>
                                    <strong>🎯 Study Hack:</strong> Export your notes as PDF study guides before exams for better retention.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Course Creation Modal -->
<div class="modal fade" id="createCourseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>
                    Create New Course
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createCourseForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Course Title *</label>
                                <input type="text" name="title" class="form-control" placeholder="e.g., Data Structures & Algorithms" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Course Code</label>
                                <input type="text" name="course_code" class="form-control" placeholder="e.g., CS-201">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Instructor</label>
                                <input type="text" name="instructor" class="form-control" placeholder="e.g., Prof. Martinez">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Semester</label>
                                <input type="text" name="semester" class="form-control" placeholder="e.g., Spring 2025">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Brief description of the course..."></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Color Theme</label>
                                <select name="color_theme" class="form-select">
                                    <option value="#3B82F6">🔵 Blue</option>
                                    <option value="#10B981">🟢 Green</option>
                                    <option value="#F59E0B">🟡 Yellow</option>
                                    <option value="#EF4444">🔴 Red</option>
                                    <option value="#8B5CF6">🟣 Purple</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Total Weeks</label>
                                <input type="number" name="total_weeks" class="form-control" value="16" min="1" max="52">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="createCourseForm" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>
                    Create Course
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.sidebar {
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.card {
    border: 1px solid rgba(0,0,0,0.125);
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
}

.nav-link:hover {
    background-color: rgba(13, 110, 253, 0.1);
}

.nav-link.active {
    background-color: #0d6efd;
    color: white !important;
}

.btn {
    border-radius: 0.375rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Course creation modal handling
    const createCourseModal = new bootstrap.Modal(document.getElementById('createCourseModal'));
    
    // Modal will show automatically with data-bs-toggle="modal" data-bs-target="#createCourseModal"
    
    // Handle form submission
    document.getElementById('createCourseForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = document.querySelector('button[form="createCourseForm"]');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Creating...';
        
        fetch('{{ route("api.courses.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showAlert('success', data.message);
                
                // Reset form and close modal
                this.reset();
                createCourseModal.hide();
                
                // Redirect to course page or reload
                if (data.redirect) {
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1000);
                } else {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            } else {
                showAlert('danger', data.message || 'An error occurred');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'An error occurred while creating the course');
        })
        .finally(() => {
            // Restore button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
    
    // Utility function to show alerts
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Insert alert at top of main content
        const mainContent = document.querySelector('main .container-fluid');
        mainContent.insertAdjacentHTML('afterbegin', alertHtml);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            const alert = mainContent.querySelector('.alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    }
});

// Add CSRF token to all AJAX requests
fetch.defaults = {
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
};
</script>
@endsection
