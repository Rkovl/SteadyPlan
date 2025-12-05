<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/auth.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/repos/userRepo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/repos/TokensRepo.php';

$error = "";
$username = $_POST['username'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'] ?? '';
    $remember_me = isset($_POST['remember_me']);

    $result = UserController::authenticateUser($username, $password, $remember_me);

    if(is_array($result)) {
        header('Location: dashboard.php');
        exit();
    } else {
        $error = $result;
    }

}
?>
<!doctype html>
<html lang="en" class="h-100">
<head>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/partials/defaultHead.php';
    ?>
    <title>Login - Steady Plan</title>
</head>
<body class="d-flex flex-column min-vh-100">
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/partials/header.php';
?>

<main class="d-flex flex-grow-1 flex-column justify-content-center align-items-center">
    <div class="card p-4 shadow" style="width: 100%; max-width: 600px;">
        <h2 class="text-center mb-4">Login</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="login.php" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                       placeholder="Enter username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required>

                <div class="invalid-feedback">
                    Please enter your username.
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password"
                       required>
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

<script src="/public/js/validate-input.js"></script>
</body>
</html>
