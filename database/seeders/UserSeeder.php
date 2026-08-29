<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password'),
                'status'   => 0,
                'profile_photo' => "/home/ahmad3-4/Desktop/php/school_mangment_system/storage/app/public/profiles/essmkN1JqUEgVouVqHMrw3axRSf06DS3eEu94yYy.jpg",
            ]
        );
        $admin->assignRole('admin');

        // Teacher
        $teacherUser = User::firstOrCreate(
            ['email' => 'teacher@example.com',],
            [
                'name'     => 'Teacher User',
                'password' => Hash::make('password'),
                'status'   => 0,
                'profile_photo' => "/home/ahmad3-4/Desktop/php/school_mangment_system/storage/app/public/profiles/essmkN1JqUEgVouVqHMrw3axRSf06DS3eEu94yYy.jpg",
            ]
        );
        $teacherUser->assignRole('teacher');

        Teacher::firstOrCreate(
            ['user_id' => $teacherUser->id],
            [
                'teacher_id'     => 'TCH-0001',
                'phone'          => '0599999999',
                'specialization' => 'Mathematics',
                'hire_date'      => now()->subYear(),
                'address'        => 'Amman',
            ]
        );

        // Student
        $studentUser = User::firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name'     => 'Student User',
                'password' => Hash::make('password'),
                'status'   => 0,
                'profile_photo' => "/home/ahmad3-4/Desktop/php/school_mangment_system/storage/app/public/profiles/essmkN1JqUEgVouVqHMrw3axRSf06DS3eEu94yYy.jpg",
            ]
        );
        $studentUser->assignRole('student');

        // make sure at least one classroom exists to attach the student to
        $classroom = Classes::first();

        Student::firstOrCreate(
            ['user_id' => $studentUser->id],
            [
                'student_id'      => 'STU-0001',
                'class_id'        => $classroom->id,
                'phone'           => '0588888888',
                'birth_date'      => '2010-01-01',
                'address'         => 'Amman',
                'guardian_name'   => 'Guardian Name',
                'guardian_phone'  => '0577777777',
            ]
        );
    }

}
