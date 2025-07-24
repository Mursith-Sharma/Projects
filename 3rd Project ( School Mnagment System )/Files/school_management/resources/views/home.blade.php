<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Lanka - School Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#10B981',
                        danger: '#EF4444',
                        warning: '#F59E0B',
                        info: '#3B82F6',
                        dark: '#1F2937',
                        light: '#F3F4F6',
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar { transition: all 0.3s ease; }
        .sidebar.collapsed { width: 70px; }
        .sidebar.collapsed .sidebar-text, .sidebar.collapsed .logo-text { display: none; }
        .sidebar.collapsed .nav-item { justify-content: center; }
        .main-content { transition: all 0.3s ease; }
        .sidebar.collapsed + .main-content { margin-left: 70px; }
        .active-nav {
            background-color: rgba(79, 70, 229, 0.1);
            border-left: 4px solid #4F46E5;
            color: #4F46E5;
        }
        .dropdown-content { display: none; position: absolute; right: 0; background-color: white; min-width: 200px; box-shadow: 0 8px 16px rgba(0,0,0,0.1); z-index: 1; border-radius: 0.5rem; }
        .dropdown:hover .dropdown-content { display: block; }
        .submenu { transition: all 0.2s ease; }
        .sidebar.collapsed .submenu { left: 70px; }
        .notification-badge {
            position: absolute; top: -5px; right: -5px; font-size: 10px;
            background-color: #EF4444; color: white; border-radius: 50%;
            width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;
        }
        @media (max-width: 768px) {
            .sidebar { position: absolute; z-index: 100; left: -250px; }
            .sidebar.show { left: 0; }
            .main-content { margin-left: 0 !important; }
            .sidebar-toggle { display: block !important; }
        }
    </style>
</head>
<body class="bg-gray-50">

@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('student'))
        <h1 class="text-2xl font-bold">Welcome, {{ session('student')->full_name }}!</h1>
        <p class="text-gray-600 mt-2">You are logged in as <strong>{{ ucfirst(session('student')->role) }}</strong></p>
    @else
        <p class="text-red-500">Not logged in.</p>
    @endif
</div>
@endsection

<!-- Sidebar Toggle Button (Mobile) -->
<button class="sidebar-toggle md:hidden fixed top-4 left-4 z-50 bg-white p-2 rounded-full shadow-md">
    <i class="fas fa-bars text-gray-600"></i>
</button>

