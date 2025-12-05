<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/db/auth.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/userRepo.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/models/user.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? null;
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;
    $user = new User($username, $email, $password);

    if (!$email || !$username || !$password) {
        $error = "All fields are required";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long";
    } else {
        $userId = UserRepo::register($user);

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
                       placeholder="Enter password" required minlength="8">
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
<script src="/public/js/validate-input.js"></script>
<script src="/public/js/validate-register.js"></script>
</body>
</html>