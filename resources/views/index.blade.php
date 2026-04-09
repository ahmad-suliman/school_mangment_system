
<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Admin Dashboard
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    School Management System Overview
                </p>
            </div>

            <div class="flex items-center gap-2">
                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                    Logged in as Admin
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Welcome Section --}}
            <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">
                            Welcome back, ahmad 👋
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Manage your school system, users, roles, classes, attendance, and grades from one place.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href=""
                           class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-700 transition">
                            Refresh Dashboard
                        </a>
                    </div>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5">

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Users</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-900">this</h3>
                    <p class="mt-2 text-xs text-gray-400">All registered system users</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Roles</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-900">this</h3>
                    <p class="mt-2 text-xs text-gray-400">Spatie roles count</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Permissions</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-900">thiss'] }}</h3>
                    <p class="mt-2 text-xs text-gray-400">Spatie permissions count</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Teachers</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-900">this }}</h3>
                    <p class="mt-2 text-xs text-gray-400">Active teaching staff</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Students</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-900">this }}</h3>
                    <p class="mt-2 text-xs text-gray-400">Enrolled students</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Classes</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-900">this}}</h3>
                    <p class="mt-2 text-xs text-gray-400">School classes / sections</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Subjects</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-900">this }}</h3>
                    <p class="mt-2 text-xs text-gray-400">Available subjects</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Class-Subject-Teacher</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-900">thisect_teacher'] }}</h3>
                    <p class="mt-2 text-xs text-gray-400">Teaching assignments</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Attendances</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-900">thiss'] }}</h3>
                    <p class="mt-2 text-xs text-gray-400">Attendance records</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <p class="text-sm text-gray-500">Grades</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-900">this}</h3>
                    <p class="mt-2 text-xs text-gray-400">Grade / mark records</p>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
                    <span class="text-sm text-gray-400">Admin shortcuts</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href=""
                       class="rounded-2xl border border-gray-200 p-4 hover:shadow-md hover:border-indigo-300 transition">
                        <h4 class="font-semibold text-gray-800">Manage Students</h4>
                        <p class="text-sm text-gray-500 mt-1">View, create, update, and delete students</p>
                    </a>

                    <a href=""
                       class="rounded-2xl border border-gray-200 p-4 hover:shadow-md hover:border-indigo-300 transition">
                        <h4 class="font-semibold text-gray-800">Manage Teachers</h4>
                        <p class="text-sm text-gray-500 mt-1">Add and manage teacher profiles</p>
                    </a>

                    <a href=""
                       class="rounded-2xl border border-gray-200 p-4 hover:shadow-md hover:border-indigo-300 transition">
                        <h4 class="font-semibold text-gray-800">Manage Classes</h4>
                        <p class="text-sm text-gray-500 mt-1">Create classes, sections, and assignments</p>
                    </a>

                    <a href=""
                       class="rounded-2xl border border-gray-200 p-4 hover:shadow-md hover:border-indigo-300 transition">
                        <h4 class="font-semibold text-gray-800">Manage Subjects</h4>
                        <p class="text-sm text-gray-500 mt-1">Organize subject catalog</p>
                    </a>

                    <a href=""
                       class="rounded-2xl border border-gray-200 p-4 hover:shadow-md hover:border-indigo-300 transition">
                        <h4 class="font-semibold text-gray-800">Attendance</h4>
                        <p class="text-sm text-gray-500 mt-1">Track and review attendance records</p>
                    </a>

                    <a href=""
                       class="rounded-2xl border border-gray-200 p-4 hover:shadow-md hover:border-indigo-300 transition">
                        <h4 class="font-semibold text-gray-800">Grades</h4>
                        <p class="text-sm text-gray-500 mt-1">Manage exam results and marks</p>
                    </a>

                    <a href=""
                       class="rounded-2xl border border-gray-200 p-4 hover:shadow-md hover:border-indigo-300 transition">
                        <h4 class="font-semibold text-gray-800">System Users</h4>
                        <p class="text-sm text-gray-500 mt-1">Manage login users and access</p>
                    </a>

                    <a href=""
                       class="rounded-2xl border border-gray-200 p-4 hover:shadow-md hover:border-indigo-300 transition">
                        <h4 class="font-semibold text-gray-800">Roles & Permissions</h4>
                        <p class="text-sm text-gray-500 mt-1">Manage Spatie roles and permissions</p>
                    </a>
                </div>
            </div>

            {{-- Recent Data Grids --}}
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

                {{-- Recent Users --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Users</h3>
                        <a href="" class="text-sm text-indigo-600 hover:text-indigo-700">View All</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100 text-left text-gray-500">
                                    <th class="py-3 pr-4">Name</th>
                                    <th class="py-3 pr-4">Email</th>
                                    <th class="py-3 pr-4">Role</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Recent Students --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Students</h3>
                        <a href="" class="text-sm text-indigo-600 hover:text-indigo-700">View All</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100 text-left text-gray-500">
                                    <th class="py-3 pr-4">Student ID</th>
                                    <th class="py-3 pr-4">Name</th>
                                    <th class="py-3 pr-4">Class</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Recent Teachers --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Teachers</h3>
                        <a href="" class="text-sm text-indigo-600 hover:text-indigo-700">View All</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100 text-left text-gray-500">
                                    <th class="py-3 pr-4">Teacher ID</th>
                                    <th class="py-3 pr-4">Name</th>
                                    <th class="py-3 pr-4">Specialization</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Recent Attendance --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Attendance</h3>
                        <a href="" class="text-sm text-indigo-600 hover:text-indigo-700">View All</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100 text-left text-gray-500">
                                    <th class="py-3 pr-4">Student ID</th>
                                    <th class="py-3 pr-4">Date</th>
                                    <th class="py-3 pr-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Recent Grades --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 xl:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Grades</h3>
                        <a href="" class="text-sm text-indigo-600 hover:text-indigo-700">View All</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100 text-left text-gray-500">
                                    <th class="py-3 pr-4">Student ID</th>
                                    <th class="py-3 pr-4">Exam Type</th>
                                    <th class="py-3 pr-4">Score</th>
                                    <th class="py-3 pr-4">Max Score</th>
                                    <th class="py-3 pr-4">Percentage</th>
                                    <th class="py-3 pr-4">Grade</th>
                                    <th class="py-3 pr-4">Term</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Footer Summary --}}
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-2xl shadow-sm p-6 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold">School System Control Center</h3>
                        <p class="text-sm text-indigo-100 mt-1">
                            You have access to users, roles, teachers, classes, students, subjects, attendance, and grades.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href=""
                           class="inline-flex items-center rounded-xl bg-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/20 transition">
                            Students
                        </a>
                        <a href=""
                           class="inline-flex items-center rounded-xl bg-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/20 transition">
                            Teachers
                        </a>
                        <a href=""
                           class="inline-flex items-center rounded-xl bg-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/20 transition">
                            Attendance
                        </a>
                        <a href=""
                           class="inline-flex items-center rounded-xl bg-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/20 transition">
                            Grades
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
