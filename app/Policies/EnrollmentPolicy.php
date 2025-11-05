<?php

namespace App\Policies;

use App\Models\Enrollment;
use App\Models\User;

class EnrollmentPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'instructor', 'student']);
    }

    public function view(User $user, Enrollment $enrollment): bool
    {
        if ($user->role === 'admin') return true;
        if ($user->role === 'student') return $enrollment->user_id === $user->id;
        if ($user->role === 'instructor') return $enrollment->course && $enrollment->course->instructor_id === $user->id;
        return false;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'student']);
    }

    public function update(User $user, Enrollment $enrollment): bool
    {
        if ($user->role === 'admin') return true;
        if ($user->role === 'student') return $enrollment->user_id === $user->id;
        if ($user->role === 'instructor') return $enrollment->course && $enrollment->course->instructor_id === $user->id;
        return false;
    }

    public function delete(User $user, Enrollment $enrollment): bool
    {
        if ($user->role === 'admin') return true;
        if ($user->role === 'student') return $enrollment->user_id === $user->id;
        if ($user->role === 'instructor') return $enrollment->course && $enrollment->course->instructor_id === $user->id;
        return false;
    }
}