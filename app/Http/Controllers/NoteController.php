<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NoteController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $user = Auth::user();
        $notes = $user->notes()
            ->with('course')
            ->when(request('course_id'), function ($query, $courseId) {
                return $query->where('course_id', $courseId);
            })
            ->when(request('week'), function ($query, $week) {
                return $query->where('week_number', $week);
            })
            ->when(request('type'), function ($query, $type) {
                return $query->where('note_type', $type);
            })
            ->when(request('important'), function ($query) {
                return $query->where('is_important', true);
            })
            ->when(request('search'), function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%")
                      ->orWhereJsonContains('tags', $search);
                });
            })
            ->latest()
            ->paginate(15);

        $courses = $user->courses()->get();
        
        return view('notes.index', compact('notes', 'courses'));
    }

    public function create()
    {
        $courses = Auth::user()->courses()->get();
        $courseId = request('course_id');
        $selectedCourse = $courseId ? Course::find($courseId) : null;
        
        return view('notes.create', compact('courses', 'selectedCourse'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'note_type' => 'required|in:lecture,study_guide,practice,assignment,quiz,project,other',
            'week_number' => 'nullable|integer|min:1|max:52',
            'lecture_date' => 'nullable|date',
            'tags' => 'nullable|string',
            'is_important' => 'boolean',
            'media_files.*' => 'file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,mp3,mp4,mov|max:10240',
        ]);

        // Verify course belongs to user
        $course = Auth::user()->courses()->findOrFail($request->course_id);

        // Process tags
        $tags = $request->tags ? 
            array_map('trim', explode(',', $request->tags)) : 
            [];

        // Handle media file uploads
        $mediaFiles = [];
        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                $path = $file->store('notes/media/' . $course->id, 'public');
                $mediaFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'type' => $file->getMimeType(),
                    'size' => $file->getSize()
                ];
            }
        }

        $note = $course->notes()->create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'note_type' => $request->note_type,
            'week_number' => $request->week_number,
            'lecture_date' => $request->lecture_date,
            'tags' => $tags,
            'media_files' => $mediaFiles,
            'is_important' => $request->boolean('is_important'),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Note created successfully!',
                'note' => $note->load('course'),
                'redirect' => route('notes.show', $note)
            ]);
        }

        return redirect()->route('notes.show', $note)
            ->with('success', 'Note created successfully!');
    }

    public function show(Note $note)
    {
        // Check if user owns this note or it's shared
        if ($note->user_id !== Auth::id() && !$note->is_shared) {
            abort(403, 'Unauthorized access to this note.');
        }
        
        // Increment view count
        $note->increment('view_count');
        $note->update(['last_viewed_at' => now()]);
        
        $note->load('course');
        
        // Get related notes from same course/week
        $relatedNotes = Note::where('course_id', $note->course_id)
            ->where('id', '!=', $note->id)
            ->when($note->week_number, function ($query, $week) {
                return $query->where('week_number', $week);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('notes.show', compact('note', 'relatedNotes'));
    }

    public function edit(Note $note)
    {
        // Check if user owns this note
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this note.');
        }
        
        $courses = Auth::user()->courses()->get();
        $note->load('course');
        
        return view('notes.edit', compact('note', 'courses'));
    }

    public function update(Request $request, Note $note)
    {
        // Check if user owns this note
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this note.');
        }
        
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'note_type' => 'required|in:lecture,study_guide,practice,assignment,quiz,project,other',
            'week_number' => 'nullable|integer|min:1|max:52',
            'lecture_date' => 'nullable|date',
            'tags' => 'nullable|string',
            'is_important' => 'boolean',
        ]);

        // Verify course belongs to user
        $course = Auth::user()->courses()->findOrFail($request->course_id);

        // Process tags
        $tags = $request->tags ? 
            array_map('trim', explode(',', $request->tags)) : 
            [];

        $note->update([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'content' => $request->content,
            'note_type' => $request->note_type,
            'week_number' => $request->week_number,
            'lecture_date' => $request->lecture_date,
            'tags' => $tags,
            'is_important' => $request->boolean('is_important'),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Note updated successfully!',
                'note' => $note->load('course')
            ]);
        }

        return redirect()->route('notes.show', $note)
            ->with('success', 'Note updated successfully!');
    }

    public function destroy(Note $note)
    {
        // Check if user owns this note
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this note.');
        }
        
        // Delete associated media files
        if ($note->media_files) {
            foreach ($note->media_files as $file) {
                Storage::disk('public')->delete($file['path']);
            }
        }
        
        $note->delete();
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Note deleted successfully!'
            ]);
        }

        return redirect()->route('notes.index')
            ->with('success', 'Note deleted successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $courseId = $request->get('course_id');
        
        $notes = Auth::user()->notes()
            ->with('course')
            ->when($query, function ($q) use ($query) {
                return $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('title', 'like', "%{$query}%")
                             ->orWhere('content', 'like', "%{$query}%")
                             ->orWhereJsonContains('tags', $query);
                });
            })
            ->when($courseId, function ($q) use ($courseId) {
                return $q->where('course_id', $courseId);
            })
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'notes' => $notes->map(function ($note) {
                return [
                    'id' => $note->id,
                    'title' => $note->title,
                    'excerpt' => $note->excerpt,
                    'course' => $note->course->title,
                    'week' => $note->week_number,
                    'type' => $note->note_type,
                    'important' => $note->is_important,
                    'url' => route('notes.show', $note)
                ];
            })
        ]);
    }

    public function export(Note $note, $format = 'pdf')
    {
        // Check if user owns this note or it's shared
        if ($note->user_id !== Auth::id() && !$note->is_shared) {
            abort(403, 'Unauthorized access to this note.');
        }
        
        // This would integrate with a PDF/export service
        // For now, return a simple response
        
        return response()->json([
            'success' => true,
            'message' => "Note exported as {$format}",
            'download_url' => route('notes.download', ['note' => $note, 'format' => $format])
        ]);
    }
}