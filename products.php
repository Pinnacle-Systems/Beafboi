<?php
include_once('admin/managers/product_manager.php');
if (isset($_GET['category'])) {
    $products = getProductsByCategory($_GET['category']);
} else {
    $products = getProductsByFilterAndLimit(1, "null", 0);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Salem fresh Meat</title>
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
        </style>
    </head>
    <body>
        <?php
        $page = "products";
        include('header.php');
        ?>


        <div class="container py-5">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <?php
                        if (sizeof($products) > 0) {
                            for ($i = 0; $i < sizeof($products); $i++) {
                                ?>
                                <div class="col-sm-4 blog">
                                    <a href="order.php?product=<?php echo $products[$i]['PRODUCT_MASTER_ID']; ?>" style="text-decoration:none;">
                                        <img src="img/products/<?php echo $products[$i]['PRODUCT_IMAGE']; ?>" class="img-fluid">
                                        <!--<h6>MONDAY 12 JUNE 2019</h6>-->
                                        <h3><?php echo $products[$i]['PRODUCT_NAME']; ?></h3>
                                        <p class="price">
                                            <span class="strike">Rs. <?php echo $products[$i]['TOTAL_AMOUNT']; ?></span> 
                                            <i>now</i> Rs. <?php echo $products[$i]['FINAL_AMOUNT']; ?>
                                        </p>
                                    </a>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="col-12 text-center">
                                No Products Found.
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!--------------Blog section ends here------------------>


        <?php
        include('footer.php');
        ?>

        <script src="https://code.jquery.com/jquery-3.3.1.js"></script> 
        <script src="js/bootstrap.js"></script> 
    </body>
</html>
