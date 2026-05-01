<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../include/checklogin.php';
include '../include/connection.php';

$role_id = $_SESSION['role_id'] ?? 0;

$request = $_REQUEST;

$columns = [
    0 => 'que.id',
    1 => 'corner.sem',
    2 => 'corner.subject_code',
    3 => 'corner.subject_name',
    4 => 'que.chapter',
    5 => 'que.question',
    6 => 'que.marks',
    7 => 'que.co_level',
    8 => 'que.bl_level'
];

$search_value = $request['search']['value'];
$start = $request['start'];
$length = $request['length'];
$order_column = $columns[$request['order'][0]['column']];
$order_dir = $request['order'][0]['dir'];

// Total records
$sql_total = "SELECT COUNT(*) AS total FROM tbl_questions WHERE is_delete = 0";
$result_total = $con->query($sql_total);
$totalData = $result_total->fetch_assoc()['total'];

// Build base query
$sql = "SELECT 
            que.id, que.chapter, que.question, que.marks, que.bl_level, que.co_level,
            corner.sem, corner.subject_code AS subject_code_real, corner.subject_name
        FROM tbl_questions AS que
        LEFT JOIN tbl_std_corner_exam AS corner ON que.subject_code = corner.id
        WHERE que.is_delete = 0";

// Filter
if (!empty($search_value)) {
    $sql .= " AND (
        corner.sem LIKE '%$search_value%' OR
        corner.subject_code LIKE '%$search_value%' OR
        corner.subject_name LIKE '%$search_value%' OR
        que.chapter LIKE '%$search_value%' OR
        que.question LIKE '%$search_value%' OR
        que.marks LIKE '%$search_value%' OR
        que.co_level LIKE '%$search_value%' OR
        que.bl_level LIKE '%$search_value%'
    )";
}

// Filtered count
$sql_count = "SELECT COUNT(*) AS filtered FROM tbl_questions AS que
LEFT JOIN tbl_std_corner_exam AS corner ON que.subject_code = corner.id
WHERE que.is_delete = 0";

if (!empty($search_value)) {
    $sql_count .= " AND (
        corner.sem LIKE '%$search_value%' OR
        corner.subject_code LIKE '%$search_value%' OR
        corner.subject_name LIKE '%$search_value%' OR
        que.chapter LIKE '%$search_value%' OR
        que.question LIKE '%$search_value%' OR
        que.marks LIKE '%$search_value%' OR
        que.co_level LIKE '%$search_value%' OR
        que.bl_level LIKE '%$search_value%'
    )";
}

$filtered_result = $con->query($sql_count);
$totalFiltered = $filtered_result->fetch_assoc()['filtered'];

// Add order & pagination
$sql .= " ORDER BY $order_column $order_dir LIMIT $start, $length";

$data = [];
$result = $con->query($sql);

while ($row = $result->fetch_assoc()) {
    $nested = [];

    $nested[] = $row['id'];
    $nested[] = $row['sem'] ?: 'N/A';
    $nested[] = $row['subject_code_real'] ?: 'N/A';
    $nested[] = $row['subject_name'] ?: 'N/A';
    $nested[] = $row['chapter'] ?: 'N/A';
    $nested[] = htmlspecialchars($row['question']);
    $nested[] = $row['marks'];
    $nested[] = $row['co_level'];
    $nested[] = $row['bl_level'];

    if (in_array($role_id, [8, 51, 54])) {
        $nested[] = '
            <a href="edit_question.php?id=' . $row['id'] . '" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
            <a href="delete_question.php?id=' . $row['id'] . '" class="btn btn-danger"><i class="fas fa-trash"></i></a>
        ';
    }

    $data[] = $nested;
}

$response = [
    "draw" => intval($request['draw']),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);
