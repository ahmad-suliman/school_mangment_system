<?php

namespace App\Providers;

use App\Models\Announcement;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Attendance;
use App\Models\Class_subject_teacher;
use App\Models\Classes;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Policies\AnnouncementPolicy;
use App\Policies\AttendancePolicy;
use App\Policies\ClassroomPolicy;
use App\Policies\ClassSubjectTeacherPolicy;
use App\Policies\GradePolicy;
use App\Policies\StudentPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\TeacherPolicy;
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
        Gate::policy(Subject::class,SubjectPolicy::class);
        Gate::policy(Teacher::class,TeacherPolicy::class);
        Gate::policy(Announcement::class,AnnouncementPolicy::class);
    }
}
