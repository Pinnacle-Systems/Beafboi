<?php
include_once('managers/utils/security_utils.php');
$pass = "manoj";
$enc =  encodeDatabaseData($pass);
echo decodeDatabaseData($enc);
?>