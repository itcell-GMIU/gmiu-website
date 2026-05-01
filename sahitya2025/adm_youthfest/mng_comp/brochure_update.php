<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include './validation.php';
include './function.php';
include '../include/checklogin.php';

// Check if the form is submitted
if (isset($_POST['submit'])) {

    $brochure_id = mysqli_real_escape_string($con, $_POST['id']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
$fees = mysqli_real_escape_string($con, $_POST['fees']);
    // validate data
    $title = validate_data($title);
    $brochure_id = validate_data($brochure_id);

    $document = $_FILES['document']; // Get the value of 'document' from the form

    // Check if a new document file is selecteds
    if (!empty($document['name']) && $document['name'] !== NULL) {
        $targetDirectory = "../../docs/";
        $file_upload_status = upload_single_file($_FILES["document"], $targetDirectory, 0); // Upload the new 'document' file using a custom function 'upload_single_file'
        $document = $file_upload_status['message']; // Get the file name of the uploaded document
    } else {
        $document = NULL; // Use the existing 'document' value if no new file is selected
    }

    $stmt = $con->prepare("UPDATE `tbl_competetion` SET name =?, file=?, fees = ? WHERE id = ? "); // Prepare the update statement
    $stmt->bind_param("sssi",  $title, $document, $fees,$brochure_id); // Bind the parameters for the prepared statement
    $result = $stmt->execute(); // Execute the prepared statement and get the   result

    // Check if the update was successful
    if ($result) {

        // Sweet Alert of Success Message
        $_SESSION['status'] = "Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='brochure_view.php'},1000);</script>";
    } else {

        // Sweet Alert of Error Message
        $_SESSION['status'] = "Updation Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='brochure_view.php'},1000)</script>";
    }
}
?>