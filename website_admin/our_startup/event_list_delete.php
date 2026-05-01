<?php
include '../include/checklogin.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the record from the database
    $stmt = $con->prepare("SELECT list_ename, event_type, month, department FROM tbl_event WHERE id = ?");
    $stmt->bind_param("i", $id);  // Bind the ID as an integer
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // Proceed to delete the record from the database
        $deleteStmt = $con->prepare("DELETE FROM tbl_event WHERE id = ?");
        $deleteStmt->bind_param("i", $id);  // Bind the ID as an integer
        if ($deleteStmt->execute()) {
            $_SESSION['status'] = "Event record deleted successfully.";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Failed to delete the event record from the database.";
            $_SESSION['status_code'] = "error";
        }
        $deleteStmt->close();
    } else {
        $_SESSION['status'] = "Event record not found.";
        $_SESSION['status_code'] = "error";
    }

    // Redirect back to the view page
    echo "<script>setTimeout(function(){window.location='event_list_view.php'},1000);</script>";
} else {
    $_SESSION['status'] = "Invalid request.";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='event_list_view.php'},1000);</script>";
}
?>
