<?php
include 'common/importwebsitefile.php';
$res = mysqli_query($con, "SHOW COLUMNS FROM tbl_faculty");
while($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . "\n";
}
?>
