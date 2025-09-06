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
                    <h1 class="h2 mb-1">Create New Note ✏️</h1>
                    <p class="text-muted mb-0">Add a new note to your knowledge base</p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i>Back to Notes
                    </a>
                </div>
            </div>

            <!-- Note Creation Form -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-edit me-2"></i>Note Details
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="createNoteForm" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- Course Selection -->
                                <div class="mb-3">
                                    <label class="form-label">Course *</label>
                                    <select name="course_id" class="form-select" required>
                                        <option value="">Select a course</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" 
                                                {{ $selectedCourse && $selectedCourse->id == $course->id ? 'selected' : '' }}>
                                                {{ $course->title }} 
                                                @if($course->course_code) ({{ $course->course_code }}) @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($courses->count() == 0)
                                        <div class="form-text text-warning">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            You need to create a course first. 
                                            <a href="{{ route('courses.create') }}">Create one here</a>.
                                        </div>
                                    @endif
                                </div>

                                <!-- Note Title -->
                                <div class="mb-3">
                                    <label class="form-label">Note Title *</label>
                                    <input type="text" name="title" class="form-control" 
                                           placeholder="e.g., Introduction to Data Structures" required>
                                </div>

                                <!-- Note Content -->
                                <div class="mb-3">
                                    <label class="form-label">Content *</label>
                                    <textarea name="content" id="noteContent" class="form-control" rows="12" 
                                              placeholder="Start writing your note here..." required></textarea>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        You can use markdown formatting or plain text
                                    </div>
                                </div>

                                <!-- Note Type & Week -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Note Type *</label>
                                            <select name="note_type" class="form-select" required>
                                                <option value="">Select type</option>
                                                <option value="lecture">📚 Lecture Notes</option>
                                                <option value="study_guide">📖 Study Guide</option>
                                                <option value="practice">✏️ Practice Problems</option>
                                                <option value="assignment">📝 Assignment</option>
                                                <option value="quiz">❓ Quiz Notes</option>
                                                <option value="project">🚀 Project Notes</option>
                                                <option value="other">📄 Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Week Number</label>
                                            <input type="number" name="week_number" class="form-control" 
                                                   placeholder="e.g., 5" min="1" max="52">
                                        </div>
                                    </div>
                                </div>

                                <!-- Lecture Date & Tags -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Lecture Date</label>
                                            <input type="date" name="lecture_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tags</label>
                                            <input type="text" name="tags" class="form-control" 
                                                   placeholder="e.g., arrays, sorting, algorithms">
                                            <div class="form-text">Separate tags with commas</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Media Files -->
                                <div class="mb-3">
                                    <label class="form-label">Attachments</label>
                                    <input type="file" name="media_files[]" class="form-control" multiple 
                                           accept="image/*,application/pdf,.doc,.docx,.mp3,.mp4,.mov">
                                    <div class="form-text">
                                        Upload images, PDFs, documents, audio, or video files (max 10MB each)
                                    </div>
                                </div>

                                <!-- Important Note -->
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_important" 
                                               id="importantCheck">
                                        <label class="form-check-label" for="importantCheck">
                                            <i class="fas fa-star text-warning me-1"></i>
                                            Mark this note as important
                                        </label>
                                    </div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Save Note
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="previewNote()">
                                        <i class="fas fa-eye me-1"></i>Preview
                                    </button>
                                    <a href="{{ route('notes.index') }}" class="btn btn-outline-danger">
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
                                <i class="fas fa-lightbulb me-2"></i>Quick Tips
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Use descriptive titles for easy searching
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Add tags to organize related notes
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Mark important notes with the star
                                </li>
                                <li class="mb-0">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Attach files for complete reference
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Recent Notes -->
                    @if($courses->count() > 0)
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-history me-2"></i>Recent Notes
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="text-muted text-center">
                                    Your recent notes will appear here for quick reference
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Note Preview
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="previewContent">
                <!-- Preview content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitForm()">
                    <i class="fas fa-save me-1"></i>Save Note
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

#noteContent {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
}

.form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission
    document.getElementById('createNoteForm').addEventListener('submit', function(e) {
        e.preventDefault();
        submitForm();
    });
});

function submitForm() {
    const form = document.getElementById('createNoteForm');
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Saving...';
    
    fetch('{{ route("api.notes.store") }}', {
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
            
            // Redirect to note view or notes index
            setTimeout(() => {
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    window.location.href = '{{ route("notes.index") }}';
                }
            }, 1000);
        } else {
            showAlert('danger', data.message || 'An error occurred');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'An error occurred while saving the note');
    })
    .finally(() => {
        // Restore button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        
        // Close preview modal if open
        const modal = bootstrap.Modal.getInstance(document.getElementById('previewModal'));
        if (modal) {
            modal.hide();
        }
    });
}

function previewNote() {
    const form = document.getElementById('createNoteForm');
    const formData = new FormData(form);
    
    // Get form values
    const title = formData.get('title') || 'Untitled Note';
    const content = formData.get('content') || 'No content yet...';
    const noteType = formData.get('note_type');
    const weekNumber = formData.get('week_number');
    const tags = formData.get('tags');
    const isImportant = formData.get('is_important');
    
    // Build preview HTML
    let previewHtml = `
        <div class="mb-3">
            <h3>${title} ${isImportant ? '<i class="fas fa-star text-warning"></i>' : ''}</h3>
            <div class="text-muted">
                ${noteType ? `<span class="badge bg-primary me-2">${noteType.charAt(0).toUpperCase() + noteType.slice(1)}</span>` : ''}
                ${weekNumber ? `<span class="badge bg-secondary me-2">Week ${weekNumber}</span>` : ''}
            </div>
        </div>
        <div class="mb-3">
            <div style="white-space: pre-wrap; line-height: 1.6;">${content}</div>
        </div>
    `;
    
    if (tags) {
        const tagList = tags.split(',').map(tag => `<span class="badge bg-secondary me-1">#${tag.trim()}</span>`).join('');
        previewHtml += `<div class="mb-3"><strong>Tags:</strong><br>${tagList}</div>`;
    }
    
    // Show preview modal
    document.getElementById('previewContent').innerHTML = previewHtml;
    const modal = new bootstrap.Modal(document.getElementById('previewModal'));
    modal.show();
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
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        const alert = mainContent.querySelector('.alert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
}
</script>
@endsection
