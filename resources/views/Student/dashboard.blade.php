@extends('layouts.master')

@section('title', 'Student Dashboard')

@section('content')

    <div class="container-fluid p-0">


        {{-- SIDEBAR --}}
        <div class="bg-dark text-white position-fixed vh-100 d-flex flex-column" style="width:250px;">

            {{-- LOGO --}}
            <div class="text-center py-4 border-bottom border-secondary">
                <h5 class="fw-bold mb-0">
                    <i class="fa-solid fa-graduation-cap text-primary me-2"></i>
                    Student Panel
                </h5>
            </div>

            {{-- MENU --}}
            <ul class="nav flex-column px-2 mt-3 flex-grow-1">

                <li class="nav-item mb-2">
                    <a href="#" class="nav-link text-white bg-primary rounded px-3 py-2">
                        <i class="fa-solid fa-gauge me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{route('student.subjects.index')}}" class="nav-link text-white px-3 py-2 rounded">
                        <i class="fa-solid fa-book me-2"></i> Subjects
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{route('student.grades.index')}}" class="nav-link text-white px-3 py-2 rounded">
                        <i class="fa-solid fa-chart-line me-2"></i> Grades
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{route('student.attendance.index')}}" class="nav-link text-white px-3 py-2 rounded">
                        <i class="fa-solid fa-calendar-check me-2"></i> Attendance
                    </a>
                </li>

            </ul>

            {{-- FOOTER --}}
            <div class="p-3 border-top border-secondary">

                <a href="{{ route('profile.show') }}" class="btn btn-outline-light w-100 mb-2">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger w-100">
                        Logout
                    </button>
                </form>

            </div>

        </div>


        {{-- MAIN CONTENT --}}
        <div style="margin-left:250px; width: calc(100% - 250px);">

            {{-- TOPBAR --}}
            <div class="bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center sticky-top">
                <h5 class="fw-bold mb-0">
                    <i class="fa-solid fa-gauge-high text-primary me-2"></i>
                    Dashboard
                </h5>

                <div class="d-flex align-items-center gap-2">
                    @if (auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" class="rounded-circle"
                            width="40" height="40" style="object-fit:cover;">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                            style="width:40px;height:40px;"> <i class="fa-solid fa-user text-secondary"></i> </div>
                    @endif
                    <span class="fw-semibold">{{ auth()->user()->name }}</span>
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="p-4">

                {{-- STATS --}}
                <div class="row g-4 mb-4">

                    <div class="col-md-4">
                        <div class="card shadow-sm text-center p-3">
                            <i class="fa-solid fa-calendar-check fa-2x text-success mb-2"></i>
                            <h6 class="text-muted">Attendance</h6>
                            <h4>{{ $attendanceRate ?? 0 }}%</h4>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm text-center p-3">
                            <i class="fa-solid fa-chart-line fa-2x text-primary mb-2"></i>
                            <h6 class="text-muted">Average Grade</h6>
                            <h4>{{ $averageGrade ?? 0 }}</h4>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm text-center p-3">
                            <i class="fa-solid fa-book fa-2x text-warning mb-2"></i>
                            <h6 class="text-muted">Subjects</h6>
                            <h4>{{ $subjectsCount ?? 0 }}</h4>
                        </div>
                    </div>

                </div>

                {{-- MAIN SECTION --}}
                <div class="row g-4">

                    {{-- SUBJECTS --}}
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white fw-bold">
                                <i class="fa-solid fa-book text-warning me-2"></i>
                                My Subjects
                            </div>

                            <div class="card-body">

                                @forelse($subjects as $subject)
                                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                        <span>{{ $subject->subject_name }}</span>
                                        <span class="badge bg-primary">Active</span>
                                    </div>
                                @empty
                                    <p class="text-muted">No subjects assigned</p>
                                @endforelse

                            </div>
                        </div>
                    </div>

                    {{-- GRADES --}}
                    <div class="col-lg-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white fw-bold">
                                <i class="fa-solid fa-chart-line text-primary me-2"></i>
                                Recent Grades
                            </div>

                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Subject</th>
                                            <th>Marks</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($grades as $grade)
                                            <tr>
                                                <td>{{ $grade->subject->subject_name ?? '-' }}</td>
                                                <td>
                                                    <span class="badge bg-success">
                                                        {{ $grade->marks }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center text-muted">
                                                    No grades available
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>


    </div>

@endsection
