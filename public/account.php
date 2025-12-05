<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/auth.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/partials/defaultHead.php';
    ?>
    <title>Account Settings</title>
</head>
<body>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/partials/header.php';
?>
<div class="container py-5" style="max-width: 700px">
    <h2>Account Settings</h2>
    <hr style="height: 5px; background-color: black; border: none;">

    <form class="mb-5 border p-3 bg-light-subtle rounded needs-validation" id="updateAccountForm" novalidate>
        <h4>Update Account Info</h4>

        <div id="updateAccountFeedback" class="alert alert-danger d-none"></div>
        <div class="mb-3">
            <label class="form-label" for="updateUsername">Username</label>
            <input type="text" id="updateUsername" class="form-control" placeholder="Enter username" required>
            <div class="invalid-feedback">
                Please enter a username.
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="updateEmail">Email</label>
            <input type="email" id="updateEmail" class="form-control" placeholder="Enter email" required>
            <div class="invalid-feedback">
                Please enter a valid email.
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="updatePassword">Current Password (required to verify)</label>
            <input type="password" id="updatePassword" class="form-control" placeholder="Enter password" required>
            <div class="invalid-feedback">
                Please enter your current password.
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update Info</button>
    </form>

    <form class="mb-5 border p-3 bg-light-subtle rounded needs-validation" id="newPasswordForm" novalidate>
        <h4>Change Password</h4>

        <div id="newPasswordFeedback" class="alert alert-danger d-none"></div>
        <div class="mb-3">
            <label class="form-label" for="currentPasswordChange">Current Password</label>
            <input type="password" id="currentPasswordChange" class="form-control"
                   placeholder="Enter current password" required>
            <div class="invalid-feedback">
                Please enter your current password.
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="newPasswordChange">New Password</label>
            <input type="password" id="newPasswordChange" class="form-control" placeholder="Enter new password" required>
            <div class="invalid-feedback">
                Please enter a new password.
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="confirmPasswordChange">Confirm New Password</label>
            <input type="password" id="confirmPasswordChange" class="form-control" placeholder="Re-enter new password"
                   required>
            <div class="invalid-feedback">
                Password confirmation does not match.
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Change Password</button>
    </form>

    <form class="border p-3 bg-light-subtle rounded needs-validation" id="deleteAccountForm" novalidate>
        <h4 class="text-danger">Delete Account</h4>
        <div id="deleteUserFeedback" class="alert alert-danger d-none"></div>
        <label class="form-label" for="deletePassword">This action is permanent. Enter your password to confirm.</label>
        <div class="mb-3">
            <input type="password" class="form-control" id="deletePassword" placeholder="Enter password" required>
            <div class="invalid-feedback">
                Please enter your password to delete your account.
            </div>
        </div>
        <label class="form-label" for="confirmText">Please type <strong>DELETE</strong> to confirm:</label>
        <div class="mb-3">
            <input type="text" class="form-control" id="confirmDeleteText" placeholder="Type DELETE to confirm" required>
            <div class="invalid-feedback">
                You must type DELETE to confirm account deletion.
            </div>
        </div>
        <button type="submit" class="btn btn-danger">Delete Account</button>
    </form>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/partials/footer.php';
?>
<script src="/public/js/update_account.js"></script>
</body>
</html>
