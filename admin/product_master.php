<?php
$condition = true;
include_once('condition_check.php');
include_once('managers/category_manager.php');
include_once('managers/product_manager.php');
if (isset($_POST['product_name']) && isset($_POST['product_image'])) {
    $productName = $_POST['product_name'];
    $productImage = $_POST['product_image'];
    $perfectFor = $_POST['perfect_for'];
    $grossWeight = $_POST['gross_weight'];
    $netWeight = $_POST['net_weight'];
    $totalAmount = $_POST['total_amount'];
    $finalAmount = $_POST['final_amount'];
    $deliveryTime = $_POST['delivery_time'];
    $categoryId = $_POST['category'];
    $productStatus = 0;
    $status = true;
    $msg = "Product Added Successfully.";
    if (isset($_POST['product_status'])) {
        $productStatus = 1;
    }
    if ($productName == null || $productName == "") {
        $status = false;
        $msg = "Product name cannot be empty.";
    }
    if ($status && doesProductNameExist($productName, "null")) {
        $status = false;
        $msg = "Product name already exist";
    }
    if ($sattus && $categoryId == "null") {
        $status = false;
        $msg = "Please select a category";
    }
    if ($status && ($productImage == null || $productImage == "")) {
        $status = false;
        $msg = "Please upload the product image.";
    }
    if ($status && ($perfectFor == null || $perfectFor == "")) {
        $status = false;
        $msg = "Please enter perfect for.";
    }
    if ($status && ($grossWeight == null || $grossWeight == "")) {
        $status = false;
        $msg = "Please enter the gross weight.";
    }
//    if ($status && ($netWeight == null || $netWeight == "")) {
//        $status = false;
//        $msg = "Please enter the net weight.";
//    }
    if ($status && ($totalAmount == null || $totalAmount == "")) {
        $status == false;
        $msg = "Please enter the total amount.";
    }
    if ($status && ($finalAmount == null || $finalAmount == "")) {
        $status = false;
        $msg = "Please enter the final amount.";
    }
    if ($status && ($deliveryTime == null || $deliveryTime == "")) {
        $status = false;
        $msg = "Please enter the delivery time.";
    }
    if ($status && !addProduct($productName, $productImage, $perfectFor, $grossWeight,
                    $netWeight, $totalAmount, $finalAmount, $deliveryTime, $productStatus, $admin['ADMIN_MASTER_ID'], $categoryId)) {
        $status = false;
        $msg = "Internal Server Error.";
    }
    $_SESSION['STATUS'] = $status;
    $_SESSION['MESSAGE'] = $msg;
    exit(header("location:product_master.php"));
}
$categories = getCategoriesByFilterAndLimit(1, "null", "null");
$products = getProductsByFilterAndLimit("null", "null", "null");
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
        <script src="../js/jquery.min.js" type="text/javascript"></script>
        <style>
            .product-item__badge {
                position: absolute;
                top: -26px;
                left: -94px;
                width: 200px;
                padding: 40px 4px 4px;
                text-align: center;
                color: #fff;
                background-color: #ea3f00;
                font-size: .8125em;
                font-weight: 700;
                -ms-transform: rotate(-45deg) translateZ(0);
                -webkit-transform: rotate(
                    -45deg) translateZ(0);
                transform: rotate(
                    -45deg) translateZ(0);
            }
            .active-badge{
                background-color: #03fc2c;
            }
            .card:hover{
                transition-duration: 0.5s;
                transform: scale(1.05);
                box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
            }
            .strike{
                text-decoration: line-through;
                color:gray;
            }

            .image_container:hover .overlay {
                opacity: 1;
                cursor: pointer;
            }

            .overlay {
                position: absolute;
                top: 50%;
                bottom: 0;
                left: 0;
                right: 0;
                height: 50%;
                width: 100%;
                opacity: 0;
                transition: .5s ease;
                background-color: rgba(195,195,195,1);
            }

            .overlay .text {
                color: white;
                font-size: 14px;
                position: absolute;
                top: 50%;
                left: 50%;
                -webkit-transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
                text-align: center;
            }
        </style>
        <script>
            $(document).ready(function () {
<?php
if (isset($_SESSION['STATUS']) && isset($_SESSION['MESSAGE'])) {
    if ($_SESSION['STATUS'] == 1) {
        echo 'swal("Success","' . $_SESSION['MESSAGE'] . '","success");';
    } else {
        echo 'swal("Failed","' . $_SESSION['MESSAGE'] . '","error");';
    }
    unset($_SESSION['STATUS']);
    unset($_SESSION['MESSAGE']);
}
?>
            });
        </script>
    </head>
    <body>
        <?php
        $page = "product";
        include('header.php');
        ?>
        <div class="bg-wrapper">
            <div class="container py-5">
                <div class="row justify-content-around">
                    <div class="col-md-6 col-sm-12">
                        <div class="section-title section-title-2">
                            <h2>Products</h2>                            
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <button type="button" class="btn btn-warning font-weight-bold dd2 text-white float-md-right" data-toggle="modal" data-target="#exampleModalCenter">
                            Add New
                        </button>
                    </div>
                </div>
                <div class="row">
                    <?php
                    for ($i = 0; $i < sizeof($products); $i++) {
                        ?>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
                            <div class="card bg-white" style="overflow: hidden;">
                                <div class="card-body">
                                    <span class="product-item__badge <?php if ($products[$i]['PRODUCT_STATUS'] == 1) echo 'active-badge'; ?>"></span>
                                    <div class="about-product text-center mt-2"><img src="../img/products/<?php echo $products[$i]['PRODUCT_IMAGE']; ?>" style="width:100%;" />
                                        <div>
                                            <h4><?php echo $products[$i]['PRODUCT_NAME']; ?></h4>
                                            <!--<h6 class="mt-0 text-black-50">Apple pro display XDR</h6>-->
                                        </div>
                                    </div>
                                    <div class="stats mt-2">
                                        <div class="d-flex justify-content-between p-price"><span>Gross Weight</span><span><?php echo $products[$i]['GROSS_WEIGHT']; ?></span></div>
                                        <!--<div class="d-flex justify-content-between p-price"><span>Net Weight</span><span><?php echo $products[$i]['NET_WEIGHT']; ?></span></div>-->
                                        <!--<div class="d-flex justify-content-between p-price"><span>Category</span><span>$199</span></div>-->
                                    </div>
                                    <div class="d-flex justify-content-between total font-weight-bold mt-4">
                                        <span>Price</span>
                                        <span>
                                            <span class="strike">Rs <?php echo $products[$i]['TOTAL_AMOUNT']; ?></span>
                                            Rs <?php echo $products[$i]['FINAL_AMOUNT']; ?>
                                        </span>
                                    </div>
                                    <div class="row justify-content-around">
                                        <a href="javascript:void(0)" class="edit" data-id="<?php echo $products[$i]['PRODUCT_MASTER_ID']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                            </svg>
                                        </a>
                                        <a href="javascript:void(0)" class="delete" data-id="<?php echo $products[$i]['PRODUCT_MASTER_ID']; ?>"
                                           data-name="<?php echo $categories[$i]['CATEGORY_NAME']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        include('footer.php');
        ?>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form method="post" action="product_master.php" onsubmit="return validateAddForm()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">New Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 text-center image_container">
                                <input type="hidden" id="productImageName" name="product_image" />
                                <input type="file" id="productImageSelector" style="display:none;" accept="image/*" />
                                <div class="col-12 text-center">
                                    <img src="../img/product_image.png" id="productImagePreview" alt="product" style="max-height: 300px;max-width: 100%;" />
                                </div>
                                <div id="productImageProgress" style="width:0%;height:100%;position: absolute;top:0%;left:100;background-color: rgba(170,170,170,0.7);"></div>
                                <div class="overlay" id="productImageOverlay">
                                    <div class="text">Click here to upload category image.</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="productName">Category<sup class="text-danger">*</sup></label>
                                <select class="form-control" name="category" id="categorySelector">
                                    <option value="null"></option>
                                    <?php
                                    for ($i = 0; $i < sizeof($categories); $i++) {
                                        ?>
                                        <option value="<?php echo $categories[$i]['CATEGORY_MASTER_ID']; ?>"><?php echo $categories[$i]['CATEGORY_NAME']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="productName">Product Name<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" name="product_name" id="productName" />
                                <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                            </div>
                            <div class="form-group">
                                <label for="perfectFor">Perfect For<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" name="perfect_for" id="perfectFor" />
                            </div>
                            <div class="form-group">
                                <label for="grossWeight">Gross Weight<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" name="gross_weight" id="grossWeight" value="1 kg" />
                            </div>
                            <div class="form-group col-md-6" style="display: none;">
                                <label for="netWeight">Net Weight<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" name="net_weight" id="netWeight" />
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="totalAmount">Total Amount<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="total_amount" id="totalAmount" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="finalAmount">Final Amount<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="final_amount" id="finalAmount" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="deliveryTime">Delivery Time<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" name="delivery_time" id="deliveryTime" />
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="status" name="product_status">
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <small id="productAddMsg" class="text-danger"></small>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="productEditModal" tabindex="-1" role="dialog" aria-labelledby="productEditModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <input type="hidden" id="productIdEdit" />
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Product Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 text-center image_container">
                            <input type="hidden" id="productImageEdit" />
                            <input type="file" id="productImageSelectorEdit" style="display:none;" accept="image/*" />
                            <div class="col-12 text-center">
                                <img src="../img/product_image.png" id="productImagePreviewEdit" alt="product" style="max-height: 300px;max-width: 100%;" />
                            </div>
                            <div id="productImageProgressEdit" style="width:0%;height:100%;position: absolute;top:0%;left:100;background-color: rgba(170,170,170,0.7);"></div>
                            <div class="overlay" id="productImageOverlayEdit">
                                <div class="text">Click here to upload category image.</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="productName">Category<sup class="text-danger">*</sup></label>
                            <select class="form-control" id="categoryEdit">
                                <?php
                                for ($i = 0; $i < sizeof($categories); $i++) {
                                    ?>
                                    <option value="<?php echo $categories[$i]['CATEGORY_MASTER_ID']; ?>"><?php echo $categories[$i]['CATEGORY_NAME']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="productNameEdit">Product Name<sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="productNameEdit" />
                            <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                        </div>
                        <div class="form-group">
                            <label for="perfectForEdit">Perfect For<sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="perfectForEdit" />
                        </div>
                        <div class="form-group">
                            <label for="grossWeightEdit">Gross Weight<sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="grossWeightEdit" />
                        </div>
                        <div class="form-group col-md-6" style="display: none;">
                            <label for="netWeightEdit">Net Weight<sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="netWeightEdit" />
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="totalAmountEdit">Total Amount<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="totalAmountEdit" />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="finalAmountEdit">Final Amount<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="finalAmountEdit" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deliveryTimeEdit">Delivery Time<sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="deliveryTimeEdit" />
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="productStatusEdit">
                            <label class="form-check-label" for="productStatusEdit">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <small id="productEditMsg" class="text-danger"></small>
                        <button type="button" class="btn btn-success" onclick="validateEditForm()">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="../js/bootstrap.js"></script> 
        <script src="../js/sweetalert.min.js" type="text/javascript"></script>
        <script>
                            $('.edit').on("click", function () {
                                $id = $(this).data('id');
                                $.ajax({
                                    url: "ajaxfile.php",
                                    type: "POST",
                                    data: {
                                        request: 104,
                                        product_id: $id
                                    },
                                    cache: false,
                                    success: function (dataResult) {
                                        var dataResult = JSON.parse(dataResult);
                                        if (dataResult.statusCode == 200) {
                                            $('#productIdEdit').val($id);
                                            $('#productNameEdit').val(dataResult.PRODUCT.PRODUCT_NAME);
                                            $('#productImageEdit').val(dataResult.PRODUCT.PRODUCT_IMAGE);
                                            $('#productImagePreviewEdit').attr("src", "../img/products/" + dataResult.PRODUCT.PRODUCT_IMAGE);
                                            $('#perfectForEdit').val(dataResult.PRODUCT.PERFECT_FOR);
                                            $('#grossWeightEdit').val(dataResult.PRODUCT.GROSS_WEIGHT);
                                            $('#netWeightEdit').val(dataResult.PRODUCT.NET_WEIGHT);
                                            $('#totalAmountEdit').val(dataResult.PRODUCT.TOTAL_AMOUNT);
                                            $('#finalAmountEdit').val(dataResult.PRODUCT.FINAL_AMOUNT);
                                            $('#deliveryTimeEdit').val(dataResult.PRODUCT.DELIVERY_TIME);
                                            $('#categoryEdit').val(dataResult.PRODUCT.CATEGORY_MASTER_ID);
                                            if (dataResult.PRODUCT.PRODUCT_STATUS == 1) {
                                                $('#productStatusEdit').prop("checked", "checked");
                                            } else {
                                                $('#productStatusEdit').prop("checked", "");
                                            }
                                            $('#productEditModal').modal('show');
                                        } else if (dataResult.statusCode == 201) {
                                            swal('Error', dataResult.MESSAGE, 'error');
                                        } else if (dataResult.statusCode == 500) {
                                            alert(dataResult.MESSAGE);
                                        }
                                    }
                                });
                            });
                            $('.delete').on("click", function () {
                                $id = $(this).data('id');
                                $name = $(this).data('name');
                                swal({
                                    title: $name,
                                    text: "Are you sure you want to delete this Product?",
                                    icon: "warning",
                                    buttons: [
                                        'No',
                                        'Yes'
                                    ],
                                    dangerMode: true,
                                }).then((willDelete) => {
                                    if (willDelete) {
                                        $.ajax({
                                            url: "ajaxfile.php",
                                            type: "POST",
                                            data: {
                                                request: 106,
                                                product_id: $id
                                            },
                                            cache: false,
                                            success: function (dataResult) {
                                                var dataResult = JSON.parse(dataResult);
                                                if (dataResult.statusCode == 200) {
                                                    swal('Success', dataResult.MESSAGE, 'success').then((value) => {
                                                        location.reload();
                                                    });
                                                } else if (dataResult.statusCode == 201) {
                                                    swal('Error', dataResult.MESSAGE, 'error');
                                                } else if (dataResult.statusCode == 500) {
                                                    alert(dataResult.MESSAGE);
                                                }
                                            }
                                        });
                                    }
                                });
                            });
        </script>
        <script>
            $(document).ready(function () {
                $('#productImageOverlay').click(function () {
                    $('#productImageSelector').trigger('click');
                });
                $('#productImageOverlayEdit').click(function () {
                    $('#productImageSelectorEdit').trigger('click');
                });
                $('#productImageSelector').change(function () {
                    if (this.files && this.files[0]) {
                        $('#productImageProgress').css({'width': '100%', 'left': '0%'});
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#productImagePreview').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(this.files[0]);
                        var formData = new FormData();
                        formData.append("request", "108");
                        formData.append("file1", this.files[0]);
                        $.ajax({
                            url: 'ajaxfile.php',
                            method: 'POST',
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            xhr: function () {
                                var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function (event) {
                                    var percent = (event.loaded / event.total) * 100;
                                    var progress = Math.round(percent);
                                    $('#productImageProgress').css({'width': (100 - progress) + '%', 'left': progress + '%'});
                                }, false);
                                xhr.addEventListener("load", function (event) {
                                }, false);
                                xhr.addEventListener("error", function (event) {
                                    $('#productImageProgress').css({'background': 'red'});
                                    alert(event);
                                }, false);
                                xhr.addEventListener("abort", function (event) {
                                }, false);

                                return xhr;
                            },
                            success: function (dataResult) {
                                console.log(dataResult);
                                var dataResult = JSON.parse(dataResult);
                                if (dataResult.statusCode == 200) {
                                    $('#productImageName').val(dataResult.NAME);
                                } else if (dataResult.statusCode == 201)
                                {
                                    alert("Error");
                                }
                            }
                        });
                    }
                });
                $('#productImageSelectorEdit').change(function () {
                    if (this.files && this.files[0]) {
                        $('#productImageProgressEdit').css({'width': '100%', 'left': '0%'});
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#productImagePreviewEdit').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(this.files[0]);
                        var formData = new FormData();
                        formData.append("request", "108");
                        formData.append("file1", this.files[0]);
                        $.ajax({
                            url: 'ajaxfile.php',
                            method: 'POST',
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            xhr: function () {
                                var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function (event) {
                                    var percent = (event.loaded / event.total) * 100;
                                    var progress = Math.round(percent);
                                    $('#productImageProgressEdit').css({'width': (100 - progress) + '%', 'left': progress + '%'});
                                }, false);
                                xhr.addEventListener("load", function (event) {
                                }, false);
                                xhr.addEventListener("error", function (event) {
                                    $('#productImageProgressEdit').css({'background': 'red'});
                                    alert(event);
                                }, false);
                                xhr.addEventListener("abort", function (event) {
                                }, false);

                                return xhr;
                            },
                            success: function (dataResult) {
                                var dataResult = JSON.parse(dataResult);
                                if (dataResult.statusCode == 200) {
                                    $('#productImageEdit').val(dataResult.NAME);
                                } else if (dataResult.statusCode == 201)
                                {
                                    alert("Error");
                                }
                            }
                        });
                    }
                });
            });
        </script>
        <script>
            function validateAddForm() {
                if ($('#categorySelector').val() == "null") {
                    $('#productAddMsg').html("Please select a category");
                    return false;
                }
                if ($('#productName').val() == "") {
                    $('#productAddMsg').html("Please enter the product name");
                    return false;
                }
                if ($('#productImageName').val() == "") {
                    $('#productAddMsg').html("Please upload the product image");
                    return false;
                }
                if ($('#perfectFor').val() == "") {
                    $('#productAddMsg').html("Please enter perfect for");
                    return false;
                }
                if ($('#grossWeight').val() == "") {
                    $('#productAddMsg').html("Please enter product gross weight");
                    return false;
                }
//                if ($('#netWeight').val() == "") {
//                    $('#productAddMsg').html("Please enter product net weight");
//                    return false;
//                }
                if ($('#totalAmount').val() == "") {
                    $('#productAddMsg').html("Please enter product total amount");
                    return false;
                }
                if ($('#finalAmount').val() == "") {
                    $('#productAddMsg').html("Please enter product final amount");
                    return false;
                }
                if ($('#deliveryTime').val() == "") {
                    $('#productAddMsg').html("Please enter product delivery time");
                    return false;
                }
            }

            function validateEditForm() {
                if ($('#categoryEdit').val() == "null") {
                    $('#productEditMsg').html("Please select a category");
                    return false;
                }
                if ($('#productNameEdit').val() == "") {
                    $('#productEditMsg').html("Please enter the product name");
                    return false;
                }
                if ($('#productImageEdit').val() == "") {
                    $('#productEditMsg').html("Please upload the product image");
                    return false;
                }
                if ($('#perfectForEdit').val() == "") {
                    $('#productEditMsg').html("Please enter perfect for");
                    return false;
                }
                if ($('#grossWeightEdit').val() == "") {
                    $('#productEditMsg').html("Please enter product gross weight");
                    return false;
                }
//                if ($('#netWeightEdit').val() == "") {
//                    $('#productEditMsg').html("Please enter product net weight");
//                    return false;
//                }
                if ($('#totalAmountEdit').val() == "") {
                    $('#productEditMsg').html("Please enter product total amount");
                    return false;
                }
                if ($('#finalAmountEdit').val() == "") {
                    $('#productEditMsg').html("Please enter product final amount");
                    return false;
                }
                if ($('#deliveryTimeEdit').val() == "") {
                    $('#productEditMsg').html("Please enter product delivery time");
                    return false;
                }
                $.ajax({
                    url: "ajaxfile.php",
                    type: "POST",
                    data: {
                        request: 105,
                        product_id: $('#productIdEdit').val(),
                        category_id: $('#categoryEdit').val(),
                        product_name: $('#productNameEdit').val(),
                        perfect_for: $('#perfectForEdit').val(),
                        product_image: $('#productImageEdit').val(),
                        gross_weight: $('#grossWeightEdit').val(),
                        net_weight: $('#netWeightEdit').val(),
                        total_amount: $('#totalAmountEdit').val(),
                        final_amount: $('#finalAmountEdit').val(),
                        delivery_time: $('#deliveryTimeEdit').val(),
                        product_status: $('#productStatusEdit').is(":checked"),
                    },
                    cache: false,
                    success: function (dataResult) {
                        console.log(dataResult);
                        var dataResult = JSON.parse(dataResult);
                        if (dataResult.statusCode == 200) {
                            $('#productEditModal').modal('hide');
                            swal('Success', dataResult.MESSAGE, 'success').then((value) => {
                                location.reload();
                            });
                        } else if (dataResult.statusCode == 201) {
                            swal('Error', dataResult.MESSAGE, 'error');
                        } else if (dataResult.statusCode == 500) {
                            alert(dataResult.MESSAGE);
                        }
                    }
                });
            }
        </script>
    </body>
</html>