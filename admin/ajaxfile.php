<?php

/* Request 
 * 
 * 101 - Get Selected Category Details 
 * 102 - Save Edited Category
 * 103 - Delete Category.
 * 
 * 104 - Get selected Product Details
 * 105 - Save Edited Product
 * 106 - Delete Product
 * 
 * 107 - Upload Category Image
 * 108 - Upload Product Image
 * 
 *  */

if (isset($_POST['request'])) {
    $request = $_POST['request'];
    $errorStatus = true;

    if ($request == 101 && isset($_POST['category_id'])) {
        $errorStatus = false;
        $categoryId = $_POST['category_id'];
        include_once('managers/category_manager.php');
        $category = getCategoryById($categoryId);
        echo json_encode(array("statusCode" => 200, "CATEGORY" => $category));
    }

    if ($request == 102 && isset($_POST['category_name']) && isset($_POST['category_description']) &&
            isset($_POST['category_image']) && isset($_POST['category_id'])) {
        $errorStatus = false;
        $categoryId = $_POST['category_id'];
        $categoryName = $_POST['category_name'];
        $categoryDescription = $_POST['category_description'];
        $categoryImage = $_POST['category_image'];
        $categoryStatus = 0;
        if ($_POST['category_status'] == "true") {
            $categoryStatus = 1;
        }
        include_once('managers/category_manager.php');
        if (doesCategoryNameExist($categoryName, $categoryId)) {
            echo json_encode(array("statusCode" => 201, "MESSAGE" => "Category Name Already Exist."));
        } else {
            if (updateCategory($categoryName, $categoryDescription, $categoryImage, $categoryStatus, $categoryId)) {
                echo json_encode(array("statusCode" => 200, "MESSAGE" => "Category Updated."));
            } else {
                echo json_encode(array("statusCode" => 201, "MESSAGE" => "Internal Server Error."));
            }
        }
    }

    if ($request == 103 && isset($_POST['category_id'])) {
        $errorStatus = false;
        $categoryId = $_POST['category_id'];
        include_once('managers/category_manager.php');
        include_once('managers/product_manager.php');
        if (deleteProductByCategoryId($categoryId)) {
            if (deleteCategory($categoryId)) {
                echo json_encode(array("statusCode" => 200, "MESSAGE" => "Category Deleted."));
            } else {
                echo json_encode(array("statusCode" => 201, "MESSAGE" => "Internal Server Error."));
            }
        } else {
            echo json_encode(array("statusCode" => 201, "MESSAGE" => "Internal Server Error."));
        }
    }

    if ($request == 104 && isset($_POST['product_id'])) {
        $errorStatus = false;
        $productId = $_POST['product_id'];
        include_once('managers/product_manager.php');
        $product = getProductById($productId);
        echo json_encode(array("statusCode" => 200, "PRODUCT" => $product));
    }

    if ($request == 105 && isset($_POST['product_id']) && isset($_POST['category_id']) && isset($_POST['product_name']) &&
            isset($_POST['perfect_for']) && isset($_POST['gross_weight']) && isset($_POST['net_weight']) &&
            isset($_POST['product_image']) && isset($_POST['total_amount']) && isset($_POST['final_amount']) &&
            isset($_POST['delivery_time'])) {
        $errorStatus = false;
        $productId = $_POST['product_id'];
        $categoryId = $_POST['category_id'];
        $productName = $_POST['product_name'];
        $productImage = $_POST['product_image'];
        $perfectFor = $_POST['perfect_for'];
        $grossWeight = $_POST['gross_weight'];
        $netWeight = $_POST['net_weight'];
        $totalAmount = $_POST['total_amount'];
        $finalAmount = $_POST['final_amount'];
        $deliveryTime = $_POST['delivery_time'];
        $productStatus = 0;
        if ($_POST['product_status'] == "true") {
            $productStatus = 1;
        }
        include_once('managers/product_manager.php');
        if (doesProductNameExist($productName, $productId)) {
            echo json_encode(array("statusCode" => 201, "MESSAGE" => "Product Name Already Exist."));
        } else {
            if (updateProduct($productName, $productImage, $categoryId, $perfectFor, $grossWeight, $netWeight, $totalAmount,
                            $finalAmount, $deliveryTime, $productStatus, $productId)) {
                echo json_encode(array("statusCode" => 200, "MESSAGE" => "Product Updated."));
            } else {
                echo json_encode(array("statusCode" => 201, "MESSAGE" => "Internal Server Error."));
            }
        }
    }

    if ($request == 106 && isset($_POST['product_id'])) {
        $errorStatus = false;
        $productId = $_POST['product_id'];
        include_once('managers/product_manager.php');
        if (deleteProduct($productId)) {
            echo json_encode(array("statusCode" => 200, "MESSAGE" => "Product Deleted."));
        } else {
            echo json_encode(array("statusCode" => 201, "MESSAGE" => "Internal Server Error."));
        }
    }

    if ($request == 107 && isset($_FILES["file1"])) {
        include_once('managers/utils/date_utils.php');
        include_once('managers/category_manager.php');
        $errorStatus = false;
        $uploadfile = $_FILES["file1"];
        $folderPath = "../img/category/";
        $name = $_FILES["file1"]["name"];
        $path_parts = pathinfo($_FILES["file1"]["name"]);
        $extension = $path_parts['extension'];
        $size = $_FILES["file1"]["size"];
        $date = getCurrentDate($timestamp_format);
        $new_name = getNewFileName($date, $extension, 0);
        if (move_uploaded_file($_FILES["file1"]["tmp_name"], $folderPath . $new_name)) {
            echo json_encode(array("statusCode" => 200,
                "NAME" => $new_name));
        } else {
            echo json_encode(array("statusCode" => 201));
        }
    }

    if ($request == 108 && isset($_FILES["file1"])) {
        include_once('managers/utils/date_utils.php');
        include_once('managers/product_manager.php');
        $errorStatus = false;
        $uploadfile = $_FILES["file1"];
        $folderPath = "../img/products/";
        $name = $_FILES["file1"]["name"];
        $path_parts = pathinfo($_FILES["file1"]["name"]);
        $extension = $path_parts['extension'];
        $size = $_FILES["file1"]["size"];
        $date = getCurrentDate($timestamp_format);
        $new_name = getNewProductFileName($date, $extension, 0);
        if (move_uploaded_file($_FILES["file1"]["tmp_name"], $folderPath . $new_name)) {
            echo json_encode(array("statusCode" => 200,
                "NAME" => $new_name));
        } else {
            echo json_encode(array("statusCode" => 201));
        }
    }

    if ($errorStatus) {
        echo json_encode(array("statusCode" => 201, "MESSAGE" => "Invalid Request."));
    }
} else {
    echo json_encode(array("statusCode" => 201, "MESSAGE" => "Access Restricted."));
}
?>