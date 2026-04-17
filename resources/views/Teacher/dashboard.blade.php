@extends('layouts.master')
@section('title', 'Teacher Dashboard')

@section('content')
<div class="container-fluid">
<div class="row min-vh-100">

    {{-- SIDEBAR --}}
    <div class="col-md-3 col-lg-2 bg-dark text-white p-0 d-flex flex-column">

        <div class="p-3 border-bottom text-center">
            <h5 class="fw-bold mb-0">
                <i class="fa fa-chalkboard-user text-success me-1"></i> Teacher Panel
            </h5>
        </div>

        <ul class="nav flex-column">

            <li>
                <a href="#" class="nav-link text-white bg-success">
                    <i class="fa fa-gauge me-2"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('teacher.attendance.create') }}" class="nav-link text-white">
                    <i class="fa fa-calendar-check me-2"></i> Take Attendance
                </a>
            </li>

            <li>
                <a href="{{ route('teacher.attendance.index') }}" class="nav-link text-white">
                    <i class="fa fa-list me-2"></i> Attendance List
                </a>
            </li>

            <li>
                <a href="{{ route('teacher.grades.create') }}" class="nav-link text-white">
                    <i class="fa fa-pen me-2"></i> Add Grades
                </a>
            </li>

            <li>
                <a href="{{ route('teacher.grades.index') }}" class="nav-link text-white">
                    <i class="fa fa-chart-column me-2"></i> Grades List
                </a>
            </li>

        </ul>

        <div class="mt-auto p-3 border-top">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-light w-100">Logout</button>
            </form>
        </div>

    </div>

    {{-- MAIN --}}
    <div class="col-md-9 col-lg-10 bg-light p-0">

        {{-- TOPBAR --}}
        <div class="bg-white border-bottom px-4 py-3 d-flex justify-content-between">

            <div>
                <h5 class="fw-bold mb-0">Teacher Dashboard</h5>
                <small class="text-muted">Manage your classes and students</small>
            </div>

            <div>
                {{ auth()->user()->name }}
                <a href="/profile" class="btn btn-sm btn-outline-info ">profile</a>
            </div>

        </div>

        <div class="p-4">

            {{-- STATS --}}
            <div class="row g-4 mb-4">

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h6 class="text-muted">My Classes</h6>
                            <h3>{{ $totalClasses }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h6 class="text-muted">My Subjects</h6>
                            <h3>{{ $totalSubjects }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h6 class="text-muted">My Students</h6>
                            <h3>{{ $totalStudents }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Today Attendance</h6>
                            <h3>{{ $todayAttendance }}</h3>
                        </div>
                    </div>
                </div>

            </div>

            {{-- QUICK ACTIONS --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold">
                    Quick Actions
                </div>

                <div class="card-body d-flex gap-2 flex-wrap">

                    <a href="{{ route('teacher.attendance.create') }}" class="btn btn-success">
                        Take Attendance
                    </a>

                    <a href="{{ route('teacher.grades.create') }}" class="btn btn-primary">
                        Add Grades
                    </a>

                </div>
            </div>

            <div class="row g-4">

                {{-- MY CLASSES --}}
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0">

                        <div class="card-header bg-white fw-bold">
                            My Classes
                        </div>

                        <ul class="list-group list-group-flush">

                            @foreach($classes as $class)
                                <li class="list-group-item">
                                    {{ $class->classroom->class_name }} - {{ $class->classroom->section }}
                                </li>
                            @endforeach

                        </ul>

                    </div>
                </div>

                {{-- MY SUBJECTS --}}
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0">

                        <div class="card-header bg-white fw-bold">
                            My Subjects
                        </div>

                        <ul class="list-group list-group-flush">

                            @foreach($subjects as $subject)
                                <li class="list-group-item">
                                    {{ $subject->subject->subject_name }}
                                </li>
                            @endforeach

                        </ul>

                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
</div>
@endsection
