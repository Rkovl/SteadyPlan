<?php
session_start();
require "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $query->execute(['username' => $username]);

    if($query->rowCount() === 1){
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if(password_verify($password, $row['password'])){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            header('Location: dashboard.php');
            exit();
        }
    }

    $error = "Wrong username or password";
}
?>