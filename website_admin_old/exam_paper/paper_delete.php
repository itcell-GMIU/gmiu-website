<?php
include '../include/checklogin.php';
    
// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the ID is set in the GET request
if (isset($_GET['id'])) {
    $paper_id = $_GET['id'];

    // Retrieve the document path from the database
    $stmt = $con->prepare("SELECT document FROM tbl_exam_paper WHERE id = ?");
    $stmt->bind_param("i", $paper_id);
    $stmt->execute();
    $stmt->bind_result($document);
    $stmt->fetch();
    $stmt->close();

    // Check if the document exists and delete it from the server
    if (!empty($document)) {
        $document_path = '../uploads/exam_paper/document/' . $document;
        if (file_exists($document_path)) {
            unlink($document_path); // Delete the file from the server
        }
    }

    // Prepare the delete statement for the record
    $stmt = $con->prepare("DELETE FROM tbl_exam_paper WHERE id = ?");
    $stmt->bind_param("i", $paper_id);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['status'] = "Exam Paper is Deleted Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='paper_view.php'},1000);</script>";
        exit; // Terminate the script execution
    } else {
        $_SESSION['status'] = "Exam Paper Deletion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='paper_view.php'},1000);</script>";
        exit; // Terminate the script execution
    }

    // Close the statement
    $stmt->close();
} else {
    // If the ID is not set, redirect to the paper view page
    header("Location: paper_view.php");
    exit();
}

// Close the database connection
$con->close();
?>
