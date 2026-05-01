<?php
include 'common/importwebsitefile.php';
$res = mysqli_query($con, 'DESCRIBE tbl_Industry_visit');
while($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
?>