<!-- Sidebar -->
<div class="sidebar fixed top-0 left-0 h-screen w-64 bg-white shadow-md z-40 md:w-64">
    <div class="flex items-center justify-between p-4 border-b">
        <div class="flex items-center space-x-2">
            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center">
                <i class="fas fa-graduation-cap text-white"></i>
            </div>
            <span class="logo-text text-xl font-bold text-primary">School Lanka</span>
        </div>
        <button class="sidebar-collapse-btn text-gray-500 hover:text-gray-700">
            <i class="fas fa-chevron-left"></i>
        </button>
    </div>

    <div class="p-4 border-b flex items-center space-x-3">
        <div class="relative">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Profile" class="w-12 h-12 rounded-full object-cover">
            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
        </div>
        <div>
            @if(session('student'))
                <p class="font-medium">{{ session('student')->full_name }}</p>
                <p class="text-sm text-gray-500">{{ ucfirst(session('student')->role) }}</p>
            @else
                <p class="font-medium">Guest</p>
                <p class="text-sm text-gray-500">Visitor</p>
            @endif
        </div>
    </div>

    <nav class="p-2">
        <ul class="space-y-1">
            <li>
                <a href="#" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 active-nav">
                    <i class="fas fa-tachometer-alt w-6 text-center"></i>
                    <span class="sidebar-text ml-3">Dashboard</span>
                </a>
            </li>
            <li class="group">
                <a href="#" class="nav-item flex items-center justify-between p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <div class="flex items-center">
                        <i class="fas fa-users w-6 text-center"></i>
                        <span class="sidebar-text ml-3">Students</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transform group-hover:rotate-180 transition-transform"></i>
                </a>
                <ul class="submenu hidden group-hover:block bg-white border-t border-gray-200 mt-1 py-1 space-y-1 w-full shadow-md rounded-b-lg z-50">
                    <li>
                       <a href="{{ route('view.students') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">View All Students</a>
                    </li>
                    <li>
                        <a href="{{ url('/student_admission') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Student Admission</a>
                    </li>
                    <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Class & Section</a></li>
                    <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Attendance Record</a></li>
                    <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Exams & Marks</a></li>
                    <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Fee Status</a></li>
                </ul>
            </li>
            <li class="group">
                <a href="#" class="nav-item flex items-center justify-between p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <div class="flex items-center">
                        <i class="fas fa-chalkboard-teacher w-6 text-center"></i>
                        <span class="sidebar-text ml-3">Teachers</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transform group-hover:rotate-180 transition-transform"></i>
                </a>
                <ul class="submenu hidden group-hover:block bg-white border-t border-gray-200 mt-1 py-1 space-y-1 w-full shadow-md rounded-b-lg z-50">
                <li>
                    <a href="{{ route('teachers.view') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">View All Teachers</a>
                </li>
                    <li>
                        <a href="{{ route('teacher.admission.form') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Teacher Admission</a>
                    </li>
                    <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Time Table</a></li>
                    <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Attendance Record</a></li>
                    <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Performance & Feedback</a></li>
                    <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Salary Status</a></li>
                </ul>
            </li>

            <li class="group">
                <a href="#" class="nav-item flex items-center justify-between p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <div class="flex items-center">
                        <i class="fas fa-book w-6 text-center"></i>
                        <span class="sidebar-text ml-3">Grades & Subjects</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transform group-hover:rotate-180 transition-transform"></i>
                </a>
                <ul class="submenu hidden group-hover:block bg-white border-t border-gray-200 mt-1 py-1 space-y-1 w-full shadow-md rounded-b-lg z-50">
                    
                     <li>
                         <a href="{{ route('grades.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Grades & Sections</a>
                     </li>
                     <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Subjects</a></li>
                     <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Grades Time table</a></li>
                     <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">Fee Status</a></li>
                </ul>
            </li>

            <li><a href="#" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100"><i class="fas fa-calendar-alt w-6 text-center"></i><span class="sidebar-text ml-3">Timetable</span></a></li>
            <li><a href="#" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100"><i class="fas fa-clipboard-check w-6 text-center"></i><span class="sidebar-text ml-3">Attendance</span></a></li>
            <li><a href="#" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100"><i class="fas fa-file-alt w-6 text-center"></i><span class="sidebar-text ml-3">Exams & Marks</span></a></li>
            <li><a href="#" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100"><i class="fas fa-money-bill-wave w-6 text-center"></i><span class="sidebar-text ml-3">Fees Management</span></a></li>
            <li><a href="#" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100"><i class="fas fa-bullhorn w-6 text-center"></i><span class="sidebar-text ml-3">Announcements</span></a></li>
            <li><a href="#" class="nav-item flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100"><i class="fas fa-cog w-6 text-center"></i><span class="sidebar-text ml-3">Settings</span></a></li>
        </ul>
    </nav>
</div>
    <!-- Main Content -->
    <div class="main-content md:ml-64 min-h-screen">
        <!-- Top Navigation -->
