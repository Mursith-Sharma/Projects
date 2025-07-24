<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudentViewController extends Controller
{
    public function index()
    {
        $students = Student::all();

        $newAdmissionsCount = $students->filter(function ($student) {
            return Carbon::parse($student->admission_date)->isCurrentMonth();
        })->count();

        return view('student_view', compact('students', 'newAdmissionsCount'));
    }


    public function destroy($id)                          
{
    try {
        $student = Student::findOrFail($id);
        $student->delete();
        
        return response()->json(['status' => 'success', 'message' => 'Student deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Failed to delete student'], 500);
    }
}

   public function update(Request $request, $id)
{
    $student = Student::findOrFail($id);
    
    $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'dob' => 'required|date',
        'gender' => 'required|string',
        'phone' => ['required', 'regex:/^(0\d{9}|\+94\d{9})$/'],
        'email' => 'nullable|email|unique:students,email,'.$id,
        'password' => 'nullable|string|min:8',
        'address' => 'required|string',
        'city' => 'required|string',
        'postal_code' => 'nullable|string',
        'grade' => 'required|string',
        'section' => 'required|string',
        'admission_date' => 'required|date',
        'previous_school' => 'nullable|string',
        'guardian_name' => 'required|string|max:255',
        'guardian_phone' => ['required', 'regex:/^(0\d{9}|\+94\d{9})$/'],
        'relation' => 'required|string',
    ], [
        'phone.regex' => 'Enter a valid mobile number',
        'guardian_phone.regex' => 'Enter a valid mobile number',
    ]);

    // Update password only if provided
    if ($request->filled('password')) {
        $validated['password'] = bcrypt($request->input('password'));
    } else {
        unset($validated['password']); // Remove from validated data if empty
    }

    // Handle email - set to null if empty
    if (empty($validated['email'])) {
        $validated['email'] = null;
    }

    $student->update($validated);
    
    return response()->json(['status' => 'success']);
}
}
