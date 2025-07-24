document.addEventListener("DOMContentLoaded", function () {
    // DOM Elements
    const loginForm = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const loginRoleSelect = document.getElementById('loginRole');
    const roleSelect = document.getElementById('role');
    const passwordToggle = document.getElementById('passwordToggle');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeOffIcon = document.getElementById('eyeOffIcon');
    const submitBtn = document.getElementById('submitBtn');
    const forgotPasswordBtn = document.getElementById('forgotPasswordBtn');
    const forgotPasswordModal = document.getElementById('forgotPasswordModal');
    const modalCloseBtn = document.getElementById('modalCloseBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const resetForm = document.getElementById('resetForm');

    // Error message elements
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    const loginRoleError = document.getElementById('loginRoleError');
    const roleError = document.getElementById('roleError');
    const resetEmailError = document.getElementById('resetEmailError');

    // Password toggle functionality
    passwordToggle.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        if (type === 'text') {
            eyeIcon.classList.add('hidden');
            eyeOffIcon.classList.remove('hidden');
        } else {
            eyeIcon.classList.remove('hidden');
            eyeOffIcon.classList.add('hidden');
        }
    });

    // Form validation functions
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function validatePassword(password) {
        return password.length >= 6;
    }

    function validateRole(role) {
        const validRoles = ['super_admin', 'admin', 'teacher', 'student', 'librarian', 'parents'];
        return validRoles.includes(role);
    }

    function showError(element, message) {
        element.textContent = message;
        element.previousElementSibling?.querySelector('.form-input')?.classList.add('error');
    }

    function clearError(element) {
        element.textContent = '';
        element.previousElementSibling?.querySelector('.form-input')?.classList.remove('error');
    }

    // Real-time validation
    emailInput.addEventListener('blur', function () {
        if (this.value && !validateEmail(this.value)) {
            showError(emailError, 'Please enter a valid email address');
        } else {
            clearError(emailError);
        }
    });

    passwordInput.addEventListener('blur', function () {
        if (this.value && !validatePassword(this.value)) {
            showError(passwordError, 'Password must be at least 6 characters');
        } else {
            clearError(passwordError);
        }
    });

    loginRoleSelect.addEventListener('change', function () {
        if (this.value && !validateRole(this.value)) {
            showError(loginRoleError, 'Please select a valid role');
        } else {
            clearError(loginRoleError);
        }
    });

    roleSelect?.addEventListener('change', function () {
        if (this.value && !validateRole(this.value)) {
            showError(roleError, 'Please select a valid role');
        } else {
            clearError(roleError);
        }
    });

    // Form submission
    loginForm.addEventListener('submit', function (e) {
        e.preventDefault();

        clearError(emailError);
        clearError(passwordError);
        clearError(loginRoleError);
        clearError(roleError);

        const email = emailInput.value;
        const password = passwordInput.value;
        const loginRole = loginRoleSelect.value;

        let hasErrors = false;

        if (!email) {
            showError(emailError, 'Email is required');
            hasErrors = true;
        } else if (!validateEmail(email)) {
            showError(emailError, 'Please enter a valid email address');
            hasErrors = true;
        }

        if (!password) {
            showError(passwordError, 'Password is required');
            hasErrors = true;
        } else if (!validatePassword(password)) {
            showError(passwordError, 'Password must be at least 6 characters');
            hasErrors = true;
        }

        if (!loginRole) {
            showError(loginRoleError, 'Please select your role');
            hasErrors = true;
        } else if (!validateRole(loginRole)) {
            showError(loginRoleError, 'Please select a valid role');
            hasErrors = true;
        }

        if (hasErrors) return;

        // UI loading effect
        submitBtn.disabled = true;
        document.querySelector('.btn-text').classList.add('hidden');
        document.querySelector('.btn-icon').classList.add('hidden');
        document.querySelector('.loading-spinner').classList.remove('hidden');

        setTimeout(() => {
            submitBtn.disabled = false;
            document.querySelector('.btn-text').classList.remove('hidden');
            document.querySelector('.btn-icon').classList.remove('hidden');
            document.querySelector('.loading-spinner').classList.add('hidden');

            alert(`Login successful as ${loginRole.replace('_', ' ').toUpperCase()}!`);
        }, 2000);
    });

    // Modal handling
    forgotPasswordBtn?.addEventListener('click', () => forgotPasswordModal.classList.remove('hidden'));
    modalCloseBtn?.addEventListener('click', () => forgotPasswordModal.classList.add('hidden'));
    cancelBtn?.addEventListener('click', () => forgotPasswordModal.classList.add('hidden'));

    forgotPasswordModal?.addEventListener('click', function (e) {
        if (e.target === this) this.classList.add('hidden');
    });

    // Reset password form
    resetForm?.addEventListener('submit', function (e) {
        e.preventDefault();

        const resetEmailInput = document.getElementById('resetEmail');
        const resetEmail = resetEmailInput.value.trim();

        resetEmailError.textContent = '';
        resetEmailInput.classList.remove('error');

        if (!resetEmail) {
            resetEmailError.textContent = 'Email is required';
            resetEmailInput.classList.add('error');
            return;
        }

        if (!validateEmail(resetEmail)) {
            resetEmailError.textContent = 'Please enter a valid email address';
            resetEmailInput.classList.add('error');
            return;
        }

        const resetBtn = document.getElementById('resetBtn');
        resetBtn.disabled = true;
        document.querySelector('.reset-btn-text').classList.add('hidden');
        document.querySelector('.reset-loading-spinner').classList.remove('hidden');

        setTimeout(() => {
            resetBtn.disabled = false;
            document.querySelector('.reset-btn-text').classList.remove('hidden');
            document.querySelector('.reset-loading-spinner').classList.add('hidden');
            forgotPasswordModal.classList.add('hidden');
            alert('Password reset link sent to your email!');
            resetEmailInput.value = '';
        }, 2000);
    });

    // Contact admin alert
    document.querySelector('.contact-admin-btn')?.addEventListener('click', function () {
        alert('Please contact the system administrator at admin@school.edu or call +1-234-567-8900');
    });
});
