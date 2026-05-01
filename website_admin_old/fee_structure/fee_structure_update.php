<?php
include '../include/checklogin.php';

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Validate and sanitize input
    $document_id = isset($_POST['id']) ? mysqli_real_escape_string($con, $_POST['id']) : '';
    $document = isset($_FILES['document']) ? $_FILES['document'] : null;

    // Check if fee_id is empty
    if (empty($document_id)) {
        $_SESSION['status'] = "Error: Missing fee ID.";
        $_SESSION['status_code'] = "error";
        header("Location: ../common/dashboard.php");
        exit();
    }

    // Check if a new document file is selected
    if (!empty($document['name'])) {
        // Upload the new document file using a custom function 'upload_single_file'
        $targetDirectory = "../uploads/fee_structure/document/";
        $file_upload_status = upload_single_file($document, $targetDirectory, 0);
        
        // Check if file upload was successful
        if ($file_upload_status['status'] == 200) {
            $document = $file_upload_status['message']; // Get the file name of the uploaded document
        } else {
            $_SESSION['status'] = "Error uploading document: " . $file_upload_status['message'];
            $_SESSION['status_code'] = "error";
            header("Location: ../common/dashboard.php.php");
            exit();
        }

        // Prepare the update statement
        $stmt = $con->prepare("UPDATE `tbl_gmiu_doc` SET document = ? WHERE id = ?");
        // Check if the statement was prepared successfully
        if ($stmt) {
            // Bind the parameters for the prepared statement
            $stmt->bind_param("si", $document, $document_id);
            // Execute the prepared statement and get the result
            $result = $stmt->execute();

            // Check if the update was successful
            if ($result) {
                $_SESSION['status'] = "Fee Structure Updated Successfully";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "Fee Structure Update Failed";
                $_SESSION['status_code'] = "error";
            }
        } else {
            $_SESSION['status'] = "Error in preparing update statement";
            $_SESSION['status_code'] = "error";
        }

    } else {
        $_SESSION['status'] = "Error: No document file selected.";
        $_SESSION['status_code'] = "error";
    }

    // Redirect to appropriate page
    header("Location: ../common/dashboard.php");
    exit();
}
?>
