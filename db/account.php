<?php
require_once "database.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = "";
$success = "";
// Change all this shi later once Jons done with his weird models
$query = $pdo->prepare("SELECT username, email FROM user WHERE id = :id");
$query->execute(['id' => $user_id]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update'])) {
    $current_password = $_POST['current_password'];
    $new_username = trm($_POST['username']);
    $new_email = trim($_POST['email']);

    $query = $pdo->prepare("SELECT password FROM users WHERE id = :id");
    $query->execute(['id' => $user_id]);
    $row = $query->fetch(PDO::FETCH_ASSOC);

    if(!password_verify($current_password, $row['password'])) {
        $error = "Incorrect password";
    } else {
        $query = $pdo->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
        $query->execute([
            'username' => $new_username,
            'email' => $new_email,
            'id' => $user_id
        ]);
        $_SESSION['username'] = $new_username;
        $success = "Your account has been updated";
    }
}
// Add handle delete logic later


