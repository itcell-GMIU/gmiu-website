<?php
// Include the necessary files and configurations
include '../include/checklogin.php';

// Check if the exp_id parameter is set in the URL
if (isset($_GET['exp_id'])) {
    // Get the exp_id value from the URL
    $exp_id = $_GET['exp_id'];

    // Delete the record from tbl_our_project
    $deleteProjectStmt = $con->prepare("DELETE FROM tbl_our_project WHERE id = ?");
    $deleteProjectStmt->bind_param("i", $exp_id);

    // Execute the delete query
    $deleteProjectSuccess = $deleteProjectStmt->execute();
    // Check if both delete operations were successful
    if ($deleteProjectSuccess) {   
        // Redirect to the view page
        header("Location: our_project_view.php");
        exit();
    } else {
        // Error in deleting, display an error message
        echo "Error deleting project: " . $con->error;
    }

    // Close the statements
    $deleteProjectStmt->close();
} else {
    // Redirect to the view page if exp_id is not set in the URL
    header("Location: our_project_view.php");
    exit();
}

// Close the database connection
$con->close();
?>
