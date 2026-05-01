<?php
session_start();

include '../../common/globalvariable.php';
include '../../database/connect.php';
// include '../../common/function.php';
// include '../../common/validation.php';

header('Content-Type: application/json');

$inquiry_type = isset($_POST['inquiry_type']) ? $_POST['inquiry_type'] : '';
$starting_inquiry = isset($_POST['starting_inquiry']) ? $_POST['starting_inquiry'] : '';
$ending_id = isset($_POST['ending_id']) ? $_POST['ending_id'] : '';
$staff_id = isset($_POST['staff_id']) ? $_POST['staff_id'] : '';
$assign_by = isset($_SESSION['staff_id']) ? $_SESSION['staff_id'] : 0;
$sentotp = isset($_POST['sentotp']) ? $_POST['sentotp'] : '';
$last_exam = isset($_POST['completed_study']) ? $_POST['completed_study'] : '';
$ip_address = $_SERVER['REMOTE_ADDR'];



// OTP check (placeholder logic)
if ($sentotp != $_SESSION['otp']) {
    echo json_encode([
        "status" => "wrongotp",
        "message" => "Wrong OTP"
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Use existing variable: $unique
|--------------------------------------------------------------------------
*/
$unique = [
    "%-$starting_inquiry",
    "%-$ending_id"
];

$sql = "
    SELECT COUNT(id) AS total
    FROM tbl_inquiry_student
    WHERE 
        inq_student_id IN (
            SELECT inq_student_id
            FROM tbl_inquiry_student
            WHERE inq_student_id LIKE ? OR inq_student_id LIKE ?
        )
        AND is_online = ?
        AND last_exam = ?
";

$stmt = $con->prepare($sql);
$stmt->bind_param(
    "ssis",
    $unique[0],
    $unique[1],
    $inquiry_type,
    $last_exam
);

$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

/*
|--------------------------------------------------------------------------
| If both IDs are not present → FAIL
|--------------------------------------------------------------------------
*/
if ((int) $data['total'] < 2) {
    echo json_encode([
        "status" => "idnotexist",
        "message" => "your starting id or the ending id is not present"
    ]);
    exit;
}


// Step 1: Check for already assigned inquiries
$checkQuery = "
SELECT inq_student_id 
FROM tbl_inquiry_student 
WHERE id BETWEEN 
  (SELECT id FROM tbl_inquiry_student WHERE inq_student_id LIKE '%-$starting_inquiry' AND is_online = ? AND last_exam = ? LIMIT 1)
  AND
  (SELECT id FROM tbl_inquiry_student WHERE inq_student_id LIKE '%-$ending_id' AND is_online = ? AND last_exam = ? LIMIT 1)
  AND is_online = ?
  AND last_exam = ?
  AND (staff_id IS NOT NULL AND staff_id != '')
";

$stmtCheck = $con->prepare($checkQuery);
$stmtCheck->bind_param("iiiiii", $inquiry_type, $last_exam, $inquiry_type, $last_exam, $inquiry_type, $last_exam);
$stmtCheck->execute();
$result = $stmtCheck->get_result();

if ($result && $result->num_rows > 0) {
    $assigned_ids = [];
    while ($row = $result->fetch_assoc()) {
        $assigned_ids[] = $row['inq_student_id'];
    }
    echo json_encode([
        "status" => "exists",
        "assigned_ids" => $assigned_ids
    ]);
    exit;
}

// Step 2: Assign if no conflicts found
$updateQuery = "
UPDATE tbl_inquiry_student 
SET staff_id = ?, assign_by = ?, ip_address_column = ?
WHERE id BETWEEN 
  (SELECT id FROM tbl_inquiry_student WHERE inq_student_id LIKE '%-$starting_inquiry' AND is_online = ? AND last_exam = ? LIMIT 1)
  AND
  (SELECT id FROM tbl_inquiry_student WHERE inq_student_id LIKE '%-$ending_id' AND is_online = ? AND last_exam = ? LIMIT 1)
  AND is_online = ?
  AND last_exam = ?
  AND (staff_id IS NULL OR staff_id = '')
";

$stmt = $con->prepare($updateQuery);
$stmt->bind_param("iisiiiiii", $staff_id, $assign_by, $ip_address, $inquiry_type, $last_exam, $inquiry_type, $last_exam, $inquiry_type, $last_exam);

if ($stmt->execute()) {

    // Step 3: Get the exact updated inquiry IDs
    $selectUpdated = "
    SELECT inq_student_id 
    FROM tbl_inquiry_student 
    WHERE staff_id = ? 
      AND assign_by = ?
      AND id BETWEEN 
          (SELECT id FROM tbl_inquiry_student WHERE inq_student_id LIKE '%-$starting_inquiry' AND is_online = ? AND last_exam = ? LIMIT 1)
          AND
          (SELECT id FROM tbl_inquiry_student WHERE inq_student_id LIKE '%-$ending_id' AND is_online = ? AND last_exam = ? LIMIT 1)
          AND is_online = ?
          AND last_exam = ?
    ";

    $stmtSelect = $con->prepare($selectUpdated);
    $stmtSelect->bind_param("iiiiiiii", $staff_id, $assign_by, $inquiry_type, $last_exam, $inquiry_type, $last_exam, $inquiry_type, $last_exam);
    $stmtSelect->execute();
    $res = $stmtSelect->get_result();

    $updated_ids = [];
    while ($row = $res->fetch_assoc()) {
        $updated_ids[] = $row['inq_student_id'];
    }

    $total = count($updated_ids);

    // Step 4: Insert into main log table
    if ($total === 1) {
        $first_id = $updated_ids[0];
        $end_id = NULL;
    } else {
        $first_id = $updated_ids[0];
        $end_id = end($updated_ids);
    }

    $logQuery = $con->prepare("
        INSERT INTO tbl_inquiry_assign_log 
        (assign_by, staff_id, starting_id, ending_id, total, created_at)
        VALUES (?, ?, ?, ?, ?, NOW())
    ");
    $logQuery->bind_param("iissi", $assign_by, $staff_id, $first_id, $end_id, $total);
    $logQuery->execute();
    $log_id = $con->insert_id;

    // Step 5: Insert into pivot table ONLY if total > 1
    if ($total > 1) {
        $pivotQuery = $con->prepare("
            INSERT INTO tbl_inquiry_assign_log_pivot (log_id, inq_student_id, created_at)
            VALUES (?, ?, NOW())
        ");
        foreach ($updated_ids as $inq_id) {
            $pivotQuery->bind_param("is", $log_id, $inq_id);
            $pivotQuery->execute();
        }
    }

    echo json_encode(["status" => "success"]);

} else {
    echo json_encode([
        "status" => "error",
        "message" => $stmt->error
    ]);
}
?>