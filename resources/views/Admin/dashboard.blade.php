@extends('layouts.master')
@section('title', 'Admin Dshboard')
@section('content')
    <div class="container-fluid">
        <div class="row min-vh-100">


            {{-- SIDEBAR --}}

            <div class="col-md-3 col-lg-2 bg-dark text-white d-flex flex-column p-0">

                ```
                {{-- LOGO --}}
                <div class="p-3 border-bottom border-secondary text-center">
                    <h5 class="fw-bold mb-0">
                        <i class="fa-solid fa-school text-primary me-2"></i>School Panel
                    </h5>
                </div>

                {{-- MENU --}}
                <ul class="nav flex-column w-100">

                    <li class="nav-item">
                        <a href="#" class="nav-link text-white d-flex align-items-center gap-2 px-3 py-2 bg-primary">
                            <i class="fas fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('students.index') }}"
                            class="nav-link text-white d-flex align-items-center gap-2 px-3 py-2">
                            <i class="fa-solid fa-user-graduate"></i>
                            <span>Students</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('teachers.index') }}"
                            class="nav-link text-white d-flex align-items-center gap-2 px-3 py-2">
                            <i class="fa-solid fa-chalkboard-user"></i>
                            <span>Teachers</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('classes.index') }}"
                            class="nav-link text-white d-flex align-items-center gap-2 px-3 py-2">
                            <i class="fa-solid fa-door-open"></i>
                            <span>Classes</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('subjects.index') }}"
                            class="nav-link text-white d-flex align-items-center gap-2 px-3 py-2">
                            <i class="fa-solid fa-book"></i>
                            <span>Subjects</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('class-subject-teachers.index') }}"
                            class="nav-link text-white d-flex align-items-center gap-2 px-3 py-2">
                            <i class="fa-solid fa-diagram-project"></i>
                            <span>Assign Subjects</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('attendance.index') }}"
                            class="nav-link text-white d-flex align-items-center gap-2 px-3 py-2">
                            <i class="fa-solid fa-calendar-check"></i>
                            <span>Attendance</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('grades.index') }}"
                            class="nav-link text-white d-flex align-items-center gap-2 px-3 py-2">
                            <i class="fa-solid fa-chart-column"></i>
                            <span>Grades</span>
                        </a>
                    </li>

                </ul>

                {{-- LOGOUT (BOTTOM) --}}
                <div class="mt-auto p-3 border-top border-secondary">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-light w-100">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                        </button>
                    </form>
                </div>
                ```

            </div>

            {{-- MAIN --}}
            <div class="col-md-9 col-lg-10 bg-light">

                {{-- TOPBAR --}}
                <div class="bg-white shadow-sm px-4 py-3 d-flex justify-content-between align-items-center">

                    <h5 class="mb-0 fw-bold">
                        <i class="fa-solid fa-gauge-high me-2 text-primary"></i>Dashboard
                    </h5>

                    <div class="d-flex align-items-center gap-3">

                        <span class="fw-semibold">
                            <i class="fa-solid fa-user-circle me-1"></i>
                            {{ auth()->user()->name }}
                        </span>

                        <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-primary">
                            Profile
                        </a>

                    </div>

                </div>

                <div class="p-4">

                    {{-- STATS --}}
                    <div class="row g-4 mb-4">

                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm text-center p-3">
                                <i class="fa-solid fa-user-graduate fa-2x text-primary mb-2"></i>
                                <h6 class="text-muted">Students</h6>
                                <h4 class="fw-bold">{{ $totalStudents }}</h4>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm text-center p-3">
                                <i class="fa-solid fa-chalkboard-user fa-2x text-success mb-2"></i>
                                <h6 class="text-muted">Teachers</h6>
                                <h4 class="fw-bold">{{ $totalTeachers }}</h4>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm text-center p-3">
                                <i class="fa-solid fa-door-open fa-2x text-warning mb-2"></i>
                                <h6 class="text-muted">Classes</h6>
                                <h4 class="fw-bold">{{ $totalClasses }}</h4>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card border-0 shadow-sm text-center p-3">
                                <i class="fa-solid fa-calendar-check fa-2x text-danger mb-2"></i>
                                <h6 class="text-muted">Attendance</h6>
                                <h4 class="fw-bold">{{ $attendanceRate }}%</h4>
                            </div>
                        </div>

                    </div>

                    {{-- QUICK ACTIONS --}}
                    <div class="d-flex flex-wrap gap-3 mb-4">

                        <a href="{{ route('students.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-user-plus me-1"></i>Student
                        </a>

                        <a href="{{ route('teachers.create') }}" class="btn btn-success">
                            <i class="fa-solid fa-chalkboard-user me-1"></i>Teacher
                        </a>

                        <a href="{{ route('class-subject-teachers.create') }}" class="btn btn-warning text-white">
                            <i class="fa-solid fa-diagram-project me-1"></i>Assign
                        </a>

                        <a href="{{ route('grades.create') }}" class="btn btn-dark">
                            <i class="fa-solid fa-chart-line me-1"></i>Grade
                        </a>

                    </div>

                    <div class="row g-4">

                        {{-- LATEST STUDENTS --}}
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white fw-bold">
                                    <i class="fa-solid fa-users text-primary me-1"></i>
                                    Latest Students
                                </div>

                                <ul class="list-group list-group-flush">
                                    @foreach ($latestStudents as $student)
                                        <li class="list-group-item d-flex justify-content-between">
                                            {{ $student->user->name ?? 'N/A' }}
                                            <span class="badge bg-primary">
                                                {{ $student->classroom->class_name ?? '-' }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>

                        {{-- ASSIGNMENTS --}}
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white fw-bold">
                                    <i class="fa-solid fa-diagram-project text-warning me-1"></i>
                                    Assignments
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
                                            @foreach ($assignments as $item)
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
