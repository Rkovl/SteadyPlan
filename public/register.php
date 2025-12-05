<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/auth.php';
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/partials/defaultHead.php';
    ?>
    <title>Register - Steady Plan</title>
</head>
<body class="d-flex flex-column min-vh-100">
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/partials/header.php';
?>

<main class="d-flex flex-grow-1 flex-column justify-content-center align-items-center">
    <div class="card p-4 shadow" style="width: 100%; max-width: 600px;">
        <h2 class="text-center mb-4">Register</h2>
        <div id="error-alert" class="alert alert-danger d-none"></div>
        <form id="registerForm" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                       placeholder="Enter your email" required>
                <div class="invalid-feedback">Please enter a valid email.</div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                       placeholder="Choose a username" required>
                <div class="invalid-feedback">Please enter a username.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                       placeholder="Enter password" required minlength="8">
                <div class="invalid-feedback">Please enter a password.</div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
    </div>
</main>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/partials/footer.php';
?>
<script src="/public/js/validate-input.js"></script>
<script src="/public/js/validate-register.js"></script>
<script src="/public/js/register.js"></script>
</body>
</html>
