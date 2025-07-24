<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;  // for home route
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StudentAdmissionController;
use App\Http\Controllers\StudentViewController;
use App\Http\Controllers\TeacherAdmissionController;
use App\Http\Controllers\ViewGradeController;
use App\Http\Controllers\TeacherViewController;




Route::get('/', function () {
    return view('welcome');
});



// To show the form
Route::get('/student_admission', [StudentAdmissionController::class, 'showForm'])->name('student_admission_form');
// To handle the POST submission
Route::post('/student_admission', [StudentAdmissionController::class, 'store'])->name('student_admission');


Route::get('/home', [HomeController::class, 'index'])->name('home');    //home


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');   // login
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');   // login


Route::put('/students/{id}', [StudentViewController::class, 'update'])->name('students.update');   //update
Route::get('/view_students', [StudentViewController::class, 'index'])->name('view.students');         // view
Route::delete('/students/{id}', [StudentViewController::class, 'destroy'])->name('students.destroy');   //delete

// Teacher Admission Routes
Route::get('/teacher_admission', [TeacherAdmissionController::class, 'showForm'])->name('teacher.admission.form');
Route::post('/teacher_admission', [TeacherAdmissionController::class, 'submitForm'])->name('teacher.admission.submit');

Route::get('/grades', [ViewGradeController::class, 'index'])->name('grades.index');
Route::get('/grades/create', [ViewGradeController::class, 'create'])->name('grades.create');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/teachers_view', [TeacherViewController::class, 'index'])->name('teachers.view');
Route::get('/teacher/registration', [TeacherController::class, 'showRegistrationForm'])
     ->name('teacher_registration_form');

// Edit Teacher
Route::get('/teachers/{id}/edit', [TeacherViewController::class, 'edit'])->name('teachers.edit');
Route::post('/teachers/{id}', [TeacherViewController::class, 'update'])->name('teachers.update');
Route::delete('/teachers/{id}', [TeacherViewController::class, 'destroy'])->name('teachers.destroy');
// routes/web.php

Route::put('/teachers/{id}', [TeacherViewController::class, 'update'])->name('teachers.update');
?>