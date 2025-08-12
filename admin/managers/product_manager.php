<?php

include_once('database_manager.php');
include_once('utils/date_utils.php');

function getProductSummary() {
    $sql = "SELECT COUNT(*) AS TOTAL, COUNT(IF(PRODUCT_STATUS=1,1,null)) AS ACTIVE FROM product_master";
    return getDataFromQuery($sql);
}

/**
 * 
 * @param type $filter should be 1/0
 * @param type $limit null or number
 * @param type $count number
 * @return 2d  array
 */
function getProductsByFilterAndLimit($filter, $limit, $count) {
    $sql = "SELECT * FROM " . getProductTableName();
    $filter != "null" ? $sql .= " WHERE PRODUCT_STATUS = $filter ORDER BY PRODUCT_MASTER_ID DESC" : $sql .= " ORDER BY PRODUCT_MASTER_ID DESC";
    $limit != "null" ? $sql .= " LIMIT $limit,$count" : "";
    return getDatasFromQuery($sql);
}

function getProductsByCategory($categoryId) {
    $sql = "SELECT * FROM " . getProductTableName() . " WHERE CATEGORY_MASTER_ID = $categoryId";
    return getDatasFromQuery($sql);
}

function getProductById($productId) {
    $sql = "SELECT * FROM " . getProductTableName() . " WHERE PRODUCT_MASTER_ID = $productId";
    return getDataFromQuery($sql);
}

function getProductsByMutipleId($productIdArray) {
    $sql = "SELECT * FROM " . getProductTableName() . " WHERE ";
    for ($i = 0; $i < sizeof($productIdArray); $i++) {
        $sql .= "PRODUCT_MASTER_ID = $productIdArray[$i]";
        if (($i + 1) != sizeof($productIdArray)) {
            $sql .= " OR ";
        }
    }
    return getDatasFromQuery($sql);
}

function doesProductNameExist($productName, $exceptionId) {
    $sql = "SELECT * FROM " . getProductTableName() . " WHERE PRODUCT_NAME = '$productName'";
    if ($exceptionId != "null") {
        $sql .= " AND PRODUCT_MASTER_ID != $exceptionId";
    }
    $product = getDataFromQuery($sql);
    if (sizeof($product) > 0) {
        return true;
    }
    return false;
}

function addProduct($productName, $productImage, $perfectFor, $grossWeight,
        $netWeight, $totalAmount, $finalAmount, $deliveryTime, $productStatus, $createdBy, $categoryId) {
    global $timestamp_format;
    $date = getCurrentDate($timestamp_format);
    $sql = "INSERT INTO " . getProductTableName() . " (PRODUCT_NAME,PRODUCT_IMAGE,PERFECT_FOR,GROSS_WEIGHT,NET_WEIGHT,"
            . "TOTAL_AMOUNT,FINAL_AMOUNT,DELIVERY_TIME,PRODUCT_STATUS,PRODUCT_CREATED_DATE,PRODUCT_CREATED_BY,"
            . "CATEGORY_MASTER_ID) "
            . "VALUES('$productName','$productImage','$perfectFor','$grossWeight','$netWeight','$totalAmount',"
            . "'$finalAmount','$deliveryTime',$productStatus,'$date',$createdBy,$categoryId)";
    return insert($sql);
}

function updateProduct($productName, $productImage, $categoryId, $perfectFor, $grossWeight, $netWeight, $totalAmount,
        $finalAmount, $deliveryTime, $productStatus, $productId) {
    $sql = "UPDATE " . getProductTableName() . " SET "
            . "PRODUCT_NAME = '$productName', "
            . "PRODUCT_IMAGE = '$productImage', "
            . "CATEGORY_MASTER_ID = $categoryId, "
            . "PERFECT_FOR = '$perfectFor', "
            . "GROSS_WEIGHT = '$grossWeight', "
            . "NET_WEIGHT = '$netWeight', "
            . "TOTAL_AMOUNT = '$totalAmount', "
            . "FINAL_AMOUNT = '$finalAmount', "
            . "DELIVERY_TIME = '$deliveryTime', "
            . "PRODUCT_STATUS = $productStatus "
            . "WHERE PRODUCT_MASTER_ID = $productId";
    return update($sql);
}

function deleteProductByCategoryId($categoryId) {
    $sql = "DELETE FROM " . getProductTableName() . " WHERE CATEGORY_MASTER_ID = $categoryId";
    return delete($sql);
}

function deleteProduct($productId) {
    $sql = "DELETE FROM " . getProductTableName() . " WHERE PRODUCT_MASTER_ID = $productId";
    return delete($sql);
}

function getNewProductFileName($date, $extension, $num) {
    global $timestamp_format;
    global $time_name;
    if ($num == 0) {
        $newName = changeFormat($date, $timestamp_format, $time_name) . "." . $extension;
    } else {
        $newName = changeFormat($date, $timestamp_format, $time_name) . "_" . $num . "." . $extension;
    }
    if (doesProductFileNameExist($newName)) {
        return getNewProductFileName($date, $extension, $num + 1);
    } else {
        return $newName;
    }
}

function doesProductFileNameExist($newName) {
    $path = "../img/products/" . $newName;
    if (file_exists($path)) {
        return true;
    } else {
        return false;
    }
}

?>