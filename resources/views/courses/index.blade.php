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
                    <h1 class="h2 mb-1">My Courses 📚</h1>
                    <p class="text-muted mb-0">Manage and organize your learning journey</p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCourseModal">
                        <i class="fas fa-plus me-1"></i>
                        New Course
                    </button>
                </div>
            </div>

            <!-- Course Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-primary mb-1">{{ $courses->total() }}</h3>
                            <small class="text-muted">Total Courses</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-success mb-1">{{ $courses->where('is_active', true)->count() }}</h3>
                            <small class="text-muted">Active Courses</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-info mb-1">{{ $courses->sum('notes_count') }}</h3>
                            <small class="text-muted">Total Notes</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-warning mb-1">{{ $courses->sum('documents_count') }}</h3>
                            <small class="text-muted">Documents</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courses Grid -->
            @if($courses->count() > 0)
                <div class="row">
                    @foreach($courses as $course)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card course-card h-100" style="border-left: 4px solid {{ $course->color_theme }};">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="card-title mb-0">{{ $course->title }}</h5>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('courses.show', $course) }}">
                                                    <i class="fas fa-eye me-2"></i>View Course
                                                </a></li>
                                                <li><a class="dropdown-item" href="{{ route('courses.notes', $course) }}">
                                                    <i class="fas fa-sticky-note me-2"></i>View Notes
                                                </a></li>
                                                <li><a class="dropdown-item" href="{{ route('courses.edit', $course) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit Course
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteCourse({{ $course->id }})">
                                                    <i class="fas fa-trash me-2"></i>Delete Course
                                                </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    @if($course->course_code)
                                        <p class="text-muted mb-2">
                                            <i class="fas fa-code me-1"></i>{{ $course->course_code }}
                                        </p>
                                    @endif
                                    
                                    @if($course->instructor)
                                        <p class="text-muted mb-2">
                                            <i class="fas fa-user-tie me-1"></i>{{ $course->instructor }}
                                        </p>
                                    @endif
                                    
                                    @if($course->semester)
                                        <p class="text-muted mb-3">
                                            <i class="fas fa-calendar me-1"></i>{{ $course->semester }}
                                        </p>
                                    @endif
                                    
                                    @if($course->description)
                                        <p class="card-text small">{{ Str::limit($course->description, 100) }}</p>
                                    @endif
                                    
                                    <!-- Course Stats -->
                                    <div class="row text-center mt-3">
                                        <div class="col-4">
                                            <div class="border-end">
                                                <h6 class="mb-0">{{ $course->notes_count }}</h6>
                                                <small class="text-muted">Notes</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="border-end">
                                                <h6 class="mb-0">{{ $course->progress }}%</h6>
                                                <small class="text-muted">Progress</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <h6 class="mb-0">{{ $course->total_weeks }}</h6>
                                            <small class="text-muted">Weeks</small>
                                        </div>
                                    </div>
                                    
                                    <!-- Progress Bar -->
                                    <div class="progress mt-3" style="height: 6px;">
                                        <div class="progress-bar" style="width: {{ $course->progress }}%; background-color: {{ $course->color_theme }}"></div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                        <a href="{{ route('notes.create', ['course_id' => $course->id]) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus me-1"></i>Add Note
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $courses->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <i class="fas fa-book-open text-muted mb-4" style="font-size: 5rem; opacity: 0.3;"></i>
                    <h3 class="text-muted mb-3">No courses yet</h3>
                    <p class="text-muted mb-4">Start your learning journey by creating your first course</p>
                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#createCourseModal">
                        <i class="fas fa-plus me-2"></i>Create Your First Course
                    </button>
                </div>
            @endif
        </main>
    </div>
</div>

<!-- Course Creation Modal -->
<div class="modal fade" id="createCourseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Create New Course
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
                    <i class="fas fa-save me-1"></i>Create Course
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
    transition: transform 0.2s ease;
}

.course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
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
    // Course creation form handling
    document.getElementById('createCourseForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = document.querySelector('button[form="createCourseForm"]');
        const originalText = submitBtn.innerHTML;
        
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
                window.location.reload();
            } else {
                alert(data.message || 'An error occurred');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while creating the course');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
});

function deleteCourse(courseId) {
    if (confirm('Are you sure you want to delete this course? This action cannot be undone.')) {
        fetch(`/api/courses/${courseId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'An error occurred');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the course');
        });
    }
}
</script>
@endsection
