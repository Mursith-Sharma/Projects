<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\GradeSection;

class Teacher extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'full_name',
        'dob',
        'gender',
        'phone',
        'email',
        'password',
        'role',
        'address',
        'city',
        'postal_code',
        'qualification',
        'specialization',
        'experience',
        'joining_date',
        'previous_institution',
        'grade_sections', // Changed from preferred_grades
        'designations',
        'resume_path',
        'emergency_name',
        'emergency_phone',
        'relation',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'dob' => 'date',
        'joining_date' => 'date',
        'grade_sections' => 'array',
        'designations' => 'array',
    ];

//     public function grades()
// {
//     return $this->hasMany(GradeSection::class, 'teacher_id');
// }
    public function getGradeSectionsFormatted(): array
    {
        if (empty($this->grade_sections)) {
            return [];
        }

        return array_map(function($assignment) {
            return sprintf(
                'Grade %d: Sections %s', 
                $assignment['grade'], 
                implode(', ', $assignment['sections'])
            );
        }, $this->grade_sections);
    }

    /**
     * Check if teacher is assigned to specific grade-section
     */
    public function teachesIn(int $grade, string $section): bool
    {
        if (empty($this->grade_sections)) {
            return false;
        }

        foreach ($this->grade_sections as $assignment) {
            if ($assignment['grade'] == $grade && 
                in_array($section, $assignment['sections'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all assigned grades
     */
    public function getAssignedGrades(): array
    {
        return array_map(
            fn($assignment) => $assignment['grade'],
            $this->grade_sections ?? []
        );
    }
}