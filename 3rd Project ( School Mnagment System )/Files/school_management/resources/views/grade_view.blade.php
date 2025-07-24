<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Grade Management | School System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
</head>
<body class="bg-gray-50 min-h-screen">
<header class="bg-white shadow-sm">
    <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <button
                onclick="window.history.back()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center"
            >
                <i class="fas fa-arrow-left mr-2"></i> Previous
            </button>
            <h1 class="text-xl font-bold text-gray-800">School Management System</h1>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600"
                >Admin Dashboard</a
            >
            <div
                class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white"
            >
                <i class="fas fa-user"></i>
            </div>
        </div>
    </nav>
</header>

<main class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Grades</h2>
    </div>

    <!-- Grade Filter -->
    <div
        class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4"
    >
        <form method="GET" action="{{ route('grades.index') }}" class="w-full md:w-64">
            <select
                name="grade"
                id="grade-filter"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
                <option value="">All Grades</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option
                        value="{{ $i }}"
                        {{ request('grade') == $i ? 'selected' : '' }}
                    >
                        Grade {{ $i }}
                    </option>
                @endfor
            </select>
        </form>
        <button
            onclick="window.location.href='{{ route('grades.create') }}'"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center w-full md:w-auto"
        >
            <i class="fas fa-plus mr-2"></i> Add New Grade
        </button>
    </div>

    <!-- Display selected grade heading if filtered -->
    @if(request('grade'))
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-800">
                Grade {{ request('grade') }}
            </h3>
        </div>
    @endif

    <!-- Statistics -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Quick Stats</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Total Sections</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalSections }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Teachers Arranged</p>
                    <p class="text-2xl font-bold text-green-600">{{ $assignedTeachers }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Recent Activity</h3>
            <ul class="space-y-3">
                @foreach($recentActivities as $activity)
                    <li class="flex items-start">
                        <div
                            class="bg-{{ $activity['color'] }}-100 p-2 rounded-full mr-3"
                        >
                            <i
                                class="fas fa-{{ $activity['icon'] }} text-{{ $activity['color'] }}-600 text-sm"
                            ></i>
                        </div>
                        <div>
                            <p class="text-sm">{{ $activity['message'] }}</p>
                            <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Teachers Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden mt-8">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Section
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Class Teacher
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Designation
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $sectionsData = [];
                        foreach ($teachers as $teacher) {
                            $gradeSections = json_decode($teacher->grade_sections ?? '[]', true);
                            foreach ($gradeSections as $gradeSection) {
                                $grade = $gradeSection['grade'];
                                $sections = $gradeSection['sections'] ?? [];
                                foreach ($sections as $section) {
                                    if (!isset($sectionsData[$grade][$section])) {
                                        $sectionsData[$grade][$section] = [];
                                    }
                                    $sectionsData[$grade][$section][] = $teacher;
                                }
                            }
                        }
                        ksort($sectionsData);
                        foreach ($sectionsData as &$sections) {
                            ksort($sections);
                        }

                        $filteredGrades = request('grade') ? [request('grade')] : array_keys($sectionsData);
                    @endphp

                    @php $hasData = false; @endphp

                    @foreach ($filteredGrades as $grade)
                        @if (isset($sectionsData[$grade]))
                            @foreach ($sectionsData[$grade] as $section => $teachersList)
                                @php $hasData = true; @endphp
                                <tr>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap font-medium text-gray-900"
                                    >
                                        {{ $section }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @foreach ($teachersList as $teacher)
                                            <div class="mb-2 last:mb-0">
                                                <!-- Removed profile image -->
                                                <span>{{ $teacher->full_name }}</span>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                        @foreach ($teachersList as $teacher)
                                            <div class="mb-2 last:mb-0">
                                                {{ json_decode($teacher->designations ?? '[]')[0] ?? 'N/A' }}
                                            </div>
                                        @endforeach
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap flex items-center space-x-4"
                                    >
                                        <button
                                            class="text-blue-600 hover:text-blue-800 view-btn"
                                            onclick="handleViewTimetable('Grade {{ $grade }} - {{ $section }}')"
                                            title="View Timetable"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button
                                            class="text-green-600 hover:text-green-800 edit-btn"
                                            onclick="handleEditSection('{{ $grade }}', '{{ $section }}')"
                                            title="Edit Section"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach

                    @unless ($hasData)
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                No sections found
                                {{ request('grade') ? ' for Grade ' . request('grade') : '' }}.
                            </td>
                        </tr>
                    @endunless
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    document
        .getElementById('grade-filter')
        .addEventListener('change', function () {
            this.form.submit();
        });

    function handleEditSection(grade, section) {
        // Redirect to your existing teachers_view route
        window.location.href = "{{ route('teachers.view') }}" + '?grade=' + grade + '&section=' + section;
    }

    function handleViewTimetable(section) {
        alert(`Viewing timetable for: ${section}`);
    }
</script>
</body>
</html>
