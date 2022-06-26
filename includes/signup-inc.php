<?php

require_once __DIR__ . "/../config.php";

if (isset($_POST["submit"])) {
    require_once "db-inc.php";
    require_once "functions-inc.php";

    $firstName = $_POST["firstname"];
    $lastName = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["pwd"];
    $repeatedPassword = $_POST["re-pwd"];
    $countryId = GetCountryId($dbConnect, $_POST["flag"])['regionId'];

    if (EmptyFieldExistance($_POST) !== false) {
        header("location: {$baseUrl}?page=signup&result=failed&msg=emptyfield");
        exit();
    }

    if (InvalidEmail($email)) {
        header("location: {$baseUrl}?page=signup&result=failed&msg=invalidemail");
        exit();
    }

    if (InvalidPwd($password)) {
        header("location: {$baseUrl}?page=signup&result=failed&msg=invalidpwd");
        exit();
    }

    if (PasswordsDontMatch($password, $repeatedPassword)) {
        header("location: {$baseUrl}?page=signup&result=failed&msg=pwdsdontmatch");
        exit();
    }

    if (UserExists($dbConnect, $email) !== false) {
        header("location: {$baseUrl}?page=signup&result=failed&msg=userexists");
        exit();
    }

    $stmt = mysqli_stmt_init($dbConnect);
    $sqlInsert = "INSERT INTO users (firstName, lastName, email, pwd, regionId) VALUES (?,?,?,?,?);";

    if (!mysqli_stmt_prepare($stmt, $sqlInsert)) {
        header("location: {$baseUrl}?page=signup&result=failed&msg=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($password, PASSWORD_DEFAULT, ['cost' => 15]);

    mysqli_stmt_bind_param($stmt, "ssssi", $firstName, $lastName, $email, $hashedPwd, $countryId);
    mysqli_stmt_execute($stmt);

    $userId = GetUserId($dbConnect, $email)["userId"];

    $msg = "You signed up successfully.";

    #$token = random_bytes(32);
    $token = md5(GenerateRandomString(20));
    $url = "{$baseUrl}includes/emailverification-inc.php?validator=" . bin2hex($token);

    $startDate = date("Y-m-d H:i:s");
    $expireDate = strtotime("+10 minutes", strtotime($startDate));
    $expireDate = date('Y-m-d H:i:s', $expireDate);
    $typeId = 1;

    $sqlDelete = "DELETE FROM useractivityvalidation WHERE userId = ? and typeId = ?;";

    if (!mysqli_stmt_prepare($stmt, $sqlDelete)) {
        header("location: {$baseUrl}?page=signup&result=failed&msg=stmtfailed");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ii", $userId, $typeId);
        mysqli_stmt_execute($stmt);
    }

    $sqlInsert = "INSERT INTO useractivityvalidation (validationCode, CreatedTime, expiredTime, userId, typeId) VALUES (?, ?, ?, ?, ?);";

    if (!mysqli_stmt_prepare($stmt, $sqlInsert)) {
        header("location: {$baseUrl}?page=signup&result=failed&msg=stmtfailed");
        exit();
    } else {
        // $hashedToken = $token;#password_hash($token, PASSWORD_DEFAULT, ['cost' => 15]);  
        mysqli_stmt_bind_param($stmt, "sssii", $token, $startDate, $expireDate, $userId, $typeId);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);

    $to = "eli.salamat63@gmail.com";

    $subject = "Activate your email for terminplaner";

    $message = "<p> We recieved a signup request. The link to activate your account </p>";
    $message .= "<p>Here is your activation link: </br>";
    $message .= "<a href='{$url}'>{$url}</a></p>";

    die($message);

    $header = "From: terminplaner <eli.salamat63@gmail.com>\r\n";
    $header .= "Reply-To eli_salamat63@yahoo.com\r\n";
    $header .= "Content-type : text/html";

    $mail = mail($to, $subject, $message, $header);

    header("location: {$baseUrl}?page=signup&result=done&msg=mailsent");
    exit();
} else {
    header("location:{$baseUrl}?page=signup");
    exit();
}
