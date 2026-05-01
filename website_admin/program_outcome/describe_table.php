<?php
include 'c:/xampp/htdocs/gmiu/database/connect.php';
$res = mysqli_query($con, "DESCRIBE tbl_program_outcome");
while($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . ' - ' . $row['Type'] . PHP_EOL;
}
?>
