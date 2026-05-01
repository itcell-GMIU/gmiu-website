<?php
include '../include/checklogin.php';

// Check if the "select all pages" flag is set to '1'
if (isset($_POST['select_all_pages']) && $_POST['select_all_pages'] == '1') {

    // The user wants to archive EVERYTHING.
    // The query updates all posts that are not already marked as deleted.
    $sql = "UPDATE `tbl_post` SET is_active = 0, is_delete = 1 WHERE is_delete = 0";
    $stmt = $con->prepare($sql);

    if ($stmt->execute()) {
        $_SESSION['status'] = "All posts have been successfully archived.";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Failed to archive all posts.";
        $_SESSION['status_code'] = "error";
    }

} elseif (isset($_POST['selected_ids']) && !empty($_POST['selected_ids'])) {

    // This is the original logic for handling specific IDs from the current page
    $ids_to_update = $_POST['selected_ids'];
    $all_updated_successfully = true;

    $stmt = $con->prepare("UPDATE `tbl_post` SET is_active = 0, is_delete = 1 WHERE id = ?");

    foreach ($ids_to_update as $id) {
        $id = (int) $id;
        if ($id > 0) {
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                $all_updated_successfully = false;
            }
        }
    }
    $stmt->close();

    if ($all_updated_successfully) {
        $_SESSION['status'] = "Selected posts have been successfully archived.";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Some posts could not be archived.";
        $_SESSION['status_code'] = "error";
    }

} else {
    // This runs if no checkboxes were selected
    $_SESSION['status'] = "No posts were selected.";
    $_SESSION['status_code'] = "warning";
}

// Redirect back to the view page
header("Location: post_view.php");
exit;
?>