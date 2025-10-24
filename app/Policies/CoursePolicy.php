<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->role === 'admin') {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Course $course): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['instructor', 'admin']);
    }

    public function update(User $user, Course $course): bool
    {
        return $user->role === 'admin' || ($user->role === 'instructor' && $user->id === $course->instructor_id);
    }

    public function delete(User $user, Course $course): bool
    {
        return $user->role === 'admin' || ($user->role === 'instructor' && $user->id === $course->instructor_id);
    }

    public function restore(User $user, Course $course): bool
    {
        return false;
    }

    public function forceDelete(User $user, Course $course): bool
    {
        return false;
    }
}
