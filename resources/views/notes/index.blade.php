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
            <!-- Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                <div>
                    <h1 class="h2 mb-1">My Notes 📝</h1>
                    <p class="text-muted mb-0">All your study notes in one place</p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('notes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        New Note
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('notes.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Search notes..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Course</label>
                            <select name="course_id" class="form-select">
                                <option value="">All Courses</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Week</label>
                            <input type="number" name="week" class="form-control" placeholder="Week #" value="{{ request('week') }}" min="1" max="52">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select">
                                <option value="">All Types</option>
                                <option value="lecture" {{ request('type') == 'lecture' ? 'selected' : '' }}>Lecture</option>
                                <option value="study_guide" {{ request('type') == 'study_guide' ? 'selected' : '' }}>Study Guide</option>
                                <option value="practice" {{ request('type') == 'practice' ? 'selected' : '' }}>Practice</option>
                                <option value="assignment" {{ request('type') == 'assignment' ? 'selected' : '' }}>Assignment</option>
                                <option value="quiz" {{ request('type') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                                <option value="project" {{ request('type') == 'project' ? 'selected' : '' }}>Project</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                    
                    <div class="mt-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="important" id="importantFilter" {{ request('important') ? 'checked' : '' }}>
                            <label class="form-check-label" for="importantFilter">
                                <i class="fas fa-star text-warning me-1"></i>Important only
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Grid -->
            @if($notes->count() > 0)
                <div class="row">
                    @foreach($notes as $note)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card note-card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-1">
                                                {{ $note->title }}
                                                @if($note->is_important)
                                                    <i class="fas fa-star text-warning ms-1"></i>
                                                @endif
                                            </h5>
                                            <p class="text-muted small mb-0">
                                                <i class="fas fa-book me-1"></i>{{ $note->course->title }}
                                                @if($note->week_number)
                                                    • Week {{ $note->week_number }}
                                                @endif
                                            </p>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('notes.show', $note) }}">
                                                    <i class="fas fa-eye me-2"></i>View Note
                                                </a></li>
                                                <li><a class="dropdown-item" href="{{ route('notes.edit', $note) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit Note
                                                </a></li>
                                                <li><a class="dropdown-item" href="{{ route('notes.export', $note) }}">
                                                    <i class="fas fa-download me-2"></i>Export PDF
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteNote({{ $note->id }})">
                                                    <i class="fas fa-trash me-2"></i>Delete Note
                                                </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <p class="card-text">{{ $note->excerpt }}</p>
                                    
                                    <!-- Tags -->
                                    @if($note->tags && count($note->tags) > 0)
                                        <div class="mb-3">
                                            @foreach($note->tags as $tag)
                                                <span class="badge bg-secondary me-1">#{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <!-- Note Stats -->
                                    <div class="d-flex justify-content-between align-items-center text-muted small">
                                        <div>
                                            <span class="badge bg-primary">{{ ucfirst($note->note_type) }}</span>
                                            @if($note->media_files && count($note->media_files) > 0)
                                                <i class="fas fa-paperclip ms-2" title="{{ count($note->media_files) }} attachments"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <i class="fas fa-eye me-1"></i>{{ $note->view_count }}
                                            <span class="ms-2">{{ $note->created_at->format('M j') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('notes.show', $note) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                        <a href="{{ route('notes.edit', $note) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $notes->appends(request()->query())->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <i class="fas fa-sticky-note text-muted mb-4" style="font-size: 5rem; opacity: 0.3;"></i>
                    <h3 class="text-muted mb-3">
                        @if(request()->hasAny(['search', 'course_id', 'week', 'type', 'important']))
                            No notes found
                        @else
                            No notes yet
                        @endif
                    </h3>
                    <p class="text-muted mb-4">
                        @if(request()->hasAny(['search', 'course_id', 'week', 'type', 'important']))
                            Try adjusting your search filters or create a new note
                        @else
                            Start taking notes to build your knowledge base
                        @endif
                    </p>
                    <a href="{{ route('notes.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Create Your First Note
                    </a>
                </div>
            @endif
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

.note-card {
    transition: transform 0.2s ease;
}

.note-card:hover {
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
    // Important filter checkbox
    document.getElementById('importantFilter').addEventListener('change', function() {
        const form = this.closest('form');
        const formData = new FormData(form);
        
        if (this.checked) {
            formData.set('important', '1');
        } else {
            formData.delete('important');
        }
        
        const params = new URLSearchParams(formData);
        window.location.href = form.action + '?' + params.toString();
    });
});

function deleteNote(noteId) {
    if (confirm('Are you sure you want to delete this note? This action cannot be undone.')) {
        fetch(`/api/notes/${noteId}`, {
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
            alert('An error occurred while deleting the note');
        });
    }
}
</script>
@endsection
