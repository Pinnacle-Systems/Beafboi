<?php
include_once('admin/managers/product_manager.php');
if (isset($_GET['product'])) {
    $product = getProductById($_GET['product']);
} else {
    exit(header("location:products.php"));
}
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
                        <div class="col-sm-12 col-md-6">
                            <img src="img/products/<?php echo $product['PRODUCT_IMAGE']; ?>" style="max-width: 100%;"/>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <h3><?php echo $product['PRODUCT_NAME']; ?></h3>
                            <p class="price">
                                <span class="strike">Rs. <?php echo $product['TOTAL_AMOUNT']; ?></span> 
                                <i>now</i> Rs. <?php echo $product['FINAL_AMOUNT']; ?>
                            </p>
                            <div>
                                <b>Perfect For :</b> <span><?php echo $product['PERFECT_FOR']; ?></span></br>
                                <b>Gross Weight :</b> <span><?php echo $product['GROSS_WEIGHT']; ?></span></br>
<!--                                <b>Net Weight :</b> <span><?php echo $product['NET_WEIGHT']; ?></span></br>-->
                                <b>Delivery Time :</b> <span><?php echo $product['DELIVERY_TIME']; ?></span></br>
                            </div>
                            <a href="https://api.whatsapp.com/send?phone=+916380178964&amp;text=Hi,%20I%20want%20to%20order%20this%20product:%20<?php echo $product['PRODUCT_NAME']; ?>" target="_blank" style="text-decoration: none;">                
                                <div style="margin-top: 20px; margin-bottom:20px; padding: 11px; text-align: center; background-color: #1EA651;height: 44px;color:white;">                  
                                    <img src="https://cdn.shopify.com/s/files/1/0073/2522/0979/files/whatsapp-icon.png?v=1615793565" width="25px" style="vertical-align:middle;"> Order On <span style="font-weight: bold;">WhatsApp</span>                  
                                </div>               
                            </a>
                        </div>
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
