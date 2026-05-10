<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Attendance;
use App\Models\Class_subject_teacher;
use App\Models\Classes;
use App\Models\Grade;
use App\Models\Student;
use App\Policies\AttendancePolicy;
use App\Policies\ClassroomPolicy;
use App\Policies\ClassSubjectTeacherPolicy;
use App\Policies\GradePolicy;
use App\Policies\StudentPolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Gate::policy(Attendance::class, AttendancePolicy::class);
        Gate::policy(Classes::class, ClassroomPolicy::class);
        Gate::policy(Class_subject_teacher::class , ClassSubjectTeacherPolicy::class);
        Gate::policy(Grade::class, GradePolicy::class);
        Gate::policy(Student::class,StudentPolicy::class);
    }
}
