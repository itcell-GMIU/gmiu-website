<?php
include '../include/checklogin.php';

// Check if the form is submitted
if (isset($_POST['submit'])) {

    $brochure_id = mysqli_real_escape_string($con, $_POST['id']);
    $faculty_name = mysqli_real_escape_string($con, $_POST['faculty_name']);
    $level_name = mysqli_real_escape_string($con, $_POST['level_name']);

    // validate data
    $brochure_id = validate_data($brochure_id);
    $faculty_name = validate_data($faculty_name);
    $level_name = validate_data($level_name);

    // Get the value of 'document' from the form
    $document = $_FILES['document'];

    // Check if a new document file is selected
    if (!empty($document['name'])) {
        $targetDirectory = "../uploads/faculty_brochure/document/";
        $file_upload_status = upload_single_file($_FILES["document"], $targetDirectory, 0); // Upload the new 'document' file using a custom function 'upload_single_file'
        $document = $file_upload_status['message']; // Get the file name of the uploaded document
    } else {
        $document = $_POST['olddocument']; // Use the existing 'document' value if no new file is selected
    }

    $stmt = $con->prepare("UPDATE `tbl_faculty_brochure` SET faculty_id = ?, level_id = ?, document = ? WHERE id = ? "); // Prepare the update statement
    $stmt->bind_param("iisi", $faculty_name, $level_name, $document, $brochure_id); // Bind the parameters for the prepared statement
    $result = $stmt->execute(); // Execute the prepared statement and get the result

    // Check if the update was successful
    if ($result) {
        // Sweet Alert of Success Message
        $_SESSION['status'] = "E-Brochure Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='faculty_brochure_view.php'},1000);</script>";
    } else {
        // Sweet Alert of Error Message
        $_SESSION['status'] = "E-Brochure Updation Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='faculty_brochure_view.php'},1000);</script>";
    }
}
?>








<!-- 
echo "<script>
    setTimeout(function() {
        window.location = 'faculty_brochure_view.php'
    }, 1000);
</script>"; -->