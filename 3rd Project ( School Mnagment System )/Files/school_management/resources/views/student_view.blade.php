<!DOCTYPE html>
<html lang="en">
<head>
    <base target="_self">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>View All Students</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#4f46e5",
                        secondary: "#3730a3",
                        success: "#10b981",
                        info: "#3b82f6"
                    }
                }
            }
        };
    </script>  
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-8 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Previous Button -->
            <div class="mb-4">
                <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Previous
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Total Students Card -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-50 text-primary">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Students</p>
                            <p class="text-2xl font-semibold text-gray-900" id="totalStudents">0</p>
                        </div>
                    </div>
                </div>

                <!-- New Admissions Card -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-50 text-success">
                            <i class="fas fa-user-plus text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">New Admissions (This Month)</p>
                            <p class="text-2xl font-semibold text-gray-900" id="newAdmissions">0</p>
                        </div>
                    </div>
                </div>

                <!-- Class Distribution Card -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-50 text-info">
                            <i class="fas fa-chalkboard-teacher text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Active Classes</p>
                            <p class="text-2xl font-semibold text-gray-900" id="activeClasses">12</p>
                        </div>
                    </div>
                </div>
            </div>

            <!----------------------------------->
            <!-- Edit Modal -->
            <div id="editModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl p-6 relative animate-fade-in-up max-h-[90vh] overflow-y-auto">

                    <!-- Close Button -->
                    <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-red-500 text-3xl font-bold leading-none">
                        &times;
                    </button>

                    <h2 class="text-2xl font-semibold mb-4 text-green-800 text-center border-b pb-3">
                        <i class="fas fa-user-edit mr-2 text-green-700"></i> Edit Student Details
                    </h2>

                    <form id="editStudentForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="hidden" id="editId" name="id" />

                        <!-- Full Name -->
                        <div>
                            <label for="editFullName" class="block font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" id="editFullName" name="name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-200" required>
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="editDob" class="block font-medium text-gray-700 mb-1">Date of Birth</label>
                            <input type="date" id="editDob" name="dob" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-200" required>
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="editPhone" class="block font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" id="editPhone" name="phone" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-200" required>
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="editGender" class="block font-medium text-gray-700 mb-1">Gender</label>
                            <select id="editGender" name="gender" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-200" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="editEmail" class="block font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="editEmail" name="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-200">
                        </div>

                        <!-- Password -->
                        <!-- Password -->
<div>
    <label for="editPassword" class="block font-medium text-gray-700 mb-1">Password</label>
    <div class="relative">
        <input type="password" id="editPassword" name="password" 
               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-200 pr-10">
        <button type="button" onclick="togglePasswordVisibility('editPassword')"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
            <i class="far fa-eye" id="editPasswordToggleIcon"></i>
        </button>
    </div>
