@extends('layouts.master')

@section('content')
<div class="container-fluid">

<div class="row min-vh-100">

    {{-- SIDEBAR --}}
    <div class="col-md-3 col-lg-2 bg-dark text-white p-3">

        <h5 class="text-center mb-4 fw-bold">
            <i class="fa-solid fa-school text-primary me-1"></i> School Panel
        </h5>

        <ul class="nav flex-column gap-2">

            <li>
                <a href="#" class="nav-link text-white bg-primary rounded">
                    <i class="fas fa-chart-line me-2"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="{{route('students.index')}}" class="nav-link text-white">
                    <i class="fa-solid fa-user-graduate me-2"></i> Students
                </a>
            </li>

            <li>
                <a href="{{route('teachers.index')}}" class="nav-link text-white">
                    <i class="fa-solid fa-chalkboard-user me-2"></i> Teachers
                </a>
            </li>

            <li>
                <a href="{{route('classes.index')}}" class="nav-link text-white">
                    <i class="fa-solid fa-door-open me-2"></i> Classes
                </a>
            </li>

            <li>
                <a href="{{route('subjects.index')}}" class="nav-link text-white">
                    <i class="fa-solid fa-book me-2"></i> Subjects
                </a>
            </li>

            <li>
                <a href="{{route('class-subject-teachers.index')}}" class="nav-link text-white">
                    <i class="fa-solid fa-diagram-project me-2"></i> Assign Subjects
                </a>
            </li>

            <li>
                <a href="{{route('attendance.index')}}" class="nav-link text-white">
                    <i class="fa-solid fa-calendar-check me-2"></i> Attendance
                </a>
            </li>

            <li>
                <a href="{{route('grades.index')}}" class="nav-link text-white">
                    <i class="fa-solid fa-chart-column me-2"></i> Grades
                </a>
            </li>

        </ul>

    </div>

    {{-- MAIN --}}
    <div class="col-md-9 col-lg-10 p-0">

        {{-- TOPBAR --}}
        <div class="bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">Dashboard</h4>

            <a href="{{ route('profile.show') }}" class="text-decoration-none text-dark">
                <i class="fa-solid fa-user me-1"></i> Profile
            </a>
        </div>

        <div class="p-4">

            {{-- STATS --}}
            <div class="row g-4 mb-4">

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Students</p>
                                <h4 class="fw-bold">{{ $totalStudents }}</h4>
                            </div>
                            <i class="fa-solid fa-user-graduate fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Teachers</p>
                                <h4 class="fw-bold">{{ $totalTeachers }}</h4>
                            </div>
                            <i class="fa-solid fa-chalkboard-user fa-2x text-success"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Classes</p>
                                <h4 class="fw-bold">{{ $totalClasses }}</h4>
                            </div>
                            <i class="fa-solid fa-door-open fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1">Attendance</p>
                                <h4 class="fw-bold">{{ $attendanceRate }}%</h4>
                            </div>
                            <i class="fa-solid fa-calendar-check fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>

            </div>

            {{-- QUICK ACTIONS --}}
            <div class="row g-3 mb-4">

                <div class="col-md-3">
                    <a href="{{ route('students.create') }}" class="btn btn-primary w-100">
                        <i class="fa-solid fa-user-plus me-1"></i> Add Student
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('teachers.create') }}" class="btn btn-success w-100">
                        <i class="fa-solid fa-chalkboard-user me-1"></i> Add Teacher
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('class-subject-teachers.create') }}" class="btn btn-warning w-100 text-white">
                        <i class="fa-solid fa-diagram-project me-1"></i> Assign Class
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('grades.create') }}" class="btn btn-dark w-100">
                        <i class="fa-solid fa-chart-line me-1"></i> Add Grade
                    </a>
                </div>

            </div>

            {{-- MAIN CONTENT --}}
            <div class="row g-4">

                {{-- LATEST STUDENTS --}}
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white fw-bold">
                            <i class="fa-solid fa-users me-1 text-primary"></i>
                            Latest Students
                        </div>

                        <div class="card-body">

                            <ul class="list-group list-group-flush">

                                @foreach($latestStudents as $student)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $student->user->name ?? 'N/A' }}</span>

                                    <span class="badge bg-primary">
                                        {{ $student->classroom->class_name ?? '-' }}
                                    </span>
                                </li>
                                @endforeach

                            </ul>

                        </div>
                    </div>
                </div>

                {{-- CLASS SUBJECT TEACHER --}}
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white fw-bold">
                            <i class="fa-solid fa-diagram-project me-1 text-warning"></i>
                            Class Subject Assignments
                        </div>

                        <div class="card-body p-0">

                            <table class="table mb-0">

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
