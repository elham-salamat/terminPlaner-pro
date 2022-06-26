<?php
require_once __DIR__ . "/../config.php";
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TP-Reset password</title>

    <link href="<?= $baseUrl ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?= $baseUrl ?>assets/css/animate.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">Forget password</h2>

                    <p>
                        Enter your email address you use as the username to reset you password.
                    </p>

                    <div class="row">

                        <div class="col-lg-12">
                            <form class="m-t" action="<?= $baseUrl ?>includes/reset-request-inc.php" method="POST">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>

                                <button type="submit" name="submit" value="S1" class="btn btn-primary block full-width m-b">Reset your password</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-6">
                Copyright Example Company
            </div>
            <div class="col-md-6 text-right">
                <small>© 2014-2015</small>
            </div>
        </div>
    </div>

</body>



</html>