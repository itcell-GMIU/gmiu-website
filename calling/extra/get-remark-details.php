<?php
include '../../database/connect.php';

// ---------- GET CATEGORY FROM REMARK ----------
if (isset($_POST['remark'])) {

    $remark = trim($_POST['remark']);

    $stmt = $con->prepare("
        SELECT category 
        FROM tbl_inquiry_calling_short_remarks
        WHERE remark = ? AND is_delete = 0
        LIMIT 1
    ");
    $stmt->bind_param("s", $remark);
    $stmt->execute();
    $stmt->bind_result($category);
    $stmt->fetch();
    $stmt->close();

    // Fetch conversations based on category
    $conversations = [];

    if (!empty($category)) {
        $q = $con->prepare("
            SELECT id, conversation
            FROM tbl_inquiry_calling_conversations
            WHERE category = ? AND is_delete = 0
        ");
        $q->bind_param("s", $category);
        $q->execute();
        $res = $q->get_result();

        while ($row = $res->fetch_assoc()) {
            $conversations[] = $row;
        }
        $q->close();
    }

    echo json_encode([
        'status' => true,
        'category' => $category,
        'conversations' => $conversations
    ]);
}
