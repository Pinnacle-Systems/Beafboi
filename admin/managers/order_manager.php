<?php

include_once('database_manager.php');
include_once('utils/utils.php');

function getOrderByTransactionId($transactionId) {
    $sql = "SELECT * FROM " . getOrderTableName() . " WHERE TRANSACTION_ID = '$transactionId'";
    return getDataFromQuery($sql);
}

function getOrderedProductsByTransactionId($transactionId) {
    $sql = "SELECT * FROM " . getOrderedTableName() . " WHERE TRANSACTION_ID = '$transactionId'";
    return getDatasFromQuery($sql);
}

function doesTransactionIdExist($transactionId) {
    $order = getOrderByTransactionId($transactionId);
    if (sizeof($order) > 0) {
        return true;
    }
    return false;
}

function getNewTransactionId() {
    $transactionId = "ORD-" . getRandomUpperCaseCode(7);
    if (doesTransactionIdExist($transactionId)) {
        return getNewTransactionId();
    }
    return $transactionId;
}

function addOrder($transactionId, $customerName, $customerEmail, $customerMobile, $customerStreetAddress, $customerTownCity,
        $customerPincode, $paymentMethod) {
    $sql = "INSERT INTO " . getOrderTableName() . " (TRANSACTION_ID,CUSTOMER_NAME,CUSTOMER_EMAIL,CUSTOMER_MOBILE,"
            . "CUSTOMER_STREET_ADDRESS,CUSTOMER_TOWN_CITY,CUSTOMER_PINCODE,ORDER_STATUS,PAYMENT_METHOD) "
            . "VALUES('$transactionId','$customerName','$customerEmail','$customerMobile','$customerStreetAddress',"
            . "'$customerTownCity','$customerPincode',0,'$paymentMethod')";
    return insert($sql);
}

function addOrderedProducts($transactionId, $productName, $productQuantity, $productTotalAmount, $productFinalAmount, $count) {
    $sql = "INSERT INTO " . getOrderedTableName() . " (TRANSACTION_ID,PRODUCT_NAME,PRODUCT_QUANTITY,PRODUCT_TOTAL_AMOUNT,PRODUCT_FINAL_AMOUNT,NUMBER_OF_PRODUCTS) "
            . "VALUES('$transactionId','$productName','$productQuantity','$productTotalAmount','$productFinalAmount','$count')";
    return insert($sql);
}

function updateOrder($transactionId, $paymentId, $status) {
    $sql = "UPDATE " . getOrderTableName() . " SET ORDER_STATUS = $status,PAYMENT_ID='$paymentId' WHERE TRANSACTION_ID = '$transactionId'";
    return update($sql);
}

function compose_mail($transactionId, $paymentId) {
    $order = getOrderByTransactionId($transactionId);
    $orderProducts = getOrderedProductsByTransactionId($transactionId);

    $message1 = "Transaction Id : $paymentId \n";
    $totalAmount = 0;
    for ($i = 0; $i < sizeof($orderProducts); $i++) {
        $message1 = $message1 . $orderProducts[$i]['PRODUCT_NAME'] . " (" . $orderProducts[$i]['PRODUCT_QUANTITY'] . " * " . $orderProducts[$i]['NUMBER_OF_PRODUCTS'] . ") - " .
                $orderProducts[$i]['PRODUCT_FINAL_AMOUNT'] . " * " . $orderProducts[$i]['NUMBER_OF_PRODUCTS'] . " = " . ($orderProducts[$i]['PRODUCT_FINAL_AMOUNT'] * $orderProducts[$i]['NUMBER_OF_PRODUCTS']) . "\n";
        $totalAmount = $totalAmount + ($orderProducts[$i]['PRODUCT_FINAL_AMOUNT'] * $orderProducts[$i]['NUMBER_OF_PRODUCTS']);
    }

    $message1 = $message1 . "TOTAL : $totalAmount \n"
            . "Payment Method : " . $order['PAYMENT_METHOD'];
    $to_email = 'salemfreshmeat@gmail.com';
    $subject = 'Product Purchase';
    $emailMsg = "Name : " . $order['CUSTOMER_NAME'] . " \n"
            . "Email : " . $order['CUSTOMER_EMAIL'] . " \n"
            . "Address : " . $order['CUSTOMER_STREET_ADDRESS'] . ", " . $order['CUSTOMER_TOWN_CITY'] . "\n"
            . "Pincode : " . $order['CUSTOMER_PINCODE'] . " \n"
            . "Phone : " . $order['CUSTOMER_MOBILE'] . " \n"
            . "\n\n"
            . "$message1";

    $headers = 'From: noreply@salemfreshmeat.com';
    if (!mail($to_email, $subject, $emailMsg, $headers)) {
//        $log_file = "./my-errors.log";
//        error_log($emailMsg . "\n", 3, $log_file);
        return false;
    }
    if (!mail($order['CUSTOMER_EMAIL'], $subject, $message1, $headers)) {
        mail($order['CUSTOMER_EMAIL'], $subject, $message1, $headers);
    }
    return true;
}

?>

