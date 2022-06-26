<?php

require_once __DIR__ . "/../config.php";

if (isset($_GET["validator"])) {


    require_once __DIR__ . "/db-inc.php";
    require_once __DIR__ . "/functions-inc.php";

    $validator = $_GET["validator"];
    $token = hex2bin($validator);
    $currentTime = ("Y-m-d H:i:s");

    $stmt = mysqli_stmt_init($dbConnect);
    $sqlQuery = "SELECT * FROM useractivityvalidation WHERE validationCode = ? AND expiredTime >= ? ;";

    if (!mysqli_stmt_prepare($stmt, $sqlQuery)) {
        header("location: {$baseUrl}?page=signin&result=failed&msg=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $token, $currentTime);
    mysqli_stmt_execute($stmt);

    $resultsData = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($resultsData);

    if (!isset($row['activityId'])) {
        header("location: {$baseUrl}?page=signin&result=failed&msg=tokennotfound");
        exit();
    } else {
        if ($token !== $row["validationCode"]) {
            header("location: {$baseUrl}?page=signin&result=failed&msg=invalidtoken");
            exit();
        } else {
            $userId = $row["userId"];
        }
    }

    $sqlUpdate = "UPDATE users SET userStatus = ? WHERE userId = ?;";

    if (!mysqli_stmt_prepare($stmt, $sqlUpdate)) {
        header("location: {$baseUrl}?page=signin&result=failed&msg=stmtfailed");
        exit();
    } else {
        $userStatus = 1;

        mysqli_stmt_bind_param($stmt, "ii", $userStatus, $userId);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);

    header("location: {$baseUrl}?page=signin&result=done&msg=successfulverification");
    exit();
} else {
    header("location: {$baseUrl}?page=signup");
    exit();
}
