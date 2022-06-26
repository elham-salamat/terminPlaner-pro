<?php

require_once __DIR__ . "/../config.php";

if (isset($_POST["submit"])) {

    require_once __DIR__ . "/db-inc.php";
    require_once __DIR__ . "/functions-inc.php";

    $userEmail = $_POST["email"];
    $userId = GetUserId($dbConnect, $userEmail)["userId"];


    $token = md5(GenerateRandomString(20));
    $url = "{$baseUrl}?page=create-new-password&validator=" . bin2hex($token);

    $startDate  = date("Y-m-d H:i:s");
    $expireDate    = strtotime("+10 minutes", strtotime($startDate));
    $expireDate = date('Y-m-d H:i:s', $expireDate);
    $typeId = 2;

    $stmt = mysqli_stmt_init($dbConnect);
    $sqlDelete = "DELETE FROM useractivityvalidation WHERE userId = ? and typeId = ?;";


    if (!mysqli_stmt_prepare($stmt, $sqlDelete)) {
        header("location: {$baseUrl}?page=signin&result=failed&msg=stmtfailed");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ii", $userId, $typeId);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);


    $sql = "INSERT INTO useractivityvalidation (validationCode, CreatedTime, expiredTime, userId, typeId) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($dbConnect);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: {$baseUrl}");
        exit();
    } else {
        $hashedToken = $token; #password_hash($token, PASSWORD_DEFAULT, ['cost' => 15]);

        mysqli_stmt_bind_param($stmt, "sssii", $hashedToken, $startDate, $expireDate, $userId, $typeId);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);

    mysqli_close($dbConnect);

    $to = "mari.salamat63@gmail.com";
    $subject = "reset your password for terminplaner";

    $message = "<p> We recieved a password reset request. The link to reset your password </p>";
    $message .= "<p>Here is your password reset link: </br>";
    $message .= "<a href='{$url}'>{$url}</a></p>";


    die($message);

    $header = "From: eli.salamat63@gmail.com\r\n";
    $header .= "Reply-To: mari.salamat63@gmail.com\r\n";
    $header .= "Content-type: text/html; charset=utf-8\n";

    $mail = mail($to, $subject, $message, $header);

    if ($mail) {
        header("location: {$baseUrl}?page=reset-password&result=done");
        exit();
    } else {
        header("location: {$baseUrl}?page=reset-password&result=failed");
        exit();
    }
} else {
    header("location: {$baseUrl}");
    exit();
}
