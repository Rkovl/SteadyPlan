function resetAlert($element) {
    $element.addClass('d-none');
    $element.removeClass('alert-danger');
    $element.removeClass('alert-success');
}

function updateAlert(element, message, isSuccess) {
    element.text(message);
    element.removeClass('d-none');
    if (isSuccess) {
        element.addClass('alert-success');
    } else {
        element.addClass('alert-danger');
    }
}

$('#deleteAccountForm').on('submit', async (e) => {
    e.preventDefault();

    // Client-side validation
    const form = e.target;
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    const $errorAlert = $('#deleteUserFeedback');
    resetAlert($errorAlert);

    const formData = {
        password: $('#deletePassword').val(),
        confirm_text: $('#confirmDeleteText').val()
    };

    try {
        const response = await fetch('/SteadyPlan/api/deregister.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData),
            credentials: 'same-origin'
        });

        const data = await response.json();

        if (response.ok) {
            logOut();
        } else {
            // Server-side error
            updateAlert($errorAlert, data.error || 'Account deletion failed', false);
        }
    } catch (error) {
        // Network/parsing error
        updateAlert($errorAlert, 'An error occurred. Please try again.', false);
    }
});

$('#updateAccountForm').on('submit', async (e) => {
    e.preventDefault();

    // Client-side validation
    const form = e.target;
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    const $errorAlert = $('#updateAccountFeedback');
    resetAlert($errorAlert);

    const formData = {
        username: $('#updateUsername').val(),
        email: $('#updateEmail').val(),
        password: $('#updatePassword').val(),
        update_type: 'account_info'
    };

    try {
        const response = await fetch('/SteadyPlan/api/update-user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData),
            credentials: 'same-origin'
        });

        const data = await response.json();

        if (response.ok) {
            updateAlert($errorAlert, 'Account updated successfully', true);
        } else {
            // Server-side error
            updateAlert($errorAlert, data.error || 'Account update failed', false);
        }
    } catch (error) {
        // Network/parsing error
        updateAlert($errorAlert, 'An error occurred. Please try again.', false);
    }
});

$('#newPasswordForm').on('submit', async (e) => {
    e.preventDefault();

    // Client-side validation
    const form = e.target;
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }
    let $newPassword = $('#newPasswordChange');
    let $confirmPassword = $('#confirmPasswordChange');
    let $passwordFeedback = $('#newPasswordFeedback');
    resetAlert($passwordFeedback);

    if ($newPassword.val() !== $confirmPassword.val()) {
        updateAlert($passwordFeedback, 'New password and confirmation do not match.', false);
        return;
    }

    $passwordFeedback.addClass('d-none');

    const formData = {
        password: $('#currentPasswordChange').val(),
        new_password: $newPassword.val(),
        confirm_password: $confirmPassword.val(),
        update_type: 'password'
    };

    try {
        const response = await fetch('/SteadyPlan/api/update-user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData),
            credentials: 'same-origin'
        });

        const data = await response.json();

        if (response.ok) {
            updateAlert($errorAlert, 'Password reset successfully.', true);
        } else {
            // Server-side error
            updateAlert($passwordFeedback, data.error || 'Password reset failed', false);
        }
    } catch (error) {
        // Network/parsing error
        updateAlert($passwordFeedback, 'An error occurred. Please try again.', false);
    }
});
