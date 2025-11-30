<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/auth.php';
?>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/userRepo.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? null;
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;

    if (!$username || !$email || !$password) {
        $error = "All fields are required";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long";
    } else {
        $userRepo = new UserRepo();
        $userId = $userRepo->register($password, $username, $email);

        if ($userId) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Username or email already exists";
        }
    }
}
?>


<!doctype html>
<html lang="en" class="h-100">
<head>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/partials/defaultHead.php';
    ?>
    <title>Register - Steady Plan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/partials/header.php';
?>

<main class="d-flex flex-grow-1 flex-column justify-content-center align-items-center">
    <div class="card p-4 shadow" style="width: 100%; max-width: 600px;">
        <h2 class="text-center mb-4">Register</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="register.php" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                       placeholder="Enter your email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                <div class="invalid-feedback">
                    Please enter a valid email.
                </div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                       placeholder="Choose a username" value="<?php echo htmlspecialchars($username ?? ''); ?>"
                       required>
                <div class="invalid-feedback">
                    Please enter a username.
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                       placeholder="Enter password" required minlength="6">
                <div class="invalid-feedback" id="passwordFeedback">
                    Please enter a password.
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
    </div>
</main>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/partials/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                const passwordInput = form.querySelector('#password');
                const feedback = form.querySelector('#passwordFeedback');
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                if (passwordInput.value.length === 0) {
                    feedback.textContent = "Please enter a password."
                } else if (passwordInput.value.length < 6) {
                    feedback.textContent = "Password must be at least 6 characters."
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
</body>
</html>