<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Admission Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .form-section {
            transition: all 0.3s ease;
        }
        .form-section:not(.active) {
            display: none;
        }
        .progress-step.active {
            background-color: #3b82f6;
            color: white;
        }
        .progress-step.completed {
            background-color: #10b981;
            color: white;
        }
        input:focus, select:focus, textarea:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-gray-100">
    <div class="container mx-auto px-4 py-8 max-w-6xl relative">
        <!-- Previous Button -->
        <button id="prev-btn" class="absolute left-0 top-0 -ml-16 mt-8 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Previous
        </button>
        <script>
            document.getElementById('prev-btn').addEventListener('click', function () {
                window.location.href = "http://localhost:8000/home";
            });
        </script>

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-800 mb-2">Teacher Admission Form</h1>
            <p class="text-gray-600">Please fill out all required fields to complete the teacher application process</p>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Error!</strong>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form Sections -->
        <form id="admission-form" class="bg-white rounded-xl shadow-xl p-8" action="{{ route('teacher.admission.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Personal Information -->
            <div class="mb-8" id="section-1">
                <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center border-b-2 border-blue-100 pb-3">
                    <span class="bg-blue-100 text-blue-700 p-2 rounded-full mr-3">
                        <i class="fas fa-user"></i>
                    </span> 
                    Personal Information
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-300">
                        @error('full_name')
                            <div id="full_name-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Date of Birth -->
                    <div>
                        <label for="dob" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth <span class="text-red-500">*</span></label>
                        <input type="date" id="dob" name="dob" value="{{ old('dob') }}" required
                            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('dob')
                            <div id="dob-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Gender -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gender <span class="text-red-500">*</span></label>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="male" class="h-5 w-5 text-blue-600 border-2 border-gray-300 focus:ring-blue-500" 
                                    {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">Male</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="female" class="h-4 w-4 text-blue-600"
                                    {{ old('gender') == 'female' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Female</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="other" class="h-4 w-4 text-blue-600"
                                    {{ old('gender') == 'other' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Other</span>
                            </label>
                        </div>
                        @error('gender')
                            <div id="gender-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Phone Number -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-gray-500">+94</span>
                            </div>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                                class="w-full pl-12 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="7XXXXXXXX">
                        </div>
                        @error('phone')
                            <div id="phone-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="teacher@example.com (optional)">
                        @error('email')
                            <div id="email-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="•••••••• (optional)">
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600 hover:text-gray-800">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div id="password-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                        <select id="role" name="role" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="teacher" {{ old('role', 'teacher') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                        </select>
                        @error('role')
                            <div id="role-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Details -->
            <div class="mb-8" id="section-2">
                <h2 class="text-xl font-semibold text-blue-800 mb-4 flex items-center">
                    <i class="fas fa-address-book mr-2"></i> Contact Details
                </h2>
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Full Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Full Address <span class="text-red-500">*</span></label>
                        <textarea id="address" name="address" rows="3" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('address') }}</textarea>
                        @error('address')
                            <div id="address-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- City -->
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                            <input type="text" id="city" name="city" value="{{ old('city') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('city')
                                <div id="city-error" class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Postal Code -->
                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">
                                Postal Code <span class="text-gray-500">(optional)</span>
                            </label>
                            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('postal_code')
                                <div id="postal_code-error" class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="mb-8" id="section-3">
                <h2 class="text-xl font-semibold text-blue-800 mb-4 flex items-center">
                    <i class="fas fa-briefcase mr-2"></i> Professional Information
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Highest Qualification -->
                    <div>
                        <label for="qualification" class="block text-sm font-medium text-gray-700 mb-1">Highest Qualification <span class="text-red-500">*</span></label>
                        <input type="text" id="qualification" name="qualification" value="{{ old('qualification') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Example: B.Ed, M.Ed, MSc, MA">
                        @error('qualification')
                            <div id="qualification-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Subject Specialization -->
                    <div>
                        <label for="specialization" class="block text-sm font-medium text-gray-700 mb-1">Subject Specialization <span class="text-red-500">*</span></label>
                        <input type="text" id="specialization" name="specialization" value="{{ old('specialization') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Example: Mathematics, Science, English">
                        @error('specialization')
                            <div id="specialization-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Years of Experience -->
                    <div>
                        <label for="experience" class="block text-sm font-medium text-gray-700 mb-1">Years of Experience <span class="text-red-500">*</span></label>
                        <input type="number" id="experience" name="experience" value="{{ old('experience') }}" min="0" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('experience')
                            <div id="experience-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Joining Date -->
                    <div>
                        <label for="joining_date" class="block text-sm font-medium text-gray-700 mb-1">Joining Date <span class="text-red-500">*</span></label>
                        <input type="date" id="joining_date" name="joining_date" value="{{ old('joining_date') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('joining_date')
                            <div id="joining_date-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Previous Institution -->
                    <div>
                        <label for="previous_institution" class="block text-sm font-medium text-gray-700 mb-1">Previous School/Institution (if any)</label>
                        <input type="text" id="previous_institution" name="previous_institution" value="{{ old('previous_institution') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('previous_institution')
                            <div id="previous_institution-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Preferred Grades -->
                    <!-- Grade and Section Selection -->
<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">Grade & Section Assignment <span class="text-red-500">*</span></label>
    
    <div id="grade-section-container">
        <!-- Existing assignments (for form validation errors) -->
        @if(old('grade_section'))
            @foreach(old('grade_section') as $index => $assignment)
                <div class="grade-section-block mb-4 p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-start gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Grade</label>
                            <select name="grade_section[{{ $index }}][grade]" class="grade-select w-full px-3 py-2 border rounded-md" required>
                                <option value="">Select Grade</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $assignment['grade'] == $i ? 'selected' : '' }}>
                                        Grade {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sections</label>
                            <div class="sections-checkbox-grid">
                                @foreach(range('A', 'J') as $section)
                                    <label class="inline-flex items-center mr-3 mb-2">
                                        <input type="checkbox" name="grade_section[{{ $index }}][sections][]" 
                                            value="{{ $section }}" class="h-4 w-4 text-blue-600"
                                            {{ in_array($section, $assignment['sections'] ?? []) ? 'checked' : '' }}>
                                        <span class="ml-2">{{ $section }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <button type="button" class="remove-grade-btn text-red-500 hover:text-red-700 mt-6">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    
    <button type="button" id="add-grade-btn" class="mt-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200">
        <i class="fas fa-plus mr-2"></i> Add Grade
    </button>
    
    @error('grade_section')
        <div class="error-message mt-2">{{ $message }}</div>
    @enderror
</div>

<!-- Add this script section -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('grade-section-container');
    const addButton = document.getElementById('add-grade-btn');
    let blockCount = {{ old('grade_section') ? count(old('grade_section')) : 0 }};
    
    // Add new grade-section block
    addButton.addEventListener('click', function() {
        const newBlock = document.createElement('div');
        newBlock.className = 'grade-section-block mb-4 p-4 border border-gray-200 rounded-lg';
        newBlock.innerHTML = `
            <div class="flex items-start gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Grade</label>
                    <select name="grade_section[${blockCount}][grade]" class="grade-select w-full px-3 py-2 border rounded-md" required>
                        <option value="">Select Grade</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">Grade {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sections</label>
                    <div class="sections-checkbox-grid">
                        @foreach(range('A', 'J') as $section)
                            <label class="inline-flex items-center mr-3 mb-2">
                                <input type="checkbox" name="grade_section[${blockCount}][sections][]" 
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
        
        container.appendChild(newBlock);
        blockCount++;
    });
    
    // Remove grade-section block
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-grade-btn')) {
            e.target.closest('.grade-section-block').remove();
        }
    });
    
    // Validate at least one grade-section is selected
    const form = document.getElementById('admission-form');
    form.addEventListener('submit', function() {
        const blocks = container.querySelectorAll('.grade-section-block');
        if (blocks.length === 0) {
            alert('Please add at least one grade and section assignment');
            return false;
        }
        
        // Validate each block has at least one section selected
        let isValid = true;
        blocks.forEach(block => {
            const gradeSelect = block.querySelector('.grade-select');
            const sectionCheckboxes = block.querySelectorAll('input[type="checkbox"]:checked');
            
            if (!gradeSelect.value) {
                isValid = false;
                gradeSelect.classList.add('border-red-500');
            }
            
            if (sectionCheckboxes.length === 0) {
                isValid = false;
                block.querySelector('.sections-checkbox-grid').classList.add('border-red-500', 'p-2');
            }
        });
        
        if (!isValid) {
            alert('Please ensure each grade has at least one section selected');
            return false;
        }
    });
});
</script>

<style>
    .sections-checkbox-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .grade-section-block {
        background-color: #f9fafb;
    }
</style>
                    <!-- Designations -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Designations</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @php
                                $oldDesignations = old('designations', []);
                            @endphp
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="designations[]" value="Principal" class="h-4 w-4 text-blue-600"
                                    {{ in_array('Principal', $oldDesignations) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Principal</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="designations[]" value="Vice Principal" class="h-4 w-4 text-blue-600"
                                    {{ in_array('Vice Principal', $oldDesignations) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Vice Principal</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="designations[]" value="Head of Department (HOD)" class="h-4 w-4 text-blue-600"
                                    {{ in_array('Head of Department (HOD)', $oldDesignations) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">HOD</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="designations[]" value="Senior Teacher" class="h-4 w-4 text-blue-600"
                                    {{ in_array('Senior Teacher', $oldDesignations) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Senior Teacher</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="designations[]" value="Assistant Teacher" class="h-4 w-4 text-blue-600"
                                    {{ in_array('Assistant Teacher', $oldDesignations) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Assistant Teacher</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="designations[]" value="Co-Class Teacher" class="h-4 w-4 text-blue-600"
                                    {{ in_array('Co-Class Teacher', $oldDesignations) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Co-Class Teacher</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="designations[]" value="Substitute Teacher" class="h-4 w-4 text-blue-600"
                                    {{ in_array('Substitute Teacher', $oldDesignations) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Substitute Teacher</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="designations[]" value="Trainee Teacher" class="h-4 w-4 text-blue-600"
                                    {{ in_array('Trainee Teacher', $oldDesignations) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Trainee Teacher</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="designations[]" value="Librarian" class="h-4 w-4 text-blue-600"
                                    {{ in_array('Librarian', $oldDesignations) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Librarian</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="designations[]" value="Physical/Sports Instructor" class="h-4 w-4 text-blue-600"
                                    {{ in_array('Physical/Sports Instructor', $oldDesignations) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Sports Instructor</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="designations[]" value="Counselor" class="h-4 w-4 text-blue-600"
                                    {{ in_array('Counselor', $oldDesignations) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Counselor</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="designations[]" value="Coordinator" class="h-4 w-4 text-blue-600"
                                    {{ in_array('Coordinator', $oldDesignations) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Coordinator</span>
                            </label>
                        </div>
                        @error('designations')
                            <div id="designations-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Resume Upload -->
                    <div>
                        <label for="resume" class="block text-sm font-medium text-gray-700 mb-1">Upload Resume/CV <span class="text-gray-500">(optional)</span></label>
                        <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">PDF or Word documents only (max 5MB)</p>
                        @error('resume')
                            <div id="resume-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="mb-8" id="section-4">
                <h2 class="text-xl font-semibold text-blue-800 mb-4 flex items-center">
                    <i class="fas fa-phone-alt mr-2"></i> Emergency Contact
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Emergency Contact Name -->
                    <div>
                        <label for="emergency_name" class="block text-sm font-medium text-gray-700 mb-1">Emergency Contact Name <span class="text-red-500">*</span></label>
                        <input type="text" id="emergency_name" name="emergency_name" value="{{ old('emergency_name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('emergency_name')
                            <div id="emergency_name-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Emergency Phone -->
                    <div>
                        <label for="emergency_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-gray-500">+94</span>
                            </div>
                            <input type="tel" id="emergency_phone" name="emergency_phone" value="{{ old('emergency_phone') }}" required
                                class="w-full pl-12 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="7XXXXXXXX">
                        </div>
                        @error('emergency_phone')
                            <div id="emergency_phone-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Relation -->
                    <div>
                        <label for="relation" class="block text-sm font-medium text-gray-700 mb-1">Relation <span class="text-red-500">*</span></label>
                        <select id="relation" name="relation" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Relation</option>
                            <option value="Spouse" {{ old('relation') == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                            <option value="Parent" {{ old('relation') == 'Parent' ? 'selected' : '' }}>Parent</option>
                            <option value="Sibling" {{ old('relation') == 'Sibling' ? 'selected' : '' }}>Sibling</option>
                            <option value="Friend" {{ old('relation') == 'Friend' ? 'selected' : '' }}>Friend</option>
                            <option value="Other" {{ old('relation') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('relation')
                            <div id="relation-error" class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="flex justify-center mt-6">
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg hover:from-blue-700 hover:to-blue-900 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-bold text-lg">
                        Submit Application <i class="fas fa-check-circle ml-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-green-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-800 mb-2">Application Submitted!</h3>
                <p class="text-gray-600 mb-6">Thank you for submitting the admission form. We will contact you soon.</p>
                <button id="close-modal" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('admission-form');
            
            // Only prevent default if we're handling the submission with AJAX
            form.addEventListener('submit', function(e) {
                // Keep client-side validation
                if (!validateForm()) {
                    e.preventDefault();
                    return false;
                }
                
                // If validation passes, allow normal form submission
                // Optionally show success modal before submitting
                document.getElementById('success-modal').classList.remove('hidden');
                
                // For debugging, you can log the form data
                const formData = new FormData(form);
                const data = {};
                formData.forEach((value, key) => {
                    data[key] = value;
                });
                console.log('Form data:', data);
            });
            
            // Close modal
            document.getElementById('close-modal').addEventListener('click', function() {
                document.getElementById('success-modal').classList.add('hidden');
            });
            
            // Form validation (client-side)
            function validateForm() {
                let isValid = true;
                
                // Clear previous errors
                document.querySelectorAll('.error-message').forEach(el => {
                    if (!el.classList.contains('server-error')) {
                        el.textContent = '';
                    }
                });
                
                // Validate all required fields
                const requiredInputs = document.querySelectorAll('[required]');
                requiredInputs.forEach(input => {
                    if (!input.value.trim()) {
                        const errorId = `${input.id}-error`;
                        const errorElement = document.getElementById(errorId);
                        if (errorElement) {
                            errorElement.textContent = 'This field is required';
                        }
                        isValid = false;
                        input.classList.add('border-red-500');
                        input.addEventListener('input', function() {
                            if (this.value.trim()) {
                                this.classList.remove('border-red-500');
                                const errorId = `${this.id}-error`;
                                const errorElement = document.getElementById(errorId);
                                if (errorElement) {
                                    errorElement.textContent = '';
                                }
                            }
                        });
                    }
                });
                
                // Validation for email (only if provided)
                const emailInput = document.getElementById('email');
                if (emailInput.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) {
                    document.getElementById('email-error').textContent = 'Please enter a valid email address';
                    isValid = false;
                    emailInput.classList.add('border-red-500');
                    emailInput.addEventListener('input', function() {
                        if (!this.value.trim() || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value.trim())) {
                            this.classList.remove('border-red-500');
                            document.getElementById('email-error').textContent = '';
                        }
                    });
                }

                // Validation for password (only if provided)
                const passwordInput = document.getElementById('password');
                if (passwordInput.value.trim() && passwordInput.value.trim().length < 8) {
                    document.getElementById('password-error').textContent = 'Password must be at least 8 characters';
                    isValid = false;
                    passwordInput.classList.add('border-red-500');
                    passwordInput.addEventListener('input', function() {
                        if (!this.value.trim() || this.value.trim().length >= 8) {
                            this.classList.remove('border-red-500');
                            document.getElementById('password-error').textContent = '';
                        }
                    });
                }

      

                // Sri Lankan phone number validation
                const phoneInputs = [
                    { input: document.getElementById('phone'), errorId: 'phone-error' },
                    { input: document.getElementById('emergency_phone'), errorId: 'emergency_phone-error' }
                ];
                
                phoneInputs.forEach(({input, errorId}) => {
                    if (input) {
                        const phoneNumber = input.value.replace(/\D/g, '');
                        let phoneValid = false;
                        
                        // Check if it's a valid Sri Lankan mobile number
                        if (phoneNumber.startsWith('94') && phoneNumber.length === 11) {
                            // Type 1: +94 format (total 11 digits)
                            phoneValid = /^947\d{8}$/.test(phoneNumber);
                        } else if (phoneNumber.startsWith('0') && phoneNumber.length === 10) {
                            // Type 2: 0 format (total 10 digits)
                            phoneValid = /^07\d{8}$/.test(phoneNumber);
                        } else if (phoneNumber.length > 0) {
                            phoneValid = false;
                        }
                        
                        if (input.required && !phoneValid && phoneNumber.length > 0) {
                            document.getElementById(errorId).textContent = 'Please enter a valid Sri Lankan phone number (e.g., +947XXXXXXXX or 07XXXXXXXX)';
                            isValid = false;
                            input.classList.add('border-red-500');
                            input.addEventListener('input', function() {
                                const newNumber = this.value.replace(/\D/g, '');
                                const newValid = (newNumber.startsWith('94') && newNumber.length === 11 && /^947\d{8}$/.test(newNumber)) || 
                                                (newNumber.startsWith('0') && newNumber.length === 10 && /^07\d{8}$/.test(newNumber));
                                if (newValid) {
                                    this.classList.remove('border-red-500');
                                    document.getElementById(errorId).textContent = '';
                                }
                            });
                        }
                    }
                });
                
                // Validate preferred grades (checkboxes)
                const preferredGrades = document.querySelectorAll('input[name="preferred_grades[]"]:checked');
                if (preferredGrades.length === 0) {
                    document.getElementById('preferred_grades-error').textContent = 'Please select at least one preferred grade';
                    isValid = false;
                    
                    // Add event listeners to clear error when any grade is selected
                    document.querySelectorAll('input[name="preferred_grades[]"]').forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            const checkedGrades = document.querySelectorAll('input[name="preferred_grades[]"]:checked');
                            if (checkedGrades.length > 0) {
                                document.getElementById('preferred_grades-error').textContent = '';
                            }
                        });
                    });
                }

                // Validate resume upload
                // Validate resume upload (only if file is provided)
                const resumeInput = document.getElementById('resume');
                if (resumeInput && resumeInput.files.length > 0) {
                    const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                    const maxSize = 5 * 1024 * 1024; // 5MB
                    
                    const file = resumeInput.files[0];
                    if (!allowedTypes.includes(file.type) || file.size > maxSize) {
                        document.getElementById('resume-error').textContent = 'Please upload a PDF or Word document (max 5MB)';
                        isValid = false;
                        resumeInput.classList.add('border-red-500');
                    }
                    
                    resumeInput.addEventListener('change', function() {
                        if (this.files.length > 0) {
                            const file = this.files[0];
                            if (allowedTypes.includes(file.type) && file.size <= maxSize) {
                                this.classList.remove('border-red-500');
                                document.getElementById('resume-error').textContent = '';
                            }
                        }
                    });
                }
                
                // Date inputs validation
                const today = new Date().toISOString().split('T')[0];
                const dobInput = document.getElementById('dob');
                if (dobInput && dobInput.value > today) {
                    document.getElementById('dob-error').textContent = 'Date of birth cannot be in the future';
                    isValid = false;
                    dobInput.classList.add('border-red-500');
                }
                
                const joiningDateInput = document.getElementById('joining_date');
                if (joiningDateInput && joiningDateInput.value < today) {
                    document.getElementById('joining_date-error').textContent = 'Joining date cannot be in the past';
                    isValid = false;
                    joiningDateInput.classList.add('border-red-500');
                }
                
                return isValid;
            }
            
            // Sri Lankan phone number formatting
            const phoneFields = ['phone', 'emergency_phone'];
            
            phoneFields.forEach(fieldId => {
                const input = document.getElementById(fieldId);
                if (input) {
                    input.addEventListener('input', function(e) {
                        formatSriLankanPhoneNumber(this);
                    });
                    
                    input.addEventListener('blur', function() {
                        validateSriLankanPhoneNumber(this);
                    });
                }
            });
            
            function formatSriLankanPhoneNumber(input) {
                // Remove all non-digit characters
                let phoneNumber = input.value.replace(/\D/g, '');
                
                // If user starts typing with 7 (assuming they want +94 format)
                if (phoneNumber.length > 0 && !phoneNumber.startsWith('0') && !phoneNumber.startsWith('94')) {
                    phoneNumber = '94' + phoneNumber;
                }
                
                // Format based on the starting digits
                if (phoneNumber.startsWith('94') && phoneNumber.length <= 11) {
                    // Type 1: +94 format (total 11 digits)
                    input.value = '+' + phoneNumber.substring(0, 11);
                } else if (phoneNumber.startsWith('0') && phoneNumber.length <= 10) {
                    // Type 2: 0 format (total 10 digits)
                    input.value = phoneNumber.substring(0, 10);
                }
            }
            
            function validateSriLankanPhoneNumber(input) {
                const phoneNumber = input.value.replace(/\D/g, '');
                let isValid = false;
                
                if (phoneNumber.startsWith('94') && phoneNumber.length === 11) {
                    // Type 1: +94 format (total 11 digits)
                    isValid = /^947\d{8}$/.test(phoneNumber);
                } else if (phoneNumber.startsWith('0') && phoneNumber.length === 10) {
                    // Type 2: 0 format (total 10 digits)
                    isValid = /^07\d{8}$/.test(phoneNumber);
                } else if (phoneNumber.length === 0 && !input.required) {
                    isValid = true;
                }
                
                const errorId = `${input.id}-error`;
                const errorElement = document.getElementById(errorId);
                
                if (!isValid && (phoneNumber.length > 0 || input.required)) {
                    if (errorElement) {
                        errorElement.textContent = 'Please enter a valid Sri Lankan phone number (e.g., +947XXXXXXXX or 07XXXXXXXX)';
                    }
                    input.classList.add('border-red-500');
                } else {
                    if (errorElement) {
                        errorElement.textContent = '';
                    }
                    input.classList.remove('border-red-500');
                }
                
                return isValid;
            }
            
            // Date inputs - set max to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('dob')?.setAttribute('max', today);
            document.getElementById('joining_date')?.setAttribute('min', today);

            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            
            if (togglePassword && password) {
                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('fa-eye');
                    this.querySelector('i').classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>
</html>