<?php

require_once __DIR__ . "/../includes/db-inc.php";
require_once __DIR__ . "/../config.php";

if (!isset($_SESSION["email"])) {
    header("location: {$baseUrl}?page=signin&result=failed&msg=loginfaild");
    die();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP-Dashboard</title>
    <link href="<?= $baseUrl ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- Morris -->
    <link href="<?= $baseUrl ?>assets/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/css/animate.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/css/style.css" rel="stylesheet">
    <!-- Toastr style -->
    <link href="<?= $baseUrl ?>assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side hide-xs hide-sm" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                                <img alt="image" width="50px" height="50px" class="img-circle" src="<?= $baseUrl ?>assets/img/profile_small1.jpg" />
                            </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear"> <span class="block m-t-xs">
                                        <strong class="font-bold">
                                            <?php
                                            echo "{$_SESSION['username']}"
                                            ?>
                                        </strong>
                                        <ul class="dropdown-menu animated fadeInRight m-t-xs">

                                            <li class="divider"></li>
                                            <li><a href="<?= $baseUrl ?>?page=signout">Signout</a></li>
                                        </ul>
                        </div>
                        <div class="logo-element">
                            TP
                        </div>
                    </li>
                    <li class="active">
                        <a href="index-2.html"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li class="active"><a href="<?= $baseUrl ?>?page=dashboard">Dashboard</a></li>
                            <li><a href="<?= $baseUrl ?>?page=signout">SignOut</a></li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        <form role="search" class="navbar-form-custom" action="search_results.html">
                            <div class="form-group">
                                <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                            </div>
                        </form>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message"><a href="<?= $baseUrl ?>?page=homepage">Homepage</a></span>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="fa fa-bell"></i> <span class="label label-primary">8</span>
                            </a>
                            <ul class="dropdown-menu dropdown-alerts">
                                <li>
                                    <a href="#">
                                        <div>
                                            <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                            <span class="pull-right text-muted small">4 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#">
                                        <div>
                                            <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                            <span class="pull-right text-muted small">12 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="#">
                                        <div>
                                            <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                            <span class="pull-right text-muted small">4 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="text-center link-block">
                                        <a href="notifications.html">
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?= $baseUrl ?>?page=signout">
                                <i class="fa fa-sign-out"></i> Sign out
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <div>
                                    <span class="pull-right text-right">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal6">
                                            Add new appointment
                                        </button>
                                    </span>
                                    <h3 class="font-bold no-margins">
                                        Upcomming appointments
                                    </h3>
                                </div>
                                <?php

                                if (isset($_GET["result"]) and isset($_GET["msg"])) {

                                    if ($_GET["result"] == "failed" && $_GET["msg"] == "bigfile") {

                                        $message = "attachments is too big. Choose a file less than 1000000 or Remove the attachments";

                                        echo
                                        "
                                            <div class='alert alert-danger alert-dismissable'>
                                                <button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>
                                                {$message}
                                            </div>
                                        ";
                                    }
                                }

                                ?>
                                <div class="m-t-sm">
                                    <div class="row">
                                        <?php

                                        $stmt = mysqli_stmt_init($dbConnect);
                                        $sqlQuery = "SELECT * FROM usertermins WHERE userId = ? ORDER BY startDateTime LIMIT 3 ;";

                                        if (!mysqli_stmt_prepare($stmt, $sqlQuery)) {
                                            header("location: {$baseUrl}?page=dashboard&result=failed&msg=stmtfailed");
                                            exit();
                                        }

                                        $userId = $_SESSION["userId"];

                                        mysqli_stmt_bind_param($stmt, "i", $userId);
                                        mysqli_stmt_execute($stmt);

                                        $resultsTerminData = mysqli_stmt_get_result($stmt);

                                        for ($i = 1; $i <= 3; $i++) {
                                            $terminRow = mysqli_fetch_assoc($resultsTerminData);

                                            if ($terminRow) {

                                        ?>
                                                <div class="col-lg-12">
                                                    <div class="panel panel-info">
                                                        <div class="panel-heading" style="font-size: 20px; font-weight: bold">
                                                            <?php
                                                            echo $terminRow['terminTopic'];
                                                            ?>
                                                        </div>

                                                        <div class="panel-body">
                                                            <p style="font-weight: bold">
                                                                From:
                                                                <?php
                                                                echo $terminRow['startDateTime'];
                                                                ?>
                                                                <br />
                                                                To:
                                                                <?php
                                                                echo $terminRow['endDateTime'];
                                                                ?>
                                                                <br />
                                                                In:
                                                                <?php
                                                                echo $terminRow['terminLocation'];
                                                                ?>
                                                                <br />
                                                                participants:
                                                                <?php
                                                                echo $terminRow['participants'];
                                                                ?>
                                                                <br />
                                                                Explanation:
                                                                <?php
                                                                echo $terminRow['importantComments'];
                                                                ?>
                                                                <br />
                                                                Attachments available.<a href="">download attachments</a>
                                                                <br />
                                                                <b style="color: darkred">Final status:</b>
                                                                <?php
                                                                $statusId = $terminRow["statusId"];
                                                                $sqlStatusQuery = "SELECT * FROM eventstatus WHERE statusId = $statusId;";
                                                                $statusResultsData = mysqli_fetch_assoc(mysqli_query($dbConnect, $sqlStatusQuery));
                                                                $statusRow = ($statusResultsData);

                                                                echo "{$statusRow['runingStatus']}" . ",  " . "{$statusRow['flexibility']}";

                                                                $terminId = $terminRow['appointmentId'];
                                                                ?>
                                                            </p>
                                                        </div>

                                                        <div class="panel-footer">
                                                            <form method="POST" action="includes/termindelete-inc.php">
                                                                <button type="submit" class="btn btn-sm btn-primary m-t-n-xs" name="submit" value='"<?= $terminId ?>"."update"'>
                                                                    <strong>Update</strong>
                                                                    <button type="submit" class="btn btn-sm btn-danger m-t-n-xs" name="submit" value='"<?= $terminId ?>"."delete"'>
                                                                        <strong>Delete</strong>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        mysqli_stmt_close($stmt);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <div>
                    <strong>All rights reserved</strong> 2021 &copy; <a href="#" target="_blank">Razieh Salamat</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?= $baseUrl ?>assets/js/jquery-2.1.1.js"></script>
    <script src="<?= $baseUrl ?>assets/js/bootstrap.min.js"></script>
    <script src="<?= $baseUrl ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?= $baseUrl ?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>


    <!-- Peity -->
    <script src="<?= $baseUrl ?>assets/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="<?= $baseUrl ?>assets/js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?= $baseUrl ?>assets/js/rada.js"></script>
    <script src="<?= $baseUrl ?>assets/js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="<?= $baseUrl ?>assets/js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function() {


            var d1 = [
                [1262304000000, 6],
                [1264982400000, 3057],
                [1267401600000, 20434],
                [1270080000000, 31982],
                [1272672000000, 26602],
                [1275350400000, 27826],
                [1277942400000, 24302],
                [1280620800000, 24237],
                [1283299200000, 21004],
                [1285891200000, 12144],
                [1288569600000, 10577],
                [1291161600000, 10295]
            ];
            var d2 = [
                [1262304000000, 5],
                [1264982400000, 200],
                [1267401600000, 1605],
                [1270080000000, 6129],
                [1272672000000, 11643],
                [1275350400000, 19055],
                [1277942400000, 30062],
                [1280620800000, 39197],
                [1283299200000, 37000],
                [1285891200000, 27000],
                [1288569600000, 21000],
                [1291161600000, 17000]
            ];

            var data1 = [{
                    label: "Data 1",
                    data: d1,
                    color: '#17a084'
                },
                {
                    label: "Data 2",
                    data: d2,
                    color: '#127e68'
                }
            ];
            $.plot($("#flot-chart1"), data1, {
                xaxis: {
                    tickDecimals: 0
                },
                series: {
                    lines: {
                        show: true,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 1
                            }, {
                                opacity: 1
                            }]
                        },
                    },
                    points: {
                        width: 0.1,
                        show: false
                    },
                },
                grid: {
                    show: false,
                    borderWidth: 0
                },
                legend: {
                    show: false,
                }
            });

            var lineData = {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [{
                        label: "Example dataset",
                        backgroundColor: "rgba(26,179,148,0.5)",
                        borderColor: "rgba(26,179,148,0.7)",
                        pointBackgroundColor: "rgba(26,179,148,1)",
                        pointBorderColor: "#fff",
                        data: [48, 48, 60, 39, 56, 37, 30]
                    },
                    {
                        label: "Example dataset",
                        backgroundColor: "rgba(220,220,220,0.5)",
                        borderColor: "rgba(220,220,220,1)",
                        pointBackgroundColor: "rgba(220,220,220,1)",
                        pointBorderColor: "#fff",
                        data: [65, 59, 40, 51, 36, 25, 40]
                    }
                ]
            };

            var lineOptions = {
                responsive: true
            };


            var ctx = document.getElementById("lineChart").getContext("2d");
            new Chart(ctx, {
                type: 'line',
                data: lineData,
                options: lineOptions
            });


        });
    </script>
    <script>
        $("body").addClass('boxed-layout');
        $('#fixednavbar').prop('checked', false);
        $(".navbar-fixed-top").removeClass('navbar-fixed-top').addClass('navbar-static-top');
        $("body").removeClass('fixed-nav');
        $(".footer").removeClass('fixed');
        $('#fixedfooter').prop('checked', false);
        $("body").addClass('mini-navbar');
        SmoothlyMenu();
        $("body").addClass('fixed-sidebar');
        $('.sidebar-collapse').slimScroll({
            height: '100%',
            railOpacity: 0.9,
        });
    </script>

    <!-- Toastr script -->
    <script src="js/plugins/toastr/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "preventDuplicates": true,
            "positionClass": "toast-top-left",
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "1000",
            "timeOut": "7000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr["success"]("Welcome To Termin Planer Dashboard", "Message")
    </script>

    <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="<?= $baseUrl ?>includes/termininsert-inc.php" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button></h4>
                        <h2 font-weight="bold" color="black" class="font-bold">Add new event</h2>
                    </div>
                    <div class="container" style="text-align: left; margin: 25px">
                        <label for="topic"><b>Subject</b></label>
                        <input name="topic" type="text" />
                        <br />
                        <label for="starttime"><b>Starts at</b></label>
                        <input name="startdate" type="datetime-local" />
                        <br />
                        <label for="endtime"><b>Ends at</b></label>
                        <input name="enddate" type="datetime-local" />
                        <br />
                        <label for="comments"><b>Explanation</b></label>
                        <input name="" type="text" placeholder="explanation" />
                        <br />
                        <select name="status">
                            <option>select flexibility status</option>
                            <option value="flexible">flexible</option>
                            <option value="not flexible">not flexible</option>
                            <option value="postponded">Postponed</option>
                            <option value="done">done</option>

                        </select>
                        <br />
                    </div>
                    <div class="modal-footer">
                        <div class="pull-left">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button name="submit" value="S1" type="submit" class="btn btn-primary">Add this termin to my calendar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="<?= $baseUrl ?>includes/termininsert-inc.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button></h4>
                        <h2 font-weight="bold" color="black" class="font-bold">Add new appointment</h2>
                    </div>

                    <div class="container" style="text-align: left; margin: 25px">
                        <label for="topic"><b>Subject</b></label>
                        <input name="topic" type="text" />
                        <br />
                        <label for="starttime"><b>Starts at</b></label>
                        <input name="startdate" type="datetime-local" />
                        <br />
                        <label for="endtime"><b>Ends at</b></label>
                        <input name="enddate" type="datetime-local" />
                        <br />
                        <label for="location"><b>Location</b></label>
                        <input name="place" type="text" />
                        <br />
                        <label for="participants"><b>Participants</b></label>
                        <input name="participants" type="text" />
                        <br />
                        <label for="comments"><b>Additional comments</b></label>
                        <input name="explanation" type="text" placeholder="explanation" />
                        <br />
                        <select name="status">
                            <option>select flexibility status</option>
                            <option value="flexible">flexible</option>
                            <option value="not flexible">not flexible</option>
                            <option value="postponded">Postponed</option>

                            <option value="done">done</option>
                        </select>
                        <br />
                        <label for="attachments"><b>Attachments</b></label>
                        <input name="attachments" type="file" required />
                        <b>File Size < 10MB</b>
                                <br />
                    </div>
                    <div class="modal-footer">
                        <div class="pull-left">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button name="submit" value="S1" type="submit" class="btn btn-primary">Add this termin to my calendar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>