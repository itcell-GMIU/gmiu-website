<?php
// Include the checklogin.php file
include '../include/checklogin.php';

// GET  id from display table
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $id = only_digits($id);
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='publish_hall_ticket.php'},100)</script>";
    }
    // Prepare and execute the SQL statement to delete a record in the tbl_program_outcome
    $stmt = $con->prepare("UPDATE `tbl_exam_form` SET pr_hallticket_status = 1 WHERE id = ? ");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    $cmdexam = $con->prepare("SELECT ef.year as year, ef.type as type,ef.session as session, ef.semester as sem, sn.short_name as short_name
    FROM tbl_exam_form as ef
    LEFT JOIN tbl_short_name as sn ON ef.faculty_id = sn.faculty_id AND ef.level_id = sn.level_id
    WHERE ef.id = ?");
    $cmdexam->bind_param("i", $id);
    $cmdexam->execute();
    $resultexam = $cmdexam->get_result();

    if ($resultexam) {
        $_SESSION['status'] = "Hall Ticket Published";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='publish_hall_ticket.php'},100);</script>";
    } else {
        $_SESSION['status'] = "Hall Ticket Publishing Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='publish_hall_ticket.php'},100);</script>";
    }
}
