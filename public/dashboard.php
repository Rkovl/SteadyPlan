<?php
require_once __DIR__ . '/../db/auth.php';
if(!isLoggedIn()){
    header('Location: index.php');
    exit();
}
?>