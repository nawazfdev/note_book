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
            <!-- Course Header -->
            <div class="course-header py-4 mb-4" style="background: linear-gradient(135deg, {{ $course->color_theme }}22 0%, {{ $course->color_theme }}11 100%); border-left: 4px solid {{ $course->color_theme }};">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center mb-2">
                            <h1 class="h2 mb-0 me-3">{{ $course->title }}</h1>
                            @if($course->course_code)
                                <span class="badge bg-primary">{{ $course->course_code }}</span>
                            @endif
                        </div>
                        
                        @if($course->instructor || $course->semester)
                            <div class="text-muted mb-2">
                                @if($course->instructor)
                                    <i class="fas fa-user-tie me-1"></i>{{ $course->instructor }}
                                @endif
                                @if($course->instructor && $course->semester) • @endif
                                @if($course->semester)
                                    <i class="fas fa-calendar me-1"></i>{{ $course->semester }}
                                @endif
                            </div>
                        @endif
                        
                        @if($course->description)
                            <p class="mb-0">{{ $course->description }}</p>
                        @endif
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-cog me-1"></i>Course Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('notes.create', ['course_id' => $course->id]) }}">
                                    <i class="fas fa-plus me-2"></i>Add New Note
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('courses.analytics', $course) }}">
                                    <i class="fas fa-chart-bar me-2"></i>View Analytics
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
                </div>
            </div>

            <!-- Course Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-primary mb-1">{{ $course->total_notes }}</h3>
                            <small class="text-muted">Total Notes</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-success mb-1">{{ $course->important_notes }}</h3>
                            <small class="text-muted">Important Notes</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-info mb-1">{{ $weeklyNotes->count() }}</h3>
                            <small class="text-muted">Weeks Covered</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-warning mb-1">{{ $course->progress }}%</h3>
                            <small class="text-muted">Progress</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Weekly Progress -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-calendar-week me-2"></i>
                                Weekly Progress
                            </h5>
                            <a href="{{ route('notes.create', ['course_id' => $course->id]) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i>Add Note
                            </a>
                        </div>
                        <div class="card-body">
                            @if($weeklyNotes->count() > 0)
                                <div class="row">
                                    @for($week = 1; $week <= $course->total_weeks; $week++)
                                        <div class="col-md-3 col-sm-4 col-6 mb-3">
                                            <div class="week-item text-center p-3 rounded {{ $weeklyNotes->has($week) ? 'bg-primary text-white' : 'bg-light' }}">
                                                <div class="fw-bold">Week {{ $week }}</div>
                                                <small>
                                                    {{ $weeklyNotes->has($week) ? $weeklyNotes[$week]->count . ' notes' : 'No notes' }}
                                                </small>
                                            </div>
                                        </div>
                                        @if($week % 4 == 0 && $week < $course->total_weeks)
                                            <div class="w-100"></div>
                                        @endif
                                    @endfor
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-calendar-plus text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                    <p class="text-muted mb-3">No notes added yet</p>
                                    <a href="{{ route('notes.create', ['course_id' => $course->id]) }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add Your First Note
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Notes -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-sticky-note me-2"></i>
                                Recent Notes
                            </h5>
                            <a href="{{ route('courses.notes', $course) }}" class="btn btn-sm btn-outline-primary">
                                View All Notes
                            </a>
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
                                                <p class="mb-1 text-muted small">{{ $note->excerpt }}</p>
                                                <small class="text-muted">
                                                    @if($note->week_number)
                                                        Week {{ $note->week_number }} •
                                                    @endif
                                                    {{ $note->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            <div>
                                                <span class="badge bg-secondary">{{ ucfirst($note->note_type) }}</span>
                                                <a href="{{ route('notes.show', $note) }}" class="btn btn-sm btn-outline-primary ms-2">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-sticky-note text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                    <p class="text-muted mb-3">No notes in this course yet</p>
                                    <a href="{{ route('notes.create', ['course_id' => $course->id]) }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Create Your First Note
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar Info -->
                <div class="col-lg-4">
                    <!-- Important Notes -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-star me-2"></i>
                                Important Notes
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($importantNotes->count() > 0)
                                @foreach($importantNotes as $note)
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $note->title }}</h6>
                                            <small class="text-muted">
                                                @if($note->week_number)Week {{ $note->week_number }} • @endif
                                                {{ $note->created_at->format('M j') }}
                                            </small>
                                        </div>
                                        <a href="{{ route('notes.show', $note) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted text-center mb-0">No important notes marked yet</p>
                            @endif
                        </div>
                    </div>

                    <!-- Course Info -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Course Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Total Weeks:</strong>
                                <span class="float-end">{{ $course->total_weeks }}</span>
                            </div>
                            <div class="mb-3">
                                <strong>Created:</strong>
                                <span class="float-end">{{ $course->created_at->format('M j, Y') }}</span>
                            </div>
                            <div class="mb-3">
                                <strong>Last Updated:</strong>
                                <span class="float-end">{{ $course->updated_at->format('M j, Y') }}</span>
                            </div>
                            <div class="mb-0">
                                <strong>Status:</strong>
                                <span class="float-end">
                                    <span class="badge bg-{{ $course->is_active ? 'success' : 'secondary' }}">
                                        {{ $course->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </span>
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

.course-header {
    border-radius: 0.5rem;
}

.week-item {
    transition: all 0.2s ease;
    cursor: pointer;
}

.week-item:hover {
    transform: translateY(-2px);
}

.list-group-item {
    border-left: none;
    border-right: none;
}

.list-group-item:first-child {
    border-top: none;
}

.list-group-item:last-child {
    border-bottom: none;
}
</style>

<script>
function deleteCourse(courseId) {
    if (confirm('Are you sure you want to delete this course? This will also delete all associated notes and documents.')) {
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
                window.location.href = '{{ route("courses.index") }}';
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
