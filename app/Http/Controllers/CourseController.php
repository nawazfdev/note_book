<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CourseController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $user = Auth::user();
        $courses = $user->courses()
            ->withCount(['notes', 'documents'])
            ->latest()
            ->paginate(12);
            
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_code' => 'nullable|string|max:50',
            'instructor' => 'nullable|string|max:255',
            'semester' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'color_theme' => 'nullable|string|max:7',
            'total_weeks' => 'integer|min:1|max:52',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $course = Auth::user()->courses()->create([
            'title' => $request->title,
            'course_code' => $request->course_code,
            'instructor' => $request->instructor,
            'semester' => $request->semester,
            'description' => $request->description,
            'color_theme' => $request->color_theme ?? '#3B82F6',
            'total_weeks' => $request->total_weeks ?? 16,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course created successfully!',
            'course' => $course,
            'redirect' => route('courses.show', $course)
        ]);
    }

    public function show(Course $course)
    {
        // Check if user owns this course
        if ($course->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $course->load(['notes' => function ($query) {
            $query->latest();
        }]);
        
        $weeklyNotes = $course->notes()
            ->selectRaw('week_number, COUNT(*) as count')
            ->groupBy('week_number')
            ->orderBy('week_number')
            ->get()
            ->keyBy('week_number');
            
        $importantNotes = $course->notes()->important()->latest()->take(5)->get();
        $recentNotes = $course->notes()->latest()->take(10)->get();
        
        return view('courses.show', compact(
            'course', 'weeklyNotes', 'importantNotes', 'recentNotes'
        ));
    }

    public function edit(Course $course)
    {
        // Check if user owns this course
        if ($course->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        // Check if user owns this course
        if ($course->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'course_code' => 'nullable|string|max:50',
            'instructor' => 'nullable|string|max:255',
            'semester' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'color_theme' => 'nullable|string|max:7',
            'total_weeks' => 'integer|min:1|max:52',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $course->update($request->only([
            'title', 'course_code', 'instructor', 'semester', 
            'description', 'color_theme', 'total_weeks', 
            'start_date', 'end_date'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully!',
            'course' => $course
        ]);
    }

    public function destroy(Course $course)
    {
        // Check if user owns this course
        if ($course->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $course->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully!'
        ]);
    }

    public function notes(Course $course)
    {
        // Check if user owns this course
        if ($course->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $notes = $course->notes()
            ->when(request('week'), function ($query, $week) {
                return $query->where('week_number', $week);
            })
            ->when(request('type'), function ($query, $type) {
                return $query->where('note_type', $type);
            })
            ->when(request('important'), function ($query) {
                return $query->where('is_important', true);
            })
            ->latest()
            ->paginate(12);
            
        return view('courses.notes', compact('course', 'notes'));
    }

    public function analytics(Course $course)
    {
        // Check if user owns this course
        if ($course->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }
        
        $analytics = [
            'total_notes' => $course->notes()->count(),
            'important_notes' => $course->notes()->important()->count(),
            'weeks_covered' => $course->notes()->distinct('week_number')->count(),
            'progress_percentage' => $course->progress,
            'note_types' => $course->notes()
                ->selectRaw('note_type, COUNT(*) as count')
                ->groupBy('note_type')
                ->get()
                ->keyBy('note_type'),
            'weekly_activity' => $course->notes()
                ->selectRaw('week_number, COUNT(*) as count')
                ->groupBy('week_number')
                ->orderBy('week_number')
                ->get(),
            'recent_activity' => $course->notes()
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->take(30)
                ->get()
        ];
        
        return view('courses.analytics', compact('course', 'analytics'));
    }
}