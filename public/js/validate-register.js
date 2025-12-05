const $reg_forms = $('.needs-validation');
for (let form of $reg_forms) {
    form.addEventListener('submit', () => {
        const $passwordInput = $('#password');
        const $feedback = $('#passwordFeedback');
        if ($passwordInput.val().length === 0) {
            $feedback.text("Please enter a password.");
        } else if ($passwordInput.val().length < 6) {
            $feedback.text("Password must be at least 6 characters.");
        }
    }, false);
}