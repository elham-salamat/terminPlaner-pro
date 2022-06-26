<?php

require_once __DIR__ . "/../config.php";

if (isset($_POST["submit"])) {

    require_once __DIR__ . "/db-inc.php";

    $submitValue = explode(".", $_POST["submit"]);


    $action = str_replace('"', '', $submitValue[1]);

    $appointmentId = (int)str_replace('"', '', $submitValue[0]);

    if ($action == "delete") {

        $stmt = mysqli_stmt_init($dbConnect);
        $sqlQuery = "SELECT * FROM usertermins WHERE appointmentId = ?;";

        if (!mysqli_stmt_prepare($stmt, $sqlQuery)) {
            header("location: {$baseUrl}?page=dashboard&result=failed&msg=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $appointmentId);
        mysqli_stmt_execute($stmt);

        $resultsData = mysqli_stmt_get_result($stmt);

        if (!$terminRow = mysqli_fetch_assoc($resultsData)) {
            header("location: {$baseUrl}?page=dashboard&result=failed&msg=notfound");
            exit();
        }

        if (!in_array($terminRow['statusId'], [5, 6])) {
            header("location: {$baseUrl}?page=dashboard&result=failed&msg=stillopen");
            exit();
        } else {

            $sqlDelete = "DELETE FROM usertermins WHERE appointmentId = ? ;";

            if (!mysqli_stmt_prepare($stmt, $sqlDelete)) {
                header("location: {$baseUrl}?page=dashboard&result=failed&msg=stmtfailed");
                exit();
            }

            mysqli_stmt_bind_param($stmt, "i", $appointmentId);
            mysqli_stmt_execute($stmt);

            header("location: {$baseUrl}?page=dashboard&result=done&msg=deletesuccess");
            exit();
        }
    }

    if ($action == "update") {

        $stmt = mysqli_stmt_init($dbConnect);
        $sqlQuery = "SELECT * FROM usertermins WHERE appointmentId = ?;";

        if (!mysqli_stmt_prepare($stmt, $sqlQuery)) {
            header("location: {$baseUrl}?page=dashboard&result=failed&msg=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $appointmentId);
        mysqli_stmt_execute($stmt);

        $resultsData = mysqli_stmt_get_result($stmt);

        if (!$terminRow = mysqli_fetch_assoc($resultsData)) {
            header("location: {$baseUrl}?page=dashboard&result=failed&msg=notfound");
            exit();
        } else {
            header("location: {$baseUrl}html/updateform.php?termin={$appointmentId}");
            exit();
        }
    }

    if ($action == "sendupdate") {

        $topic = $_POST["topic"];
        $location = $_POST["place"];
        $startTime = date("Y-m-d H:i:s", strtotime($_POST["startdate"]));
        $endTime = date("Y-m-d H:i:s", strtotime($_POST["enddate"]));
        $participants = $_POST["participants"];
        $explanation = $_POST["explanation"];
        $runningSt = $_POST["runningstatus"];
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
                        echo "Your file is to big!";
                    }
                } else {
                    echo "There are some errors in uploadin your file! try it later.";
                }
            } else {
                echo "You cannot upload files of this type!";
            }
        }

        $stmt = mysqli_stmt_init($dbConnect);
        $sqlQuery = "SELECT * FROM eventstatus WHERE runingStatus = ? and flexibility = ?;";

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


        $sqlUpdate = "UPDATE `usertermins`
        SET `terminTopic` = ?, `startDateTime` = ?,`endDateTime` = ?, `terminLocation` = ?,
        `participants` = ?, `importantComments` = ?, `attachments` = ? , `statusId` = ?
        WHERE appointmentId = ?;";

        if (!mysqli_stmt_prepare($stmt, $sqlUpdate)) {
            header("location: {$baseUrl}?page=dashboard&result=failed&msg=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sssssssii", $topic, $startTime, $endTime, $location, $participants, $explanation, $newAttName, $terminNewStatus, $appointmentId);
        mysqli_stmt_execute($stmt);

        header("location: {$baseUrl}?page=dashboard&result=done&msg=updatesuccess");
        exit();

        mysqli_stmt_close($stmt);
    }
} else {
    header("location: {$baseurl}?page=dashboard");
    exit();
}