<!-- Top Navigation -->
<header class="bg-white shadow-sm">
    <div class="flex items-center justify-between p-4">
        <div class="flex items-center space-x-4">
            <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
        </div>
        
        <div class="flex items-center space-x-2 sm:space-x-4">
            <!-- Search -->
            <div class="relative hidden sm:block">
                <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            
            <!-- Notifications -->
            <div class="relative">
                <button class="notification-btn p-2 rounded-full hover:bg-gray-100 relative">
                    <i class="fas fa-bell text-gray-600"></i>
                    <span class="notification-badge">3</span>
                </button>
                <!-- Notification Dropdown -->
                <div class="dropdown-content hidden w-80 right-0 mt-2 p-0">
                    <div class="border-b p-3 flex justify-between items-center">
                        <h3 class="font-medium">Notifications</h3>
                        <button class="text-primary text-sm">Mark all as read</button>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        <a href="#" class="block p-3 hover:bg-gray-50 border-b">
                            <div class="flex items-start space-x-3">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-full">
                                    <i class="fas fa-user-graduate text-primary"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">New student registered</p>
                                    <p class="text-xs text-gray-500">John Doe enrolled in Grade 10</p>
                                    <p class="text-xs text-gray-400 mt-1">2 mins ago</p>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="block p-3 hover:bg-gray-50 border-b">
                            <div class="flex items-start space-x-3">
                                <div class="bg-warning bg-opacity-10 p-2 rounded-full">
                                    <i class="fas fa-money-bill-wave text-warning"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Fee payment reminder</p>
                                    <p class="text-xs text-gray-500">5 students have pending fees</p>
                                    <p class="text-xs text-gray-400 mt-1">1 hour ago</p>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="block p-3 hover:bg-gray-50 border-b">
                            <div class="flex items-start space-x-3">
                                <div class="bg-info bg-opacity-10 p-2 rounded-full">
                                    <i class="fas fa-calendar-alt text-info"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Upcoming event</p>
                                    <p class="text-xs text-gray-500">Parent-Teacher meeting tomorrow</p>
                                    <p class="text-xs text-gray-400 mt-1">3 hours ago</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="border-t p-3 text-center">
                        <a href="#" class="text-primary text-sm font-medium">View all notifications</a>
                    </div>
                </div>
            </div>
            
            <!-- WhatsApp Contact -->
            <div class="relative">
                <a href="https://wa.me/760011886" target="_blank" class="whatsapp-btn p-2 rounded-full hover:bg-gray-100 relative">
                    <i class="fab fa-whatsapp text-green-500"></i>
                </a>
            </div>
            
            <!-- User Dropdown -->
            <div class="dropdown relative">
                <button class="flex items-center space-x-2 focus:outline-none">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg " alt="Profile" class="w-8 h-8 rounded-full">
                    <span class="hidden md:inline-block">
                        @if(session('teacher'))
                            {{ session('teacher')->full_name }}
                        @elseif(session('student'))
                            {{ session('student')->full_name }}
                        @else
                            Guest
                        @endif
                    </span>
                    <i class="fas fa-chevron-down text-xs hidden md:inline-block"></i>
                </button>
                <div class="dropdown-content hidden right-0 mt-2">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user mr-2"></i> Profile
                    </a>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-cog mr-2"></i> Settings
                    </a>
                    <div class="border-t"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

        <!-- Dashboard Content -->
        <main class="p-2 sm:p-4">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Total Students</p>
                <h3 id="totalStudents" class="text-2xl font-bold">{{ number_format($totalStudents) }}</h3>
            </div>
            <div class="bg-primary bg-opacity-10 p-3 rounded-full">
                <i class="fas fa-users text-primary text-xl"></i>
            </div>
        </div>
        <p class="text-sm text-green-500 mt-2"><i class="fas fa-arrow-up"></i> 12% from last month</p>
    </div>

    <!-- Total Teachers -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500">Total Teachers</p>
                <h3 id="totalTeachers" class="text-2xl font-bold">{{ number_format($totalTeachers) }}</h3>
            </div>
            <div class="bg-blue-500 bg-opacity-10 p-3 rounded-full">
                <i class="fas fa-chalkboard-teacher text-blue-600 text-xl"></i>
            </div>
        </div>
        <p class="text-sm text-green-500 mt-2"><i class="fas fa-arrow-up"></i> 8% from last month</p>
    </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500">Today's Attendance</p>
                            <h3 class="text-2xl font-bold">92%</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-full">
                            <i class="fas fa-clipboard-check text-warning text-xl"></i>
                        </div>
                    </div>
                    <p class="text-sm text-red-500 mt-2"><i class="fas fa-arrow-down"></i> 3% from yesterday</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500">Fees Collected</p>
                            <h3 class="text-2xl font-bold">$24,580</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-full">
                            <i class="fas fa-money-bill-wave text-info text-xl"></i>
                        </div>
                    </div>
                    <p class="text-sm text-green-500 mt-2"><i class="fas fa-arrow-up"></i> 8% from last month</p>
                </div>
            </div>

            <!-- Charts and Recent Activities -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mb-6">
                <!-- Attendance Chart -->
                <div class="bg-white rounded-lg shadow p-4 lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-medium">Weekly Attendance</h3>
                        <select class="border rounded px-2 py-1 text-sm">
                            <option>This Week</option>
                            <option>Last Week</option>
                            <option>Last Month</option>
                        </select>
                    </div>
                    <div class="h-64">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                </div>
                
                <!-- Recent Activities -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="font-medium mb-4">Recent Activities</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-full">
                                <i class="fas fa-user-plus text-primary"></i>
                            </div>
                            <div>
                                <p class="text-sm">New student <span class="font-medium">John Doe</span> enrolled</p>
                                <p class="text-xs text-gray-500">Grade 10, Section A</p>
                                <p class="text-xs text-gray-400 mt-1">10 mins ago</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="bg-secondary bg-opacity-10 p-2 rounded-full">
                                <i class="fas fa-book text-secondary"></i>
                            </div>
                            <div>
                                <p class="text-sm">New subject <span class="font-medium">Computer Science</span> added</p>
                                <p class="text-xs text-gray-500">Assigned to Mr. Smith</p>
                                <p class="text-xs text-gray-400 mt-1">45 mins ago</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="bg-warning bg-opacity-10 p-2 rounded-full">
                                <i class="fas fa-money-bill-wave text-warning"></i>
                            </div>
                            <div>
                                <p class="text-sm"><span class="font-medium">5 students</span> paid their fees</p>
                                <p class="text-xs text-gray-500">Total $1,250 collected</p>
                                <p class="text-xs text-gray-400 mt-1">2 hours ago</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="bg-info bg-opacity-10 p-2 rounded-full">
                                <i class="fas fa-calendar-alt text-info"></i>
                            </div>
                            <div>
                                <p class="text-sm">New event <span class="font-medium">Sports Day</span> scheduled</p>
                                <p class="text-xs text-gray-500">15th June, 2023</p>
                                <p class="text-xs text-gray-400 mt-1">5 hours ago</p>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="block text-center text-primary text-sm font-medium mt-4">View all activities</a>
                </div>
            </div>

