<?php

include_once('database_manager.php');
include_once('utils/utils.php');
include_once('utils/security_utils.php');

function getAdminByEmailAndPassword($email, $password) {
        $admin = array();
        $enc_pass = encodeDatabaseData($password);
        $sql = "SELECT * FROM " . getAdminTableName() . " WHERE ADMIN_EMAIL = '$email' AND STATUS = 1";
        $result = select($sql);
               
    if ($result->num_rows > 0) {
        if ($row = $result->fetch_assoc()) {
        
            $db_email = $row['ADMIN_EMAIL'];
            $db_password = $row['ADMIN_PASSWORD'];
            $enc_db_password = encodeDatabaseData($db_password);
       

            if ($email == $db_email && $enc_pass == $enc_db_password) {
                $admin['ADMIN_MASTER_ID'] = $row['ADMIN_MASTER_ID'];
                $admin['ADMIN_EMAIL'] = $row['ADMIN_EMAIL'];
                $admin['STATUS'] = $row['STATUS'];
            }
      
       
        }
    }
   
    return $admin;
}

function isvalidAdminToken($email, $token) {
    $sql = "SELECT * FROM " . getAdminTokenTable() . " WHERE  ADMIN_EMAIL = '$email'";
    $result = select($sql);
    if ($row = $result->fetch_assoc()) {
        if ($token == $row['TOKEN']) {
            return true;
        }
    }
    return false;
}

function getAdminByEmail($email) {
    $admin = array();
    $sql = "SELECT * FROM " . getAdminTableName()
            . " WHERE ADMIN_EMAIL = '$email' AND STATUS = 1";
    $result = select($sql);
    if ($row = $result->fetch_assoc()) {
        $admin['ADMIN_MASTER_ID'] = $row['ADMIN_MASTER_ID'];
        $admin['ADMIN_NAME'] = $row['ADMIN_NAME'];
        $admin['ADMIN_EMAIL'] = $row['ADMIN_EMAIL'];
        $admin['STATUS'] = $row['STATUS'];
    }
    return $admin;
}

function setAdminToken($email, $length) {
    $token = getRandomCode($length);
    $sql = "SELECT * FROM " . getAdminTokenTable() . " WHERE ADMIN_EMAIL = '$email'";
    $result = select($sql);
    if ($result->num_rows > 0) {
        $sql = "UPDATE " . getAdminTokenTable()
                . " SET TOKEN = '$token' WHERE ADMIN_EMAIL = '$email'";
    } else {
        $sql = "INSERT INTO " . getAdminTokenTable() . " (ADMIN_EMAIL,TOKEN)"
                . " VALUES('$email','$token')";
    }
    if (insert($sql)) {
        return $token;
    }
    return '';
}

?>