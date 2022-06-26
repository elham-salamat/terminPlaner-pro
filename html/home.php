<?php
include __DIR__ . "/../config.php";
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tp-Homepage</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= $baseUrl ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/style-header.css">

    <!-- Animation CSS -->
    <link href="<?= $baseUrl ?>assets/css/animate.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= $baseUrl ?>assets/css/style.css" rel="stylesheet">
</head>

<body id="page-top" class="landing-page">

    <div class="navbar-wrapper">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>


                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a class="page-scroll" href="#page-top">Home</a></li>
                        <li><a class="page-scroll" href="#calendar">Calendar</a></li>
                        <li><a class="page-scroll" href="#contact">Contact</a></li>
                        <?php
                        if (!isset($_SESSION["email"])) {
                        ?>
                            <li><a class="page-scroll" href="<?= $baseUrl ?>?page=signin">Sign In</a></li>
                            <li><a class="page-scroll" href="<?= $baseUrl ?>?page=signup">Sign Up</a></li>
                        <?php
                        } else {
                        ?>
                            <li><a class="page-scroll" href="<?= $baseUrl ?>?page=dashboard">Dashboard</a></li>
                            <li><a class="page-scroll" href="<?= $baseUrl ?>?page=signout">Sign Out</a></li>
                            <li><a class="page-scroll" href="<?= $baseUrl ?>?page=search">Search</a></li>
                        <?php
                        }
                        ?>


                    </ul>
                    <ul class="nav navbar-top-links navbar-left">
                        <li>
                            <a href="">
                                <h1 style="font-weight: bold;">Termin Planer</h1>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div id="inSlider" class="carousel carousel-fade" data-ride="carousel" style="width: 100%; height: 10px">
        <ol class="carousel-indicators">
            <li data-target="#inSlider" data-slide-to="0" class="active"></li>
        </ol>
        <div class="item">
            <div class="container">
                <div class="carousel-caption blank" style="margin: 40px">
                    <h2>Manage you day efficiently and enjoy your life. </h2>
                    <h2>With TP app you experience life without stress.</h2>
                </div>
            </div>
            <div class="header-back two"></div>
        </div>

        <section class="features">
            <!-- <!-- <div class="container"> -->
            <div class="row">
                <!-- <div class="col-7 calendar"> --> -->
                <div class="sep-calendar">
                    <h2>
                        January 2021
                    </h2>
                    <ul class="days">

                        <?php

                        $days = ["Sun", "Mon", "Tue", "wed", "Thu", "Fri", "Sat"];

                        foreach ($days as $item) {
                        ?>
                            <li><?= $item ?></li>
                        <?php
                        }
                        ?>
                    </ul>
                    <ul class="date">

                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo "<li style='margin-top: 25px; margin-buttom: 25px'></li>";
                        }
                        for ($i = 1; $i <= 31; $i++) {
                            if (isset($_SESSION["email"])) {
                        ?>
                                <li style='margin-top: 25px; margin-buttom: 25px'><?= $i ?></li>
                            <?php
                            } else {
                            ?>
                                <li style='margin-top: 25px; margin-buttom: 25px'><?= $i ?></li>
                        <?php
                            }
                        }
                        ?>

                    </ul>
                </div>

            </div>

            <!-- </div>
    </div> -->

        </section>

        <section id="contact" class="gray-section contact">
            <div class="container">
                <div class="row m-b-lg">
                    <div class="col-lg-12 text-center">
                        <div class="navy-line"></div>
                        <h1>Contact Us</h1>
                        <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p>
                    </div>
                </div>
                <div class="row m-b-lg">
                    <div class="col-lg-3 col-lg-offset-3">
                        <address>
                            <strong><span class="navy">Company name, Inc.</span></strong><br />
                            795 Folsom Ave, Suite 600<br />
                            San Francisco, CA 94107<br />
                            <abbr title="Phone">P:</abbr> (123) 456-7890
                        </address>
                    </div>
                    <div class="col-lg-4">
                        <p class="text-color">
                            Consectetur adipisicing elit. Aut eaque, totam corporis laboriosam veritatis quis ad perspiciatis, totam corporis laboriosam veritatis, consectetur adipisicing elit quos non quis ad perspiciatis, totam corporis ea,
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <a href="<?= $baseUrl ?>?page=contactus" class="btn btn-primary">Contact Us</a>
                        <p class="m-t-sm">
                            Or follow us on social platform
                        </p>
                        <ul class="list-inline social-icon">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-send"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 text-center m-t-lg m-b-lg">
                        <p><strong>All rights reserved</strong> 2021 &copy; <a href="#" target="_blank">Razieh Salamat</a></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mainly scripts -->
        <script src="<?= $baseUrl ?>assets/js/jquery-2.1.1.js"></script>
        <script src="<?= $baseUrl ?>assets/js/bootstrap.min.js"></script>
        <script src="<?= $baseUrl ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="<?= $baseUrl ?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="<?= $baseUrl ?>assets/js/rada.js"></script>
        <script src="<?= $baseUrl ?>assets/js/plugins/pace/pace.min.js"></script>
        <script src="<?= $baseUrl ?>assets/js/plugins/wow/wow.min.js"></script>


        <script>
            $(document).ready(function() {

                $('body').scrollspy({
                    target: '.navbar-fixed-top',
                    offset: 80
                });

                // Page scrolling feature
                $('a.page-scroll').bind('click', function(event) {
                    var link = $(this);
                    $('html, body').stop().animate({
                        scrollTop: $(link.attr('href')).offset().top - 50
                    }, 500);
                    event.preventDefault();
                    $("#navbar").collapse('hide');
                });
            });

            var cbpAnimatedHeader = (function() {
                var docElem = document.documentElement,
                    header = document.querySelector('.navbar-default'),
                    didScroll = false,
                    changeHeaderOn = 200;

                function init() {
                    window.addEventListener('scroll', function(event) {
                        if (!didScroll) {
                            didScroll = true;
                            setTimeout(scrollPage, 250);
                        }
                    }, false);
                }

                function scrollPage() {
                    var sy = scrollY();
                    if (sy >= changeHeaderOn) {
                        $(header).addClass('navbar-scroll')
                    } else {
                        $(header).removeClass('navbar-scroll')
                    }
                    didScroll = false;
                }

                function scrollY() {
                    return window.pageYOffset || docElem.scrollTop;
                }
                init();

            })();

            // Activate WOW.js plugin for animation on scrol
            new WOW().init();
        </script>

</body>


</html>