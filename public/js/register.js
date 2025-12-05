$('#registerForm').on('submit', async e => {
    e.preventDefault();

    // Client-side validation
    const form = e.target;
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    const $passwordInput = $('#password');
    const $feedback = $('#passwordFeedback');
    if ($passwordInput.val().length === 0) {
        $feedback.text("Please enter a password.");
        return;
    } else if ($passwordInput.val().length < 8) {
        $feedback.text("Password must be at least 8 characters.");
        return;
    }

    const errorAlert = $('#error-alert');
    errorAlert.addClass('d-none');

    const formData = {
        email: $('#email').val(),
        username: $('#username').val(),
        password: $passwordInput.val()
    };

    try {
        const response = await fetch('/SteadyPlan/api/register.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (response.ok) {
            window.location.href = '/SteadyPlan/public/login.php';
        } else {
            errorAlert.text(data.error || 'Registration failed');
            errorAlert.removeClass('d-none');
        }
    } catch (error) {
        errorAlert.text('An error occurred. Please try again.');
        errorAlert.removeClass('d-none');
    }
});
