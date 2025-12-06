<?php
/*
 * User login page.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/auth.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}
?>
<!doctype html>
<html lang="en" class="h-100">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/partials/defaultHead.php'; ?>
    <title>Login - Steady Plan</title>
</head>
<body class="d-flex flex-column min-vh-100">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/partials/header.php'; ?>

<main class="d-flex flex-grow-1 flex-column justify-content-center align-items-center">
    <div class="card p-4 shadow" style="width: 100%; max-width: 600px;">
        <h2 class="text-center mb-4">Login</h2>
        <div id="error-alert" class="alert alert-danger d-none"></div>
        <form id="loginForm" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                       placeholder="Enter username" required>
                <div class="invalid-feedback">
                    Please enter your username.
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                       placeholder="Enter password" required>
                <div class="invalid-feedback">
                    Please enter your password.
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                <label class="form-check-label" for="remember_me">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="text-center mt-3">Don't have an account? <a href="register.php">Sign up</a></p>
    </div>
</main>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/partials/footer.php';
?>

<script src="/public/js/login.js"></script>
</body>
</html>