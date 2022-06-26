<?php
include __DIR__."/../config.php";
?>
<!DOCTYPE html>
<html>



<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TP-404 Error</title>

    <link href="<?=$baseUrl?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=$baseUrl?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?=$baseUrl?>assets/css/animate.css" rel="stylesheet">
    <link href="<?=$baseUrl?>assets/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">


<div class="middle-box text-center animated fadeInDown">
    <h1>404</h1>
    <h3 class="font-bold">Page Not Found</h3>

    <div class="error-desc">
        Sorry, but the page you are looking for has note been found. <br  /> <br  />
        Try checking the URL for error, then hit the refresh button on your browser or try found something else in our app.
        <form class="form-inline m-t" role="form">
            <a data-toggle="modal" class="btn btn-primary" href="<?=$baseUrl?>">Go Home</a>
        </form>
    </div>
</div>

<!-- Mainly scripts -->
<script src="<?=$baseUrl?>assets/js/jquery-2.1.1.js"></script>
<script src="<?=$baseUrl?>assets/js/bootstrap.min.js"></script>

</body>



</html>
