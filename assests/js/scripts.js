document.addEventListener('DOMContentLoaded', function() {
    // Simple form validation
    const forms = document.querySelectorAll('form');
    
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            const inputs = form.querySelectorAll('input[type="text"], input[type="password"], textarea');
            let isValid = true;

            inputs.forEach(function(input) {
                if (input.value.trim() === '') {
                    isValid = false;
                    alert('Please fill in all fields');
                }
            });

            if (!isValid) {
                event.preventDefault();  // Prevent form submission
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    // Confirm before applying to a job
    const applyButtons = document.querySelectorAll('form button');

    applyButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            const confirmation = confirm('Are you sure you want to apply for this job?');
            if (!confirmation) {
                event.preventDefault();  // Cancel the form submission if the user cancels
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const logoutButton = document.querySelector('.logout-button');

    if (logoutButton) {
        logoutButton.addEventListener('click', function(event) {
            const confirmation = confirm('Are you sure you want to log out?');
            if (!confirmation) {
                event.preventDefault();  // Cancel the logout if the user clicks "Cancel"
            }
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');

    loginForm.addEventListener('submit', function(event) {
        const email = loginForm.querySelector('input[name="email"]').value;
        const password = loginForm.querySelector('input[name="password"]').value;

        if (!email || !password) {
            alert('Both email and password are required.');
            event.preventDefault();  // Prevent form submission if validation fails
        }
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const postJobForm = document.getElementById('postJobForm');

    postJobForm.addEventListener('submit', function(event) {
        const title = postJobForm.querySelector('input[name="title"]').value.trim();
        const description = postJobForm.querySelector('textarea[name="description"]').value.trim();
        const salary = postJobForm.querySelector('input[name="salary"]').value;

        if (title === '' || description === '' || salary <= 0) {
            alert('Please fill in all required fields and ensure salary is a positive number.');
            event.preventDefault();  // Prevent form submission if validation fails
        }
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');

    registerForm.addEventListener('submit', function(event) {
        const password = registerForm.querySelector('input[name="password"]').value;
        const email = registerForm.querySelector('input[name="email"]').value;
        const username = registerForm.querySelector('input[name="username"]').value;

        // Basic email validation
        if (!email.includes('@')) {
            alert('Please enter a valid email address.');
            event.preventDefault();
        }

        // Password length validation
        if (password.length < 6) {
            alert('Password must be at least 6 characters long.');
            event.preventDefault();
        }

        // Username length validation
        if (username.length < 3) {
            alert('Username must be at least 3 characters long.');
            event.preventDefault();
        }
    });
});
