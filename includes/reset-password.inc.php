<?php

require_once __DIR__ . "/../config.php";

if (isset($_POST["submit"])) {

    require_once __DIR__ . "/db-inc.php";
    require_once __DIR__ . "/functions-inc.php";

    $validator = $_POST["validator"];
    $token = hex2bin($validator);
    $password = $_POST["pwd"];
    $repeatedPassword = $_POST["re-pwd"];
    //dont touch this line 
    #$validator = password_hash($validator, PASSWORD_DEFAULT);

    if (EmptyFieldExistance($_POST) !== false) {
        header("location: {$baseUrl}?page=create-new-password&validator=$validator&result=failed&msg=emptyfield");
        exit();
    }

    if (InvalidPwd($password) !== false) {
        header("location: {$baseUrl}?page=create-new-password&validator=$validator&result=failed&msg=invalidpwd");
        exit();
    }

    if (PasswordsDontMatch($password, $repeatedPassword) !== false) {
        header("location: {$baseUrl}?page=create-new-password&validator=$validator&result=failed&msg=pwdsdontmatch");
        exit();
    }

    $currentTime = ("Y-m-d H:i:s");

    $stmt = mysqli_stmt_init($dbConnect);
    $sqlQuery = "SELECT * FROM useractivityvalidation WHERE validationCode = ? AND expiredTime >= ? ;";

    if (!mysqli_stmt_prepare($stmt, $sqlQuery)) {
        header("location: {$baseUrl}?page=reset-password&result=failed&msg=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $token, $currentTime);
    mysqli_stmt_execute($stmt);

    $resultsData = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($resultsData);

    if (!isset($row['activityId'])) {
        header("location: {$baseUrl}?page=reset-password&result=failed&msg=tokennotfound");
        exit();
    } else {
        if ($token !== $row["validationCode"]) {
            header("location: {$baseUrl}?page=reset-password&result=failed&msg=invalidtoken");
            exit();
        } else {
            $userId = $row["userId"];
        }
    }

    $sqlUpdate = "UPDATE users SET pwd = ? WHERE userId = ?;";

    if (!mysqli_stmt_prepare($stmt, $sqlUpdate)) {
        header("location: {$baseUrl}?page=reset-password&result=failed&msg=stmtfailed");
        exit();
    } else {
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT, ['cost' => 15]);
        mysqli_stmt_bind_param($stmt, "si", $hashedPwd, $userId);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    header("location: {$baseUrl}?page=signin&result=done");
    exit();
} else {
    header("location: {$baseUrl}?page=signin");
    exit();
}
