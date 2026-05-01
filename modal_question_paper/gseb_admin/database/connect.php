<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$dbuser="u977112581_boardmodal";
$dbpass="Boardmodal@123#$";
$host="localhost";
$db="u977112581_boardmodal";

$con = new mysqli($host,$dbuser, $dbpass, $db);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


?>