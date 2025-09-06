<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    public function isNormalUser(): bool
    {
        return $this->hasRole('normal_user');
    }

    // Relationships for EduNotes features
    public function courses()
    {
        return $this->hasMany(\App\Models\Course::class);
    }

    public function notes()
    {
        return $this->hasMany(\App\Models\Note::class);
    }

    public function documents()
    {
        return $this->hasMany(\App\Models\Document::class);
    }
}