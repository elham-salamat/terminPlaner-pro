<?php

require_once __DIR__."/../config.php";

if (isset($_POST["submit"]))
{
    $_SESSION["topic"] = $_POST["topic"]; 
    $_SESSION["starttime"] = $_POST["starttime"]; 
    $_SESSION["endtime"] = $_POST["endtime"]; 
    $_SESSION["status"] = $_POST["status"]; 
}
?>

<!DOCTYPE html>

<html>
    <head>

    </head>
    <body>
        <h2>Search based on the filters to see how is the next plan</h2>
        
        
        <form action="<?=$baseUrl?>includes/search-inc.php" method="POST"> 
            <div class="container" style="text-align: left; margin: 25px">          
                <label for="topic"><b>Subject</b></label>
                <input name="topic" type="text" value="<?= @$_SESSION["topic"]; ?>"/>
                <br />
                <br />
   
            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    <button name="submit" value="S1" type="submit" class="btn btn-primary">search</button>
                </div>
            </div>
        
        </form>
    </body>
</html>