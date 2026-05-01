<?php
include '../include/checklogin.php';

// Check if an ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Get the ID from the URL
    $id = $_GET['id'];

    // Prepare the SQL statement to delete the record
    $stmt = $con->prepare("DELETE FROM tbl_event WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Success message
        $_SESSION['status'] = "Record deleted successfully.";
        $_SESSION['status_code'] = "success";
    } else {
        // Error message
        $_SESSION['status'] = "Failed to delete the record.";
        $_SESSION['status_code'] = "error";
    }

    $stmt->close();
} else {
    // ID was not provided
    $_SESSION['status'] = "Invalid request.";
    $_SESSION['status_code'] = "error";
}

// Redirect back to the event report list page
echo "<script>setTimeout(function(){window.location='event_report_view.php'},1000);</script>";
?>
