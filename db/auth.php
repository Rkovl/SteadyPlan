<?php
session_start();

function isLoggedIn() {
//    return isset($_SESSION['user_id']);
    if(isset($_SESSION['login_cookie'])) {}
}

?>