</div>

                        <!-- Full Address -->
                        <div class="md:col-span-2">
                            <label for="editAddress" class="block font-medium text-gray-700 mb-1">Full Address</label>
                            <textarea id="editAddress" name="address" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-200" required></textarea>
                        </div>

                        <!-- City -->
                        <div>
                            <label for="editCity" class="block font-medium text-gray-700 mb-1">City</label>
                            <input type="text" id="editCity" name="city" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-200" required>
                        </div>

                        <!-- Postal Code -->
                        <div>
                            <label for="editPostalCode" class="block font-medium text-gray-700 mb-1">Postal Code</label>
                            <input type="text" id="editPostalCode" name="postal_code" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-200">
                        </div>

                        <!-- Class/Grade -->
                        <div>
                            <label for="editGrade" class="block font-medium text-gray-700 mb-1">Class/Grade</label>
                            <select id="editGrade" name="class" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-200" required>
                                <option value="">Select Class/Grade</option>
                                <option value="Grade 1">Grade 1</option>
                                <option value="Grade 2">Grade 2</option>
                                <option value="Grade 3">Grade 3</option>
                                <option value="Grade 4">Grade 4</option>
                                <option value="Grade 5">Grade 5</option>
                                <option value="Grade 6">Grade 6</option>
                                <option value="Grade 7">Grade 7</option>
                                <option value="Grade 8">Grade 8</option>
                                <option value="Grade 9">Grade 9</option>
                                <option value="Grade 10">Grade 10</option>
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>
                            </select>
                        </div>

                        <!-- Section -->
                        <div>
                            <label for="editSection" class="block font-medium text-gray-700 mb-1">Section</label>
                            <select id="editSection" name="section" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-200" required>
                                <option value="">Select Section</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                                <option value="H">H</option>
                                <option value="I">I</option>
                                <option value="J">J</option>
                            </select>
                        </div>

                        <!-- Previous School -->
                        <div>
                            <label for="editPreviousSchool" class="block font-medium text-gray-700 mb-1">Previous School</label>
                            <input type="text" id="editPreviousSchool" name="previous_school" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-200">
                        </div>

                        <!-- Date of Admission -->
                        <div>
                            <label for="editAdmissionDate" class="block font-medium text-gray-700 mb-1">Date of Admission</label>
                            <input type="date" id="editAdmissionDate" name="admission_date" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-200" required>
                        </div>

                        <!-- Guardian Name -->
                        <div>
                            <label for="editGuardianName" class="block font-medium text-gray-700 mb-1">Guardian Name</label>
                            <input type="text" id="editGuardianName" name="guardian_name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-200" required>
                        </div>

                        <!-- Guardian Phone -->
                        <div>
                            <label for="editGuardianPhone" class="block font-medium text-gray-700 mb-1">Guardian Phone</label>
                            <input type="text" id="editGuardianPhone" name="guardian_phone" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-200" required>
                        </div>

                        <div>
                            <label for="editRelation" class="block font-medium text-gray-700 mb-1">Relation to Student</label>
                            <select id="editRelation" name="guardian_relation" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-green-200" required>
                                <option value="">Select Relation</option>
                                <option value="Father">Father</option>
                                <option value="Mother">Mother</option>
                                <option value="Uncle">Uncle</option>
                                <option value="Aunt">Aunt</option>
                                <option value="Brother">Brother</option>
                                <option value="Sister">Sister</option>
                                <option value="Guardian">Guardian</option>
                            </select>
                        </div>

                        <!-- Buttons: Cancel & Update -->
                        <div class="md:col-span-2 flex justify-end space-x-4 mt-6">
                            <button type="button" onclick="closeEditModal()" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                                Cancel
                            </button>
                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition shadow-md flex items-center">
                                <i class="fas fa-save mr-2"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!----------------------------------->

            <!-- Page Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">All Students</h1>
                <div class="flex space-x-3">
                    <a href="{{ route('student_admission_form') }}" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-secondary transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add New Student
                    </a>

                    <button class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                </div>
            </div>
            

            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Class Filter -->
                    <div>
                        <label for="classFilter" class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                        <select id="classFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            <option value="">All Classes</option>
                            <option value="Grade 1">Grade 1</option>
                            <option value="Grade 2">Grade 2</option>
                            <option value="Grade 3">Grade 3</option>
                            <option value="Grade 4">Grade 4</option>
                            <option value="Grade 5">Grade 5</option>
                            <option value="Grade 6">Grade 6</option>
                            <option value="Grade 7">Grade 7</option>
                            <option value="Grade 8">Grade 8</option>
                            <option value="Grade 9">Grade 9</option>
                            <option value="Grade 10">Grade 10</option>
                            <option value="Grade 11">Grade 11</option>
                            <option value="Grade 12">Grade 12</option>
                        </select>
                    </div>

                    <!-- Section Filter -->
                    <div>
                        <label for="sectionFilter" class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                        <select id="sectionFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            <option value="">All Sections</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                        </select>
                    </div>

                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="search" placeholder="Search students..." 
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Table -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Student ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Class & Section
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Guardian
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Phone
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Admission Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody id="studentsTableBody"></tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700" id="paginationInfo">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">0</span> students
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50" id="prevPage">
                                    <span class="sr-only">Previous</span>
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                                <a href="#" aria-current="page" class="z-10 bg-primary border-primary text-white relative inline-flex items-center px-4 py-2 border text-sm font-medium" id="page1">1</a>
                                <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium" id="page2">2</a>
                                <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium" id="page3">3</a>
                                <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50" id="nextPage">
                                    <span class="sr-only">Next</span>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        //////////////////////////////////////////////////////////////////////////

