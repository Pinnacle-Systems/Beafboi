<?php

include_once('configuration/config.php');

// function createConnection() {
//     global $host, $uname, $pass, $data_base ,$port;
//     //$conn = mysql_connect($host, $username, $password);
    
//     $conn = new mysqli($host, $uname, $pass, $data_base , $port);

//     if ($conn->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//     }
//     return $conn;
// }

function createConnection() {
    $host = "beafbai.com";   
    $username = "root";
    $password = "root";    
    $database = "beafbai_db1";
    $port = 3300;

  $conn = new mysqli($host, $username, $password, $database,  $port );

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

    return $conn;
}


function closeConnection() {
    mysql_close($conn);
}

function insert($sql) {
//    $log_file = "./my-errors.log";
//    error_log($sql."\n", 3, $log_file);
    
    $conn = createConnection();
    return $conn->query($sql);
}

function update($sql) {
    $conn = createConnection();
    return $conn->query($sql);
}

function select($sql) {
    $conn = createConnection();
    $result = $conn->query($sql);
    return $result;
}

function delete($sql) {
    $conn = createConnection();
    return $conn->query($sql);
}

function getData($sql, $cols) {
    $data = array();
    $result = select($sql);
    if ($row = $result->fetch_assoc()) {
        for ($i = 0; $i < sizeof($cols); $i++) {
            $data[$cols[$i][0]] = $row[$cols[$i][1]];
        }
    }
    return $data;
}

function getDataFromQuery($sql) {
    $fields = array();
    $data = array();
    $result = select($sql);
    $i = 0;
    while ($i < mysqli_num_fields($result)) {
        $field = mysqli_fetch_field_direct($result, $i);
        $fields[$i] = $field->name;
        $i++;
    }
    if ($row = $result->fetch_assoc()) {
        for ($i = 0; $i < sizeof($fields); $i++) {
            $data[$fields[$i]] = $row[$fields[$i]];
        }
    }
    return $data;
}

function getDatas($sql, $cols) {
    $datas = array();
    $result = select($sql);
    $j = 0;
    while ($row = $result->fetch_assoc()) {
        $datas[$j] = array();
        for ($i = 0; $i < sizeof($cols); $i++) {
            $datas[$j][$cols[$i][0]] = $row[$cols[$i][1]];
        }
        $j++;
    }
    return $datas;
}

function getDatasFromQuery($sql) {
    $fields = array();
    $datas = array();
    $result = select($sql);
    $i = 0;
    while ($i < mysqli_num_fields($result)) {
        $field = mysqli_fetch_field_direct($result, $i);
        $fields[$i] = $field->name;
        $i++;
    }
    $j = 0;
    while ($row = $result->fetch_assoc()) {
        $datas[$j] = array();
        for ($i = 0; $i < sizeof($fields); $i++) {
            $datas[$j][$fields[$i]] = $row[$fields[$i]];
        }
        $j++;
    }
    return $datas;
}

?>