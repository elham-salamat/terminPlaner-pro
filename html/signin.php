<?php
require_once __DIR__ . "/../config.php";
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TP-Sign in</title>

    <link href="<?= $baseUrl ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?= $baseUrl ?>assets/css/animate.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/css/plugins/iCheck/custom.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">TP</h1>

            </div>
            <h3>Welcome to Termin Planer</h3>
            <p>Are you searching for an efficient way to organize your life.
            </p>
            <p>Sign in to TP to see its capability.</p>
            <form class="m-t" action="<?= $baseUrl ?>includes/signin-inc.php" method="POST">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="password" name="pwd" class="form-control" placeholder="Password">
                </div>
                <div class="col-lg-12 col-lg-pull-3 col-md-pull-3">
                    <div class="i-checks">
                        <label class="">
                            <div class="icheckbox_square-green" style="position: relative;">
                                <input type="checkbox" name="remember-me" style="position: absolute; opacity: 0;">
                                <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                            </div>
                            <i></i> Remember me
                        </label>
                    </div>
                </div>
                <button type="submit" value="S1" name="submit" class="btn btn-primary block full-width m-b">Sign In</button>

                <?php

                if (isset($_GET["result"]) and isset($_GET["msg"])) {

                    $message = "";
                    switch ($_GET["result"]) {
                        case "done":
                            switch ($_GET['msg']) {
                                case "successfulverification":
                                    $message = "our email verified successfully! Now you have more features when signing in!";
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
                                    $message = "all the fields need to be filled!";
                                    break;

                                case "invalidemail":
                                    $message = "please enter a valid email!";
                                    break;

                                case "wrongpwd":
                                    $message = "you entered a wrong password!";
                                    break;

                                case "notexists":
                                    $message = "you are already signed up";
                                    break;

                                case "stmtfailed" or "tokennotfound" or "invalidtoken":
                                    $message = "when verifying your email, something went wrong. Please try it later!";
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

                <a href="<?= $baseUrl ?>?page=reset-password"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="<?= $baseUrl ?>?page=signup">Create an account</a>
            </form>

            <p class="m-t"> <strong>All rights reserved</strong> 2021 &copy; <a href="#">Razieh Salamat</a></small> </p>
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