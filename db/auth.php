<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/repos/TokensRepo.php');
function isLoggedIn() {
    if (isset($_SESSION["user_id"])) {
        return true;
    }

    TokensRepo::purgeTokens();

    if(isset($_COOKIE['login_cookie'])) {
        $login_token = $_COOKIE['login_cookie'];
        $user_id = TokensRepo::authenticateToken($login_token);

        if($user_id) {
            return true;
        }
    }
    return false;
}
?>