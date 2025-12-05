$('#registerForm').on('submit', async e => {
    e.preventDefault();

    const errorAlert = $('#error-alert');
    errorAlert.addClass('d-none');

    const formData = {
        email: $('#email').val(),
        username: $('#username').val(),
        password: $('#password').val()
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
