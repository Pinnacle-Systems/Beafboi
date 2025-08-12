<?php
include_once('admin/managers/category_manager.php');
include_once('admin/managers/product_manager.php');
$limitedCategories = getCategoriesByFilterAndLimit("1", "0", "6");
$limitedProducts = getProductsByFilterAndLimit("1", "0", "4");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>BeafBai</title>
        <link href="https://fonts.googleapis.com/css?family=Heebo:300,400,500,700,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/jquery.bxslider.css">
        <link rel="stylesheet" href="https://cdn.lineicons.com/1.0.1/LineIcons.min.css">
        <style>
            .price{
                color:#F7941D;
            }
            .strike{
                text-decoration: line-through;
                color:gray;
            }
            .strikethrough {
                position: relative;
                color:gray;
            }
            .strikethrough:before {
                position: absolute;
                content: "";
                left: 0;
                top: 50%;
                right: 0;
                border-top: 1px solid;
                border-color: inherit;

                -webkit-transform:rotate(-5deg);
                -moz-transform:rotate(-5deg);
                -ms-transform:rotate(-5deg);
                -o-transform:rotate(-5deg);
                transform:rotate(-5deg);
            }
        </style>
    </head>
    <body>
        <?php
        $page = "home";
        include('header.php');
        ?>

        <div class="bd-example">
            <div id="carouselExampleCaptions" class="carousel carousel-fade slide" data-ride="carousel">
<!--                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
                </ol>-->
                <div class="carousel-inner">
                    <div class="carousel-item active"> <img src="img/new21500.jpeg" class="d-block w-100" alt="..." style="max-height: 521px;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Yummy <span> and </span> Delicious <span></span></h5>
                            <p>Don't worry we will help you out!<br />
                                Fastest delivery ever!</p>
                            <a href="products.php" class="btn btn-outline-light align-items-center float-left d-flex text-uppercase dd2">Choose Now &nbsp; <i class="lni-arrow-right"></i></a> 
                        </div>
                    </div>
                    <div class="carousel-item"> <img src="img/cow_beef.jpg" class="d-block w-100" alt="..." style="max-height: 521px;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Yummy <span> and </span> Delicious <span></span></h5>
                            <p>Don't worry we will help you out!<br />
                                Fastest delivery ever!</p>
                            <a href="products.php" class="btn btn-outline-light align-items-center float-left d-flex text-uppercase dd2">Choose Now &nbsp; <i class="lni-arrow-right"></i></a> 
                        </div>
                    </div>
                    <div class="carousel-item"> <img src="img/main-meat.png" class="d-block w-100" alt="..." style="max-height: 521px;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Yummy <span> and </span> Delicious <span></span></h5>
                            <p>Don't worry we will help you out!<br />
                                Fastest delivery ever!</p>
                            <a href="products.php" class="btn btn-outline-light align-items-center float-left d-flex text-uppercase dd2">Choose Now &nbsp; <i class="lni-arrow-right"></i></a> 
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
                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev"> 
                    <span class="carousel-control-prev-icon bb" aria-hidden="true"></span> 
                    <span class="sr-only">Previous</span> 
                </a> 
                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next"> 
                    <span class="carousel-control-next-icon bb" aria-hidden="true"></span> 
                    <span class="sr-only">Next</span> 
                </a> 
            </div>
        </div>

        <!--------------banner ends here------------------>

        <div class="bg-wrapper-2">
            <div class="container">
                <div class="row pt-4 justify-content-center">
                    <div class="col-7 text-center">
                        <div class="section-title section-title-2">
                            <h2>Best Categories</h2>
                            <!--<h3>Best Categories</h3>-->
                            <span class="divider divider-line"></span> </div>
                    </div>
                </div>
                <div class="row">
                    <?php
                    for ($i = 0; $i < sizeof($limitedCategories); $i++) {
                        ?>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                            <div class="feature-item">
                                <a href="products.php?category=<?php echo $limitedCategories[$i]['CATEGORY_MASTER_ID']; ?>" style="text-decoration: none;">
                                    <div class="row align-items-center">
                                        <div class="col-5"> <img src="img/category/<?php echo $limitedCategories[$i]['CATEGORY_IMAGE']; ?>" class="img-fluid rounded-circle" /> </div>
                                        <div class="col-7">
                                            <h4><?php echo $limitedCategories[$i]['CATEGORY_NAME']; ?></h4>
                                            <p><?php echo $limitedCategories[$i]['CATEGORY_DESCRIPTION']; ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="row pb-4 pt-3 justify-content-center">
                    <div class="col-md-4"> <a href="products.php" class="btn d-block btn-outline-dark text-uppercase font-weight-bold dd2">Show All &nbsp; <i class="lni-arrow-right"></i></a> </div>
                </div>
            </div>
        </div>

        <!--------------service section ends here------------------>

        <div class="container py-5">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <h2 class="rr3">Products</h2>
                        <p class="mt-2"><a href="products.php" class="rr2 font-weight-bold">View All</a></p>
                    </div>
                    <div class="row">
                        <?php
                        for ($i = 0; $i < sizeof($limitedProducts); $i++) {
                            ?>
                            <div class="col-sm-3 blog"> 
                                <a href="order.php?product=<?php echo $limitedProducts[$i]['PRODUCT_MASTER_ID']; ?>" style="text-decoration:none;">
                                    <img src="img/products/<?php echo $limitedProducts[$i]['PRODUCT_IMAGE']; ?>" class="img-fluid">
                                    <!--<h6>MONDAY 12 JUNE 2019</h6>-->
                                    <h3><?php echo $limitedProducts[$i]['PRODUCT_NAME']; ?></h3>
                                    <p class="price">
                                        <span class="strikethrough">Rs. <?php echo $limitedProducts[$i]['TOTAL_AMOUNT']; ?></span> 
                                        <i>now</i> Rs. <?php echo $limitedProducts[$i]['FINAL_AMOUNT']; ?>
                                    </p>
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!--------------Blog section ends here------------------>

        <div class="bg-yello">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="cta-image"> <img src="img/img-man.png" class="img-fluid" /> </div>
                    </div>
                    <div class="col-md-6 align-items-center d-flex flex-row">
                        <div>
                            <h4 class="text-white font-italic" style="font-family:Georgia, 'Times New Roman', Times, serif;">Have Any Question!</h4>
                            <h2 class="text-white font-weight-bold">DON'T HESITATE TO CONTACT US ANY TIME.</h2>
                        </div>
                    </div>
                    <div class="col-md-3  align-items-center d-flex"> <a href="contact_us.php" class="btn btn-outline-light w-100 text-uppercase font-weight-bold dd2">Contact Us &nbsp; <i class="lni-arrow-right"></i></a> </div>
                </div>
            </div>
        </div>
        <!--------------Call to action section ends here------------------>

        <?php
        include('footer.php');
        ?>

        <script src="https://code.jquery.com/jquery-3.3.1.js"></script> 
        <script src="js/bootstrap.js"></script> 
        <script src="js/jquery.bxslider.min.js"></script> 
        <script>
            $(document).ready(function () {
                $('.slider').bxSlider({
                    minSlides: 1,
                    maxSlides: 1,
                    captions: false
                });
            });
        </script>
    </body>
</html>
