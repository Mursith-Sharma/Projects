<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Validator;

class TeacherViewController extends Controller
{
    /**
     * Display the teacher management view.
     */
    public function index()
    {
        $teachers = Teacher::all();

        $teachersData = $teachers->map(function ($teacher) {
            return [
                'id' => $teacher->id,
                'name' => $teacher->full_name,
                'email' => $teacher->email,
                'contact' => $teacher->phone,
                'gender' => $teacher->gender,
                'dob' => $teacher->dob,
                'address' => $teacher->address,
                'city' => $teacher->city,
                'postal_code' => $teacher->postal_code,
                'qualification' => $teacher->qualification,
                'specialization' => $teacher->specialization,
                'experience' => $teacher->experience,
                'previous_institution' => $teacher->previous_institution,
                'joiningDate' => $teacher->joining_date,
                'emergency_name' => $teacher->emergency_name,
                'emergency_phone' => $teacher->emergency_phone,
                'relation' => $teacher->relation,
                'role' => $teacher->role,
                'designation' => json_decode($teacher->designations, true) ?? [],
                'grades' => json_decode($teacher->grade_sections, true) ?? [],
            ];
        });

        return view('teacher_view', compact('teachersData'));
    }

    /**
     * Update the specified teacher in storage.
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^(\+94|0)[1-9][0-9]{8}$/'],
            'email' => 'nullable|email|max:255|unique:teachers,email,' . $id,
            'gender' => 'required|in:male,female,other',
            'dob' => 'required|date|before:today',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'experience' => 'required|integer|min:0',
            'joining_date' => 'required|date|after_or_equal:today',
            'previous_institution' => 'nullable|string|max:255',
            'emergency_name' => 'required|string|max:255',
            'emergency_phone' => ['required', 'regex:/^(\+94|0)[1-9][0-9]{8}$/'],
            'relation' => 'required|in:Spouse,Parent,Sibling,Friend,Other',
            'grade_sections' => 'required|array|min:1',
            'grade_sections.*.grade' => 'required|integer|between:1,12',
            'grade_sections.*.sections' => 'required|array|min:1',
            'grade_sections.*.sections.*' => 'string|in:A,B,C,D,E,F,G,H,I,J',
            'designations' => 'nullable|array',
            'designations.*' => 'string',
        ], [
            'phone.regex' => 'Please enter a valid Sri Lankan phone number (e.g., +947XXXXXXXX or 07XXXXXXXX)',
            'emergency_phone.regex' => 'Please enter a valid emergency phone number.',
            'grade_sections.*.grade.required' => 'Please select a grade.',
            'grade_sections.*.sections.required' => 'Select at least one section per grade.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Format grade sections safely
        $gradeSections = collect($request->input('grade_sections'))->map(function ($item) {
            return [
                'grade' => (int)$item['grade'],
                'sections' => is_array($item['sections']) ? $item['sections'] : []
            ];
        })->toArray();

        // Update teacher
        $teacher->update([
            'full_name' => $request->input('full_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'gender' => $request->input('gender'),
            'dob' => $request->input('dob'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'postal_code' => $request->input('postal_code'),
            'qualification' => $request->input('qualification'),
            'specialization' => $request->input('specialization'),
            'experience' => (int)$request->input('experience'),
            'joining_date' => $request->input('joining_date'),
            'previous_institution' => $request->input('previous_institution'),
            'emergency_name' => $request->input('emergency_name'),
            'emergency_phone' => $request->input('emergency_phone'),
            'relation' => $request->input('relation'),
            'role' => $request->input('role', 'teacher'), // fallback
            'grade_sections' => json_encode($gradeSections),
            'designations' => $request->has('designations') ? json_encode($request->input('designations')) : null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Teacher updated successfully!',
        ]);
    }

    /**
     * Remove the specified teacher from storage.
     */
    public function destroy(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Teacher deleted successfully!'
        ]);
    }
}