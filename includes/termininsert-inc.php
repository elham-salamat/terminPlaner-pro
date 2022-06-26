<?php

session_start();

require_once __DIR__ . "/../config.php";

if (isset($_POST["submit"])) {
    require_once __DIR__ . "/db-inc.php";

    $topic = $_POST["topic"];
    $location = $_POST["place"];
    $startTime = $_POST["startdate"];
    $endTime = $_POST["enddate"];
    $participants = $_POST["participants"];
    $explanation = $_POST["explanation"];
    $flexibilitySt = $_POST["status"];


    if (isset($_FILES["attachments"])) {
        $attName = $_FILES["attachments"]["name"];
        $attTmpName = $_FILES["attachments"]["tmp_name"];
        $attSize = $_FILES["attachments"]["size"];
        $attError = $_FILES["attachments"]["error"];
        $atttype = $_FILES["attachments"]["type"];

        $attExt = strtolower(explode(".", $attName)[1]);

        $allowedExt = array("jpg", "jpeg", "pdf", "zip");


        if (in_array($attExt,  $allowedExt)) {
            if ($attError === 0) {
                if ($attSize < 1000000) {
                    $newAttName = uniqid('', true) . "." . $attExt;
                    $attDestination = __DIR__ . '/../uploads/' . $newAttName;
                    move_uploaded_file($attTmpName, $attDestination);
                } else {
                    header("location: {$baseUrl}?page=dashboard&result=failed&msg=bigfile");
                    exit();
                    // echo "Your file is to big!";
                }
            } else {
                echo "There are some errors in uploadin your file! try it later.";
            }
        } else {
            echo "You cannot upload files of this type!";
        }
    }


    $userId = $_SESSION['userId'];
    $startTime = date("Y-m-d H:i:s", strtotime($startTime));
    $endTime = date("Y-m-d H:i:s", strtotime($endTime));

    $stmt = mysqli_stmt_init($dbConnect);
    $sqlQuery = "SELECT `appointmentId` FROM `usertermins` WHERE `userId` = ? AND `startDateTime` >= ? AND `endDateTime` <= ?;";

    if (!mysqli_stmt_prepare($stmt, $sqlQuery)) {
        header("location: {$baseUrl}?page=dashboard&result=failed&msg=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "iss",  $userId, $startTime, $endTime);
    mysqli_stmt_execute($stmt);

    $resultsData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultsData)) {
        $terminId = $row['appointmentId'];
        header("location: {$baseUrl}?page=dashboard&result=failed&msg=conflict&termin={$terminId}");
        exit();
    } else {

        $sqlQuery = "SELECT * FROM eventstatus WHERE runingStatus = ? and flexibility = ?;";
        $runningSt = "open";

        if (!mysqli_stmt_prepare($stmt, $sqlQuery)) {
            header("location: {$baseUrl}?page=dashboard&result=failed&msg=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $runningSt, $flexibilitySt);
        mysqli_stmt_execute($stmt);

        $resultsData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultsData)) {
            $terminNewStatus = $row['statusId'];
        }

        $sqlInsert = "INSERT INTO usertermins
        (`terminTopic`, `startDateTime`,`endDateTime`,`terminLocation`, `participants`, `importantComments`, `attachments`, `userId`, `statusId`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

        if (!mysqli_stmt_prepare($stmt, $sqlInsert)) {
            header("location: {$baseUrl}?page=dashboard&result=failed&msg=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sssssssii", $topic, $startTime, $endTime, $location, $participants, $explanation, $newAttName, $userId, $terminNewStatus);
        mysqli_stmt_execute($stmt);

        header("location: {$baseUrl}?page=dashboard&result=done&msg=insertsuccess");
        exit();
    }
    mysqli_stmt_close($stmt);
} else {
    header("location: {$baseUrl}?page=dashboard");
    exit();
}
