
<?php
// Include the checklogin.php file
include '../include/checklogin.php';


if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type_id = mysqli_real_escape_string($con, $_POST['type']);
    $date = $_POST['date'];
    $participants = $_POST['participants'];
    $image_upload = $_FILES['image_upload'];
    // $type_id = null;
    // if ($type == 'FDP') {
    //     $type_id = 1;
    // } elseif ($type == 'SDP') {
    //     $type_id = 2;
    // } elseif($type == 'workshops&seminars'){
    //     $type_id = 3;

    // }elseif ($type == 'Other Activities'){
    //     $type_id = 4;
    // }else{
    //     $type_id = null;
    // }
    

    // Perform data validation if needed

    // Check if a new image is uploaded
    if (!empty($image_upload['name'])) {
        // Upload the new image
        $targetDirectory = "../uploads/iksve_cell/";
        $file_upload_status = upload_single_file($image_upload, $targetDirectory, 1);

        if ($file_upload_status['status'] == 200) {
            // If the upload is successful, update the image name in the database
            $img_name = $file_upload_status['message'];
            $stmt = $con->prepare("UPDATE `tbl_iksve_cell` SET `name`=?, `type_id`=?,`date`=?,`img_name`=?, `participants`=? WHERE id = ?");
            $stmt->bind_param("sisssi", $name, $type_id,$date,$img_name,  $participants, $id);
        } else {
            // If the upload fails, display an error message
            $_SESSION['status'] = $file_upload_status['message'];
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='activities_edit.php?ic_id=$id'},1000)</script>";
            exit();
        }
    } else {
        // If no new image is uploaded, update the other fields without changing the existing image
        $stmt = $con->prepare("UPDATE `tbl_iksve_cell` SET `name`=?,`type_id`=?,`date`=?, `participants`=? WHERE id = ?");
        $stmt->bind_param("sissi",  $name, $type_id,$date,  $participants, $id);
    }

    // Execute the SQL statement to update the record
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['status'] = "Activities Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='activities_view.php'},1000);</script>";
    } else {
        // Check for SQL errors
        $_SESSION['status'] = "Activities Updation Failed: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='activities_edit.php?ic_id=$id'},1000)</script>";
    }
}
?>
