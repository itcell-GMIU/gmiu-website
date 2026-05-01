<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// GET faculty id from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $staff_id = mysqli_real_escape_string($con, $_GET['id']);
    $staff_id = only_digits($staff_id);
    if ($staff_id == false) {
        $_SESSION['status'] = "Invalid data in URL";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='staff_view.php'},1000)</script>";
    }

    $stmt = $con->prepare("SELECT `image` FROM `tbl_staff` WHERE id = ?");
    $stmt->bind_param("i", $staff_id);
    $result = $stmt->execute();

    if ($result) {
        $stmt->store_result();
        $stmt->bind_result($file_name);
        $stmt->fetch();
        $stmt->free_result();

        $path = "../uploads/profile/";
        if (delete_file($file_name, $path)) {
            $stmt = $con->prepare("UPDATE `tbl_staff` SET is_delete = 1, is_active = 0  WHERE id = ?");
            $stmt->bind_param("i", $staff_id);
            $result = $stmt->execute();

            if ($result) {

                // Delete data from relational table staff qualification
                $stmt = $con->prepare("DELETE FROM `tbl_staff_qualification` WHERE staff_id = ?");
                $stmt->bind_param("i", $staff_id);
                $result1 = $stmt->execute();

                // Delete data from relational table staff experience
                $stmt = $con->prepare("DELETE FROM `tbl_staff_experience` WHERE staff_id = ?");
                $stmt->bind_param("i", $staff_id);
                $result2 = $stmt->execute();

                if ($result1 && $result2) {

                    // Sweet Alert of Success Message
                    $_SESSION['status'] = "Faculty Details Deleted Successfully";
                    $_SESSION['status_code'] = "success";
                    echo "<script>setTimeout(function(){window.location='staff_view.php'},1000);</script>";
                } else {

                    // Sweet Alert of Error Message
                    $_SESSION['status'] = "Faculty Details Deletion Failed";
                    $_SESSION['status_code'] = "error";
                    echo "<script>setTimeout(function(){window.location='staff_view.php'},1000);</script>";
                }
            } else {

                // Sweet Alert of Error Message
                $_SESSION['status'] = "Faculty Details Deletion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='staff_view.php'},1000);</script>";
            }
        }
    } else {
        // Handle the case when the execute() method returns false
        $_SESSION['status'] = "Failed to retrieve faculty details";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='staff_view.php'},1000);</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['organization'])) {
        // Process deletions (if needed)
        $deleteQuery = "DELETE FROM tbl_staff_experience WHERE staff_id = ?";
        $stmt = $con->prepare($deleteQuery);
        $stmt->bind_param("i", $staff_id);
        $stmt->execute();

        // Insert new experience data
        $organizations = $_POST['organization'];
        $roles = $_POST['role'];
        $join_dates = $_POST['join_date'];
        $till_dates = $_POST['till_date'];

        for ($i = 0; $i < count($organizations); $i++) {
            if (!empty($organizations[$i])) {
                $insertQuery = "INSERT INTO tbl_staff_experience (staff_id, organization, role, join_date, till_date) VALUES (?, ?, ?, ?, ?)";
                $stmt = $con->prepare($insertQuery);
                $stmt->bind_param("issss", $staff_id, $organizations[$i], $roles[$i], $join_dates[$i], $till_dates[$i]);
                $stmt->execute();
            }
        }

    }
}
?>
