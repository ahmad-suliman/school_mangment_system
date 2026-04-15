@extends('layouts.master')
@section('title', 'Classes')

@section('content')
    <div class="container py-4">


        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="fa-solid fa-school text-primary me-2"></i>
                    Calss Management
                </h2>
                <p class="text-muted mb-0">View, edit, and manage all Class in the system.</p>
            </div>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Dashbard
                </a>
                <a href="{{ route('classes.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-chalkboard"></i> Add New Class
                </a>
            </div>

        </div>


        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3 border-0" role="alert">
                <i class="fas fa-circle-check me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('danger'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3 border-0" role="alert">
                <i class="fas fa-circle-check me-2"></i>
                {{ session('danger') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif



        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-list me-2 text-primary"></i>Class List
                    </h5>


                    <div class="w-100" style="max-width: 320px;">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-0 bg-light" placeholder="Search Class...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">

                @if ($classes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">#</th>
                                    <th class="py-3">Class Name</th>
                                    <th class="py-3">Section</th>
                                    <th class="py-3">Academic Year</th>
                                    <th class="py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classes as $index => $class)
                                    <tr>

                                        <td class="px-4 fw-semibold text-muted">
                                            {{ $index + 1 }}
                                        </td>
                                        <td>
                                            <span class="text-dark">
                                                {{ $class->class_name }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-dark">
                                                {{ $class->section }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-dark">
                                                {{ $class->academic_year }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">

                                                <a href="" class="btn btn-sm btn-info text-light rounded-3"
                                                    title="View Class">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a href="{{ route('classes.edit', $class->id) }}"
                                                    class="btn btn-sm btn-warning text-dark rounded-3" title="Edit Calss">
                                                    <i class="fas fa-pen-to-square"></i>
                                                </a>


                                                <form action="{{ route('classes.destroy', $class->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this Class?');"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger rounded-3"
                                                        title="Delete Class">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="card-footer bg-white border-0 py-3 px-4">
                        <small class="text-muted">
                            <i class="fas fa-database me-1"></i>
                            Total Classes: <strong>{{ $classes->count() }}</strong>
                        </small>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-chalkboard-teacher fa-3x text-secondary opacity-50"></i>
                        </div>
                        <h5 class="fw-bold text-dark">No Class Found</h5>
                        <p class="text-muted mb-4">There are no classes added yet. Start by creating a new class.</p>
                        <a href="{{ route('classes.create') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i> Add First Class
                        </a>
                    </div>
                @endif

            </div>
        </div>



    @endsection
