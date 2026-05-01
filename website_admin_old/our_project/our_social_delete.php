<?php
// Include the necessary files and configurations
include '../include/checklogin.php';

// Check if the exp_id parameter is set in the URL
if (isset($_GET['exp_id'])) {
    // Get the exp_id value from the URL
    $exp_id = $_GET['exp_id'];

    // Delete the record from tbl_our_project
    $deleteProjectStmt = $con->prepare("DELETE FROM tbl_our_social WHERE id = ?");
    $deleteProjectStmt->bind_param("i", $exp_id);

    // Execute the delete query
    $deleteProjectSuccess = $deleteProjectStmt->execute();

    // Delete records from tbl_site_photos
    $deletePhotosStmt = $con->prepare("DELETE FROM tbl_site_photos WHERE type = 'our_social' AND type_id = ?");
    $deletePhotosStmt->bind_param("i", $exp_id);

    // Execute the delete query for photos
    $deletePhotosSuccess = $deletePhotosStmt->execute();

    // Check if both delete operations were successful
    if ($deleteProjectSuccess && $deletePhotosSuccess) {   
        // Redirect to the view page
        header("Location: our_social_view.php");
        exit();
    } else {
        // Error in deleting, display an error message
        echo "Error deleting project: " . $con->error;
    }

    // Close the statements
    $deleteProjectStmt->close();
    $deletePhotosStmt->close();
} else {
    // Redirect to the view page if exp_id is not set in the URL
    header("Location: our_social_view.php");
    exit();
}

// Close the database connection
$con->close();
?>
