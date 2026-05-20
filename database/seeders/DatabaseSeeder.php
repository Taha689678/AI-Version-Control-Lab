<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Create Teacher
        $teacherUser = User::create([
            'name' => 'Dr. Smith',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);
        
        // Create Teacher Profile
        $teacherProfile = $teacherUser->teacherProfile()->create([
            'phone' => '123-456-7890',
            'subject' => 'Physics',
        ]);

        // 3. Create Student
        $studentUser = User::create([
            'name' => 'Ali Student',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        // Create Student Profile
        $studentProfile = $studentUser->studentProfile()->create([
            'phone' => '098-765-4321',
            'class' => 'FSC Part 1',
            'enrollment_date' => now(),
        ]);

        // 4. Create a Course
        // Note: Course belongs to a Teacher Profile, not User directly
        $course = Course::create([
            'name' => 'Introduction to Laravel', // Changed from title to name
            'course_code' => 'CS-101',
            'description' => 'Learn the basics of Laravel framework.',
            'teacher_id' => $teacherProfile->id,
        ]);

        // 5. Enroll Student
        // Note: Enrollment links to Student Profile, not User directly
        Enrollment::create([
            'student_id' => $studentProfile->id,
            'course_id' => $course->id,
            'status' => 'active',
        ]);

        // 6. Create more demo users (Optional, but need profiles if we want them functional)
        // For simplicity, we'll stick to the specific ones above to avoid factory complexity for now.
    }
}
