
<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $program_description = $_POST['program_description'];
    $image_upload = $_FILES['image_upload'];

    // Perform data validation if needed

    // Check if a new image is uploaded
    if (!empty($image_upload['name'])) {
        // Upload the new image
        $targetDirectory = "../uploads/international_cell/";
        $file_upload_status = upload_single_file($image_upload, $targetDirectory, 1);

        if ($file_upload_status['status'] == 200) {
            // If the upload is successful, update the image name in the database
            $img_name = $file_upload_status['message'];
            $stmt = $con->prepare("UPDATE `tbl_international_cell` SET `title`=?, `img_name`=?, `description`=? WHERE id = ?");
            $stmt->bind_param("sssi", $title, $img_name, $program_description, $id);
        } else {
            // If the upload fails, display an error message
            $_SESSION['status'] = $file_upload_status['message'];
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='international_cell_edit.php?ic_id=$id'},1000)</script>";
            exit();
        }
    } else {
        // If no new image is uploaded, update the other fields without changing the existing image
        $stmt = $con->prepare("UPDATE `tbl_international_cell` SET `title`=?, `description`=? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $program_description, $id);
    }

    // Execute the SQL statement to update the record
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['status'] = "International Relation Cell Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='international_cell_view.php'},1000);</script>";
    } else {
        // Check for SQL errors
        $_SESSION['status'] = "International Relation Cell Updation Failed: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='international_cell_edit.php?ic_id=$id'},1000)</script>";
    }
}
?>
