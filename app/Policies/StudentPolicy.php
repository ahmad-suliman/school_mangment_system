<?php

namespace App\Policies;

use App\Models\Class_subject_teacher;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StudentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('teacher');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Student $student): bool
    {
        if($user->hasRole('admin')){
            return true;
        }
        if($user->hasRole('teacher')){

            $teacher = $user->teacher;

            $classIds = Class_subject_teacher::where('teacher_id', $teacher->id)
                ->pluck('class_id');

            return $classIds->contains($student->class_id);
        }
        return false;
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
    public function update(User $user, Student $student): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Student $student): bool
    {
        return $user->hasRole('admin');
    }

}
