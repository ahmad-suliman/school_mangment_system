@extends('layouts.master')
@section('title','School Mangment System')
@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fa-solid fa-school me-2"></i>
                School Management System
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#modules">Modules</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-light">
                                <i class="fa-solid fa-gauge-high me-1"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-light">
                                <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                            </a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-primary text-white py-5">
        <div class="container py-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <span class="badge bg-light text-primary mb-3 fs-6">
                        <i class="fa-solid fa-graduation-cap me-2"></i>Smart School Platform
                    </span>

                    <h1 class="display-4 fw-bold mb-3">
                        Welcome to School Management System
                    </h1>

                    <p class="lead mb-4">
                        Manage students, teachers, classes, subjects, attendance, grades, and permissions
                        in one secure and easy-to-use platform.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">
                                <i class="fa-solid fa-gauge-high me-2"></i>Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                                <i class="fa-solid fa-right-to-bracket me-2"></i>Login
                            </a>
                        @endauth

                        <a href="#features" class="btn btn-outline-light btn-lg">
                            <i class="fa-solid fa-circle-info me-2"></i>Learn More
                        </a>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card shadow border-0">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-dark mb-4">
                                <i class="fa-solid fa-layer-group text-primary me-2"></i>
                                System Modules
                            </h4>

                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="border rounded p-3 text-center">
                                        <i class="fa-solid fa-users text-primary fs-3 mb-2"></i>
                                        <div class="fw-semibold text-dark">Users</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-3 text-center">
                                        <i class="fa-solid fa-user-shield text-success fs-3 mb-2"></i>
                                        <div class="fw-semibold text-dark">Roles</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-3 text-center">
                                        <i class="fa-solid fa-chalkboard-user text-warning fs-3 mb-2"></i>
                                        <div class="fw-semibold text-dark">Teachers</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-3 text-center">
                                        <i class="fa-solid fa-user-graduate text-danger fs-3 mb-2"></i>
                                        <div class="fw-semibold text-dark">Students</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-3 text-center">
                                        <i class="fa-solid fa-school text-info fs-3 mb-2"></i>
                                        <div class="fw-semibold text-dark">Classes</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-3 text-center">
                                        <i class="fa-solid fa-book-open text-secondary fs-3 mb-2"></i>
                                        <div class="fw-semibold text-dark">Subjects</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-3 text-center">
                                        <i class="fa-solid fa-calendar-check text-success fs-3 mb-2"></i>
                                        <div class="fw-semibold text-dark">Attendance</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-3 text-center">
                                        <i class="fa-solid fa-square-poll-vertical text-primary fs-3 mb-2"></i>
                                        <div class="fw-semibold text-dark">Grades</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Core Features</h2>
                <p class="text-muted">Everything your school needs in one system</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <i class="fa-solid fa-users text-primary fs-1 mb-3"></i>
                            <h5 class="fw-bold">User Management</h5>
                            <p class="text-muted mb-0">Manage admins, teachers, and students from one dashboard.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <i class="fa-solid fa-user-shield text-success fs-1 mb-3"></i>
                            <h5 class="fw-bold">Roles & Permissions</h5>
                            <p class="text-muted mb-0">Control access using Spatie roles and permissions.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <i class="fa-solid fa-calendar-check text-warning fs-1 mb-3"></i>
                            <h5 class="fw-bold">Attendance</h5>
                            <p class="text-muted mb-0">Track daily student attendance quickly and accurately.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <i class="fa-solid fa-square-poll-vertical text-danger fs-1 mb-3"></i>
                            <h5 class="fw-bold">Grades</h5>
                            <p class="text-muted mb-0">Record marks, exam scores, and performance reports.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modules -->
    <section id="modules" class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">System Modules</h2>
                <p class="text-muted">Built for complete school administration</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold"><i class="fa-solid fa-users text-primary me-2"></i>Users</h5>
                            <p class="text-muted mb-0">Store login accounts for admin, teacher, and student roles.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold"><i class="fa-solid fa-chalkboard-user text-warning me-2"></i>Teachers</h5>
                            <p class="text-muted mb-0">Teacher profiles, assignments, and subject relations.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold"><i class="fa-solid fa-user-graduate text-danger me-2"></i>Students</h5>
                            <p class="text-muted mb-0">Student data, enrollment, class assignment, and records.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold"><i class="fa-solid fa-school text-info me-2"></i>Classes</h5>
                            <p class="text-muted mb-0">Create school classes and manage class structures.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold"><i class="fa-solid fa-book-open text-secondary me-2"></i>Subjects</h5>
                            <p class="text-muted mb-0">Manage all subjects offered across classes and teachers.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold"><i class="fa-solid fa-link text-success me-2"></i>Class-Subject-Teacher</h5>
                            <p class="text-muted mb-0">Assign teachers and subjects to classes efficiently.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold"><i class="fa-solid fa-calendar-check text-primary me-2"></i>Attendance</h5>
                            <p class="text-muted mb-0">Daily attendance tracking for every student in class.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold"><i class="fa-solid fa-square-poll-vertical text-danger me-2"></i>Grades</h5>
                            <p class="text-muted mb-0">Store and manage quizzes, exams, and final results.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Roles -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">User Roles</h2>
                <p class="text-muted">Role-based access with Spatie Permission</p>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fa-solid fa-user-shield text-primary fs-1 mb-3"></i>
                            <h4 class="fw-bold">Admin</h4>
                            <p class="text-muted">Full access to users, permissions, classes, students, teachers, attendance, and grades.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fa-solid fa-chalkboard-user text-warning fs-1 mb-3"></i>
                            <h4 class="fw-bold">Teacher</h4>
                            <p class="text-muted">Can manage assigned classes, attendance, subjects, and student grades.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <i class="fa-solid fa-user-graduate text-danger fs-1 mb-3"></i>
                            <h4 class="fw-bold">Student</h4>
                            <p class="text-muted">Can view personal profile, attendance status, and academic results.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="fw-bold mb-3">Ready to Use the System?</h2>
            <p class="lead mb-4">Login to access your school dashboard and manage everything efficiently.</p>

            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">
                    <i class="fa-solid fa-gauge-high me-2"></i>Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                    <i class="fa-solid fa-right-to-bracket me-2"></i>Login Now
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-1 fw-semibold">
                <i class="fa-solid fa-school me-2"></i>School Management System
            </p>
            <p class="mb-0 text-white-50">
                &copy; {{ date('Y') }} All Rights Reserved.
            </p>
        </div>
    </footer>
@endsection
