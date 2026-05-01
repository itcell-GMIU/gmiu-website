<?php
include '../include/config.php';

$pan = isset($_GET['pan']) ? $_GET['pan'] : '';

if (!empty($pan)) {
    // Get the most recent record for this PAN
    $sql = "SELECT * FROM tbl_tada_form_data WHERE pan_card = ? ORDER BY id DESC LIMIT 1";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $pan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'not_found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'PAN is required']);
}
?>
