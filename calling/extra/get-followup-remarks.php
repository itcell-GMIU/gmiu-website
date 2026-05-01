<?php
session_start();

include '../../common/globalvariable.php';
include '../../database/connect.php';

header('Content-Type: application/json');

// 1️⃣ Validate request
if (!isset($_POST['tis_id'], $_POST['inq_student_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid parameters'
    ]);
    exit;
}

$tis_id = intval($_POST['tis_id']);
$inq_student_id = trim($_POST['inq_student_id']);

// 2️⃣ Prepare SQL (secure)
$sql = "
    SELECT 
        ticl.id,
        ticl.tis_id,
        ticl.inq_student_id,
        ts.name AS call_by,
        ticl.call_count,
        ticl.call_status,
        ticl.remark AS call_remark,
        ticl.other_remark,
        ticl.created_at
    FROM tbl_inquiry_call_logs AS ticl
    JOIN tbl_staff AS ts ON ts.id = ticl.call_by
    WHERE 
        ticl.tis_id = ?
        AND ticl.inq_student_id = ?
        AND ticl.is_active = 1
        AND ticl.is_delete = 0
    ORDER BY ticl.call_count ASC
";

// 3️⃣ Execute prepared statement
$stmt = $con->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Query preparation failed'
    ]);
    exit;
}

$stmt->bind_param('is', $tis_id, $inq_student_id);
$stmt->execute();

$result = $stmt->get_result();

// 4️⃣ Build response
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        'call_by' => $row['call_by'],
        'call_count' => $row['call_count'],
        'call_status' => $row['call_status'],
        'call_remark' => $row['call_remark'],
        'other_remark' => $row['other_remark'],
        'created_at' => date('d-m-Y H:i', strtotime($row['created_at']))
    ];
}

// 5️⃣ Output JSON
echo json_encode([
    'success' => true,
    'data' => $data
]);

$stmt->close();
$con->close();
