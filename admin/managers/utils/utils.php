<?php

function getRandomCode($number_of_chars) {
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($permitted_chars), 0, $number_of_chars);
}

function getRandomNumberCode($number_of_chars) {
    $permitted_chars = '0123456789';
    return substr(str_shuffle($permitted_chars), 0, $number_of_chars);
}

function getRandomUpperCaseCode($number_of_chars) {
    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($permitted_chars), 0, $number_of_chars);
}

function appendZero($num) {
    $newNum = $num;
    if ($num < 1000000) {
        $newNum = "0" . $newNum;
    }if ($num < 100000) {
        $newNum = "0" . $newNum;
    }if ($num < 10000) {
        $newNum = "0" . $newNum;
    }if ($num < 1000) {
        $newNum = "0" . $newNum;
    }if ($num < 100) {
        $newNum = "0" . $newNum;
    }if ($num < 10) {
        $newNum = "0" . $newNum;
    }
    return $newNum;
}

?>