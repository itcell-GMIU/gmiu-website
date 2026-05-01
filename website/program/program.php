<?php
include '../../common/importwebsitefile.php';

if (isset($_GET['faculty_id']) && !empty($_GET['faculty_id']) && isset($_GET['program_id']) && !empty($_GET['program_id'])) {
    $faculty_id = intval($_GET['faculty_id']);
    $program_id = intval($_GET['program_id']);

    // Prepare query to get faculty_slug
    $cmd_faculty = $con->prepare("SELECT faculty_slug FROM tbl_faculty WHERE id=? AND is_active=1 AND is_delete=0");
    $cmd_faculty->bind_param("i", $faculty_id);
    $cmd_faculty->execute();
    $result_faculty = $cmd_faculty->get_result();

    // Prepare query to get program_slug
    $cmd_program = $con->prepare("SELECT program_slug FROM tbl_program WHERE id=? AND is_active=1 AND is_delete=0");
    $cmd_program->bind_param("i", $program_id);
    $cmd_program->execute();
    $result_program = $cmd_program->get_result();

    if ($result_faculty->num_rows > 0 && $result_program->num_rows > 0) {
        $row_faculty = $result_faculty->fetch_assoc();
        $row_program = $result_program->fetch_assoc();

        $faculty_slug = $row_faculty['faculty_slug'];
        $program_slug = $row_program['program_slug'];

        // Redirect
        header("Location: https://gmiu.edu.in/gmiu/website/faculty/" . $faculty_slug . '/' . $program_slug, true, 301);
        exit;
    } else {
        header("Location: https://gmiu.edu.in/gmiu/website/", true, 301);
        exit;
    }
} else {
    echo "Missing parameters.";
    exit;
}
?>
