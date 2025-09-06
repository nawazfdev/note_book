<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;

class NotePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['normal_user', 'manager', 'editor']);
    }

    public function view(User $user, Note $note): bool
    {
        return $user->id === $note->user_id || $note->is_shared;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['normal_user', 'manager', 'editor']);
    }

    public function update(User $user, Note $note): bool
    {
        return $user->id === $note->user_id;
    }

    public function delete(User $user, Note $note): bool
    {
        return $user->id === $note->user_id;
    }

    public function restore(User $user, Note $note): bool
    {
        return $user->id === $note->user_id;
    }

    public function forceDelete(User $user, Note $note): bool
    {
        return $user->id === $note->user_id;
    }
}