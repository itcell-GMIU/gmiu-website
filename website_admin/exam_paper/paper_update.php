<?php
include '../include/checklogin.php';

// Check if the form is submitted
if (isset($_POST['submit'])) {

    $paper_id = mysqli_real_escape_string($con, $_POST['id']);
    $faculty_name = mysqli_real_escape_string($con, $_POST['faculty_name']);
    $level_name = mysqli_real_escape_string($con, $_POST['level_name']);
    $program_name = mysqli_real_escape_string($con, $_POST['program_name']);
    $sem = mysqli_real_escape_string($con, $_POST['sem']);
    $paper_title = mysqli_real_escape_string($con, $_POST['title']);



    // validate data
    $paper_id = validate_data($paper_id);
    $faculty_name = validate_data($faculty_name);
    $level_name = validate_data($level_name);
    $program_name = validate_data($program_name);
    $paper_title = validate_data($paper_title);



    // Get the value of 'document' from the form
    $document = $_FILES['document'];

    // Check if a new document file is selected
    if (!empty($document['name'])) {
        $targetDirectory = "../uploads/exam_paper/document/";
        $file_upload_status = upload_single_file($_FILES["document"], $targetDirectory, 0); // Upload the new 'document' file using a custom function 'upload_single_file'
        $document = $file_upload_status['message']; // Get the file name of the uploaded document
    } else {
        $document = $_POST['olddocument']; // Use the existing 'document' value if no new file is selected
    }

    $stmt = $con->prepare("UPDATE `tbl_exam_paper` SET faculty_id = ?, level_id = ?, program_id = ?, sem= ?, document = ?, title = ? WHERE id = ? "); // Prepare the update statement
    $stmt->bind_param("iiiissi", $faculty_name, $level_name, $program_name, $sem,  $document, $paper_title, $paper_id); // Bind the parameters for the prepared statement
    $result = $stmt->execute(); // Execute the prepared statement and get the result

    // Check if the update was successful
    if ($result) {
        // Sweet Alert of Success Message
        $_SESSION['status'] = "Exam Paper Updated Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='paper_view.php'},1000);</script>";
    } else {
        // Sweet Alert of Error Message
        $_SESSION['status'] = "Exam Paper Updation Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='paper_view.php'},1000);</script>";
    }
}
?>








<!-- 
echo "<script>
    setTimeout(function() {
        window.location = 'paper_view.php'
    }, 1000);
</script>"; -->