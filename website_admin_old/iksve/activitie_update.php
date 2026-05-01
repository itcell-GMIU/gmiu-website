<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files
include '../include/checklogin.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $id = isset($_POST['id']) ? only_digits($_POST['id']) : false;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $type = isset($_POST['type']) ? trim($_POST['type']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $participants = isset($_POST['participants']) ? trim($_POST['participants']) : '';
    $date = isset($_POST['date']) ? trim($_POST['date']) : '';

    // Validate required fields
    // if (!$id || empty($name) || empty($type) || empty($description) || empty($participants) || empty($date)) {
    //     $_SESSION['status'] = "All fields are required.";
    //     $_SESSION['status_code'] = "error";
    //     header("Location: activitie_view.php");
    //     exit();
    // }

    // Update activity details
    $stmt = $con->prepare("UPDATE tbl_iksve_cell SET name = ?, type_id = ?, description = ?, participants = ?, date = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $name, $type, $description, $participants, $date, $id);
    $updateResult = $stmt->execute();

    if ($updateResult) {
        // Handle report upload
        if (isset($_FILES['report_upload']) && $_FILES['report_upload']['error'] === 0) {
            $targetDirectory = "../uploads/iksve_cell/";
            $fileUploadStatus = upload_single_file($_FILES['report_upload'], $targetDirectory, 0);

            if ($fileUploadStatus['status'] === 200) {
                $fileName = $fileUploadStatus['message'];
                $reportStmt = $con->prepare("UPDATE tbl_iksve_cell SET report = ? WHERE id = ?");
                $reportStmt->bind_param("si", $fileName, $id);
                if (!$reportStmt->execute()) {
                    $_SESSION['status'] = "Failed to update report: " . $reportStmt->error;
                    $_SESSION['status_code'] = "error";
                    header("Location: activitie_view.php");
                    exit();
                }
            } else {
                $_SESSION['status'] = $fileUploadStatus['message'];
                $_SESSION['status_code'] = "error";
                header("Location: activitie_view.php");
                exit();
            }
        }

        // Handle multiple image uploads
        if (isset($_FILES['image_upload']) && isset($_FILES['image_upload']['error'][0]) && $_FILES['image_upload']['error'][0] === 0) {
            // Delete existing images
            $deleteStmt = $con->prepare("DELETE FROM tbl_iksve_cell_images WHERE iksve_cell_id = ?");
            $deleteStmt->bind_param("i", $id);
            $deleteStmt->execute();

            $target_directory = "../uploads/iksve_cell/";

            // Upload new images
            $uploadedImages = upload_multiple_files($_FILES['image_upload'], $target_directory, 1);

            if ($uploadedImages['status'] === 200) {
                foreach ($uploadedImages['message'] as $image) {
                    $image_name = $image['name'];
                    $imageStmt = $con->prepare("INSERT INTO tbl_iksve_cell_images (iksve_cell_id, image) VALUES (?, ?)");
                    $imageStmt->bind_param("is", $id, $image_name);
                    if (!$imageStmt->execute()) {
                        $_SESSION['status'] = "Failed to save image: " . $imageStmt->error;
                        $_SESSION['status_code'] = "error";
                        header("Location: activitie_view.php");
                        exit();
                    }
                }
            } else {
                $_SESSION['status'] = $uploadedImages['message'];
                $_SESSION['status_code'] = "error";
                header("Location: activitie_view.php");
                exit();
            }
        }

        $_SESSION['status'] = "Activity updated successfully.";
        $_SESSION['status_code'] = "success";
        header("Location: activitie_view.php");
    } else {
        $_SESSION['status'] = "Failed to update activity: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        header("Location: activitie_view.php");
    }
} else {
    $_SESSION['status'] = "Invalid request method.";
    $_SESSION['status_code'] = "error";
    header("Location: activitie_view.php");
}

?>
