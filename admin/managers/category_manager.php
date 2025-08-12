<?php

include_once('database_manager.php');
include_once('utils/date_utils.php');

function getCategorySummary() {
    $sql = "SELECT COUNT(*) AS TOTAL, COUNT(IF(CATEGORY_STATUS=1,1,null)) AS ACTIVE FROM category_master";
    return getDataFromQuery($sql);
}

function getCategoriesByFilterAndLimit($filter, $limit, $count) {
    $sql = "SELECT * FROM " . getCategoryTableName();
    $filter != "null" ? $sql .= " WHERE CATEGORY_STATUS = $filter ORDER BY CATEGORY_MASTER_ID DESC" : $sql .= " ORDER BY CATEGORY_MASTER_ID DESC";
    $limit != "null" ? $sql .= " LIMIT $limit,$count" : "";
    return getDatasFromQuery($sql);
}

function getCategoryById($id) {
    $sql = "SELECT * FROM " . getCategoryTableName() . " WHERE CATEGORY_MASTER_ID = $id";
    return getDataFromQuery($sql);
}

function doesCategoryNameExist($categoryName, $exceptionId) {
    $sql = "SELECT * FROM " . getCategoryTableName() . " WHERE CATEGORY_NAME = '$categoryName'";
    if ($exceptionId != "null") {
        $sql .= " AND CATEGORY_MASTER_ID != $exceptionId";
    }
    $category = getDataFromQuery($sql);
    if (sizeof($category) > 0) {
        return true;
    }
    return false;
}

function addNewCategory($categoryName, $categoryDescription, $categoryImage, $categoryStatus, $createdBy) {
    global $timestamp_format;
    $date = getCurrentDate($timestamp_format);
    $sql = "INSERT INTO " . getCategoryTableName() . " (CATEGORY_NAME,CATEGORY_DESCRIPTION,CATEGORY_IMAGE,CATEGORY_STATUS,"
            . "CATEGORY_CREATED_DATE,CATEGORY_CREATED_BY) "
            . "VALUES('$categoryName','$categoryDescription','$categoryImage',$categoryStatus,'$date',$createdBy)";
    return insert($sql);
}

function updateCategory($categoryName, $categoryDescription, $categoryImage, $categoryStatus, $categoryId) {
    $sql = "UPDATE " . getCategoryTableName() . " SET "
            . "CATEGORY_NAME = '$categoryName',"
            . "CATEGORY_DESCRIPTION = '$categoryDescription',"
            . "CATEGORY_IMAGE = '$categoryImage',"
            . "CATEGORY_STATUS = $categoryStatus "
            . "WHERE CATEGORY_MASTER_ID = $categoryId";
    return update($sql);
}

function deleteCategory($categoryId) {
    $sql = "DELETE FROM " . getCategoryTableName() . " WHERE CATEGORY_MASTER_ID = $categoryId";
    return delete($sql);
}

function getNewFileName($date, $extension, $num) {
    global $timestamp_format;
    global $time_name;
    if ($num == 0) {
        $newName = changeFormat($date, $timestamp_format, $time_name) . "." . $extension;
    } else {
        $newName = changeFormat($date, $timestamp_format, $time_name) . "_" . $num . "." . $extension;
    }
    if (doesOrderFileNameExist($newName)) {
        return getNewFileName($date, $extension, $num + 1);
    } else {
        return $newName;
    }
}

function doesOrderFileNameExist($newName) {
    $path = "../img/category/" . $newName;
    if (file_exists($path)) {
        return true;
    } else {
        return false;
    }
}

?>