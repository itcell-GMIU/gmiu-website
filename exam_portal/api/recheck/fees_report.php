<?php
include '../../../database/connect.php';
include '../../../common/validation.php';
include '../../../common/globalvariable.php';
include '../inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['from_date']) && isset($data['to_date'])) {

        $from_date = $data['from_date'];
        $to_date = $data['to_date'];

        $pay_data = [];
        $total_amount = 0;
        $cmd33 = "SELECT * FROM tbl_exam_reassement WHERE is_active= 1 AND status = 1 AND DATE(payment_date) BETWEEN DATE('$from_date') AND DATE('$to_date')";
        $stmt33 = $con->prepare($cmd33);
        $stmt33->execute();
        $result33 = $stmt33->get_result();
        if ($result33->num_rows > 0) {
            while ($row33 = $result33->fetch_assoc()) {
                $pay_data[] = [
                    'subject_code' => $row33['subject_code'],
                    'assesment_type' => $row33['assesment_type'],
                    'enrollnment_no' => $row33['enrollnment_no'],
                    'transaction_id' => $row33['transaction_id'],
                    'payment_id' => $row33['payment_id'],
                    'payment_status' => $row33['payment_status'],
                    'fee_amount' => $row33['fee_amount'],
                    'seat_no' => $row33['seat_no'],
                    'pay_date' => $row33['payment_date'],
                ];
                $total_amount += $row33['fee_amount'];
            }
        }
        // Check if any rows are returned
        if ($result33) {

            $response = array(
                'payment_data' => $pay_data,
                'total_amount' => $total_amount
            );

            // Return exam details as JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            // No exams found
            http_response_code(404);
            echo json_encode(["error" => "No Data Found"]); // Response content in uppercase
        }
    }
}
