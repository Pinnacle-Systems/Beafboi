<?php

$ymd = "Y-m-d";
$format = "d/m/Y H:i:s";
$dmy = "d/m/Y";
$mdy = "m/d/Y";
$timestamp_format = "Y-m-d H:i:s";
$time_name = "Y_m_d_H_i_s";
//date_default_timezone_set("Asia/Kolkata");
//date_default_timezone_set("Asia/Kuala_Lumpur");

function getCurrentDate($format) {
    return date($format);
}

function changeFormat($presentDate, $currentFormat, $newFormat) {
    $date = DateTime::createFromFormat($currentFormat, $presentDate);
    return $date->format($newFormat);
}

function getYear($presentDate, $currentFormat) {
    $date = DateTime::createFromFormat($currentFormat, $presentDate);
    return $date->format("Y");
}

function getMonth($presentDate, $currentFormat) {
    $date = DateTime::createFromFormat($currentFormat, $presentDate);
    return $date->format("m");
}

function getDay($presentDate, $currentFormat) {
    $date = DateTime::createFromFormat($currentFormat, $presentDate);
    return $date->format("d");
}

function resetTime($presentDate) {
    global $timestamp_format;
    $date = Date(mktime(0,0,0, getMonth($presentDate, $timestamp_format), getDay($presentDate, $timestamp_format), getYear($presentDate, $timestamp_format)));
    return date($timestamp_format,$date);
}

function maxTimeOfDay($presentDate) {
    global $timestamp_format;
    $date = Date(mktime(23,59,59, getMonth($presentDate, $timestamp_format), getDay($presentDate, $timestamp_format), getYear($presentDate, $timestamp_format)));
    return date($timestamp_format,$date);
}

function getHour($presentDate, $currentFormat) {
    $date = DateTime::createFromFormat($currentFormat, $presentDate);
    return $date->format("H");
}

function getMinute($presentDate, $currentFormat) {
    $date = DateTime::createFromFormat($currentFormat, $presentDate);
    return $date->format("i");
}

function getSecond($presentDate, $currentFormat) {
    $date = DateTime::createFromFormat($currentFormat, $presentDate);
    return $date->format("s");
}

function getMonthName($date, $currentFormat) {
    $month = getMonth($date, $currentFormat);
    switch ($month) {
        case 1 : {
                return "Jan";
            }
        case 2 : {
                return "Feb";
            }
        case 3 : {
                return "Mar";
            }
        case 4 : {
                return "Apr";
            }
        case 5 : {
                return "May";
            }
        case 6 : {
                return "Jun";
            }
        case 7 : {
                return "Jul";
            }
        case 8 : {
                return "Aug";
            }
        case 9 : {
                return "Sep";
            }
        case 10 : {
                return "Oct";
            }
        case 11 : {
                return "Nov";
            }
        case 12 : {
                return "Dec";
            }
    }
}

function getMonthDifference($deposit_date, $today) {
    global $timestamp_format;
    $months = 0;
    for ($j = 0; $j < 15; $j++) {
        $temp = strtotime(date($timestamp_format, strtotime($deposit_date)) . " +1 month");
        $deposit_date = date($timestamp_format, $temp);
        //echo "<br>".$deposit_date."<br>";
        if ($deposit_date <= $today) {

            $months = $months + 1;
        }
    }
    return $months;
}

// Shows Date in dd/mm/yyyy format.
function showDate($date, $format) {
    return getDay($date, $format) . "/" . getMonthName($date, $format) . "/" . getYear($date, $format);
}

function showMonthNumber($month) {
    switch ($month) {
        case "Jan" : {
                return 1;
            }
        case "Feb" : {
                return 2;
            }
        case "Mar" : {
                return 3;
            }
        case "Apr" : {
                return 4;
            }
        case "May" : {
                return 5;
            }
        case "Jun" : {
                return 6;
            }
        case "Jul" : {
                return 7;
            }
        case "Aug" : {
                return 8;
            }
        case "Sep" : {
                return 9;
            }
        case "Oct" : {
                return 10;
            }
        case "Nov" : {
                return 11;
            }
        case "Dec" : {
                return 12;
            }
    }
}

function getLastMonths($size) {
    $chartData = array();
    global $timestamp_format;
    $date = getCurrentDate($timestamp_format);
    $temp = strtotime(date($timestamp_format, strtotime($date)) . " -" . ($size - 1) . " month");
    $date = date($timestamp_format, $temp);
    for ($i = 0; $i < $size; $i++) {
        $chartData[$i] = array();
        $chartData[$i]['MONTH'] = getMonthName($date, $timestamp_format);
        $chartData[$i]['YEAR'] = getYear($date, $timestamp_format);
        $chartData[$i]['DATA'] = 0;
        $temp = strtotime(date($timestamp_format, strtotime($date)) . " +1 month");
        $date = date($timestamp_format, $temp);
    }
    return $chartData;
}

?>