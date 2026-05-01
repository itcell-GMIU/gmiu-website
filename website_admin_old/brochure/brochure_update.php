<?php
include '../include/checklogin.php';

// Check if the form is submitted
if (isset($_POST['submit'])) {

    $brochure_id = mysqli_real_escape_string($con, $_POST['id']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $sno = mysqli_real_escape_string($con, $_POST['sno']);

    // validate data
    $title = validate_data($title);
    $brochure_id = validate_data($brochure_id);


    $thumbnail = $_FILES['thumbnail']; // Get the value of 'thumbnail' from the form
    $document = $_FILES['document']; // Get the value of 'document' from the form

    // Check if a new thumbnail file is selected
    if (!empty($thumbnail['name'])) {
        $targetDirectory = "../uploads/brochure/thumbnail/";

        // Upload the new 'thumbnail' file using a custom function 'upload_single_file'
        $file_upload_status = upload_single_file($_FILES["thumbnail"], $targetDirectory, 1);
        $thumbnail = $file_upload_status['message'];
    } else {
        $thumbnail = $_POST['oldthumbnail']; // Use the existing 'thumbnail' value if no new file is selected
    }

    // Check if a new document file is selected
    if (!empty($document['name'])) {
        $targetDirectory = "../uploads/brochure/document/";
        $file_upload_status = upload_single_file($_FILES["document"], $targetDirectory, 0); // Upload the new 'document' file using a custom function 'upload_single_file'
        $document = $file_upload_status['message']; // Get the file name of the uploaded document
    } else {
        $document = $_POST['olddocument']; // Use the existing 'document' value if no new file is selected
    }

    $stmt = $con->prepare("UPDATE `tbl_brochure` SET sno=?, title=?, thumbnail=?, document =? WHERE id = ? "); // Prepare the update statement
    $stmt->bind_param("isssi",  $sno, $title, $thumbnail, $document, $brochure_id); // Bind the parameters for the prepared statement
    $result = $stmt->execute(); // Execute the prepared statement and get the result

    // Check if the update was successful
    if ($result) {

        // Sweet Alert of Success Message
        $_SESSION['status'] = "E-Brochure Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='brochure_view.php'},1000);</script>";
    } else {

        // Sweet Alert of Error Message
        $_SESSION['status'] = "E-Brochure  Updation Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='brochure_view.php'},1000)</script>";
    }
}
?>