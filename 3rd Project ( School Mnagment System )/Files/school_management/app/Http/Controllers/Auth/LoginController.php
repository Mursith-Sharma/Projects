<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login logic
    public function login(Request $request)
    {
        // Validate user input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'role'     => 'required',
        ]);

        // Find user by email (check both students and teachers tables)
        $student = Student::where('email', $request->email)->first();
        $teacher = Teacher::where('email', $request->email)->first();

        $user = $teacher ?? $student;
        
        if (!$user) {
            return back()->withErrors(['login_error' => 'Incorrect Email or Role.'])->withInput();
        }

        // Check password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login_error' => 'Incorrect password.'])->withInput();
        }

        // Handle role-specific logic
        $requestedRole = strtolower($request->role);
        $userRole = strtolower($user->role);

        // Special cases for role flexibility
        $validRoles = [
            'student' => ['student', 'parent'],
            'teacher' => ['teacher', 'librarian'],
            'librarian' => ['teacher', 'librarian']
        ];

        if (!isset($validRoles[$userRole])) {
            // For roles without special cases, require exact match
            if ($requestedRole !== $userRole) {
                return back()->withErrors(['login_error' => 'Incorrect role for this account.'])->withInput();
            }
        } else {
            // For roles with special cases, check if requested role is allowed
            if (!in_array($requestedRole, $validRoles[$userRole])) {
                return back()->withErrors(['login_error' => 'Incorrect role for this account.'])->withInput();
            }
        }

        // Successful login
        if ($teacher) {
            Session::put('teacher', $user);
            Session::put('user_type', 'teacher');
        } else {
            Session::put('student', $user);
            Session::put('user_type', 'student');
        }
        
        Session::put('current_role', $request->role);

        return redirect()->route('home')->with('success', 'Login successful!');
    }

    // Handle logout
 public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login')->with('success', 'Logged out successfully!');
}
}