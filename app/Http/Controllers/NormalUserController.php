<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NormalUserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $courses = $user->courses()->with('notes')->latest()->take(6)->get();
        $totalCourses = $user->courses()->count();
        $totalNotes = $user->notes()->count();
        $totalDocuments = $user->documents()->count();
        $recentNotes = $user->notes()->with('course')->latest()->take(5)->get();
        
        return view('normal-user.dashboard', compact(
            'user', 'courses', 'totalCourses', 'totalNotes', 
            'totalDocuments', 'recentNotes'
        ));
    }
    
    public function profile()
    {
        $user = Auth::user();
        return view('normal-user.profile', compact('user'));
    }
}
