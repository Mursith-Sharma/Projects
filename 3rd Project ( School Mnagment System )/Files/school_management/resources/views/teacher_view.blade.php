<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Teacchers</title>
    <script src="https://cdn.tailwindcss.com "></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css "/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .teacher-card {
            transition: all 0.3s ease;
        }

        .teacher-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .sections-checkbox-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .grade-section-block {
            background-color: #f9fafb;
            padding: 1rem;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center mb-6">
            <a href="#" class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">All Teachers</h1>
                <p class="text-sm text-gray-500">Manage and view teacher information</p>
            </div>
        </div>

                <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <i class="fas fa-chalkboard-teacher fa-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Total Teachers</h3>
                        <p class="text-2xl font-semibold text-gray-800" id="totalTeachers">0</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <i class="fas fa-user-plus fa-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">New Hires (This Year)</h3>
                        <p class="text-2xl font-semibold text-gray-800" id="newHires">0</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                        <i class="fas fa-graduation-cap fa-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Avg. Grades per Teacher</h3>
                        <p class="text-2xl font-semibold text-gray-800" id="avgGrades">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white p-4 rounded-lg shadow-md mb-6">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="gradeFilter" class="block text-sm font-medium text-gray-700 mb-1">Filter by Grade</label>
                    <select id="gradeFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="all">All Grades</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">Grade {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label for="designationFilter" class="block text-sm font-medium text-gray-700 mb-1">Filter by Role</label>
                    <select id="designationFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="all">All Designations</option>
                        <option value="Vice Principal">Vice Principal</option>
                        <option value="Head of Department (HOD)">HOD</option>
                        <option value="Senior Teacher">Senior Teacher</option>
                        <option value="Assistant Teacher">Assistant Teacher</option>
                        <option value="Co-Class Teacher">Co-Class Teacher</option>
                        <option value="Substitute Teacher">Substitute Teacher</option>
                        <option value="Trainee Teacher">Trainee Teacher</option>
                        <option value="Librarian">Librarian</option>
                        <option value="Physical/Sports Instructor">Sports Instructo</option>
                        <option value="Counselor">Counselor</option>
                        <option value="Coordinator">Coordinator</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[200px] relative">
                    <label for="searchInput" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Search by name or ID"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md pl-10">
                        <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>



        <!-- Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Teacher List</h2>
                <div class="text-sm text-gray-600">
                    Showing <span id="showingFrom">0</span>-<span id="showingTo">0</span> of <span id="showingTotal">0</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Designations</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grades</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joining Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="teacher-table-body" class="bg-white divide-y divide-gray-200">
                    <!-- Teacher rows will be inserted here -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 flex items-center justify-between border-t border-gray-200">
                <div class="flex-1 flex justify-between sm:hidden">
                    <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            onclick="prevPage()">Previous
                    </button>
                    <button class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                            onclick="nextPage()">Next
                    </button>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing <span id="showingFrom2">0</span> to <span id="showingTo2">0</span> of <span id="showingTotal2">0</span> results
                        </p>
                    </div>
                    <div id="pagination" class="flex items-center space-x-2">
                        <!-- Pagination buttons will be inserted here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Teacher Modal -->
    <div id="view-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md fade-in">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Teacher Details</h3>
                <button id="close-view-modal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6" id="teacher-details">
                <!-- Teacher details will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Edit Teacher Modal -->
    <div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl fade-in">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Edit Teacher</h3>
                <button id="close-edit-modal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editTeacherForm" class="p-6 space-y-4 overflow-y-auto max-h-[80vh]">
                <input type="hidden" id="editId">
                <input type="hidden" id="editGradeSections">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="editFullName" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="editFullName" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="editPhone" class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" id="editPhone" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="editEmail" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="editEmail" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="editGender" class="block text-sm font-medium text-gray-700">Gender</label>
                        <select id="editGender" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="editDob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" id="editDob" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="editJoiningDate" class="block text-sm font-medium text-gray-700">Joining Date</label>
                        <input type="date" id="editJoiningDate" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="editAddress" class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" id="editAddress" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="editCity" class="block text-sm font-medium text-gray-700">City</label>
                        <input type="text" id="editCity" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="editPostalCode" class="block text-sm font-medium text-gray-700">Postal Code</label>
                        <input type="text" id="editPostalCode" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="editQualification" class="block text-sm font-medium text-gray-700">Qualification</label>
                        <input type="text" id="editQualification" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="editSpecialization" class="block text-sm font-medium text-gray-700">Specialization</label>
                        <input type="text" id="editSpecialization" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="editExperience" class="block text-sm font-medium text-gray-700">Experience</label>
                        <input type="number" id="editExperience" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="editPreviousInstitution" class="block text-sm font-medium text-gray-700">Previous Institution</label>
                        <input type="text" id="editPreviousInstitution" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="editEmergencyName" class="block text-sm font-medium text-gray-700">Emergency Name</label>
                        <input type="text" id="editEmergencyName" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="editEmergencyPhone" class="block text-sm font-medium text-gray-700">Emergency Phone</label>
                        <input type="text" id="editEmergencyPhone" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="editRelation" class="block text-sm font-medium text-gray-700">Relation</label>
                       <select id="editRelation" class="w-full px-4 py-2 border border-gray-300 rounded-md">
                            <option value="">Select Relation</option>
                            <option value="Spouse">Spouse</option>
                            <option value="Parent">Parent</option>
                            <option value="Sibling">Sibling</option>
                            <option value="Friend">Friend</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="editRole" class="block text-sm font-medium text-gray-700">Role</label>
                        <select id="editRole" class="w-full px-4 py-2 border border-gray-300 rounded-md"></select>
                    </div>
                </div>

                <!-- Grade & Section Assignment -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Grade & Section Assignment</label>
                    <div id="edit-grade-section-container"></div>
                    <button type="button" id="add-edit-grade-btn" class="mt-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200">
                        <i class="fas fa-plus mr-2"></i> Add Grade
                    </button>
                </div>

                <!-- Designations -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Designations</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2" id="edit-designations-container">
                        @foreach(['Principal', 'Vice Principal', 'Head of Department (HOD)', 'Senior Teacher', 'Assistant Teacher','Trainee Teacher', 'Co-Class Teacher','Physical/Sports instructor','Librarianr','Substitute Teacher','Counselor', 'Coordinator'] as $designation)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="editDesignations[]" value="{{ $designation }}" class="h-4 w-4 text-blue-600">
                                <span class="ml-2">{{ $designation }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" id="close-edit-btn" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const elements = {
                teacherTableBody: document.getElementById('teacher-table-body'),
                pagination: document.getElementById('pagination'),
                totalTeachers: document.getElementById('totalTeachers'),
                newHires: document.getElementById('newHires'),
                avgGrades: document.getElementById('avgGrades'),
                gradeFilter: document.getElementById('gradeFilter'),
                designationFilter: document.getElementById('designationFilter'),
                searchInput: document.getElementById('searchInput'),
                showingFrom: document.getElementById('showingFrom'),
                showingTo: document.getElementById('showingTo'),
                showingTotal: document.getElementById('showingTotal'),
                showingFrom2: document.getElementById('showingFrom2'),
                showingTo2: document.getElementById('showingTo2'),
                showingTotal2: document.getElementById('showingTotal2'),
                viewModal: document.getElementById('view-modal'),
                closeViewModal: document.getElementById('close-view-modal'),
                editModal: document.getElementById('edit-modal'),
                closeEditModal: document.getElementById('close-edit-modal'),
                closeEditBtn: document.getElementById('close-edit-btn'),
                editTeacherForm: document.getElementById('editTeacherForm'),
                teacherDetails: document.getElementById('teacher-details')
            };

            const state = {
                teachers: @json($teachersData),
                filteredTeachers: [],
                currentPage: 1
            };

            const config = {
                itemsPerPage: 10
            };

            // Grade Section Container
            const editGradeSectionContainer = document.getElementById('edit-grade-section-container');
            const addEditGradeBtn = document.getElementById('add-edit-grade-btn');

            // Create a new grade-section block
            function createGradeSectionBlock(grade = '', sections = []) {
                const block = document.createElement('div');
                block.className = 'grade-section-block mb-4 p-4 border border-gray-200 rounded-lg';
                block.dataset.blockId = Date.now();

                block.innerHTML = `
                    <div class="flex items-start gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Grade</label>
                            <select name="grade_section[${block.dataset.blockId}][grade]" class="grade-select w-full px-3 py-2 border rounded-md">
                                <option value="">Select Grade</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sections</label>
                            <div class="sections-checkbox-grid">
                                @foreach(range('A', 'J') as $section)
                                    <label class="inline-flex items-center mr-3 mb-2">
                                        <input type="checkbox" name="grade_section[${block.dataset.blockId}][sections][]"
                                               value="{{ $section }}" class="h-4 w-4 text-blue-600">
                                        <span class="ml-2">{{ $section }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <button type="button" class="remove-grade-btn text-red-500 hover:text-red-700 mt-6">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                `;

                if (grade) block.querySelector('.grade-select').value = grade;
                const checkboxes = block.querySelectorAll('.sections-checkbox-grid input[type="checkbox"]');
                checkboxes.forEach(cb => {
                    if (sections.includes(cb.value)) cb.checked = true;
                });

                return block;
            }

            function populateGradeSections(grades = []) {
                editGradeSectionContainer.innerHTML = '';
                if (grades.length === 0) {
                    editGradeSectionContainer.appendChild(createGradeSectionBlock());
                    return;
                }
                grades.forEach(g => {
                    editGradeSectionContainer.appendChild(createGradeSectionBlock(g.grade, g.sections));
                });
            }

            function getRoleValue(designation) {
                const map = {
                    'Principal': 'principal',
                    'Vice Principal': 'vice_principal',
                    'Head of Department (HOD)': 'hod',
                    'Senior Teacher': 'senior_teacher',
                    'Trainee Teacher': 'trainee_teacher',
                    'Assistant Teacher': 'assistant_teacher',
                    'Co-Class Teacher': 'co_class_teacher',
                    'Physical/Sports instructor': 'physical_instructor',
                    'Librarianr': 'librarianr',
                    'Substitute Teacher': 'substitute_teacher',
                    'Counselor': 'counselor',
                    'Coordinator': 'coordinator'
                };
                return map[designation] || 'custom';
            }

            filterTeachers();
            renderTeachers();
            updateStats();
            setupEventListeners();

            function setupEventListeners() {
                elements.gradeFilter.addEventListener('change', () => {
                    state.currentPage = 1;
                    filterTeachers();
                    renderTeachers();
                    updateStats();
                });

                elements.designationFilter.addEventListener('change', () => {
                    state.currentPage = 1;
                    filterTeachers();
                    renderTeachers();
                    updateStats();
                });

                elements.searchInput.addEventListener('input', debounce(() => {
                    state.currentPage = 1;
                    filterTeachers();
                    renderTeachers();
                    updateStats();
                }, 300));

                elements.editTeacherForm.addEventListener('submit', handleEditFormSubmit);

                elements.closeEditBtn.addEventListener('click', closeEditModal);
                elements.closeViewModal.addEventListener('click', closeViewModal);

                // ✅ Attach Close (X) Button Listener
                if (elements.closeEditModal) {
                    elements.closeEditModal.addEventListener('click', closeEditModal);
                }

                addEditGradeBtn.addEventListener('click', () => {
                    editGradeSectionContainer.appendChild(createGradeSectionBlock());
                });

                editGradeSectionContainer.addEventListener('click', function (e) {
                    if (e.target.closest('.remove-grade-btn')) {
                        e.target.closest('.grade-section-block').remove();
                    }
                });
            }

            function filterTeachers() {
                let filtered = [...state.teachers];

                const grade = elements.gradeFilter.value;
                if (grade !== 'all') {
                    filtered = filtered.filter(t => t.grades.some(g => g.grade == grade));
                }

                const designation = elements.designationFilter.value;
                if (designation !== 'all') {
                    filtered = filtered.filter(t => t.designation.includes(designation));
                }

                const search = elements.searchInput.value.toLowerCase();
                if (search) {
                    filtered = filtered.filter(t => t.name.toLowerCase().includes(search) || t.id.toString().includes(search));
                }

                state.filteredTeachers = filtered;
            }

            function renderTeachers() {
                const startIndex = (state.currentPage - 1) * config.itemsPerPage;
                const endIndex = Math.min(startIndex + config.itemsPerPage, state.filteredTeachers.length);
                const pageTeachers = state.filteredTeachers.slice(startIndex, endIndex);

                elements.teacherTableBody.innerHTML = '';

                if (pageTeachers.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No teachers found</td>
                    `;
                    elements.teacherTableBody.appendChild(row);
                    return;
                }

                pageTeachers.forEach(teacher => {
                    const row = document.createElement('tr');
                    row.className = 'teacher-card';

                    const gradeSections = teacher.grades.map(g => {
                        return `<div class="text-sm"><strong>Grade ${g.grade}</strong>: ${g.sections.join(', ')}</div>`;
                    }).join('');

                    const designations = Array.isArray(teacher.designation)
                        ? teacher.designation.join(', ')
                        : teacher.designation;

                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${teacher.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${teacher.name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${designations}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div>${gradeSections}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${teacher.contact}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatDate(teacher.joiningDate)}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <button class="text-blue-600 hover:text-blue-800 mr-3 view-btn" data-id="${teacher.id}"><i class="fas fa-eye"></i></button>
                            <button class="text-green-600 hover:text-green-800 mr-3 edit-btn" data-id="${teacher.id}"><i class="fas fa-edit"></i></button>
                            <button class="text-red-600 hover:text-red-800 delete-btn" data-id="${teacher.id}"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    `;

                    elements.teacherTableBody.appendChild(row);
                });

                renderPagination();
                attachButtonListeners();
            }

            function attachButtonListeners() {
                document.querySelectorAll('.edit-btn').forEach(btn => {
                    btn.removeEventListener('click', editClickHandler);
                    btn.addEventListener('click', editClickHandler);
                });

                document.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.removeEventListener('click', deleteClickHandler);
                    btn.addEventListener('click', deleteClickHandler);
                });

                document.querySelectorAll('.view-btn').forEach(btn => {
                    btn.removeEventListener('click', viewClickHandler);
                    btn.addEventListener('click', viewClickHandler);
                });
            }

            function editClickHandler() {
                const teacherId = parseInt(this.getAttribute('data-id'));
                openEditModal(teacherId);
            }

            function deleteClickHandler() {
                const teacherId = parseInt(this.getAttribute('data-id'));
                if (confirm('Are you sure you want to delete this teacher?')) {
                    deleteTeacher(teacherId);
                }
            }

            function viewClickHandler() {
                const teacherId = parseInt(this.getAttribute('data-id'));
                openViewModal(teacherId);
            }

            function formatDate(dateString) {
                if (!dateString) return '';
                const date = new Date(dateString);
                return date.toLocaleDateString();
            }

            function renderPagination() {
                const totalPages = Math.ceil(state.filteredTeachers.length / config.itemsPerPage);
                elements.pagination.innerHTML = '';

                if (totalPages <= 1) return;

                const startPage = Math.max(1, state.currentPage - 2);
                const endPage = Math.min(totalPages, state.currentPage + 2);

                if (state.currentPage > 1) {
                    const prevBtn = document.createElement('button');
                    prevBtn.textContent = 'Previous';
                    prevBtn.className = 'px-3 py-1 border border-gray-300 rounded-md text-gray-700';
                    prevBtn.addEventListener('click', () => {
                        state.currentPage--;
                        renderTeachers();
                        updateStats();
                    });
                    elements.pagination.appendChild(prevBtn);
                }

                for (let i = startPage; i <= endPage; i++) {
                    const btn = document.createElement('button');
                    btn.textContent = i;
                    btn.className = `px-3 py-1 border border-gray-300 rounded-md ${i === state.currentPage ? 'bg-blue-600 text-white' : 'text-gray-700'}`;
                    btn.addEventListener('click', () => {
                        state.currentPage = i;
                        renderTeachers();
                        updateStats();
                    });
                    elements.pagination.appendChild(btn);
                }

                if (state.currentPage < totalPages) {
                    const nextBtn = document.createElement('button');
                    nextBtn.textContent = 'Next';
                    nextBtn.className = 'px-3 py-1 border border-gray-300 rounded-md text-gray-700';
                    nextBtn.addEventListener('click', () => {
                        state.currentPage++;
                        renderTeachers();
                        updateStats();
                    });
                    elements.pagination.appendChild(nextBtn);
                }

                updatePaginationText();
            }

            function updatePaginationText() {
                const startIndex = (state.currentPage - 1) * config.itemsPerPage;
                const endIndex = Math.min(startIndex + config.itemsPerPage, state.filteredTeachers.length);

                elements.showingFrom.textContent = startIndex + 1;
                elements.showingTo.textContent = endIndex;
                elements.showingTotal.textContent = state.filteredTeachers.length;

                elements.showingFrom2.textContent = startIndex + 1;
                elements.showingTo2.textContent = endIndex;
                elements.showingTotal2.textContent = state.filteredTeachers.length;
            }

            function updateStats() {
                const total = state.filteredTeachers.length;
                const thirtyDaysAgo = new Date();
                thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);

                const newHires = state.filteredTeachers.filter(t => {
                    const joinDate = new Date(t.joiningDate);
                    return joinDate >= thirtyDaysAgo;
                }).length;

                const totalGrades = state.filteredTeachers.reduce((sum, t) => sum + t.grades.length, 0);
                const avg = total > 0 ? (totalGrades / total).toFixed(1) : 0;

                elements.totalTeachers.textContent = total;
                elements.newHires.textContent = newHires;
                elements.avgGrades.textContent = avg;
            }

            function openEditModal(teacherId) {
                const teacher = state.teachers.find(t => t.id === teacherId);
                if (!teacher) return;

                document.querySelectorAll('#edit-designations-container input[type="checkbox"]').forEach(cb => cb.checked = false);

                document.getElementById('editId').value = teacher.id;
                document.getElementById('editFullName').value = teacher.name;
                document.getElementById('editPhone').value = teacher.contact;
                document.getElementById('editEmail').value = teacher.email || '';
                document.getElementById('editGender').value = teacher.gender || 'other';
                document.getElementById('editDob').value = formatDateForInput(teacher.dob);
                document.getElementById('editJoiningDate').value = formatDateForInput(teacher.joiningDate);
                document.getElementById('editAddress').value = teacher.address || '';
                document.getElementById('editCity').value = teacher.city || '';
                document.getElementById('editPostalCode').value = teacher.postal_code || '';
                document.getElementById('editQualification').value = teacher.qualification || '';
                document.getElementById('editSpecialization').value = teacher.specialization || '';
                document.getElementById('editExperience').value = teacher.experience || '';
                document.getElementById('editPreviousInstitution').value = teacher.previous_institution || '';
                document.getElementById('editEmergencyName').value = teacher.emergency_name || '';
                document.getElementById('editEmergencyPhone').value = teacher.emergency_phone || '';
                document.getElementById('editRelation').value = teacher.relation || '';

                const roleSelect = document.getElementById('editRole');
                roleSelect.innerHTML = '';
                const designations = Array.isArray(teacher.designation) ? teacher.designation : [teacher.designation].filter(Boolean);
                designations.forEach(designation => {
                    const option = document.createElement('option');
                    option.value = getRoleValue(designation);
                    option.textContent = designation;
                    roleSelect.appendChild(option);
                });
                if (designations.length > 0) roleSelect.value = getRoleValue(designations[0]);

                populateGradeSections(teacher.grades || []);

                designations.forEach(designation => {
                    const checkbox = document.querySelector(`#edit-designations-container input[value="${designation}"]`);
                    if (checkbox) checkbox.checked = true;
                });

                elements.editModal.classList.remove('hidden');
            }

            function closeEditModal() {
                elements.editModal.classList.add('hidden');
            }

