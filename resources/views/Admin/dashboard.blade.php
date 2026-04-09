  @extends('layouts.master')

  @section('content')
      <div class="container-fluid">
    <div class="row min-vh-100">

      <!-- Sidebar -->
      <div class="col-12 col-md-3 col-lg-2 bg-dark text-white p-3">
        <h4 class="text-center mb-4">
          <i class="fa-solid fa-school me-2"></i> School Admin
        </h4>

        <ul class="nav flex-column gap-2">
          <li class="nav-item">
            <a href="#" class="nav-link text-white bg-primary rounded">
              <i class="fa-solid fa-user-shield me-2"></i> Admin
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('students.index')}}" class="nav-link text-white">
              <i class="fa-solid fa-user-graduate me-2"></i> Student
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('teachers.index')}}" class="nav-link text-white">
              <i class="fa-solid fa-chalkboard-user me-2"></i> Teacher
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('classes.index')}}" class="nav-link text-white">
              <i class="fa-solid fa-door-open me-2"></i> Classes
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('subjects.index')}}" class="nav-link text-white">
              <i class="fas fa-book-open  me-2"></i> Subjects
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link text-white">
              <i class="fa-solid fa-calendar-check me-2"></i> Attendance
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link text-white">
              <i class="fa-solid fa-chart-line me-2"></i> Grades
            </a>
          </li>
        </ul>
      </div>

      <!-- Main Content -->
      <div class="col-12 col-md-9 col-lg-10 p-0">

        <!-- Topbar -->
        <nav class="navbar navbar-expand-lg bg-white border-bottom px-4 py-3">
          <div class="container-fluid p-0">
            <span class="navbar-brand mb-0 h4 fw-bold">Dashboard</span>

            <div class="dropdown ms-auto">
              <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://i.pravatar.cc/40?img=12" alt="Admin" width="40" height="40" class="rounded-circle border">
                <span class="ms-2 text-dark fw-semibold d-none d-md-inline">Admin</span>
              </a>

              <ul class="dropdown-menu dropdown-menu-end shadow">
                <li>
                  <a class="dropdown-item" href="{{route('profile.show')}}">
                    <i class="fa-solid fa-user me-2"></i> Profile
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="#">
                    <i class="fa-solid fa-gear me-2"></i> Settings
                  </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{route('logout')}}">
                        @csrf
                        <input type="submit" value="logout">
                    </form>

                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>

        <!-- Content -->
        <div class="p-4">

          <!-- Stats -->
          <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
              <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <p class="text-muted mb-1">Students</p>
                    <h3 class="mb-0">1,250</h3>
                  </div>
                  <i class="fa-solid fa-user-graduate fa-2x text-primary"></i>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
              <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <p class="text-muted mb-1">Teachers</p>
                    <h3 class="mb-0">85</h3>
                  </div>
                  <i class="fa-solid fa-chalkboard-user fa-2x text-success"></i>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
              <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <p class="text-muted mb-1">Classes</p>
                    <h3 class="mb-0">32</h3>
                  </div>
                  <i class="fa-solid fa-door-open fa-2x text-warning"></i>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
              <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <p class="text-muted mb-1">Attendance</p>
                    <h3 class="mb-0">96%</h3>
                  </div>
                  <i class="fa-solid fa-calendar-check fa-2x text-danger"></i>
                </div>
              </div>
            </div>
          </div>

          <!-- Table + Quick Actions -->
          <div class="row g-4">
            <div class="col-lg-8">
              <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">
                  Recent Students
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover align-middle">
                      <thead class="table-light">
                        <tr>
                          <th>Name</th>
                          <th>Class</th>
                          <th>Attendance</th>
                          <th>Grade</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>John Smith</td>
                          <td>Grade 10 - A</td>
                          <td><span class="badge bg-success">Present</span></td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Emma Watson</td>
                          <td>Grade 9 - B</td>
                          <td><span class="badge bg-success">Present</span></td>
                          <td>A+</td>
                        </tr>
                        <tr>
                          <td>Michael Lee</td>
                          <td>Grade 8 - C</td>
                          <td><span class="badge bg-danger">Absent</span></td>
                          <td>B</td>
                        </tr>
                        <tr>
                          <td>Sophia Brown</td>
                          <td>Grade 11 - A</td>
                          <td><span class="badge bg-success">Present</span></td>
                          <td>A</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">
                  Quick Actions
                </div>
                <div class="card-body d-grid gap-2">
                  <a href="#" class="btn btn-primary">
                    <i class="fa-solid fa-user-plus me-2"></i> Add Student
                  </a>
                   <a href="{{route('classes.create')}}" class="btn btn-primary">
                    <i class="fa-solid fa-user-plus me-2"></i> Add Class
                  </a>
                  <a  href="{{ route('teachers.create')}}" class="btn btn-success">
                    <i class="fa-solid fa-chalkboard-user me-2"></i> Add Teacher
                  </a>
                  <a href="#"  class="btn btn-warning text-white">
                    <i class="fa-solid fa-calendar-check me-2"></i> Mark Attendance
                  </a>
                  <a href="#"  class="btn btn-dark">
                    <i class="fa-solid fa-chart-line me-2"></i> Enter Grades
                  </a>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- End Content -->

      </div>
      <!-- End Main Content -->

    </div>
  </div>
  @endsection


