<?php
include '../include/checklogin.php';

if (isset($_POST['submit'])) {
    // Fetch data from HTML Form
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
    $sem = mysqli_real_escape_string($con, $_POST['sem']);
    $exam_type = mysqli_real_escape_string($con, $_POST['exam_type']);
    $exam_session = mysqli_real_escape_string($con, $_POST['exam_session']);
    $year = mysqli_real_escape_string($con, $_POST['year']);
    $subject_fee = mysqli_real_escape_string($con, $_POST['subject_fee']);
    $batch = mysqli_real_escape_string($con, $_POST['batch']);
    $start_date = mysqli_real_escape_string($con, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($con, $_POST['end_date']);

    // Validate Data
    $program_id = validate_data($program_id);
    $faculty_id = validate_data($faculty_id);
    $level_id = validate_data($level_id);

    // Get data from the form
    $starting_dates = $_POST['starting_date'];
    $ending_dates = $_POST['ending_date'];
    $late_fee_amounts = $_POST['late_fee_amount'];

    // Combine data into a JSON array
    $late_fee_data = [];
    for ($i = 0; $i < count($starting_dates); $i++) {
        $entry = [
            'starting_date' => $starting_dates[$i],
            'ending_date' => $ending_dates[$i],
            'late_fee_amount' => $late_fee_amounts[$i]
        ];
        $late_fee_data[] = $entry;
    }

    $late_fee_json = json_encode($late_fee_data);

    // Update the tbl_exam_form record
    $exam_id = mysqli_real_escape_string($con, $_POST['exam_id']); // Assuming you have an input for the exam_id
    $stmt = $con->prepare("UPDATE tbl_exam_form SET 
        faculty_id = ?, level_id = ?, program_id = ?, semester = ?, type = ?, 
        session = ?, start_date = ?, end_date = ?, year = ?, subject_fee = ?, 
        batch = ?, late_fee = ? WHERE id = ?");
    $stmt->bind_param("iiiissssiiisi", $faculty_id, $level_id, $program_id, $sem, $exam_type, $exam_session, $start_date, $end_date, $year, $subject_fee, $batch, $late_fee_json, $exam_id);
    $result = $stmt->execute();

    // Error handling if update fails
    if ($result) {
        // If update is successful, redirect
        $_SESSION['status'] = "Exam Form Updated Successfully!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='exam_form_view.php'},1000)</script>";
    } else {
        $_SESSION['status'] = "Exam Form Update Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='exam_form_view.php'},1000)</script>";
    }
}

?>
