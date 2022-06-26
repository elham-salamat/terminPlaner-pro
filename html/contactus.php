<?php
include  __DIR__."/../config.php"
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TP-Contact us</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=$baseUrl?>assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animation CSS -->
    <link href="<?=$baseUrl?>assets/css/animate.css" rel="stylesheet">
    <link href="<?=$baseUrl?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=$baseUrl?>assets/css/style.css" rel="stylesheet">
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
                    <li><a class="page-scroll" href="<?=$baseUrl?>#page-top">Home</a></li>
                    <li><a class="page-scroll" href="#contact">Contact</a></li>
                    <?php
                    if (!isset($_SESSION["email"]))
                    {
                        ?>
                        <li><a class="page-scroll" href="<?=$baseUrl?>?page=signin">Sign In</a></li>
                        <li><a class="page-scroll" href="<?=$baseUrl?>?page=signup">Sign Up</a></li>
                        <?php
                    }
                    else
                    {
                        ?>
                        <li><a class="page-scroll" href="<?=$baseUrl?>?page=dashboard">Dashboard</a></li>
                        <li><a class="page-scroll" href="<?=$baseUrl?>?page=signout">Sign Out</a></li>
                        <li><a class="page-scroll" href="<?=$baseUrl?>?page=search">Search</a></li>
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

<div id="inSlider" class="carousel carousel-fade" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#inSlider" data-slide-to="0" class="active"></li>
    </ol>
        <div class="item">
            <div class="container">
                <div class="carousel-caption blank" style="margin: 50px">
                    <h2>Manage you day efficiently and enjoy your life.</h2>
                    <h2>With TP app you experience life without stress.</h2>
                </div>
            </div>
            <!-- Set background for slide in css -->
            <div class="header-back two"></div>
        </div>

<section id="contact" class="gray-section contact">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Contact Us</h1>
                <p>Contact With Me With Above Form.</p>
            </div>
        </div>
        <div class="row m-b-lg">
            <div class="col-sm-6 b-r"><h3 class="m-t-none m-b">Contact Us</h3>
                <p>With Above Form </p>
                <form role="form">
                    <div class="form-group"><label>Your Email</label> <input type="email" name="your-email" placeholder="Enter Your Email" class="form-control"></div>
                    <div class="form-group"><label>Your Name</label> <input type="text" name="your-name" placeholder="Enter Your Name" class="form-control"></div>
                    <div class="form-group">
                        <label>Your Message</label>
                        <textarea name="your-message" id="" cols="30" placeholder="Enter Your Message"
                                  rows="10" class="form-control"></textarea>
                    </div>

                    <div>
                        <button class="btn btn-info pull-left m-t-n-xs" type="submit"><strong>Send</strong></button>&nbsp;&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger pull-left m-t-n-xs" type="reset"><strong>Reset</strong></button>

                    </div>
                </form>
            </div>
            <div class="col-sm-6">
                <h1>Address : Germany DE</h1>
                <h1>Phone : +49 (123) 4567</h1>
                <h1>Email : <a href="mailto:info@terminplaner.com">info@terminplaner.com</a></h1>
            </div>
        </div>
    </div>
</section>

<!-- Mainly scripts -->
<script src="<?=$baseUrl?>assets/js/jquery-2.1.1.js"></script>
<script src="<?=$baseUrl?>assets/js/bootstrap.min.js"></script>
<script src="<?=$baseUrl?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?=$baseUrl?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?=$baseUrl?>assets/js/rada.js"></script>
<script src="<?=$baseUrl?>assets/js/plugins/pace/pace.min.js"></script>
<script src="<?=$baseUrl?>assets/js/plugins/wow/wow.min.js"></script>


<script>

    $(document).ready(function () {

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
            header = document.querySelector( '.navbar-default' ),
            didScroll = false,
            changeHeaderOn = 200;
        function init() {
            window.addEventListener( 'scroll', function( event ) {
                if( !didScroll ) {
                    didScroll = true;
                    setTimeout( scrollPage, 250 );
                }
            }, false );
        }
        function scrollPage() {
            var sy = scrollY();
            if ( sy >= changeHeaderOn ) {
                $(header).addClass('navbar-scroll')
            }
            else {
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
