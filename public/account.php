<?php
session_start();
require_once __DIR__ . '/../controllers/userController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = "";
$success = "";

$userRepo = new userRepo();

$user = $userRepo->getUserById($user_id);

if (!$user) {
    $error = "User not found";
}

if (isset($_POST['update'])) {
    $current_password = $_POST['current_password'] ?? '';
    $new_username = trim($_POST['username'] ?? '');
    $new_email = trim($_POST['email'] ?? '');

    if (!password_verify($current_password, $user['password'])) {
        $error = "Incorrect current password";
    } else {
        if ($new_username && $new_username !== $user['username']) {
            $userRepo->updateUsername($new_username, $user_id);
            $_SESSION['username'] = $new_username;
        }
        if ($new_email && $new_email !== $user['email']) {
            $userRepo->updateEmail($new_email, $user_id);
        }

        $success = "Your account has been updated";
        $user = $userRepo->getUserById($user_id);
    }
}

if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password_change'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (!password_verify($current_password, $user['password'])) {
        $error = "Incorrect current password";
    } elseif ($new_password !== $confirm_password) {
        $error = "New password and confirmation do not match";
    } else {
        $userRepo->updatePassword($new_password, $user_id);
        $success = "Password successfully changed";
    }
}

if (isset($_POST['delete'])) {
    $confirm = $_POST['confirm_delete'] ?? '';
    $password = $_POST['delete_password'] ?? '';

    if ($confirm !== 'DELETE') {
        $error = "You must type DELETE to confirm account deletion.";
    } elseif (!password_verify($password, $user['password'])) {
        $error = "Password incorrect. Cannot delete account.";
    } else {
        $userRepo->deleteUser($user_id);
        session_destroy();
        header("Location: goodbye.php");
        exit();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5" style="max-width: 700px">
    <h2>Account Settings</h2>
    <hr style="height: 5px; background-color: black; border: none;">

    <form method="POST" class="mb-5 border p-3 bg-light needs-validation" novalidate>
        <h4>Update Account Info</h4>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter username" required>
            <div class="invalid-feedback">
                Please enter a username.
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter email" required>
            <div class="invalid-feedback">
                Please enter a valid email.
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Current Password (required to verify)</label>
            <input type="password" name="current_password" class="form-control" placeholder="Enter password" required>
            <div class="invalid-feedback">
                Please enter your current password.
            </div>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update Info</button>
    </form>

    <form method="POST" class="mb-5 border p-3 bg-light needs-validation" novalidate>
        <h4>Change Password</h4>

        <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" name="current_password_change" class="form-control"
                   placeholder="Enter current password" required>
            <div class="invalid-feedback">
                Please enter your current password.
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
            <div class="invalid-feedback">
                Please enter a new password.
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Re-enter new password"
                   required>
            <div class="invalid-feedback">
                Password confirmation does not match.
            </div>
        </div>
        <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
    </form>

    <form method="POST" class="border p-3 bg-light needs-validation" novalidate>
        <h4 class="text-danger">Delete Account</h4>
        <p>This action is permanent. Enter your password to confirm.</p>
        <div class="mb-3">
            <input type="password" name="delete_password" class="form-control" placeholder="Enter password" required>
            <div class="invalid-feedback">
                Please enter your password to delete your account.
            </div>
        </div>
        <button type="submit" name="delete" class="btn btn-danger">Delete Account</button>
    </form>
</div>

<script>
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

</body>
</html>
