<?php

require_once __DIR__."/../config.php";
require_once __DIR__."/db-inc.php";

if (isset($_POST["submit"]))
{

    $filterValues = strtoupper($_POST["topic"]);

    $stmt = mysqli_stmt_init($dbConnect);
    $sqlQuery = "SELECT * FROM `usertermins` JOIN `eventstatus` 
    ON usertermins.statusId = eventstatus.statusId   
    WHERE UPPER(`terminTopic`) LIKE ? ORDER BY startDateTime;";

    if (!mysqli_stmt_prepare($stmt, $sqlQuery))
    {
        header("location: {$baseUrl}?page=dashboard&result=failed&msg=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $filterValues);
    mysqli_stmt_execute($stmt);

    $records = mysqli_fetch_all(mysqli_stmt_get_result($stmt));
 
    for ($i = 1; $i <= count($records); $i++)
        
        {
            echo "Topic: "; 
            echo $records[$i-1][1];
            echo "From: ";
            echo $records[$i-1][2];
            echo "<br/>";
            echo "To: ";
            echo $records[$i-1][3];
            echo "<br/>";
            echo "In: ";
            echo $records[$i-1][4];
            echo "<br/>";
            echo "Participants: ";
            echo $records[$i-1][5];
            echo "<br/>";
            echo "explanation: ";
            echo $records[$i-1][6];
            echo "<br/>";
            echo "attachments: ";
            echo $records[$i-1][7];
            echo "<br/>";
            echo "final status: ";
            echo $records[$i-1][11];
            echo ",  ";
            echo $records[$i-1][12];
            echo "<br/>";
            ?>
            <div class="panel-footer">
                <form method="POST" action="<?=$baseUrl?>includes/termindelete-inc.php">                               
                <button type="submit" class="btn btn-sm btn-primary m-t-n-xs" name="submit" value='"<?=$records[$i-1][0]?>"."update"'>
                    <strong>Update</strong>
                <button type="submit" class="btn btn-sm btn-danger m-t-n-xs" name="submit" value='"<?= $records[$i-1][0]?>"."delete"'>
                    <strong>Delete</strong>
                                    
                </form>
            </div>

            <?php
        }
    }
           
?>




