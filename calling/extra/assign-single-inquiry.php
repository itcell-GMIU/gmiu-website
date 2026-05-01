<?php
session_start();

include '../../common/globalvariable.php';
include '../../database/connect.php';
// include '../../common/function.php';
// include '../../common/validation.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inquiry_id'], $_POST['staff_id'])) {

    $inquiry_id = $_POST['inquiry_id'];
    $staff_id = $_POST['staff_id'];
    $assign_by = isset($_SESSION['staff_id']) ? $_SESSION['staff_id'] : 0;
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // ✅ Step 1: Check if the inquiry ID exists
    $check = $con->prepare("SELECT staff_id FROM tbl_inquiry_student WHERE inq_student_id = ?");
    $check->bind_param("s", $inquiry_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows === 0) {
        echo json_encode([
            'status' => 'notfound',
            'message' => 'Inquiry ID does not exist in the database.'
        ]);
        exit;
    }

    $row = $result->fetch_assoc();

    // ✅ Step 2: Check if already assigned
    if (!empty($row['staff_id'])) {
        echo json_encode([
            'status' => 'exists',
            'message' => 'This inquiry is already assigned to a staff.'
        ]);
        exit;
    }

    // ✅ Step 3: Assign staff + log changes
    $con->begin_transaction();

    try {
        // Update assignment
        $stmt = $con->prepare("UPDATE tbl_inquiry_student SET staff_id = ?, assign_by = ?, ip_address_column = ? WHERE inq_student_id = ?");
        $stmt->bind_param("iiss", $staff_id, $assign_by, $ip_address, $inquiry_id);

        if (!$stmt->execute()) {
            throw new Exception('Failed to assign inquiry: ' . $stmt->error);
        }

        // Insert into log (only starting_id filled)
        $log_stmt = $con->prepare("INSERT INTO tbl_inquiry_assign_log 
                                        (assign_by, staff_id, starting_id, total, created_at)
                                        VALUES (?, ?, ?, ?, NOW())");
        $total = 1;
        $log_stmt->bind_param("iisi", $assign_by, $staff_id, $inquiry_id, $total);

        if (!$log_stmt->execute()) {
            throw new Exception('Failed to insert log: ' . $log_stmt->error);
        }

        // Commit changes
        $con->commit();

        echo json_encode([
            'status' => 'success',
            'message' => 'Staff assigned successfully and log recorded.'
        ]);
    } catch (Exception $e) {
        $con->rollback();
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
    exit;
}
?>