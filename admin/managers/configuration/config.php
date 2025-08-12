<?php

// BASIC CONFIGURATIONS
$host = "localhost";
$data_base = "BeafBai_db1";
$uname = "root";
$pass = "root";
$port  = "3306";


$website_name = "BeafBai";

// TABLES
function getAdminTableName()
{
    return "admin_master";
}
function getAdminTokenTable()
{
    return "admin_token";
}
function getCategoryTableName()
{
    return "category_master";
}
function getProductTableName()
{
    return "product_master";
}
function getOrderTableName()
{
    return "order_master";
}
function getOrderedTableName()
{
    return "ordered_products";
}

?>