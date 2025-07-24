<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TeacherAdmissionController extends Controller
{
    public function showForm()
    {
        return view('teacher_admission');
    }

    public function submitForm(Request $request)
    {
        // Custom validation messages
        \Log::info('Form submission started', $request->all());
        $messages = [
            'grade_section.required' => 'Please add at least one grade and section assignment.',
            'grade_section.*.grade.required' => 'Please select a grade.',
            'grade_section.*.sections.required' => 'Please select at least one section for each grade.',
            'resume.mimes' => 'The resume must be a file of type: pdf, doc, docx.',
            'resume.max' => 'The resume may not be greater than 5MB.',
            'phone.regex' => 'Please enter a valid Sri Lankan phone number (e.g., +947XXXXXXXX or 07XXXXXXXX)',
            'emergency_phone.regex' => 'Please enter a valid Sri Lankan phone number (e.g., +947XXXXXXXX or 07XXXXXXXX)',
        ];

        // Validation rules
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'dob' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'phone' => ['required', 'regex:/^(\+94|0)[1-9][0-9]{8}$/'],
            'email' => 'nullable|email|max:255|unique:teachers,email',
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|in:teacher',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'qualification' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'experience' => 'required|integer|min:0',
            'joining_date' => 'required|date|after_or_equal:today',
            'previous_institution' => 'nullable|string|max:255',
            'grade_section' => 'required|array|min:1',
            'grade_section.*.grade' => 'required|integer|between:1,12',
            'grade_section.*.sections' => 'required|array|min:1',
            'grade_section.*.sections.*' => 'string|in:A,B,C,D,E,F,G,H,I,J',
            'designations' => 'nullable|array',
            'designations.*' => 'string|in:Principal,Vice Principal,Head of Department (HOD),Senior Teacher,Assistant Teacher,Co-Class Teacher,Substitute Teacher,Trainee Teacher,Librarian,Physical/Sports Instructor,Counselor,Coordinator',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'emergency_name' => 'required|string|max:255',
            'emergency_phone' => ['required', 'regex:/^(\+94|0)[1-9][0-9]{8}$/'],
            'relation' => 'required|string|in:Spouse,Parent,Sibling,Friend,Other',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Format grade-section assignments
        $gradeSections = [];
        foreach ($request->grade_section as $assignment) {
            $gradeSections[] = [
                'grade' => (int)$assignment['grade'], // Explicitly cast to integer
                'sections' => $assignment['sections']
            ];
        }

        // Handle file upload
        $resumePath = null;
        if ($request->hasFile('resume') && $request->file('resume')->isValid()) {
            $resumeName = 'resume_' . Str::random(10) . '.' . $request->file('resume')->getClientOriginalExtension();
            $resumePath = $request->file('resume')->storeAs('resumes', $resumeName, 'public');
        }

        // Create teacher record
        $teacher = Teacher::create([
            'full_name' => $request->full_name,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : null,
            'role' => $request->role,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'qualification' => $request->qualification,
            'specialization' => $request->specialization,
            'experience' => $request->experience,
            'joining_date' => $request->joining_date,
            'previous_institution' => $request->previous_institution,
            'grade_sections' => json_encode($gradeSections), // Fixed missing comma
            'designations' => $request->designations ? json_encode($request->designations) : null,
            'resume_path' => $resumePath,
            'emergency_name' => $request->emergency_name,
            'emergency_phone' => $request->emergency_phone,
            'relation' => $request->relation,
        ]);

        return redirect()->route('teacher.admission.form')
            ->with('success', 'Teacher application submitted successfully!');
    }
}