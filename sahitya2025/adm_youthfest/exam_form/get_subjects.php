<?php
include '../include/checklogin.php';

if (isset($_POST['faculty_id']) && isset($_POST['level_id']) && isset($_POST['program_id']) && isset($_POST['sem'])) {
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
    $sem = mysqli_real_escape_string($con, $_POST['sem']);

    // Query the database to retrieve subject code and subject name based on the selected criteria
    $stmt = $con->prepare("SELECT subject_code, subject_name FROM tbl_std_corner WHERE faculty_id = ? AND level_id = ? AND program_id = ? AND sem = ?");
    $stmt->bind_param("iiii", $faculty_id, $level_id, $program_id, $sem);
    $stmt->execute();
    $result = $stmt->get_result();

    $subjects = array();
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }

    echo json_encode($subjects);
} else {
    echo json_encode([]);
}
?>
