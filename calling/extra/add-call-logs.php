<?php
session_start();

include '../../common/globalvariable.php';
include '../../database/connect.php';
// include '../../common/function.php';
// include '../../common/validation.php';

header('Content-Type: application/json');

$response = ["status" => "error", "message" => "Invalid request"];

if (isset($_POST['callForm']) && ($_SESSION['role_id'] == 15 || $_SESSION['role_id'] == 16)) {

    $tis_id = $_POST['tis_id'] ?? '';
    $inq_student_id = $_POST['inq_student_id'] ?? '';
    $call_status = $_POST['call_status'] ?? '';
    $remark = $_POST['remark'] ?? '';
    $conversation = $_POST['conversation'] ?? '';
    $other_remark = $_POST['other_remark'] ?? '';
    $staff_id = $_SESSION['staff_id'] ?? '';

    // ✅ Validation
    if ($tis_id == '' || $inq_student_id == '' || $call_status == '' || $remark == '') {
        echo json_encode(["status" => "error", "message" => "All fields are required"]);
        exit;
    }

    // -------------------------
    // CHECK CALL COUNT
    // -------------------------
    $checkSql = "SELECT 
        (SELECT COUNT(*) FROM tbl_inquiry_call_logs 
         WHERE inq_student_id = ? AND is_active = 1 AND is_delete = 0) AS total_calls,

        (SELECT call_count FROM tbl_inquiry_student 
         WHERE inq_student_id = ? AND is_active = 1 AND is_delete = 0 LIMIT 1) AS max_call_count";

    $stmt = $con->prepare($checkSql);
    $stmt->bind_param("ss", $inq_student_id, $inq_student_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    $currentCount = intval($result['total_calls']);
    $max_call_count = intval($result['max_call_count']);

    if ($currentCount >= $max_call_count) {
        echo json_encode([
            "status" => "error",
            "message" => "Call limit reached ($max_call_count)"
        ]);
        exit;
    }

    // -------------------------
    // INSERT CALL LOG
    // -------------------------
    $call_count = $currentCount + 1;

    $insertSql = "INSERT INTO tbl_inquiry_call_logs 
        (tis_id, inq_student_id, call_status, remark, conversation, call_by, call_count, other_remark)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt2 = $con->prepare($insertSql);
    $stmt2->bind_param("issssiis", $tis_id, $inq_student_id, $call_status, $remark, $conversation, $staff_id, $call_count, $other_remark);

    if ($stmt2->execute()) {

        // -------------------------
        // IF CLOSE → UPDATE STATUS
        // -------------------------
        if ($call_status === 'CLOSE') {

            $updateSql = "UPDATE tbl_inquiry_student
                          SET closed_by = ?, is_closed = 1
                          WHERE id = ? AND inq_student_id = ?";

            $stmt3 = $con->prepare($updateSql);
            $stmt3->bind_param("iis", $staff_id, $tis_id, $inq_student_id);

            if ($stmt3->execute()) {

                $totalRemark = $remark . (!empty($other_remark) ? " - " . $other_remark : "");

                $sql_i9 = "INSERT INTO tbl_inquiry_logs 
                           (inq_student_id, action, staff_id, remark) 
                           VALUES (?, 'close', ?, ?)";

                $stmt_q2 = $con->prepare($sql_i9);
                $stmt_q2->bind_param("sis", $inq_student_id, $staff_id, $totalRemark);
                $stmt_q2->execute();

                echo json_encode([
                    "status" => "success",
                    "message" => "Call log added & Inquiry Closed"
                ]);
                exit;
            }
        }

        echo json_encode([
            "status" => "success",
            "message" => "Call log added successfully"
        ]);
        exit;

    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Error while inserting call log"
        ]);
        exit;
    }
}

echo json_encode($response);