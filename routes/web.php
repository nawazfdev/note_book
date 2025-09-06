<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Redirect authenticated users to their respective dashboards
Route::get('/dashboard', function () {
    if (Auth::user()->isSuperAdmin()) {
        return redirect()->route('super-admin.dashboard');
    }
    return redirect()->route('normal-user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Super Admin Routes
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [App\Http\Controllers\SuperAdminController::class, 'users'])->name('users');
    Route::get('/settings', [App\Http\Controllers\SuperAdminController::class, 'settings'])->name('settings');
});

// Normal User Routes
Route::middleware(['auth', 'role:normal_user'])->prefix('user')->name('normal-user.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\NormalUserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [App\Http\Controllers\NormalUserController::class, 'profile'])->name('profile');
});

// Course Management Routes
Route::middleware(['auth', 'role:normal_user'])->group(function () {
    Route::resource('courses', App\Http\Controllers\CourseController::class);
    Route::get('courses/{course}/notes', [App\Http\Controllers\CourseController::class, 'notes'])->name('courses.notes');
    Route::get('courses/{course}/analytics', [App\Http\Controllers\CourseController::class, 'analytics'])->name('courses.analytics');
});

// Note Management Routes
Route::middleware(['auth', 'role:normal_user'])->group(function () {
    Route::resource('notes', App\Http\Controllers\NoteController::class);
    Route::get('notes/search', [App\Http\Controllers\NoteController::class, 'search'])->name('notes.search');
    Route::post('notes/{note}/export/{format?}', [App\Http\Controllers\NoteController::class, 'export'])->name('notes.export');
});

// Document Management Routes
Route::middleware(['auth', 'role:normal_user'])->group(function () {
    Route::resource('documents', App\Http\Controllers\DocumentController::class);
    Route::get('documents/folder/{folder}', [App\Http\Controllers\DocumentController::class, 'folder'])->name('documents.folder');
    Route::post('documents/upload', [App\Http\Controllers\DocumentController::class, 'upload'])->name('documents.upload');
});

// API Routes for AJAX requests
Route::middleware(['auth', 'role:normal_user'])->prefix('api')->name('api.')->group(function () {
    Route::post('courses', [App\Http\Controllers\CourseController::class, 'store'])->name('courses.store');
    Route::put('courses/{course}', [App\Http\Controllers\CourseController::class, 'update'])->name('courses.update');
    Route::delete('courses/{course}', [App\Http\Controllers\CourseController::class, 'destroy'])->name('courses.destroy');
    
    Route::post('notes', [App\Http\Controllers\NoteController::class, 'store'])->name('notes.store');
    Route::put('notes/{note}', [App\Http\Controllers\NoteController::class, 'update'])->name('notes.update');
    Route::delete('notes/{note}', [App\Http\Controllers\NoteController::class, 'destroy'])->name('notes.destroy');
    Route::get('notes/search', [App\Http\Controllers\NoteController::class, 'search'])->name('notes.search');
});

// Manager Routes (for future use)
Route::middleware(['auth', 'role:manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', function () {
        return view('manager.dashboard');
    })->name('dashboard');
});

// Editor Routes (for future use)
Route::middleware(['auth', 'role:editor'])->prefix('editor')->name('editor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('editor.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';


