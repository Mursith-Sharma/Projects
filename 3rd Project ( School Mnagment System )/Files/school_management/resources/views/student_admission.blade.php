<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Admission Form</title>
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
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-4xl relative">
        <!-- Previous Button -->
        <button id="prev-btn" class="absolute left-0 top-0 -ml-16 mt-8 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Previous
        </button>

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-800 mb-2">Student Admission Form</h1>
            <p class="text-gray-600">Please fill out all required fields to complete the admission process</p>
        </div>

        @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- Form Sections -->
        <form id="admission-form" class="bg-white" method="POST" action="{{ route('student_admission') }}">
            @csrf
            <!-- Student Information -->
            <div class="mb-8" id="section-1">
                <h2 class="text-xl font-semibold text-blue-800 mb-4 flex items-center">
                    <i class="fas fa-user-graduate mr-2"></i> Student Information
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" id="full_name" name="full_name" required value="{{ old('full_name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div id="full_name-error" class="error-message">@error('full_name') {{ $message }} @enderror</div>
                    </div>
                    
                    <!-- Date of Birth -->
                    <div>
                        <label for="dob" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth <span class="text-red-500">*</span></label>
                        <input type="date" id="dob" name="dob" required value="{{ old('dob') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div id="dob-error" class="error-message">@error('dob') {{ $message }} @enderror</div>
                    </div>
                    
                    <!-- Gender -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gender <span class="text-red-500">*</span></label>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="male" class="h-4 w-4 text-blue-600" required 
                                    {{ old('gender') == 'male' ? 'checked' : '' }}>
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
                        <div id="gender-error" class="error-message">@error('gender') {{ $message }} @enderror</div>
                    </div>
                    
                    <!-- Phone Number -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                                class="w-full px-4 py-2 pl-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="+947XXXXXXXX or 07XXXXXXXX">
                        </div>
                        <div id="phone-error" class="error-message">@error('phone') {{ $message }} @enderror</div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="student@example.com (optional)">
                        <div id="email-error" class="error-message">@error('email') {{ $message }} @enderror</div>
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
                        <div id="password-error" class="error-message">@error('password') {{ $message }} @enderror</div>
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                        <select id="role" name="role" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="student" selected>Student</option>
                        </select>
                        <div id="role-error" class="error-message">@error('role') {{ $message }} @enderror</div>
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
                        <div id="address-error" class="error-message">@error('address') {{ $message }} @enderror</div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- City -->
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                            <input type="text" id="city" name="city" required value="{{ old('city') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="city-error" class="error-message">@error('city') {{ $message }} @enderror</div>
                        </div>
                        
                        <!-- Postal Code -->
                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">
                                Postal Code <span class="text-gray-500">(optional)</span>
                            </label>
                            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="postal_code-error" class="error-message">@error('postal_code') {{ $message }} @enderror</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Academic Information -->
            <div class="mb-8" id="section-3">
                <h2 class="text-xl font-semibold text-blue-800 mb-4 flex items-center">
                    <i class="fas fa-graduation-cap mr-2"></i> Academic Information
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Class/Grade -->
                    <div>
                        <label for="grade" class="block text-sm font-medium text-gray-700 mb-1">Class/Grade <span class="text-red-500">*</span></label>
                        <select id="grade" name="grade" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Grade</option>
                            @foreach(['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'] as $grade)
                                <option value="{{ $grade }}" {{ old('grade') == $grade ? 'selected' : '' }}>{{ $grade }}</option>
                            @endforeach
                        </select>
                        <div id="grade-error" class="error-message">@error('grade') {{ $message }} @enderror</div>
                    </div>
                    
                    <!-- Section -->
                    <div>
                        <label for="section" class="block text-sm font-medium text-gray-700 mb-1">Section <span class="text-red-500">*</span></label>
                        <select id="section" name="section" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Section</option>
                            @foreach(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'] as $section)
                                <option value="{{ $section }}" {{ old('section') == $section ? 'selected' : '' }}>{{ $section }}</option>
                            @endforeach
                        </select>
                        <div id="section-error" class="error-message">@error('section') {{ $message }} @enderror</div>
                    </div>
                    
                    <!-- Date of Admission -->
                    <div>
                        <label for="admission_date" class="block text-sm font-medium text-gray-700 mb-1">Date of Admission <span class="text-red-500">*</span></label>
                        <input type="date" id="admission_date" name="admission_date" required value="{{ old('admission_date') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div id="admission_date-error" class="error-message">@error('admission_date') {{ $message }} @enderror</div>
                    </div>
                    
                    <!-- Previous School -->
                    <div>
                        <label for="previous_school" class="block text-sm font-medium text-gray-700 mb-1">Previous School (if any)</label>
                        <input type="text" id="previous_school" name="previous_school" value="{{ old('previous_school') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div id="previous_school-error" class="error-message">@error('previous_school') {{ $message }} @enderror</div>
                    </div>
                </div>
            </div>

            <!-- Guardian Information -->
            <div class="mb-8" id="section-4">
                <h2 class="text-xl font-semibold text-blue-800 mb-4 flex items-center">
                    <i class="fas fa-user-shield mr-2"></i> Guardian Information
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Guardian Name -->
                    <div>
                        <label for="guardian_name" class="block text-sm font-medium text-gray-700 mb-1">Guardian Name <span class="text-red-500">*</span></label>
                        <input type="text" id="guardian_name" name="guardian_name" required value="{{ old('guardian_name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div id="guardian_name-error" class="error-message">@error('guardian_name') {{ $message }} @enderror</div>
                    </div>
                    
                    <!-- Guardian Phone -->
                    <div>
                        <label for="guardian_phone" class="block text-sm font-medium text-gray-700 mb-1">
                            Guardian Phone Number <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="guardian_phone" name="guardian_phone" value="{{ old('guardian_phone') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="07XXXXXXXX or +947XXXXXXXX">
                        <div id="guardian_phone-error" class="error-message">@error('guardian_phone') {{ $message }} @enderror</div>
                    </div>
                    
                    <!-- Relation to Student -->
                    <div>
                        <label for="relation" class="block text-sm font-medium text-gray-700 mb-1">Relation to Student <span class="text-red-500">*</span></label>
                        <select id="relation" name="relation" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Relation</option>
                            @foreach(['Father', 'Mother', 'Uncle', 'Aunt', 'Grandfather', 'Grandmother', 'Brother', 'Sister', 'Guardian', 'Other'] as $relation)
                                <option value="{{ $relation }}" {{ old('relation') == $relation ? 'selected' : '' }}>{{ $relation }}</option>
                            @endforeach
                        </select>
                        <div id="relation-error" class="error-message">@error('relation') {{ $message }} @enderror</div>
                    </div>
                </div>
                
                <div class="flex justify-center mt-6">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                        Submit <i class="fas fa-check ml-2"></i>
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
        document.addEventListener('DOMContentLoaded', function () {
            // Previous button functionality
            const prevBtn = document.getElementById('prev-btn');
            if (prevBtn) {
                prevBtn.addEventListener('click', function() {
                    window.history.back();
                });
            }

            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            
            if (togglePassword && password) {
                togglePassword.addEventListener('click', function () {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    this.querySelector('i').classList.toggle('fa-eye');
                    this.querySelector('i').classList.toggle('fa-eye-slash');
                });
            }

            // Sri Lankan phone number validation and formatting
            // Sri Lankan phone number validation and formatting
['phone', 'guardian_phone'].forEach(id => {
    const input = document.getElementById(id);
    if (input) {
        input.addEventListener('input', function() {
            formatSriLankanPhoneNumber(this);
        });
        
        // Also validate on blur
        input.addEventListener('blur', function() {
            validateSriLankanPhoneNumber(this);
        });
    }
});

function formatSriLankanPhoneNumber(input) {
    // Remove all non-digit characters
    let phoneNumber = input.value.replace(/\D/g, '');
    
    // Format based on the starting digits
    if (phoneNumber.startsWith('94')) {
        // Type 1: +94 format (total 11 digits)
        if (phoneNumber.length > 2) {
            phoneNumber = phoneNumber.substring(0, 11); // Limit to 11 digits
            phoneNumber = phoneNumber.replace(/(\d{2})(\d{1,9})/, '+$1$2');
        }
    } else if (phoneNumber.startsWith('0')) {
        // Type 2: 0 format (total 10 digits)
        if (phoneNumber.length > 1) {
            phoneNumber = phoneNumber.substring(0, 10); // Limit to 10 digits
            phoneNumber = phoneNumber.replace(/(\d{1})(\d{1,9})/, '$1$2');
        }
    } else {
        // If doesn't start with 94 or 0, clear the input
        if (phoneNumber.length > 0) {
            phoneNumber = '';
        }
    }
    
    input.value = phoneNumber;
}

function validateSriLankanPhoneNumber(input) {
    const phoneNumber = input.value.replace(/\D/g, '');
    let isValid = false;
    let errorMessage = '';
    
    if (phoneNumber.startsWith('94')) {
        // Type 1 validation: +94 format (total 11 digits)
        isValid = phoneNumber.length === 11;
        errorMessage = isValid ? '' : 'Please enter a valid +94 number (11 digits total)';
    } else if (phoneNumber.startsWith('0')) {
        // Type 2 validation: 0 format (total 10 digits)
        isValid = phoneNumber.length === 10;
        errorMessage = isValid ? '' : 'Please enter a valid 0 number (10 digits total)';
    } else {
        errorMessage = 'Phone number must start with +94 or 0';
    }
    
    // Display error message
    const errorElement = document.getElementById(`${input.id}-error`);
    if (errorElement) {
        errorElement.textContent = errorMessage;
    }
    
    return isValid;
}

            // Date validation
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('dob')?.setAttribute('max', today);
            document.getElementById('admission_date')?.setAttribute('min', today);

            // Success modal handling
            const modal = document.getElementById('success-modal');
            if (modal && "{{ session('success') }}") {
                modal.classList.remove('hidden');
                document.getElementById('close-modal')?.addEventListener('click', function () {
                    modal.classList.add('hidden');
                });
            }

            // Scroll to first error if any
            if (document.querySelector('.text-red-500')) {
                const firstError = document.querySelector('.text-red-500');
                firstError.closest('div')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    </script>
</body>
</html>