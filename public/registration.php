<?php
session_start();
require "db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = $pdo->prepare("
        INSERT INTO users (email, username, password)
        VALUES (:email, :username, :password)"
    );

    try {
        $query->execute([
            "email" => $email,
            "username" => $username,
            "password" => $password
        ]);
        $success = "Registration successful";
    } catch (PDOException $e) {
        $error = "Username or email already exists";
    }
}
?>
