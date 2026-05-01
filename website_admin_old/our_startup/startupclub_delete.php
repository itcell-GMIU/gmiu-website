<?php
include '../include/checklogin.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the file path from the database
    $stmt = $con->prepare("SELECT pdf_path FROM tbl_startup_club WHERE id = ?");
    $stmt->bind_param("i", $id);  // Bind the ID as an integer
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $filePath = $row['pdf_path'];

        // Delete the file from the server
        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                // Delete the record from the database
                $deleteStmt = $con->prepare("DELETE FROM tbl_startup_club WHERE id = ?");
                $deleteStmt->bind_param("i", $id);  // Bind the ID as an integer
                if ($deleteStmt->execute()) {
                    $_SESSION['status'] = "Record and associated file deleted successfully.";
                    $_SESSION['status_code'] = "success";
                } else {
                    $_SESSION['status'] = "Failed to delete the record from the database.";
                    $_SESSION['status_code'] = "error";
                }
            } else {
                $_SESSION['status'] = "Failed to delete the file.";
                $_SESSION['status_code'] = "error";
            }
        } else {
            $_SESSION['status'] = "File does not exist.";
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status'] = "Record not found.";
        $_SESSION['status_code'] = "error";
    }

    // Redirect back to the view page
    echo "<script>setTimeout(function(){window.location='startupclub_view.php'},1000);</script>";
} else {
    $_SESSION['status'] = "Invalid request.";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='startupclub_view.php'},1000);</script>";
}
?>
