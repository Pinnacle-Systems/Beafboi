<?php
$condition = true;
include_once('condition_check.php');
include_once('managers/category_manager.php');
include_once('managers/product_manager.php');
$categorySummary = getCategorySummary();
$productSummary = getProductSummary();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Welcome</title>
        <link href="https://fonts.googleapis.com/css?family=Heebo:300,400,500,700,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/jquery.bxslider.css">
        <link rel="stylesheet" href="https://cdn.lineicons.com/1.0.1/LineIcons.min.css">
        <script src="../js/jquery.min.js"></script> 
    </head>
    <body>
        <?php
        $page = "home";
        include('header.php');
        ?>

        <div class="bd-example">
            <div id="carouselExampleCaptions" class="carousel carousel-fade slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                    <!--                    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>-->
                </ol>
           
                 <div class="carousel-inner">
                    <div class="carousel-item active"> <img src="../img/new21500.jpeg" class="d-block w-100" alt="..." style="max-height: 521px;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Yummy <span> and </span> Delicious <span></span></h5>
                            <p>Don't worry we will help you out!<br />
                                Fastest delivery ever!</p>
                        </div>
                    </div>
                    <div class="carousel-item"> <img src="../img/cow_beef.jpg" class="d-block w-100" alt="..." style="max-height: 521px;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Yummy <span> and </span> Delicious <span></span></h5>
                            <p>Don't worry we will help you out!<br />
                                Fastest delivery ever!</p>
                        </div>
                    </div>
                    <div class="carousel-item"> <img src="../img/main-meat.png" class="d-block w-100" alt="..." style="max-height: 521px;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Yummy <span> and </span> Delicious <span></span></h5>
                            <p>Don't worry we will help you out!<br />
                                Fastest delivery ever!</p>
                        </div>
                    </div>
                    <!-- <div class="carousel-item"> <img src="img/main100.jpeg" class="d-block w-100" alt="..." style="max-height: 521px;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Yummy <span> and </span> Delicious <span></span></h5>
                            <p>Don't worry we will help you out!<br />
                                Fastest delivery ever!</p>
                            <a href="products.php" class="btn btn-outline-light align-items-center float-left d-flex text-uppercase dd2">Choose Now &nbsp; <i class="lni-arrow-right"></i></a> 
                        </div>
                    </div> -->
                </div>
                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev"> <span class="carousel-control-prev-icon bb" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next"> <span class="carousel-control-next-icon bb" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
        </div>

        <!--------------banner ends here------------------>
        <div class="bg-wrapper-2">
            <div class="container pt-5">
                <div class="row pt-4 justify-content-center">
                    <div class="col-7 text-center">
                        <div class="section-title section-title-2">
                            <h2>Summary</h2>
                            <!--<h3>Best Categories</h3>-->
                            <span class="divider divider-line"></span> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-counter">
            <div class="container py-5">
                <div id="counter" class="row">
                    <div class="col-6 col-lg-3 pb-3 text-center">
                        <div class="counter counter-empty" data-count="<?php echo $productSummary['TOTAL']; ?>">0</div>
                        <h5 class="font-weight-normal text-black-50">Total Products</h5>
                    </div>
                    <div class="col-6 col-lg-3 pb-3 text-center">
                        <div class="counter counter-empty" data-count="<?php echo $productSummary['ACTIVE']; ?>">0</div>
                        <h5 class="font-weight-normal text-black-50">Active Products</h5>
                    </div>
                    <div class="col-6  col-lg-3 pb-3 text-center">
                        <div class="counter counter-empty" data-count="<?php echo $categorySummary['TOTAL']; ?>">0</div>
                        <h5 class="font-weight-normal text-black-50">Total Categories</h5>
                    </div>
                    <div class="col-6  col-lg-3 pb-3 text-center">
                        <div class="counter counter-empty" data-count="<?php echo $categorySummary['ACTIVE']; ?>">0</div>
                        <h5 class="font-weight-normal text-black-50">Active Categories</h5>
                    </div>
                </div>
            </div>
        </div>

        <!--------------counter section ends here------------------>

        <?php
        include('footer.php');
        ?>

        <script src="../js/bootstrap.js"></script> 
        <script src="../js/jquery.bxslider.min.js"></script> 
        <script>
            $(document).ready(function () {
                $('.slider').bxSlider({
                    minSlides: 1,
                    maxSlides: 1,
                    captions: false
                });
                startCounter();
            });
            var a = 0;
            $(window).scroll(function () {
                startCounter();
            });
            function startCounter() {

                var oTop = $('#counter').offset().top - window.innerHeight;
                if (a == 0 && $(window).scrollTop() > oTop) {
                    $('.counter').each(function () {
                        var $this = $(this),
                                countTo = $this.attr('data-count');
                        $({
                            countNum: $this.text()
                        }).animate({
                            countNum: countTo
                        },
                                {

                                    duration: 2000,
                                    easing: 'swing',
                                    step: function () {
                                        $this.text(Math.floor(this.countNum));
                                    },
                                    complete: function () {
                                        $this.text(this.countNum);
                                        //alert('finished');
                                    }

                                });
                    });
                    a = 1;
                }

            }
        </script>
    </body>
</html>