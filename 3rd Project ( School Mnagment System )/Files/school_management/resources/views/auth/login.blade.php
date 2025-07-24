<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>School Management System | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <style>
        body {
            background: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(30, 58, 138, 0.85);
            z-index: -1;
        }
        .role-option {
            transition: all 0.3s ease;
        }
        .role-option:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .role-option.selected {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
        .shake {
            animation: shake 0.5s;
        }
        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            10%, 30%, 50%, 70%, 90% {
                transform: translateX(-5px);
            }
            20%, 40%, 60%, 80% {
                transform: translateX(5px);
            }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-800 py-6 px-6 text-center">
            <div class="flex items-center justify-center mb-2">
                <i class="fas fa-graduation-cap text-white text-4xl mr-3"></i>
                <h1 class="text-2xl font-bold text-white">School Lanka</h1>
            </div>
            <p class="text-blue-200 text-sm">Comprehensive School Management Solution</p>
        </div>

        <!-- Login Form -->
        <div class="px-6 py-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Login to Your Account</h2>

            {{-- Show errors and success messages --}}
            @if ($errors->has('login_error'))
                <div class="text-red-600 mb-3 text-center font-semibold">
                    {{ $errors->first('login_error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="text-green-600 mb-3 text-center font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <form id="loginForm" class="space-y-4" method="POST" action="{{ route('login.submit') }}">
                @csrf
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            class="pl-10 w-full px-4 py-3 text-base rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            placeholder="your@email.com"
                        />
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="pl-10 w-full px-4 py-3 text-base rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            placeholder="••••••••"
                        />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" id="togglePassword" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Your Role</label>
                    <div class="grid grid-cols-3 gap-2">
                        <div
                            class="role-option border rounded-lg p-2 cursor-pointer text-center"
                            data-role="super_admin"
                        >
                            <i class="fas fa-user-shield text-blue-600 text-xl mb-1"></i>
                            <p class="text-xs font-medium">Super Admin</p>
                        </div>
                        <div
                            class="role-option border rounded-lg p-2 cursor-pointer text-center"
                            data-role="admin"
                        >
                            <i class="fas fa-user-tie text-blue-600 text-xl mb-1"></i>
                            <p class="text-xs font-medium">Admin</p>
                        </div>
                        <div
                            class="role-option border rounded-lg p-2 cursor-pointer text-center"
                            data-role="teacher"
                        >
                            <i class="fas fa-chalkboard-teacher text-blue-600 text-xl mb-1"></i>
                            <p class="text-xs font-medium">Teacher</p>
                        </div>
                        <div
                            class="role-option border rounded-lg p-2 cursor-pointer text-center"
                            data-role="student"
                        >
                            <i class="fas fa-user-graduate text-blue-600 text-xl mb-1"></i>
                            <p class="text-xs font-medium">Student</p>
                        </div>
                        <div
                            class="role-option border rounded-lg p-2 cursor-pointer text-center"
                            data-role="librarian"
                        >
                            <i class="fas fa-book-reader text-blue-600 text-xl mb-1"></i>
                            <p class="text-xs font-medium">Librarian</p>
                        </div>
                        <div
                            class="role-option border rounded-lg p-2 cursor-pointer text-center"
                            data-role="parent"
                        >
                            <i class="fas fa-users text-blue-600 text-xl mb-1"></i>
                            <p class="text-xs font-medium">Parent</p>
                        </div>
                    </div>
                    <input type="hidden" id="role" name="role" required />
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        />
                        <label for="remember" class="ml-2 block text-xs text-gray-700">Remember me</label>
                    </div>
                    <div class="text-xs">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Forgot password?</a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 transform hover:scale-105"
                    >
                        Sign In
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </form>

            <!-- Footer Links -->
            <div class="mt-4 text-center text-xs">
                <p class="text-gray-600">
                    Don't have an account?
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Contact administrator</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Password visibility toggle
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');

            togglePassword.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.innerHTML =
                    type === 'password'
                        ? '<i class="fas fa-eye"></i>'
                        : '<i class="fas fa-eye-slash"></i>';
            });

            // Role selection
            const roleOptions = document.querySelectorAll('.role-option');
            const roleInput = document.getElementById('role');

            roleOptions.forEach((option) => {
                option.addEventListener('click', function () {
                    // Remove selected class from all options
                    roleOptions.forEach((opt) =>
                        opt.classList.remove('selected', 'border-blue-500')
                    );

                    // Add selected class to clicked option
                    this.classList.add('selected', 'border-blue-500');

                    // Set the role value
                    roleInput.value = this.getAttribute('data-role');
                });
            });

            // Form validation
            const loginForm = document.getElementById('loginForm');

            loginForm.addEventListener('submit', function (e) {
                if (!roleInput.value) {
                    e.preventDefault(); // Block submit only if role not selected
                    const roleContainer = document.querySelector(
                        '[data-role]'
                    ).parentElement.parentElement;
                    roleContainer.classList.add('shake');

                    setTimeout(() => {
                        roleContainer.classList.remove('shake');
                    }, 500);

                    return;
                }
            });

            // Auto-select first role for demo purposes
            roleOptions[0].click();
        });
    </script>
</body>
</html>
