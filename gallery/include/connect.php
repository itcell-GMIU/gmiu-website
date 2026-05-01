<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// $dbuser = "root";
// $dbpass = "";
// $host = "localhost";
// $db = "gallery";
$dbuser="u977112581_gallery";
$dbpass="GmiuGallery@394#?";
$host="localhost";
$db="u977112581_gallery"; 
$con = new mysqli($host, $dbuser, $dbpass, $db);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


?>