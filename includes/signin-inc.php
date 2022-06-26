<?php

session_start();
require_once __DIR__ . "/../config.php";

if (isset($_POST["submit"])) {

    include __DIR__ . "/db-inc.php";
    include __DIR__ . "/functions-inc.php";

    $userName = $_POST["email"];
    $password = $_POST["pwd"];

    if (isset($_POST["remember-me"]))
        $cookies = (bool)$_POST["remember-me"];
    else
        $cookies = false;

    if (EmptyFieldExistance($_POST) !== false) {
        header("location: {$baseUrl}?page=signin?result=failed&msg=emptyfield");
        exit();
    }

    if (InvalidEmail($userName)) {
        header("location: {$baseUrl}?page=signin?result=failed&msg=invalidemail");
        exit();
    }

    SignInUser($dbConnect, $userName, $password, $cookies);
} else {
    header("location: {$baseUrl}?page=signin");
    exit();
}
