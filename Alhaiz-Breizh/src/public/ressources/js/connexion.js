const validateInput = (input, errorElement, isValid) => {
    if (!errorElement) return;
    errorElement.classList.toggle('hidden', isValid);
    input.classList.toggle('error', !isValid);
};

const validatePassword = (password) => {
    return /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+\-\=[\]{};':"\\|,.<>/?]).{8,}$/.test(password);
};

const validateEmail = (email) => {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
};

const validatePasswordsMatch = (password, confirmPassword) => {
    return password === confirmPassword;
};

function formatDateString(inputValue) {
    let formattedDate = '';
    if (inputValue.length > 0) {
        formattedDate += inputValue.substring(0, 2);
        if (inputValue.length > 2) {
            formattedDate += '/' + inputValue.substring(2, 4);
        }
        if (inputValue.length > 4) {
            formattedDate += '/' + inputValue.substring(4, 8);
        }
    }
    return formattedDate;
}

const isDateValid = (date) => {
    const maxDate = getMaxAllowedDate();
    const birthDate = convertToISODate(date);
    return birthDate < maxDate;
}

function getMaxAllowedDate() {
    const date = new Date();
    date.setFullYear(date.getFullYear() - 11);
    return date.toISOString().split('T')[0];
}

function convertToISODate(date) {
    const parts = date.split('/');
    if (parts.length === 3) {
        return `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
    }
    return null;
}

function showError(errorElement) {
    errorElement.classList.remove('hidden');
    errorElement.classList.add('visible');
}

function hideError(errorElement) {
    errorElement.classList.add('hidden');
    errorElement.classList.remove('visible');
}

const changePage = (page) => {
    const page1 = document.querySelector('.page1');
    const page2 = document.querySelector('.page2');

    if (page === 1) {
        page1.classList.remove('hidden');
        page2.classList.add('hidden');
    } else if (page === 2) {
        page1.classList.add('hidden');
        page2.classList.remove('hidden');
    }
};

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#login-form');
    const usernameInput = document.querySelector('#username-input');
    const emailInput = document.querySelector('#email-input');
    const passwordInput = document.querySelector('#password-input');
    const passwordConfirmInput = document.querySelector('#password-confirm-input');
    const buttonNext = document.querySelector('#button-next');
    const button = document.querySelector('#button-container');
    const errorMessages = document.querySelector('#error-messages');
    const visibleBirth = document.getElementById("birthdate");

    let emailValid = false;
    let passwordValid = false;
    let passwordsMatch = false;
    let dateValid = false;

    if(buttonNext) buttonNext.disabled = true;
    button.disabled = passwordConfirmInput !== null;

    function formatDate() {
        const input = document.getElementById('birthdate');
        const inputValue = input.value.replace(/\D/g, ''); // Remove non-numeric characters
        dateValid = isDateValid(inputValue);
        button.disabled = !dateValid;
        !dateValid ? button.classList.remove('allowed') : button.classList.add('allowed');
        input.value = formatDateString(inputValue);
    }

    const validateForm = () => {
        buttonNext.disabled = !(usernameInput.value !== "" && emailValid && passwordValid && passwordsMatch);
        !(usernameInput.value !== "" && emailValid && passwordValid && passwordsMatch) ? buttonNext.classList.remove('allowed') : buttonNext.classList.add('allowed');
    };

    function validateDate(formattedDate, errorElement) {
        let result = isDateValid(formattedDate);
        button.disabled = !result;
        if(result) {
            hideError(errorElement);
        } else {
            showError(errorElement);
        }
    }

    function checkFormattedDate() {
        const input = document.getElementById('birthdate');
        const error = document.getElementById('date-error');

        if (input.value.length === 10) {
            validateDate(input.value, error);
        } else if (input.value.length === 0) {
            hideError(error);
        } else {
            showError(error);
        }
    }

    const handleInputValidation = (input, errorElement, validator, type) => {
        if (!errorElement) return;

        const validateAndDisplayError = () => {
            const inputValue = input.value.trim();
            const isValid = validator(inputValue);
            validateInput(input, errorElement, isValid);
            if (isValid || inputValue === '') {
                errorMessages.classList.add('hidden');
            }
            if (type === 'email') {
                emailValid = isValid;
            } else if (type === 'password') {
                passwordValid = isValid;
            }
            validateForm();
        };

        input.addEventListener('input', () => {
            const inputValue = input.value.trim();
            if (!errorElement.classList.contains('hidden') && (inputValue === '' || validator(inputValue))) {
                validateInput(input, errorElement, true);
                errorMessages.classList.add('hidden');
            }
            if (type === 'email') {
                emailValid = inputValue === '' || validator(inputValue);
            } else if (type === 'password') {
                passwordValid = inputValue === '' || validator(inputValue);
            }
            validateForm();
        });

        input.addEventListener('focusout', () => {
            const inputValue = input.value.trim();
            if (inputValue === '' || validator(inputValue)) {
                validateInput(input, errorElement, true);
                errorMessages.classList.add('hidden');
            } else {
                validateAndDisplayError();
            }
            if (type === 'email') {
                emailValid = inputValue === '' || validator(inputValue);
            } else if (type === 'password') {
                passwordValid = inputValue === '' || validator(inputValue);
            }
            validateForm();
        });
    };

    const validateUsername = (username) => {
        return username.length >= 3;
    };

    handleInputValidation(usernameInput, document.querySelector('#username-error'), validateUsername, "username");
    handleInputValidation(emailInput, document.querySelector('#email-error'), validateEmail, "email");
    handleInputValidation(passwordInput, document.querySelector('#password-error'), validatePassword, "password");

    const validatePasswordMatch = () => {
        const passwordValue = passwordInput.value.trim();
        if(passwordConfirmInput !== null) {
            const confirmPasswordValue = passwordConfirmInput.value.trim();
            if(confirmPasswordValue === '') return;
            passwordsMatch = validatePasswordsMatch(passwordValue, confirmPasswordValue);
            validateInput(passwordConfirmInput, document.querySelector('#password-confirm-error'), passwordsMatch);
            validateForm();
        }
    };

    passwordInput.addEventListener('focusout', validatePasswordMatch);
    if(passwordConfirmInput) {
        passwordConfirmInput.addEventListener('focusout', validatePasswordMatch);
        visibleBirth.addEventListener('focusout', checkFormattedDate);
        visibleBirth.addEventListener('input', formatDate);
    }

    const togglePasswordVisibility = (inputId, eyeIcon) => {
        const passwordInput = document.getElementById(inputId);
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        eyeIcon.classList.toggle('show', isPassword);
    };

    document.querySelectorAll('.toggle-password').forEach(eyeIcon => {
        eyeIcon.addEventListener('click', function() {
            const inputId = this.previousElementSibling.id;
            togglePasswordVisibility(inputId, this);
        });
    });
});
