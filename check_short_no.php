<?php
include 'common/importwebsitefile.php';
$query = "SELECT short_no FROM tbl_faculty LIMIT 1";
$res = mysqli_query($con, $query);
if ($res) {
    echo "EXISTS";
} else {
    echo "NOT EXISTS: " . mysqli_error($con);
}
?>
