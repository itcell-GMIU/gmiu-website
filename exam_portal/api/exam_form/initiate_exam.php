<?php
include '../../../database/connect.php';
include '../../../common/validation.php';
include '../../../common/globalvariable.php';
include '../inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);


    if (isset($data['erNo']) && isset($data['exam_id']) && isset($data['txn_id']) && isset($data['amount'])) {

        $txn_id = $data['txn_id'];
        $exam_id = $data['exam_id'];
        $erNo = $data['erNo'];
        $amount = $data['amount'];

        $is_active = 1;

        $stmt = $con->prepare("UPDATE `tbl_exam_student` SET `fee_amount` = ?, `transaction_id` = ? WHERE `exam_id` =? AND `enrollnment_no` = ?");
        $stmt->bind_param("isis", $amount, $txn_id, $exam_id, $erNo);
        $result1 = $stmt->execute();
        // $cmdFees->execute();

        if ($result1) {
            // Insertion successful
            $status_updation = 1;
        } else {
            // Insertion failed
            $status_updation = 0;
        }

        $response = array(
            'is_updated' => $status_updation
        );
        // Set response headers to JSON
        header('Content-Type: application/json');

        // Output the response as JSON
        echo json_encode($response, JSON_PRETTY_PRINT);
    } else {
        echo "Invalid";
    }
}
