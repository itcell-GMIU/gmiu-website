<?php
header('Content-Type: application/json; charset=utf-8');
include '../include/checklogin.php';

if (!isset($_GET['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing paper id']);
    exit;
}

$paper_id = (int) $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// MUST READ NEW POST FORMAT
if (!isset($_POST['selected']) || !isset($_POST['order'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing sequence data']);
    exit;
}

$selected = $_POST['selected']; // slot => question_id
$order = $_POST['order']; // array of slot keys

if (!is_array($selected) || !is_array($order)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid posted arrays']);
    exit;
}

// Fetch valid questions from database
$sel = $con->prepare("SELECT question_id FROM tbl_paper_question WHERE paper_id = ?");
$sel->bind_param("i", $paper_id);
$sel->execute();
$res = $sel->get_result();

$valid = [];
while ($r = $res->fetch_assoc()) {
    $valid[(int) $r['question_id']] = true;
}
$sel->close();

$con->begin_transaction();

try {

    $seq = 1;

    $stmt = $con->prepare("
UPDATE tbl_paper_question
SET sequence_no = ?
WHERE paper_id = ? AND question_id = ?
");

    foreach ($order as $slot) {

        if (!isset($selected[$slot])) {
            continue;
        }

        $qid = (int) $selected[$slot];

        if (!isset($valid[$qid])) {
            continue;
        }

        $stmt->bind_param("iii", $seq, $paper_id, $qid);
        $stmt->execute();

        $seq++;
    }

    $con->commit();

    echo json_encode(['status' => 'ok', 'message' => 'Sequence updated successfully']);
    exit;

} catch (Exception $e) {

    $con->rollback();

    echo json_encode([
        'status' => 'error',
        'message' => 'Update failed: ' . $e->getMessage()
    ]);
    exit;
}

?>