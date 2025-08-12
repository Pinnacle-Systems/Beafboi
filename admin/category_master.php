<?php
$condition = true;
include_once('condition_check.php');
include_once('managers/category_manager.php');
if (isset($_POST['category_name']) && isset($_POST['category_description']) && isset($_POST['category_image'])) {
    $categoryName = $_POST['category_name'];
    $categoryDescription = $_POST['category_description'];
    $categoryImage = $_POST['category_image'];
    $categoryStatus = 0;
    if (isset($_POST['category_status'])) {
        $categoryStatus = 1;
    }
    $status = true;
    $msg = "Category Created Successfully";
    if ($categoryName == "") {
        $status = false;
        $msg = "Category name cannot be empty.";
    }
    if ($status && doesCategoryNameExist($categoryName, "null")) {
        $status = false;
        $msg = "Category name already exist.";
    }
    if ($status && $categoryDescription == "") {
        $status = false;
        $msg = "Category Description cannpot be empty";
    }
    if ($status && $categoryImage == "") {
        $status = false;
        $msg = "Please upload a category image";
    }
    if ($status && !addNewCategory($categoryName, $categoryDescription, $categoryImage, $categoryStatus, $admin['ADMIN_MASTER_ID'])) {
        $status = false;
        $msg = "Internal Server Error";
    }
    $_SESSION['STATUS'] = $status;
    $_SESSION['MESSAGE'] = $msg;
    exit(header("location:category_master.php"));
}
$categories = getCategoriesByFilterAndLimit("null", "null", "null");
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
        $page = "category";
        include('header.php');
        ?>
        <div class="bg-wrapper">
            <div class="container py-5">
                <div class="row justify-content-around">
                    <div class="col-md-6 col-sm-12">
                        <div class="section-title section-title-2">
                            <h2>Categories</h2>                            
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
                    for ($i = 0; $i < sizeof($categories); $i++) {
                        ?>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                            <div class="feature-item card" style="overflow: hidden;">
                                <div class="row card-body align-items-center">
                                    <span class="product-item__badge <?php if ($categories[$i]['CATEGORY_STATUS'] == 1) echo 'active-badge'; ?>"></span>
                                    <div class="col-3"> <img src="../img/category/<?php echo $categories[$i]['CATEGORY_IMAGE']; ?>" class="img-fluid rounded-circle" /> </div>
                                    <div class="col-7">
                                        <h4><?php echo $categories[$i]['CATEGORY_NAME']; ?></h4>
                                        <p><?php echo $categories[$i]['CATEGORY_DESCRIPTION']; ?></p>
                                    </div>
                                    <div class="col-2">
                                        <a href="javascript:void(0)" class="edit" data-id="<?php echo $categories[$i]['CATEGORY_MASTER_ID']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                            </svg>
                                        </a>
                                        <a href="javascript:void(0)" class="delete" data-id="<?php echo $categories[$i]['CATEGORY_MASTER_ID']; ?>"
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
                    <form method="post" action="category_master.php" onsubmit="return validateAddForm()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">New Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 text-center image_container">
                                <input type="hidden" id="categoryImageName" name="category_image" />
                                <input type="file" id="categoryImageSelector" style="display:none;" accept="image/*" />
                                <div class="col-12 text-center">
                                    <img src="../img/product_image.png" id="categoryImagePreview" alt="product" style="max-height: 300px;max-width: 100%;" />
                                </div>
                                <div id="categoryImageProgress" style="width:0%;height:100%;position: absolute;top:0%;left:100;background-color: rgba(170,170,170,0.7);"></div>
                                <div class="overlay" id="categoryImageOverlay">
                                    <div class="text">Click here to upload category image.</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="categoryName">Category Name<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" name="category_name" id="categoryName" placeholder="Enter category name">
                                <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                            </div>
                            <div class="form-group">
                                <label for="categoryDescription">Category Description<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" name="category_description" id="categoryDescription" placeholder="Enter category description">
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="status" name="category_status">
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <small id="categoryAddMsg" class="text-danger"></small>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="categoryEditModal" tabindex="-1" role="dialog" aria-labelledby="categoryEditModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <input type="hidden" id="categoryIdEdit" />
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">New Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 text-center image_container">
                            <input type="hidden" id="categoryImageEdit" />
                            <input type="file" id="categoryImageSelectorEdit" style="display:none;" accept="image/*" />
                            <div class="col-12 text-center">
                                <img src="../img/product_image.png" id="categoryImagePreviewEdit" alt="product" style="max-height: 300px;max-width: 100%;" />
                            </div>
                            <div id="categoryImageProgressEdit" style="width:0%;height:100%;position: absolute;top:0%;left:100;background-color: rgba(170,170,170,0.7);"></div>
                            <div class="overlay" id="categoryImageOverlayEdit">
                                <div class="text">Click here to upload category image.</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="categoryNameEdit">Category Name<sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="categoryNameEdit" placeholder="Enter category name">
                            <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                        </div>
                        <div class="form-group">
                            <label for="categoryDescription">Category Description<sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="categoryDescriptionEdit" placeholder="Enter category description">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="categoryStatusEdit">
                            <label class="form-check-label" for="categoryStatusEdit">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <small id="categoryEditMsg" class="text-danger"></small>
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
                                        request: 101,
                                        category_id: $id
                                    },
                                    cache: false,
                                    success: function (dataResult) {
                                        var dataResult = JSON.parse(dataResult);
                                        if (dataResult.statusCode == 200) {
                                            $('#categoryEditMsg').html("");
                                            $('#categoryIdEdit').val($id);
                                            $('#categoryNameEdit').val(dataResult.CATEGORY.CATEGORY_NAME);
                                            $('#categoryDescriptionEdit').val(dataResult.CATEGORY.CATEGORY_DESCRIPTION);
                                            $('#categoryImageEdit').val(dataResult.CATEGORY.CATEGORY_IMAGE);
                                            $('#categoryImagePreviewEdit').attr({"src": "../img/category/" + dataResult.CATEGORY.CATEGORY_IMAGE});
                                            if (dataResult.CATEGORY.CATEGORY_STATUS == 1) {
                                                $('#categoryStatusEdit').prop("checked", "checked");
                                            } else {
                                                $('#categoryStatusEdit').prop("checked", "");
                                            }
                                            $('#categoryEditModal').modal('show');
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
                                    text: "Are you sure you want to delete this category ?\nAll the products under this category will be deleted.",
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
                                                request: 103,
                                                category_id: $id
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
                $('#categoryImageOverlay').click(function () {
                    $('#categoryImageSelector').trigger('click');
                });
                $('#categoryImageOverlayEdit').click(function () {
                    $('#categoryImageSelectorEdit').trigger('click');
                });
                $('#categoryImageSelector').change(function () {
                    if (this.files && this.files[0]) {
                        $('#categoryImageProgress').css({'width': '100%', 'left': '0%'});
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#categoryImagePreview').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(this.files[0]);
                        var formData = new FormData();
                        formData.append("request", "107");
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
                                    $('#categoryImageProgress').css({'width': (100 - progress) + '%', 'left': progress + '%'});
                                }, false);
                                xhr.addEventListener("load", function (event) {
                                }, false);
                                xhr.addEventListener("error", function (event) {
                                    $('#categoryImageProgress').css({'background': 'red'});
                                    alert(event);
                                }, false);
                                xhr.addEventListener("abort", function (event) {
                                }, false);

                                return xhr;
                            },
                            success: function (dataResult) {
                                var dataResult = JSON.parse(dataResult);
                                if (dataResult.statusCode == 200) {
                                    $('#categoryImageName').val(dataResult.NAME);
                                } else if (dataResult.statusCode == 201)
                                {
                                    alert("Error");
                                }
                            }
                        });
                    }
                });
                $('#categoryImageSelectorEdit').change(function () {
                    if (this.files && this.files[0]) {
                        $('#categoryImageProgressEdit').css({'width': '100%', 'left': '0%'});
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#categoryImagePreviewEdit').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(this.files[0]);
                        var formData = new FormData();
                        formData.append("request", "107");
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
                                    $('#categoryImageProgressEdit').css({'width': (100 - progress) + '%', 'left': progress + '%'});
                                }, false);
                                xhr.addEventListener("load", function (event) {
                                }, false);
                                xhr.addEventListener("error", function (event) {
                                    $('#categoryImageProgressEdit').css({'background': 'red'});
                                    alert(event);
                                }, false);
                                xhr.addEventListener("abort", function (event) {
                                }, false);

                                return xhr;
                            },
                            success: function (dataResult) {
                                var dataResult = JSON.parse(dataResult);
                                if (dataResult.statusCode == 200) {
                                    $('#categoryImageEdit').val(dataResult.NAME);
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

        <!--validateions-->
        <script>
            function validateAddForm() {
                if ($('#categoryImageName').val() == "") {
                    $('#categoryAddMsg').html("Please upload the category image");
                    return false;
                }
                if ($('#categoryName').val() == "") {
                    $('#categoryAddMsg').html("Please enter the category name");
                    return false;
                }
                if ($('#categoryDescription').val() == "") {
                    $('#categoryAddMsg').html("Please enter the category description");
                    return false;
                }
            }

            function validateEditForm() {
                if ($('#categoryImageEdit').val() == "") {
                    $('#categoryEditMsg').html("Please upload the category image");
                    return false;
                }
                if ($('#categoryNameEdit').val() == "") {
                    $('#categoryEditMsg').html("Please enter the category name");
                    return false;
                }
                if ($('#categoryDescriptionEdit').val() == "") {
                    $('#categoryEditMsg').html("Please enter the category description");
                    return false;
                }
                $.ajax({
                    url: "ajaxfile.php",
                    type: "POST",
                    data: {
                        request: 102,
                        category_id: $('#categoryIdEdit').val(),
                        category_name: $('#categoryNameEdit').val(),
                        category_description: $('#categoryDescriptionEdit').val(),
                        category_image: $('#categoryImageEdit').val(),
                        category_status: $('#categoryStatusEdit').is(":checked"),
                    },
                    cache: false,
                    success: function (dataResult) {
                        var dataResult = JSON.parse(dataResult);
                        if (dataResult.statusCode == 200) {
                            $('#categoryEditModal').modal('hide');
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