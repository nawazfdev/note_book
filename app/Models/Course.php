<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'course_code',
        'instructor',
        'semester',
        'description',
        'color_theme',
        'course_structure',
        'total_weeks',
        'is_active',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'course_structure' => 'array',
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function getProgressAttribute(): int
    {
        $totalWeeks = $this->total_weeks;
        $completedWeeks = $this->notes()->distinct('week_number')->count();
        
        return $totalWeeks > 0 ? round(($completedWeeks / $totalWeeks) * 100) : 0;
    }

    public function getTotalNotesAttribute(): int
    {
        return $this->notes()->count();
    }

    public function getImportantNotesAttribute(): int
    {
        return $this->notes()->where('is_important', true)->count();
    }
}
