<?php
// SECURITY KEYS
$encryption_key = "somethingnotbad";
$db_encryption_key = "inverseqwerty";    // Do not change this key

function encodeData($string) {
    global $encryption_key;
    return encodeDataUsingKey($string, $encryption_key);
}

function encodeDatabaseData($string) {
    global $db_encryption_key;
    return encodeDataUsingKey($string, $db_encryption_key);
}

function encodeDataUsingKey($string, $key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    $j = 0;
    $hash = "";
    for ($i = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($string, $i, 1));
        if ($j == $keyLen) {
            $j = 0;
        }
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
    }
    return $hash;
}

function decodeData($string) {
    global $encryption_key;
    return decodeDataUsingKey($string, $encryption_key);
}

function decodeDatabaseData($string) {
    global $db_encryption_key;
    return decodeDataUsingKey($string, $db_encryption_key);
}

function decodeDataUsingKey($string, $key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    $j = 0;
    $hash = "";
    for ($i = 0; $i < $strLen; $i += 2) {
        $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
        if ($j == $keyLen) {
            $j = 0;
        }
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= chr($ordStr - $ordKey);
    }
    return $hash;
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>