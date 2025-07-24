<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentAdmissionController extends Controller
{
    // Form காண்பிக்கிறது
    public function showForm()
    {
        return view('student_admission');
    }

    // Data சேமிக்கிறது
public function store(Request $request)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'dob' => 'required|date',
        'gender' => 'required|string',
        'phone' => ['required', 'regex:/^(0\d{9}|\+94\d{9})$/'],
        'email' => 'nullable|email|unique:students,email', 
        'password' => 'nullable|string|min:8',
        'role' => 'required|string',
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
        'email.unique' => 'Email already exist.',
         'phone.regex' => 'Enter a valid mobile number',
         'guardian_phone.regex' => 'Enter a valid mobile number',
    ]);


        $student = new Student();
        $student->full_name = $request->input('full_name');
        $student->dob = $request->input('dob');
        $student->gender = $request->input('gender');
        $student->phone = $request->input('phone');
        $student->email = $request->input('email');
        $student->password = $request->filled('password') ? bcrypt($request->input('password')) : null;
        $student->role = $request->input('role');
        $student->address = $request->input('address');
        $student->city = $request->input('city');
        $student->postal_code = $request->input('postal_code');
        $student->grade = $request->input('grade');
        $student->section = $request->input('section');
        $student->admission_date = $request->input('admission_date');
        $student->previous_school = $request->input('previous_school');
        $student->guardian_name = $request->input('guardian_name');
        $student->guardian_phone = $request->input('guardian_phone');
        $student->relation = $request->input('relation');

        $student->save();

        return redirect()->back()->with('success', 'Student admitted successfully!');
    }
}