<!-- Recent Students and Upcoming Events -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
    <!-- Recent Students -->
    <div class="bg-white rounded-lg shadow p-4 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-medium">Recent Students</h3>
            <a href="{{ route('view.students') }}" class="text-primary text-sm font-medium">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admission Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($recentStudents as $student)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-0">
                                        <div class="text-sm font-medium text-gray-900">{{ $student->full_name }}</div>
                                        <div class="text-sm text-gray-500">ID: {{ $student->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $student->grade }}</div>
                                <div class="text-sm text-gray-500">Section {{ $student->section }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($student->admission_date)->format('d M, Y') }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($student->gender == 'male') 
                                        bg-blue-100 text-blue-800
                                    @elseif($student->gender == 'female') 
                                        bg-pink-100 text-pink-800
                                    @else 
                                        bg-gray-100 text-gray-800 
                                    @endif">
                                    {{ ucfirst($student->gender) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('view.students') }}" class="text-primary hover:text-primary-dark mr-3">View</a>
                                <a href="{{ route('view.students') }}" class="text-secondary hover:text-secondary-dark">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">No recent students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>   

    <!-- Upcoming Events -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-medium">Upcoming Events</h3>
            <a href="#" class="text-primary text-sm font-medium">View All</a>
        </div>
        <div class="space-y-4">
            <div class="border rounded-lg p-3 hover:border-primary transition-colors">
                <div class="flex items-start space-x-3">
                    <div class="bg-primary text-white p-2 rounded-lg text-center min-w-12">
                        <p class="text-sm font-bold">15</p>
                        <p class="text-xs">JUN</p>
                    </div>
                    <div>
                        <h4 class="font-medium">Sports Day</h4>
                        <p class="text-sm text-gray-500">Annual sports competition</p>
                        <div class="flex items-center text-xs text-gray-400 mt-1">
                            <i class="fas fa-clock mr-1"></i>
                            <span>9:00 AM - 3:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border rounded-lg p-3 hover:border-secondary transition-colors">
                <div class="flex items-start space-x-3">
                    <div class="bg-secondary text-white p-2 rounded-lg text-center min-w-12">
                        <p class="text-sm font-bold">20</p>
                        <p class="text-xs">JUN</p>
                    </div>
                    <div>
                        <h4 class="font-medium">Parent-Teacher Meeting</h4>
                        <p class="text-sm text-gray-500">Term 1 evaluation</p>
                        <div class="flex items-center text-xs text-gray-400 mt-1">
                            <i class="fas fa-clock mr-1"></i>
                            <span>10:00 AM - 2:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border rounded-lg p-3 hover:border-warning transition-colors">
                <div class="flex items-start space-x-3">
                    <div class="bg-warning text-white p-2 rounded-lg text-center min-w-12">
                        <p class="text-sm font-bold">25</p>
                        <p class="text-xs">JUN</p>
                    </div>
                    <div>
                        <h4 class="font-medium">Mid-Term Exams</h4>
                        <p class="text-sm text-gray-500">Grade 6-12</p>
                        <div class="flex items-center text-xs text-gray-400 mt-1">
                            <i class="fas fa-clock mr-1"></i>
                            <span>8:00 AM - 12:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border rounded-lg p-3 hover:border-info transition-colors">
                <div class="flex items-start space-x-3">
                    <div class="bg-info text-white p-2 rounded-lg text-center min-w-12">
                        <p class="text-sm font-bold">30</p>
                        <p class="text-xs">JUN</p>
                    </div>
                    <div>
                        <h4 class="font-medium">Science Fair</h4>
                        <p class="text-sm text-gray-500">Student projects exhibition</p>
                        <div class="flex items-center text-xs text-gray-400 mt-1">
                            <i class="fas fa-clock mr-1"></i>
                            <span>10:00 AM - 4:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        </main>
    </div>

    <!-- Add Student Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden" id="addStudentModal">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-2 sm:mx-0">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-lg font-medium">Add New Student</h3>
                <button class="text-gray-500 hover:text-gray-700 modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                <form>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                            <input type="date" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                            <select class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option>Select Class</option>
                                <option>Grade 1</option>
                                <option>Grade 2</option>
                                <option>Grade 3</option>
                                <option>Grade 4</option>
                                <option>Grade 5</option>
                                <option>Grade 6</option>
                                <option>Grade 7</option>
                                <option>Grade 8</option>
                                <option>Grade 9</option>
                                <option>Grade 10</option>
                                <option>Grade 11</option>
                                <option>Grade 12</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                            <select class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option>Select Section</option>
                                <option>Section A</option>
                                <option>Section B</option>
                                <option>Section C</option>
                                <option>Section D</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Parent/Guardian Name</label>
                            <input type="text" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Parent/Guardian Phone</label>
                            <input type="tel" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <textarea rows="2" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Profile Photo</label>
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <button type="button" class="px-3 py-1 bg-gray-100 rounded-lg text-sm">Upload</button>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" class="px-4 py-2 border rounded-lg modal-close">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark">Save Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sidebar toggle functionality
        const sidebar = document.querySelector('.sidebar');
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const sidebarCollapseBtn = document.querySelector('.sidebar-collapse-btn');
        const mainContent = document.querySelector('.main-content');

        // Mobile sidebar toggle
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });

        // Desktop sidebar collapse
        sidebarCollapseBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

        // Close mobile sidebar when clicking outside
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768 && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });

        // Modal functionality
        const addStudentModal = document.getElementById('addStudentModal');
        const modalCloseButtons = document.querySelectorAll('.modal-close');

        modalCloseButtons.forEach(button => {
            button.addEventListener('click', () => {
                addStudentModal.classList.add('hidden');
            });
        });

        // Chart initialization
        const attendanceChartCtx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceChart = new Chart(attendanceChartCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                datasets: [{
                    label: 'Attendance Percentage',
                    data: [92, 95, 90, 94, 93, 85],
                    borderColor: '#4F46E5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#4F46E5',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });

        // Dropdown functionality
        const dropdowns = document.querySelectorAll('.dropdown');
        
        dropdowns.forEach(dropdown => {
            const button = dropdown.querySelector('button');
            const content = dropdown.querySelector('.dropdown-content');
            
            button.addEventListener('click', () => {
                content.style.display = content.style.display === 'block' ? 'none' : 'block';
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target)) {
                    content.style.display = 'none';
                }
            });
        });

        // Notification button functionality
        const notificationBtn = document.querySelector('.notification-btn');
        const notificationDropdown = document.querySelector('.notification-btn + .dropdown-content');
        
        notificationBtn.addEventListener('click', () => {
            notificationDropdown.style.display = notificationDropdown.style.display === 'block' ? 'none' : 'block';
        });
    </script>
</body>
</html>