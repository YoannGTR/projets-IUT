document.addEventListener("DOMContentLoaded", function() {
    // Enable/Disable the validate button based on the CGU checkbox
    const cguCheckbox = document.getElementById('cgv-checkbox');
    const validateButton = document.querySelector('.validate-button');
    const inputFields = document.querySelectorAll('input[type="text"]');
    const civilitySelect = document.querySelector('select[name="Civilité"]');
    const paymentOptions = document.querySelectorAll('.payment-option');

    // Function to check if all input fields are filled
    function checkInputs() {
        let allFilled = true;
        inputFields.forEach(function(input) {
            if (input.value.trim() === '') {
                allFilled = false;
            }
        });
        return allFilled;
    }

    // Function to handle input change
    function handleInputChange() {
        if (checkInputs() && cguCheckbox.checked && civilitySelect.value !== '.' && validateExpirationDate()) {
            validateButton.disabled = false;
            validateButton.style.backgroundColor = '#f57393'; // Original background color
        } else {
            validateButton.disabled = true;
            validateButton.style.backgroundColor = '#ccc'; // Grey background color
        }
    }

    // Add event listener to CGU checkbox
    cguCheckbox.addEventListener('change', handleInputChange);

    // Add event listener to Civilité select
    civilitySelect.addEventListener('change', handleInputChange);

    // Initial state check
    handleInputChange();

    // Validate the credit card infos
    const numericInputSelectors = [
        '#credit-card-option input[placeholder="Numéro de la carte"]',
        '#expiration-month',
        '#expiration-year',
        '#credit-card-option input[placeholder="CVV"]'
    ];

    const numericInputFields = document.querySelectorAll(numericInputSelectors.join(', '));

    numericInputFields.forEach(inputField => {
        inputField.addEventListener('input', function(event) {
            let value = event.target.value;
            value = value.replace(/\D/g, ''); // Remove all non-digit characters
            event.target.value = value;
        });
    });

    const cardNumberField = document.querySelector('#credit-card-option input[placeholder="Numéro de la carte"]');
    cardNumberField.addEventListener('blur', function(event) {
        const cardNumber = event.target.value;
        if (cardNumber === "") {
            cardNumberField.style.borderColor = ''; // Reset to original color
        } else if (isValidCardNumber(cardNumber)) {
            cardNumberField.style.borderColor = 'green'; // Valid card number
        } else {
            cardNumberField.style.borderColor = 'red'; // Invalid card number
        }
    });

    function isValidCardNumber(number) {
        let sum = 0;
        let shouldDouble = false;

        for (let i = number.length - 1; i >= 0; i--) {
            let digit = parseInt(number.charAt(i));

            if (shouldDouble) {
                digit *= 2;
                if (digit > 9) {
                    digit -= 9;
                }
            }

            sum += digit;
            shouldDouble = !shouldDouble;
        }

        return sum % 10 === 0;
    }

    // Validate the expiration date
    const expirationMonthField = document.getElementById('expiration-month');
    const expirationYearField = document.getElementById('expiration-year');

    function validateExpirationDate() {
        const month = expirationMonthField.value;
        const year = expirationYearField.value;
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear() % 100;
        const currentMonth = currentDate.getMonth() + 1;

        // Reset border colors
        expirationMonthField.style.borderColor = '';
        expirationYearField.style.borderColor = '';

        // Convert values to integers
        const monthNum = parseInt(month, 10);
        const yearNum = parseInt(year, 10);

        if (isNaN(monthNum)) {
            expirationYearField.style.borderColor = 'red';
            return false;
        }
        else {
            expirationYearField.style.borderColor = 'green';
        }

        if (isNaN(yearNum) || monthNum < 1 || monthNum > 12) {
            expirationMonthField.style.borderColor = 'red';
            return false;
        }
        else {
            expirationMonthField.style.borderColor = 'green';
        }

        // Compare the input date with the current date
        if (yearNum > currentYear || (yearNum === currentYear && monthNum >= currentMonth)) {
            expirationMonthField.style.borderColor = 'green';
            expirationYearField.style.borderColor = 'green';
            return true;
        } else {
            expirationMonthField.style.borderColor = 'orange';
            expirationYearField.style.borderColor = 'orange';
            return false;
        }
    }

    expirationMonthField.addEventListener('blur', () => {
        validateExpirationDate();
        handleInputChange();
    });

    expirationYearField.addEventListener('blur', () => {
        validateExpirationDate();
        handleInputChange();
    });
});