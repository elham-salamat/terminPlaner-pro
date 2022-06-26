<?php
require_once __DIR__ . "/../config.php";
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TP-Sign up</title>

    <link href="<?= $baseUrl ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/css/animate.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInUp">
        <div>
            <div>
                <h1 class="logo-name">TP</h1>
            </div>
            <h3>Register to Termin Planer</h3>
            <p>Create account to see it in action.</p>
            <form class="m-t" role="form" action="<?= $baseUrl ?>includes/signup-inc.php" method="POST">
                <div class="form-group">
                    <input name="firstname" type="text" class="form-control" placeholder="First Name*">
                </div>
                <div class="form-group">
                    <input name="lastname" type="text" class="form-control" placeholder="Last Name*">
                </div>
                <div class="form-group">
                    <input name="email" type="email" class="form-control" placeholder="Email*">
                </div>
                <div class="form-group">
                    <input name="pwd" type="password" class="form-control" placeholder="Password*">
                </div>
                <div class="form-group">
                    <input name="re-pwd" type="password" class="form-control" placeholder="Repeat Password*">
                </div>

                <div class="form-group">
                    <select class="form-control m-b" name="flag">
                        <option>select country</option>
                        <option value="DE">Germany</option>
                        <option value="IR">Iran, Islamic Republic of</option>
                        <option value="US">United States</option>
                    </select>
                </div>
                <button name="submit" value="S1" type="submit" class="btn btn-primary block full-width m-b">Sign Up</button>

                <?php

                if (isset($_GET["result"]) and isset($_GET["msg"])) {

                    $message = "";
                    switch ($_GET['result']) {
                        case "done":
                            switch ($_GET['msg']) {
                                case "signedup":
                                    $message = "You signed up succssfully";
                                    break;

                                case "mailsent":
                                    $message = "To use 'TP' efficiently you should verify your email first. An activation link was send to your email. Please check you email!";
                                    break;
                            }

                            echo
                            "
                                <div class='alert alert-success alert-dismissable'>
                                    <button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>
                                    {$message}
                                </div>
                            ";
                            break;

                        case "failed":
                            switch ($_GET["msg"]) {
                                case "emptyfield":
                                    $message = "All the fields need to be filled!";
                                    break;

                                case "invalidemail":
                                    $message = "Enter a valid email, please!";
                                    break;

                                case "invalidpwd":
                                    $message = "Enter a valid password, please!";
                                    break;

                                case "pwdsdontmatch":
                                    $message = "Passwords don't match!";
                                    break;

                                case "userexists":
                                    $message = "You are already signed up!";
                                    break;

                                case "stmtfailed":
                                    $message = "Something went wrong. Try it later, please.";
                                    break;
                            }

                            echo
                            "
                                <div class='alert alert-danger alert-dismissable'>
                                    <button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>
                                    {$message}
                                </div>
                            ";
                            break;
                    }
                }

                ?>
                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="<?= $baseUrl ?>?page=signin">Sign in</a>
            </form>
            <p class="m-t"><strong>All rights reserved</strong> 2021 &copy; <a href="#">Razieh Salamat</a></p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?= $baseUrl ?>assets/js/jquery-2.1.1.js"></script>
    <script src="<?= $baseUrl ?>assets/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?= $baseUrl ?>assets/js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
</body>



</html>