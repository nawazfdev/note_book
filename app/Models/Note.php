<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'title',
        'content',
        'note_type',
        'week_number',
        'lecture_date',
        'tags',
        'media_files',
        'drawings',
        'is_important',
        'is_shared',
        'view_count',
        'last_viewed_at',
    ];

    protected $casts = [
        'lecture_date' => 'date',
        'tags' => 'array',
        'media_files' => 'array',
        'drawings' => 'array',
        'is_important' => 'boolean',
        'is_shared' => 'boolean',
        'last_viewed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function scopeImportant($query)
    {
        return $query->where('is_important', true);
    }

    public function scopeByWeek($query, $week)
    {
        return $query->where('week_number', $week);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('note_type', $type);
    }

    public function getTagsListAttribute()
    {
        return $this->tags ? implode(', ', $this->tags) : '';
    }

    public function getExcerptAttribute()
    {
        return strlen($this->content) > 150 
            ? substr(strip_tags($this->content), 0, 150) . '...' 
            : strip_tags($this->content);
    }
}
