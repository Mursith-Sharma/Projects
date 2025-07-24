<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;

class HomeController extends Controller
{
    public function index()
    {
        // Total counts
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();

        // Get 5 most recent students
        $recentStudents = Student::orderByDesc('created_at')->take(5)->get();

        // Add formatted student_id (e.g., STU001) without touching the database
        $recentStudents = $recentStudents->map(function ($student) {
            $student->student_id = 'STU' . str_pad($student->id, 3, '0', STR_PAD_LEFT);
            return $student;
        });

        // Upcoming events (static for now)
        $upcomingEvents = collect([
            [
                'title' => 'Sports Day',
                'description' => 'Annual sports competition',
                'date' => now()->addDays(10)->format('Y-m-d'),
            ],
            [
                'title' => 'Parent-Teacher Meeting',
                'description' => 'Q2 review session',
                'date' => now()->addDays(15)->format('Y-m-d'),
            ],
            [
                'title' => 'Final Exams',
                'description' => 'Grade 9-12 final exams',
                'date' => now()->addDays(30)->format('Y-m-d'),
            ],
            [
                'title' => 'Library Week',
                'description' => 'Reading and storytelling week',
                'date' => now()->addDays(45)->format('Y-m-d'),
            ],
        ]);

        return view('home', compact(
            'totalStudents',
            'totalTeachers',
            'recentStudents',
            'upcomingEvents'
        ));
    }
}