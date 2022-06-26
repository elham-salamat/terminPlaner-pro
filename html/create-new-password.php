<?php
require_once __DIR__ . "/../config.php";
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TP-Password reset</title>

    <link href="<?= $baseUrl ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?= $baseUrl ?>assets/css/animate.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">TP</h1>

            </div>
            <?php

            $validator = $_GET["validator"];

            if (empty($validator)) {
                echo "<p>Could not reset your password at the moment. Please try it later!</p>";
            } else {
                if (ctype_xdigit($validator) !== false) {

            ?>
                    <h3>Reset your password</h3>

                    <form class="m-t" action="<?= $baseUrl ?>includes/reset-password.inc.php" method="POST">
                        <div class="form-group">
                            <input type="password" name="pwd" class="form-control" placeholder="Enter a new password">
                        </div>
                        <div class="form-group">
                            <input type="password" name="re-pwd" class="form-control" placeholder="Repeat new password">
                        </div>
                        <input type="hidden" name="validator" class="form-control" value="<?= $validator ?>">
                        <button type="submit" value="S1" name="submit" class="btn btn-primary block full-width m-b">submit</button>
                    </form>

            <?php
                }
            }
            ?>

            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?= $baseUrl ?>assets/js/jquery-2.1.1.js"></script>
    <script src="<?= $baseUrl ?>assets/js/bootstrap.min.js"></script>

</body>

</html>