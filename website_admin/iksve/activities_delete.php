<?php
include '../include/checklogin.php';

if (isset($_GET['ic_id']) && !empty($_GET['ic_id'])) {
    $id = mysqli_real_escape_string($con, $_GET['ic_id']);
    $id = only_digits($id);
    
    $stmt = $con->prepare("UPDATE `tbl_iksve_cell` SET is_delete = 1 , is_active = 0 WHERE id = ? ");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    if ($result) {

        $status = 1;
        $cmd = $con->prepare("SELECT  ic.img_name as img_name  FROM tbl_iksve_cell as ic WHERE ic.is_delete = ? and ic.id = ?");
        $cmd->bind_param("ii", $status, $id);
        $cmd->execute();
        $result = $cmd->get_result();
        while ($row = $result->fetch_assoc()) {
            $img_name = $row['img_name'];
            $path = '../uploads/iksve_cell/';
            // Delete file from directory
            if (delete_file($img_name, $path)) {
                $_SESSION['status'] = "Activites Delete Successfully";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='activities_view.php'},1000);</script>";
            } 
        }
    }
}
