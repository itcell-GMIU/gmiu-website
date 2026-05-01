<?php
include '../../database/connect.php';
include '../../common/validation.php';
include '../../common/globalvariable.php';
include './inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);


    if (isset($data['type']) && isset($data['erNo']) && isset($data['exam_id']) && isset($data['txn_id']) && isset($data['payment_response'])) {

        $txn_id = $data['txn_id'];
        $exam_id = $data['exam_id'];
        $erNo = $data['erNo'];
        $type = $data['type'];
        $payment_response = $data['payment_response'];
        $payment_responseJSON = json_encode($data['payment_response'], JSON_PRETTY_PRINT);

        $payment_id = $payment_response['easepayid'];
        $payment_status = $payment_response['status'];
        $mode = $payment_response['mode'];
        $addedon = $payment_response['addedon'];

        $is_active = 1;

        if ($payment_status == "success") {
            $status = 1;
        } else {
            $cmdDLT = $con->prepare("UPDATE tbl_exam_reassement SET is_active = 0, is_delete = 1 WHERE enrollnment_no = ? AND exam_id = ? AND transaction_id = ?");
            $cmdDLT->bind_param("sss", $erNo, $exam_id, $txn_id);
            $cmdDLT->execute();

            $status = 0;
        }

        if ($type == "reassesment_fees" && $payment_status == "success") {
            $assesment_type = 2;
        } elseif ($type == "recheck_fees" && $payment_status == "success") {
            $assesment_type = 1;
        } else {
            $assesment_type = 0;
        }

        $is_active = 1;
        $cmdSUB = $con->prepare("SELECT subject_code FROM tbl_exam_reassement WHERE enrollnment_no = ? AND exam_id = ? AND transaction_id = ?");
        $cmdSUB->bind_param("sss", $erNo, $exam_id, $txn_id);
        $cmdSUB->execute();
        $resultexamSUB = $cmdSUB->get_result();

        while ($exmSUB = $resultexamSUB->fetch_assoc()) {
            $subject_code = $exmSUB['subject_code'];
        }

        $cmdUPDATE = $con->prepare("UPDATE tbl_final_exam_results SET is_reassesment = ? WHERE enrollnment_no = ? AND exam_id = ? AND FIND_IN_SET(subject_code, ?);");
        $cmdUPDATE->bind_param("ssss", $assesment_type, $erNo, $exam_id, $subject_code);

        $cmdFees = $con->prepare("UPDATE tbl_exam_reassement SET status = ?, payment_mode = ?, payment_id = ?, payment_status = ?, payment_response = ?, payment_date = ? WHERE enrollnment_no = ? AND exam_id = ? AND transaction_id = ?");
        $cmdFees->bind_param("sssssssss", $status, $mode, $payment_id, $payment_status, $payment_responseJSON, $addedon, $erNo, $exam_id, $txn_id);
        // $cmdFees->execute();

        if ($cmdFees->execute() && $cmdUPDATE->execute()) {
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
