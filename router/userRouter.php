<?php
require_once __DIR__ . '/../controllers/userController.php';

// $method represents the HTTP request type, $path is what kind of data you are passing eg. '/users',
function route($method, $path) {
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $req_method = $_SERVER['REQUEST_METHOD'];

    if($method === $req_method && $path === $url) {

    }
}