function deleteStudent(studentId) {
    if (confirm('Are you sure you want to delete this student?')) {
        fetch(`/students/${studentId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Student deleted successfully!');
                // Remove the student from the local array and re-render
                const index = students.findIndex(s => s.id == studentId);
                if (index !== -1) {
                    students.splice(index, 1);
                }
                renderStats();
                renderStudentsTable(students);
                applyFilters(); // Reapply filters if any
            } else {
                alert('Failed to delete student: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the student.');
        });
    }
}

//////////////////////////////////////////////////////////////////////////

function togglePasswordVisibility(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + 'ToggleIcon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}


        document.getElementById("editStudentForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const studentId = document.getElementById("editId").value;

    fetch(`/students/${studentId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            // Add this for Laravel to recognize PUT/PATCH requests via POST
            'X-HTTP-Method-Override': 'PUT'
        },
        body: JSON.stringify({
            full_name: document.getElementById("editFullName").value,
            dob: document.getElementById("editDob").value,
            phone: document.getElementById("editPhone").value,
            gender: document.getElementById("editGender").value,
            email: document.getElementById("editEmail").value,
            password: document.getElementById("editPassword").value,
            address: document.getElementById("editAddress").value,
            city: document.getElementById("editCity").value,
            postal_code: document.getElementById("editPostalCode").value,
            grade: document.getElementById("editGrade").value,
            section: document.getElementById("editSection").value,
            previous_school: document.getElementById("editPreviousSchool").value,
            admission_date: document.getElementById("editAdmissionDate").value,
            guardian_name: document.getElementById("editGuardianName").value,
            guardian_phone: document.getElementById("editGuardianPhone").value,
            relation: document.getElementById("editRelation").value,
            _method: 'PUT' // Laravel way to override POST to PUT
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Student updated successfully!');
            closeEditModal();
            // Refresh the page to see changes
            window.location.reload();
        } else {
            alert('Failed to update student.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Check Your password & Other details');
    });
});

        function openEditModal(studentId) {
            const student = students.find(s => s.id == studentId);
            if (!student) {
                alert("Student not found");
                return;
            }

            // Format date for the date input (YYYY-MM-DD)
            const formatDateForInput = (dateString) => {
                if (!dateString) return '';
                try {
                    const date = new Date(dateString);
                    if (isNaN(date.getTime())) return '';
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                } catch (e) {
                    console.error("Date formatting error:", e);
                    return '';
                }
            };

            // Populate all form fields
            document.getElementById('editId').value = student.id || '';
            document.getElementById('editFullName').value = student.full_name || '';
            document.getElementById('editDob').value = formatDateForInput(student.dob || student.date_of_birth) || '';
            document.getElementById('editPhone').value = student.phone || student.phone_number || '';
            
            // Set Gender (case-insensitive match)
            if (student.gender) {
                const gender = String(student.gender).trim();
                const genderOptions = ["Male", "Female", "Other"];
                const matchedOption = genderOptions.find(opt => 
                    opt.toLowerCase() === gender.toLowerCase()
                );
                if (matchedOption) {
                    document.getElementById('editGender').value = matchedOption;
                } else {
                    document.getElementById('editGender').value = gender;
                }
            }

            document.getElementById('editEmail').value = student.email || '';
            document.getElementById('editPassword').value = '';
            document.getElementById('editAddress').value = student.address || '';
            document.getElementById('editCity').value = student.city || '';
            document.getElementById('editPostalCode').value = student.postal_code || '';
            document.getElementById('editGrade').value = student.grade || student.class_grade || '';
            document.getElementById('editSection').value = student.section || '';
            document.getElementById('editPreviousSchool').value = student.previous_school || '';
            document.getElementById('editAdmissionDate').value = formatDateForInput(student.admission_date) || '';
            document.getElementById('editGuardianName').value = student.guardian_name || '';
            document.getElementById('editGuardianPhone').value = student.guardian_phone || '';
            
            // Set Relation (case-insensitive match)
            if (student.guardian_relation || student.relation) {
                const relation = String(student.guardian_relation || student.relation).trim();
                const relationOptions = ["Father", "Mother", "Uncle", "Aunt", "Brother", "Sister", "Guardian"];
                const matchedRelation = relationOptions.find(opt => 
                    opt.toLowerCase() === relation.toLowerCase()
                );
                if (matchedRelation) {
                    document.getElementById('editRelation').value = matchedRelation;
                } else {
                    document.getElementById('editRelation').value = relation;
                }
            }

            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        document.getElementById('closeModalBtn').addEventListener('click', closeEditModal);

        const students = @json($students);
        console.log(students);

        // Pagination variables
        const itemsPerPage = 10;
        let currentPage = 1;
        let filteredStudents = students;

        // Render stats cards dynamically
        function renderStats() {
            const totalStudents = students.length;
            const now = new Date();
            const thisMonth = now.getMonth();
            const newAdmissionsCount = students.filter(s => {
                const adDate = new Date(s.admission_date);
                return adDate.getMonth() === thisMonth && adDate.getFullYear() === now.getFullYear();
            }).length;

            document.getElementById('totalStudents').textContent = totalStudents;
            document.getElementById('newAdmissions').textContent = newAdmissionsCount;
        }

        // Render students table based on current page and filtered data
        function renderStudentsTable(data) {
            const tbody = document.getElementById('studentsTableBody');
            tbody.innerHTML = '';

            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageData = data.slice(start, end);

            pageData.forEach(student => {
                tbody.innerHTML += `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${student.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
<div class="flex items-center">
    <div>
        <div class="text-sm font-medium text-gray-900">${student.full_name}</div>
        <div class="text-sm text-gray-500">${student.gender ? student.gender.charAt(0).toUpperCase() + student.gender.slice(1) : ''}</div>
    </div>
</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">${student.grade}</div>
                            <div class="text-sm text-gray-500">Section ${student.section}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${student.guardian_name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${student.phone}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${new Date(student.admission_date).toLocaleDateString()}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                        <button onclick="event.preventDefault(); viewStudent(${student.id})"class="text-blue-600 hover:text-blue-800 mr-2"><i class="fas fa-eye"></i>
                        </button>
                        <button onclick="event.preventDefault(); openEditModal(${student.id})"class="text-green-600 hover:text-green-800 mr-2"><i class="fas fa-edit"></i>
                        </button>
                        <button onclick="event.preventDefault(); deleteStudent(${student.id})"class="text-red-600 hover:text-red-900"><i class="fas fa-trash-alt"></i>
                        </button>
                        </td>
                    </tr>`;
            });

            // Update pagination info text
            const totalItems = data.length;
            const showingStart = totalItems === 0 ? 0 : start + 1;
            const showingEnd = end > totalItems ? totalItems : end;

            document.getElementById('paginationInfo').innerHTML = `Showing <span class="font-medium">${showingStart}</span> to <span class="font-medium">${showingEnd}</span> of <span class="font-medium">${totalItems}</span> students`;
        }

        // Filter function
        function applyFilters() {
            const classFilter = document.getElementById('classFilter').value.toLowerCase();
            const sectionFilter = document.getElementById('sectionFilter').value.toLowerCase();
            const searchTerm = document.getElementById('search').value.toLowerCase();

            filteredStudents = students.filter(student => {
                const gradeMatch = classFilter === '' || (student.grade && student.grade.toLowerCase() === classFilter);
                const sectionMatch = sectionFilter === '' || (student.section && student.section.toLowerCase() === sectionFilter);
                const searchMatch =
                    (student.full_name && student.full_name.toLowerCase().includes(searchTerm)) ||
                    (student.guardian_name && student.guardian_name.toLowerCase().includes(searchTerm)) ||
                    (student.phone && student.phone.toLowerCase().includes(searchTerm));

                return gradeMatch && sectionMatch && searchMatch;
            });

            currentPage = 1;
            renderStudentsTable(filteredStudents);
        }

        // Pagination controls
        document.getElementById('prevPage').addEventListener('click', e => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                renderStudentsTable(filteredStudents);
            }
        });

        document.getElementById('nextPage').addEventListener('click', e => {
            e.preventDefault();
            const totalPages = Math.ceil(filteredStudents.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderStudentsTable(filteredStudents);
            }
        });

        // Page number buttons
        document.getElementById('page1').addEventListener('click', e => {
            e.preventDefault();
            currentPage = 1;
            renderStudentsTable(filteredStudents);
        });
        document.getElementById('page2').addEventListener('click', e => {
            e.preventDefault();
            currentPage = 2;
            renderStudentsTable(filteredStudents);
        });
        document.getElementById('page3').addEventListener('click', e => {
            e.preventDefault();
            currentPage = 3;
            renderStudentsTable(filteredStudents);
        });

        // Filter event listeners
        document.getElementById('classFilter').addEventListener('change', applyFilters);
        document.getElementById('sectionFilter').addEventListener('change', applyFilters);
        document.getElementById('search').addEventListener('input', applyFilters);

        // Initial render
        renderStats();
        renderStudentsTable(students);
    </script>
</body>
</html>