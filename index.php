<?php
include __DIR__ . "/config.php";
include __DIR__ . "/includes/functions-inc.php";
include __DIR__ . "/includes/db-inc.php";

session_start();

if (isset($_COOKIE["login-info"])) {
    $usernamePassword = implode(" ", $_COOKIE["login-info"]);
    $userName = $usernamePassword[0];
    $password = $usernamePassword[1];
    $cookies = "true";


    $result = "";
    $msg = "";

    if (EmptyFieldExistance($usernamePassword) !== "false" or InvalidEmail($userName)) {
        session_destroy();
        unset($_SESSION);
        setcookie("login_info", "", time() - 1, "/");
        unset($_COOKIE["login_info"]);

        if (EmptyFieldExistance($usernamePassword) !== "false") {
            $result = "failed";
            $msg = "emptyfield";
        } else if (InvalidEmail($userName)) {
            $result = "failed";
            $msg = "invalidemail";
        }

        header("location: {$baseUrl}?page=signin?result={$result}failed&msg={$msg}");
        exit();
    } else {
        SignInUser($dbConnect, $userName, $password, $cookies);
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>TP-index</title>
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/style2.css">

</head>

<body>
    <header>

    </header>
    <main>
        <?php

        if (!isset($_GET["page"])) {
            $_GET["page"] = "homepage";
        }

        switch ($_GET["page"]) {
            case "homepage":
                include(__DIR__ . "/html/home.php");
                break;

            case "contactus":
                include(__DIR__ . "/html/contactus.php");
                break;

            case "dashboard":
                include(__DIR__ . "/html/dashboard.php");
                break;

            case "search":
                include(__DIR__ . "/html/searchfilters.php");
                break;

            case "signout":
                include(__DIR__ . "/includes/signout-inc.php");
                break;

            case "signup":
                include(__DIR__ . "/html/signup.php");
                break;

            case "signin":
                include(__DIR__ . "/html/signin.php");
                break;

            case "reset-password":
                include(__DIR__ . "/html/reset-password.php");
                break;

            case "create-new-password":
                include(__DIR__ . "/html/create-new-password.php");
                break;

            case "reset-password-inc":
                include(__DIR__ . "/includes/reset-password.inc.php");
                break;

            case "profile":
                include(__DIR__ . "/html/profile.php");
                break;

            default:
                include(__DIR__ . "/html/404.php");
        }

        ?>
    </main>
</body>

</html>