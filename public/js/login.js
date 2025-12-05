$('#loginForm').on('submit', async (e) => {
    e.preventDefault();

    // Client-side validation
    const form = e.target;
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    const errorAlert = $('#error-alert');
    errorAlert.addClass('d-none');

    const formData = {
        username: $('#username').val(),
        password: $('#password').val(),
        remember_me: $('#remember_me').is(':checked') ? 1 : 0
    };

    try {
        const response = await fetch('/api/login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (response.ok) {
            window.location.href = '/SteadyPlan/public/dashboard.php';
        } else {
            // Server-side error
            errorAlert.text(data.error || 'Login failed');
            errorAlert.removeClass('d-none');
        }
    } catch (error) {
        // Network/parsing error
        errorAlert.text('An error occurred. Please try again.');
        errorAlert.removeClass('d-none');
    }
});
