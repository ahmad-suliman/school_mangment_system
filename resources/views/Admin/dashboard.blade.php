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

                        <li><a href="{{ route('students.index') }}" class="nav-link text-white">
                                <i class="fa fa-user-graduate me-2"></i> Students
                            </a></li>

                        <li><a href="{{ route('admin.teachers.index') }}" class="nav-link text-white">
                                <i class="fa fa-chalkboard-user me-2"></i> Teachers
                            </a></li>

                        <li><a href="{{ route('admin.classes.index') }}" class="nav-link text-white">
                                <i class="fa fa-door-open me-2"></i> Classes
                            </a></li>

                        <li><a href="{{ route('admin.subjects.index') }}" class="nav-link text-white">
                                <i class="fa fa-book me-2"></i> Subjects
                            </a></li>

                        <li><a href="{{ route('admin.class-subject-teachers.index') }}" class="nav-link text-white">
                                <i class="fa fa-diagram-project me-2"></i> Assign Subjects
                            </a></li>

                        <li><a href="{{ route('admin.attendance.index') }}" class="nav-link text-white">
                                <i class="fa fa-calendar-check me-2"></i> Attendance
                            </a></li>

                        <li><a href="{{ route('admin.grades.index') }}" class="nav-link text-white">
                                <i class="fa fa-chart-column me-2"></i> Grades
                            </a></li>
                        <li>
                            <a href="{{ route('admin.announcements.index') }}" class="nav-link text-white">
                                <i class="fas fa-bullhorn me-2"></i> Announcements
                            </a>
                        </li>

                    </ul>
                </div>

                {{-- LOGOUT --}}
                <div class="p-3 border-top">
                    <a href="{{ route('profile.show') }}" class="btn btn-outline-light w-100 mb-2">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger w-100">
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

                    <div class="d-flex align-items-center gap-2">
                        @if (auth()->user()->profile_photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" class="rounded-circle"
                                width="40" height="40" style="object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                style="width:40px;height:40px;"> <i class="fa-solid fa-user text-secondary"></i> </div>
                        @endif
                        {{ auth()->user()->name }}
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

                            <a href="{{ route('students.create') }}" class="btn btn-primary">
                                Add Student
                            </a>

                            <a href="{{ route('admin.teachers.create') }}" class="btn btn-success">
                                Add Teacher
                            </a>

                            <a href="{{ route('admin.class-subject-teachers.create') }}"
                                class="btn btn-warning text-white">
                                Assign Subject
                            </a>

                            <a href="{{ route('admin.attendance.index') }}" class="btn btn-info text-white">
                                Take Attendance
                            </a>

                            <a href="{{ route('admin.grades.create') }}" class="btn btn-dark">
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
                                    @foreach ($latestStudents as $student)
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

                        <div class="row mt-4">

                            <div class="col-12">

                                <div class="card border-0 shadow-lg rounded-4">

                                    {{-- Card Header --}}
                                    <div class="card-header bg-white border-0 pt-4 px-4">

                                        <div class="d-flex justify-content-between align-items-center">

                                            <div>

                                                <h4 class="fw-bold mb-1">
                                                    School Statistics
                                                </h4>

                                                <p class="text-muted mb-0">
                                                    Overview of students, teachers and classes
                                                </p>

                                            </div>

                                            <div>

                                                <span class="badge bg-primary px-3 py-2 rounded-pill">
                                                    Admin Dashboard
                                                </span>

                                            </div>

                                        </div>

                                    </div>

                                    {{-- Card Body --}}
                                    <div class="card-body p-4">

                                        <canvas id="adminChart" height="100"></canvas>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="row mt-4">

                            <div class="col-lg-6">

                                <div class="card border-0 shadow-lg rounded-4">

                                    {{-- Header --}}
                                    <div class="card-header bg-white border-0 pt-4 px-4">

                                        <div class="d-flex justify-content-between align-items-center">

                                            <div>

                                                <h4 class="fw-bold mb-1">
                                                    Attendance Overview
                                                </h4>

                                                <p class="text-muted mb-0">
                                                    Present, absent and late statistics
                                                </p>

                                            </div>

                                            <span class="badge bg-success px-3 py-2 rounded-pill">
                                                Attendance
                                            </span>

                                        </div>

                                    </div>

                                    {{-- Body --}}
                                    <div class="card-body p-4">

                                        <canvas id="attendanceChart" height="250"></canvas>

                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- Chart.js --}}
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                        <script>
                            const ctx = document.getElementById('adminChart');
                            const attendanceCtx = document.getElementById('attendanceChart');
                            new Chart(ctx, {

                                type: 'bar',

                                data: {

                                    labels: [
                                        'Students',
                                        'Teachers',
                                        'Classes'
                                    ],

                                    datasets: [{

                                        label: 'School Data',

                                        data: [
                                            {{ $totalStudents }},
                                            {{ $totalTeachers }},
                                            {{ $totalClasses }}
                                        ],

                                        backgroundColor: [
                                            'rgba(13, 110, 253, 0.7)',
                                            'rgba(25, 135, 84, 0.7)',
                                            'rgba(255, 193, 7, 0.7)'
                                        ],

                                        borderColor: [
                                            '#0d6efd',
                                            '#198754',
                                            '#ffc107'
                                        ],

                                        borderWidth: 2,

                                        borderRadius: 12,

                                        hoverBackgroundColor: [
                                            '#0d6efd',
                                            '#198754',
                                            '#ffc107'
                                        ]
                                    }]
                                },

                                options: {

                                    responsive: true,

                                    plugins: {

                                        legend: {
                                            display: false
                                        },

                                        tooltip: {
                                            backgroundColor: '#212529',
                                            padding: 12,
                                            cornerRadius: 10
                                        }
                                    },

                                    scales: {

                                        y: {
                                            beginAtZero: true,

                                            grid: {
                                                color: 'rgba(200,200,200,0.2)'
                                            },

                                            ticks: {
                                                stepSize: 1
                                            }
                                        },

                                        x: {
                                            grid: {
                                                display: false
                                            }
                                        }
                                    }
                                }
                            });
                            new Chart(attendanceCtx, {

                                type: 'pie',

                                data: {

                                    labels: [
                                        'Present',
                                        'Absent',
                                        'Late'
                                    ],

                                    datasets: [{

                                        data: [
                                            {{ $presentCount }},
                                            {{ $absentCount }},
                                            {{ $lateCount }}
                                        ],

                                        backgroundColor: [
                                            'rgba(25, 135, 84, 0.8)',
                                            'rgba(220, 53, 69, 0.8)',
                                            'rgba(255, 193, 7, 0.8)'
                                        ],

                                        borderColor: [
                                            '#198754',
                                            '#dc3545',
                                            '#ffc107'
                                        ],

                                        borderWidth: 2,

                                        hoverOffset: 12
                                    }]
                                },

                                options: {

                                    responsive: true,

                                    plugins: {

                                        legend: {
                                            position: 'bottom',

                                            labels: {
                                                padding: 20,
                                                font: {
                                                    size: 14
                                                }
                                            }
                                        },

                                        tooltip: {
                                            backgroundColor: '#212529',
                                            padding: 12,
                                            cornerRadius: 10
                                        }
                                    }
                                }
                            });
                        </script>
                    @endsection
