<?php
require_once __DIR__."/../config.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>email-verification</title>
    </head>
    <body>
        <section>
        <?php 

            $validator = $_GET["validator"];

            if (empty($validator))
            {
                echo "<p>try it later</p>";
            }
            else 
            {
                if (ctype_xdigit($validator) !== false)
                {
                ?> 

                <form action="includes/emailverification.inc.php" method="POST">
                    <input type="hidden" name="validator" value="<?=$validator?>">
                    <button type="submit" name="submit" value="S1">activate my account</button>
                    <br>
                </form>          

                <?php 
                }    
            }
        ?>



            <!-- <?php 

                if (isset($_GET["validator"]) and ctype_xdigit($_GET["validator"]) !== false)
                    {   
                        ?>          
                        <a href="includes/emailverification.inc.php">
                            localhost/app-alireza/emailverification.inc.php?validator=<?=($_GET["validator"])?>
                        </a>
                        <?php
         
                    }  
            ?> -->
            
        </section>
    </body>
</html>