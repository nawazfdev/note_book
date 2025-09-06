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
                        <a class="nav-link active" href="{{ route('courses.index') }}">
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
            <!-- Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                <div>
                    <h1 class="h2 mb-1">Create New Course 📚</h1>
                    <p class="text-muted mb-0">Set up a new course for your studies</p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Courses
                    </a>
                </div>
            </div>

            <!-- Course Creation Form -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-book me-2"></i>Course Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="createCourseForm">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label class="form-label">Course Title *</label>
                                            <input type="text" name="title" class="form-control" 
                                                   placeholder="e.g., Data Structures & Algorithms" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Course Code</label>
                                            <input type="text" name="course_code" class="form-control" 
                                                   placeholder="e.g., CS-201">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Instructor</label>
                                            <input type="text" name="instructor" class="form-control" 
                                                   placeholder="e.g., Prof. Martinez">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Semester</label>
                                            <input type="text" name="semester" class="form-control" 
                                                   placeholder="e.g., Spring 2025">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="4" 
                                              placeholder="Brief description of the course content and objectives..."></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Color Theme</label>
                                            <select name="color_theme" class="form-select">
                                                <option value="#3B82F6">🔵 Blue (Default)</option>
                                                <option value="#10B981">🟢 Green</option>
                                                <option value="#F59E0B">🟡 Yellow</option>
                                                <option value="#EF4444">🔴 Red</option>
                                                <option value="#8B5CF6">🟣 Purple</option>
                                                <option value="#06B6D4">🔷 Cyan</option>
                                                <option value="#EC4899">🌸 Pink</option>
                                                <option value="#84CC16">🌱 Lime</option>
                                            </select>
                                            <div class="form-text">Choose a color to help identify this course</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Total Weeks</label>
                                            <input type="number" name="total_weeks" class="form-control" 
                                                   value="16" min="1" max="52">
                                            <div class="form-text">How many weeks will this course run?</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Start Date</label>
                                            <input type="date" name="start_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">End Date</label>
                                            <input type="date" name="end_date" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Create Course
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="previewCourse()">
                                        <i class="fas fa-eye me-1"></i>Preview
                                    </button>
                                    <a href="{{ route('courses.index') }}" class="btn btn-outline-danger">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Quick Tips -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-lightbulb me-2"></i>Course Setup Tips
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Use clear, descriptive course titles
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Include course codes for easy reference
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Choose colors to organize by subject
                                </li>
                                <li class="mb-0">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Set realistic week counts
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Example Courses -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-star me-2"></i>Example Courses
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Computer Science:</strong>
                                <small class="d-block text-muted">CS-101: Intro to Programming</small>
                            </div>
                            <div class="mb-3">
                                <strong>Mathematics:</strong>
                                <small class="d-block text-muted">MATH-201: Calculus II</small>
                            </div>
                            <div class="mb-0">
                                <strong>Physics:</strong>
                                <small class="d-block text-muted">PHYS-101: General Physics</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
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

.form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission
    document.getElementById('createCourseForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
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
                
                // Redirect to course view or courses index
                setTimeout(() => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        window.location.href = '{{ route("courses.index") }}';
                    }
                }, 1000);
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
});

function previewCourse() {
    const form = document.getElementById('createCourseForm');
    const formData = new FormData(form);
    
    // Get form values
    const title = formData.get('title') || 'Untitled Course';
    const courseCode = formData.get('course_code');
    const instructor = formData.get('instructor');
    const semester = formData.get('semester');
    const description = formData.get('description');
    const colorTheme = formData.get('color_theme');
    const totalWeeks = formData.get('total_weeks');
    
    // Build preview
    let previewHtml = `
        <div class="alert alert-info">
            <h4>${title} ${courseCode ? `(${courseCode})` : ''}</h4>
            ${instructor ? `<p><strong>Instructor:</strong> ${instructor}</p>` : ''}
            ${semester ? `<p><strong>Semester:</strong> ${semester}</p>` : ''}
            ${description ? `<p><strong>Description:</strong> ${description}</p>` : ''}
            <p><strong>Duration:</strong> ${totalWeeks} weeks</p>
            <p><strong>Color Theme:</strong> <span style="background-color: ${colorTheme}; padding: 2px 8px; border-radius: 3px; color: white;">${colorTheme}</span></p>
        </div>
    `;
    
    // Show preview in alert
    showAlert('info', previewHtml);
}

function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    const mainContent = document.querySelector('main .container-fluid');
    mainContent.insertAdjacentHTML('afterbegin', alertHtml);
    
    // Auto-dismiss after 8 seconds for preview
    setTimeout(() => {
        const alert = mainContent.querySelector('.alert');
        if (alert && type === 'info') {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 8000);
}
</script>
@endsection
