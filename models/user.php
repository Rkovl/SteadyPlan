<?php
/*
 * Helps with user-related DB operations.
 */
class User {
    public $username;
    public $email;
    public $password;
    public $is_admin;

    public function __construct($username, $email, $password, $is_admin = false) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->is_admin = $is_admin;
    }
}