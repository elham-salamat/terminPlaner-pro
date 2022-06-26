<?php

require_once __DIR__ . "/../config.php";

function SignInUser($dbConnect, $userName, $password, $cookies)
{
    global $baseUrl;
    $userExistance = UserExists($dbConnect, $userName);
    if ($userExistance === false) {
        header("location: {$baseUrl}?page=signin&result=failed&msg=notexists");
        exit();
    } else {
        $hashedPassword = UserExists($dbConnect, $userName)["pwd"];
        $checkPassword = password_verify($password, $hashedPassword);

        if (!$checkPassword) {
            header("location: {$baseUrl}?page=signin&result=failed&msg=wrongpwd");
            exit();
        } else {

            $_SESSION["userId"] = $userExistance["userId"];
            $_SESSION["email"] = $userExistance["email"];
            $_SESSION["username"] = $userExistance["firstName"];

            if ($cookies) {
                setcookie("login_info", "{$userName} {$password}", time() + 60 * 60 * 24 * 30, "/");
            }

            header("location: {$baseUrl}");
            exit();
        }
    }
}


function UserExists($dbConnect, $email)
{
    global $baseUrl;

    $stmt = mysqli_stmt_init($dbConnect);
    $sqlQuery = "SELECT * FROM users WHERE email = ? ;";

    if (!mysqli_stmt_prepare($stmt, $sqlQuery)) {
        header("location: {$baseUrl}?page=signup&result=failed&msg=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultsData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultsData)) {
        return $row;
    } else {
        return false;
    }

    mysqli_stmt_close($stmt);
}


function GetCountryId($dbConnect, $countryFlag)
{
    $sqlQuery = "SELECT * FROM `region` WHERE `countryFlag` = '{$countryFlag}';";
    #$sql = "SELECT * FROM `region` WHERE `countryFlag` = $countryFlag;";

    $result = mysqli_fetch_assoc(mysqli_query($dbConnect, $sqlQuery));
    return $result;
}


function EmptyFieldExistance($input = [])
{

    if ($input["submit"] == "S1") {
        // if($input["firstname"]=="" or $input["lastname"]=="" or $input["email"]=="" or $input["pwd"]=="" or $input["re-pwd"]==""){
        //     $result = true;
        // }
        // else{
        //     $result = false;
        // }

        foreach ($input as $item) {
            $result = false;
            if ($item == "") {
                $result = true;
                break;
            }
        }
    }
    return $result;
}

function InvalidEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        return true;
    }
}

function InvalidPwd($password)
{
    $result = false;
    #if (! strlen($password)>= 6 and (preg_match("/(?=.*[a-z])(?=.*[A-Z])(?=.*[!#$%^&_])[a-zA-Z0-9!#$%^&_]/", $password))){
    if (!preg_match("/(?=.*[a-z])(?=.*[A-Z])(?=.*[!#$%^&_])[a-zA-Z0-9!#$%^&_]{6,}/", $password)) {
        $result = true;
    }

    return $result;
}

function PasswordsDontMatch($password, $repeatedPassword)
{
    $result = false;
    if ($password !== $repeatedPassword) {
        return true;
    }
    return $result;
}

function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}


// function UserCreate($dbConnect, $firstName, $lastName, $email, $password, $countryId){

//     global $baseUrl;

//     $stmt = mysqli_stmt_init($dbConnect);
//     $sqlInsert = "INSERT INTO users (firstName, lastName, email, pwd, regionId) VALUES (?,?,?,?,?);";

//     if (!mysqli_stmt_prepare($stmt, $sqlInsert))
//     {
//         header("location: {$baseUrl}?page=signup&error=stmtfailed");
//         exit();
//     }

//     $hashedPwd = password_hash($password, PASSWORD_DEFAULT, ['cost' => 15]);

//     // mysqli_stmt_bind_param($stmt, "ssss", $input["fisrtname"], $input["lastname"],$input["email"],$hashedPwd);
//     mysqli_stmt_bind_param($stmt, "ssssi",$firstName, $lastName, $email,$hashedPwd,$countryId);
//     #print_r(mysqli_stmt_execute($stmt));
//     mysqli_stmt_execute($stmt);
//     #die(mysqli_info($connect));

//     $userId = GetUserID($dbConnect, $email)["userId"];

//     mysqli_stmt_close($stmt);
//     return $userId;

//     // header("location: {$baseUrl}?page=signup&error=none");
//     // exit();
// }


function GetUserId($dbConnect, $email)
{
    $sqlQuery = "SELECT * FROM users WHERE email = '{$email}';";
    // $sqlQuery = "SELECT * FROM `users` WHERE `email` = $email;";

    $result = mysqli_fetch_assoc(mysqli_query($dbConnect, $sqlQuery));
    return $result;
}


function GenerateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
