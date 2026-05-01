<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);


include 'include/checklogin.php';


if (isset($_GET['new_program_id'], $_GET['pac_id'])) {
    $newProgramId = intval($_GET['new_program_id']);
    $pacId = intval($_GET['pac_id']);

    // 1. Get token_fee from tbl_admission_student
    $query = "SELECT token_amount FROM tbl_admission_student WHERE id = $pacId LIMIT 1";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $tokenFee = floatval($row['token_amount']);
    } else {
        $tokenFee = 0;
    }

    // 2. Get sem1_fee and sem3_fee from tbl_program
    $query = "SELECT sem1, sem3 FROM tbl_program WHERE id = $newProgramId LIMIT 1";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $sem1Fee = floatval($row['sem1']);
        $sem3Fee = floatval($row['sem3']);
    } else {
        echo json_encode(['remaining_fee' => 0, 'error' => 'Program not found']);
        mysqli_close($con);
        exit;
    }

    // 3. Choose sem1_fee if available else sem3_fee
    $programFee = ($sem1Fee > 0) ? $sem1Fee : (($sem3Fee > 0) ? $sem3Fee : 0);

    // 4. Calculate remaining fee
    $remainingFee = max(0, $programFee - $tokenFee);

    echo json_encode(['remaining_fee' => $remainingFee]);
} else {
    echo json_encode(['error' => 'Missing parameters']);
}

mysqli_close($con);
exit;
