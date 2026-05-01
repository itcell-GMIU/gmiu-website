<?php
include '../include/checklogin.php';

if (isset($_POST["submit"])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $title = mysqli_real_escape_string($con, $_POST['title']);


    $stmt = $con->prepare("UPDATE `tbl_our_startup` SET title = ? WHERE id = ? ");
    $stmt->bind_param("si", $title, $id);
    $result = $stmt->execute();

    if ($result) {
        //expert talk photos update
        if ($_FILES['images']['error'][0]  == 0) {
            //delete tbl_site photos
            $type = "startup";
            $stmt = $con->prepare("DELETE FROM `tbl_site_photos` WHERE  type_id = ? and type = ?  ");
            $stmt->bind_param("is", $id, $type);
            $result = $stmt->execute();
            // check photos are deleted 
            if ($result) {
                $targetDirectory = "../uploads/our_startup/image/"; // Adjust the target directory as needed
                $uploaded_images = upload_multiple_files($_FILES["images"], $targetDirectory, 1);

                if ($uploaded_images['status'] == 200) {
                    foreach ($uploaded_images['message'] as $file_name) {
                        $file_type = "image";
                        $type = "Startup";
                        $file_name = implode("", $file_name);
                        $stmt = $con->prepare("INSERT INTO `tbl_site_photos` (`type_id`, `type`, `file_name`, `file_type`) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("isss", $id, $type, $file_name, $file_type);
                        $result = $stmt->execute();
                    }
                } else {
                    $_SESSION['status'] = $uploaded_images['message'];
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='our_startup_edit.php'},1000)</script>";
                }
            } else {
                $_SESSION['status'] = "Our Startup  Update Failed ";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='our_startup_edit.php'},1000);</script>";
            }
        }

        $_SESSION['status'] = "Our Startup Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='our_startup_view.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Our Startup  Update Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='our_startup_edit.php'},1000)</script>";
    }
}






