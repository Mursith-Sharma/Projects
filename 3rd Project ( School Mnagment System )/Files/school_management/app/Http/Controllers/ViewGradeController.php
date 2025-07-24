<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class ViewGradeController extends Controller
{
public function index(Request $request)
{
    $selectedGrade = $request->input('grade');
    $allTeachers = Teacher::all();

    if ($selectedGrade === 'all' || $selectedGrade === null) {
        // Show all teachers when no grade is selected or "all" is passed
        $filteredTeachers = $allTeachers;

        // Calculate total sections across all grades
        $totalSections = 0;
        foreach ($filteredTeachers as $teacher) {
            $gradeSections = json_decode($teacher->grade_sections ?? '[]', true);
            foreach ($gradeSections as $entry) {
                $totalSections += count($entry['sections'] ?? []);
            }
        }
    } else {
        // Filter teachers based on selected grade
        $filteredTeachers = $allTeachers->filter(function ($teacher) use ($selectedGrade) {
            $gradeSections = json_decode($teacher->grade_sections ?? '[]', true);

            foreach ($gradeSections as $entry) {
                if (isset($entry['grade']) && $entry['grade'] == (int)$selectedGrade) {
                    return true;
                }
            }
            return false;
        });

        // Stats calculation for selected grade
        $totalSections = 0;
        foreach ($filteredTeachers as $teacher) {
            $gradeSections = json_decode($teacher->grade_sections ?? '[]', true);
            foreach ($gradeSections as $entry) {
                if ($entry['grade'] == $selectedGrade) {
                    $totalSections += count($entry['sections'] ?? []);
                }
            }
        }
    }

    $assignedTeachers = $filteredTeachers->count();

    return view('grade_view', [
        'teachers' => $filteredTeachers,
        'selectedGrade' => $selectedGrade,
        'totalSections' => $totalSections,
        'assignedTeachers' => $assignedTeachers,
        'recentActivities' => $this->getRecentActivities()
    ]);
}


    // ✅ Add this method separately
public function getRecentActivities()
{
    return [
        [
            'message' => 'Assigned Mr. John to Grade 6 - A',
            'date' => '2025-07-20',
            'time' => '10:45 AM',
            'color' => 'green',
            'icon' => 'user-check',
        ],
        [
            'message' => 'Added new section to Grade 8',
            'date' => '2025-07-19',
            'time' => '02:15 PM',
            'color' => 'blue',
            'icon' => 'plus-square',
        ],
    ];
}

}
