<?php

namespace App\Policies;

use App\Models\Class_subject_teacher;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClassSubjectTeacherPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Class_subject_teacher $classSubjectTeacher): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Class_subject_teacher $classSubjectTeacher): bool
    {
        return $user->hasRole('admin');
    }

}
