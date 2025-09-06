<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['normal_user', 'manager', 'editor']);
    }

    public function view(User $user, Course $course): bool
    {
        return $user->id === $course->user_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['normal_user', 'manager', 'editor']);
    }

    public function update(User $user, Course $course): bool
    {
        return $user->id === $course->user_id;
    }

    public function delete(User $user, Course $course): bool
    {
        return $user->id === $course->user_id;
    }

    public function restore(User $user, Course $course): bool
    {
        return $user->id === $course->user_id;
    }

    public function forceDelete(User $user, Course $course): bool
    {
        return $user->id === $course->user_id;
    }
}