function handleEditFormSubmit(e) {
    e.preventDefault();

    const teacherId = document.getElementById('editId').value;
    if (!teacherId) {
        alert('No teacher selected for edit.');
        return;
    }

    // Collect grade-sections from container
    const gradeSections = [];
    document.querySelectorAll('#edit-grade-section-container .grade-section-block').forEach(block => {
        const grade = block.querySelector('.grade-select')?.value;
        const sections = Array.from(block.querySelectorAll('.sections-checkbox-grid input[type="checkbox"]:checked'))
                             .map(cb => cb.value);

        if (grade && sections.length > 0) {
            gradeSections.push({
                grade: parseInt(grade),
                sections: sections
            });
        }
    });

    // Get selected designations
    const selectedDesignations = Array.from(
        document.querySelectorAll('#edit-designations-container input[type="checkbox"]:checked')
    ).map(cb => cb.value);

    // Build form data
    const formData = {
        full_name: document.getElementById('editFullName').value,
        phone: document.getElementById('editPhone').value,
        email: document.getElementById('editEmail').value,
        gender: document.getElementById('editGender').value,
        dob: document.getElementById('editDob').value,
        address: document.getElementById('editAddress').value,
        city: document.getElementById('editCity').value,
        postal_code: document.getElementById('editPostalCode').value,
        qualification: document.getElementById('editQualification').value,
        specialization: document.getElementById('editSpecialization').value,
        experience: parseInt(document.getElementById('editExperience').value),
        previous_institution: document.getElementById('editPreviousInstitution').value,
        joining_date: document.getElementById('editJoiningDate').value,
        emergency_name: document.getElementById('editEmergencyName').value,
        emergency_phone: document.getElementById('editEmergencyPhone').value,
        relation: document.getElementById('editRelation').value,
        role: document.getElementById('editRole').value,
        grade_sections: gradeSections,
        designations: selectedDesignations,
        _token: document.querySelector('meta[name="csrf-token"]').content
    };

    // Debug: See what we're sending
    console.log("Submitting:", formData);

    fetch(`/teachers/${teacherId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': formData._token
        },
        body: JSON.stringify(formData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            alert('Teacher updated successfully!');
            closeEditModal();
            filterTeachers(); // Refresh filtered list
            renderTeachers(); // Re-render table
            updateStats();   // Update stats
        } else {
            alert('Error: ' + (data.message || 'Please check the fields.'));
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Network error. Check console for details.');
    });
}

function deleteTeacher(teacherId) {
    if (!confirm('Are you sure you want to delete this teacher?')) {
        return;
    }

    fetch(`/teachers/${teacherId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            alert('Teacher deleted successfully!');
            // Remove from UI
            state.teachers = state.teachers.filter(t => t.id !== teacherId);
            state.filteredTeachers = state.filteredTeachers.filter(t => t.id !== teacherId);
            renderTeachers();
            updateStats();
        } else {
            alert('Failed to delete teacher: ' + (data.message || 'Please try again.'));
        }
    })
    .catch(error => {
        console.error('Delete error:', error);
        alert('An error occurred while deleting the teacher. Check console for details.');
    });
}

            function openViewModal(teacherId) {
                const teacher = state.teachers.find(t => t.id === teacherId);
                if (!teacher) return;

                const gradeSections = teacher.grades.map(g => {
                    return `<div class="text-sm"><strong>Grade ${g.grade}:</strong> ${g.sections.join(', ')}</div>`;
                }).join('');

                const designations = Array.isArray(teacher.designation)
                    ? teacher.designation.join(', ')
                    : teacher.designation;

                elements.teacherDetails.innerHTML = `
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center">
                            <i class="fas fa-user text-indigo-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-xl font-bold text-gray-800">${teacher.name}</h4>
                            <p class="text-gray-600">${teacher.id}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h5 class="text-sm font-medium text-gray-500">Designations</h5>
                            <p class="mt-1">${designations}</p>
                        </div>
                        <div>
                            <h5 class="text-sm font-medium text-gray-500">Assigned Grades & Sections</h5>
                            <div class="mt-1">${gradeSections}</div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h5 class="text-sm font-medium text-gray-500">Contact</h5>
                                <p class="mt-1">${teacher.contact}</p>
                            </div>
                            <div>
                                <h5 class="text-sm font-medium text-gray-500">Email</h5>
                                <p class="mt-1">${teacher.email || 'Not provided'}</p>
                            </div>
                            <div>
                                <h5 class="text-sm font-medium text-gray-500">Joining Date</h5>
                                <p class="mt-1">${formatDate(teacher.joiningDate)}</p>
                            </div>
                        </div>
                    </div>
                `;

                elements.viewModal.classList.remove('hidden');
            }

            function closeViewModal() {
                elements.viewModal.classList.add('hidden');
            }

            function formatDateForInput(dateString) {
                if (!dateString) return '';
                const date = new Date(dateString);
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            function debounce(func, delay) {
                let timeout;
                return function (...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), delay);
                };
            }
        });
    </script>
</body>
</html>