@extends('layouts.master')
@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
<div class="row min-vh-100">

    {{-- SIDEBAR --}}
    <div class="col-md-3 col-lg-2 bg-dark text-white p-0 d-flex flex-column">

        {{-- LOGO --}}
        <div class="p-3 border-bottom text-center">
            <h5 class="fw-bold mb-0">
                <i class="fa-solid fa-school text-primary me-1"></i> School Panel
            </h5>
        </div>

        {{-- MENU --}}
        <div class="flex-grow-1">
            <ul class="nav flex-column">

                <li class="nav-item">
                    <a href="#" class="nav-link text-white bg-primary">
                        <i class="fas fa-gauge me-2"></i> Dashboard
                    </a>
                </li>

                <li><a href="{{route('students.index')}}" class="nav-link text-white">
                    <i class="fa fa-user-graduate me-2"></i> Students
                </a></li>

                <li><a href="{{route('teachers.index')}}" class="nav-link text-white">
                    <i class="fa fa-chalkboard-user me-2"></i> Teachers
                </a></li>

                <li><a href="{{route('classes.index')}}" class="nav-link text-white">
                    <i class="fa fa-door-open me-2"></i> Classes
                </a></li>

                <li><a href="{{route('subjects.index')}}" class="nav-link text-white">
                    <i class="fa fa-book me-2"></i> Subjects
                </a></li>

                <li><a href="{{route('class-subject-teachers.index')}}" class="nav-link text-white">
                    <i class="fa fa-diagram-project me-2"></i> Assign Subjects
                </a></li>

                <li><a href="{{route('attendance.index')}}" class="nav-link text-white">
                    <i class="fa fa-calendar-check me-2"></i> Attendance
                </a></li>

                <li><a href="{{route('grades.index')}}" class="nav-link text-white">
                    <i class="fa fa-chart-column me-2"></i> Grades
                </a></li>

            </ul>
        </div>

        {{-- LOGOUT --}}
        <div class="p-3 border-top">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-light w-100">
                    Logout
                </button>
            </form>
        </div>

    </div>

    {{-- MAIN --}}
    <div class="col-md-9 col-lg-10 bg-light p-0">

        {{-- TOPBAR --}}
        <div class="bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center">

            <div>
                <h5 class="fw-bold mb-0">Dashboard</h5>
                <small class="text-muted">Overview of your school system</small>
            </div>

            <div class="d-flex align-items-center gap-3">
                <span class="fw-semibold">
                    <i class="fa fa-user-circle me-1"></i>
                    {{ auth()->user()->name }}
                </span>

                <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-primary">
                    Profile
                </a>
            </div>

        </div>

        <div class="p-4">

            {{-- STATS ROW --}}
            <div class="row g-4 mb-4">

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Students</p>
                                <h4 class="fw-bold">{{ $totalStudents }}</h4>
                            </div>
                            <i class="fa fa-user-graduate fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Teachers</p>
                                <h4 class="fw-bold">{{ $totalTeachers }}</h4>
                            </div>
                            <i class="fa fa-chalkboard-user fa-2x text-success"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Classes</p>
                                <h4 class="fw-bold">{{ $totalClasses }}</h4>
                            </div>
                            <i class="fa fa-door-open fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1">Attendance</p>
                                <h4 class="fw-bold">{{ $attendanceRate }}%</h4>
                            </div>
                            <i class="fa fa-calendar-check fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>

            </div>

            {{-- QUICK ACTIONS --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">
                    Quick Actions
                </div>

                <div class="card-body d-flex flex-wrap gap-2">

                    <a href="{{route('students.create')}}" class="btn btn-primary">
                        Add Student
                    </a>

                    <a href="{{route('teachers.create')}}" class="btn btn-success">
                        Add Teacher
                    </a>

                    <a href="{{route('class-subject-teachers.create')}}" class="btn btn-warning text-white">
                        Assign Subject
                    </a>

                    <a href="{{route('attendance.create')}}" class="btn btn-info text-white">
                        Take Attendance
                    </a>

                    <a href="{{route('grades.create')}}" class="btn btn-dark">
                        Add Grade
                    </a>

                </div>
            </div>

            {{-- MAIN GRID --}}
            <div class="row g-4">

                {{-- LATEST STUDENTS --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-header bg-white fw-bold">
                            Latest Students
                        </div>

                        <ul class="list-group list-group-flush">
                            @foreach($latestStudents as $student)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $student->user->name ?? 'N/A' }}
                                    <span class="badge bg-primary">
                                        {{ $student->classroom->class_name ?? '-' }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>

                {{-- CLASS SUBJECT TEACHER --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-header bg-white fw-bold">
                            Class Assignments
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover mb-0">

                                <thead class="table-light">
                                    <tr>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Teacher</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($assignments as $item)
                                        <tr>
                                            <td>{{ $item->classroom->class_name ?? '-' }}</td>
                                            <td>{{ $item->subject->subject_name ?? '-' }}</td>
                                            <td>{{ $item->teacher->user->name ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

</div>
</div>
@endsection
