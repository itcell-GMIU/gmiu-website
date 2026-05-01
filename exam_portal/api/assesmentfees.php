<?php
include '../../database/connect.php';
include '../../common/validation.php';
include '../../common/globalvariable.php';
include './inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['subject_code']) && isset($data['type']) && isset($data['erNo']) && isset($data['exam_id']) && isset($data['txn_id'])) {

        $txn_id = $data['txn_id'];
        $exam_id = $data['exam_id'];
        $erNo = $data['erNo'];
        $type = $data['type'];
        $subject_codes = $data['subject_code'];

        if ($type == "reassesment_fees") {
            $assesment_type = 2;
        }elseif ($type == "recheck_fees") {
            $assesment_type = 1;
        }

        $is_active = 1;
        $cmdFees = $con->prepare("SELECT * FROM tbl_exam_fees_settings WHERE is_active = ? AND type = ?");
        $cmdFees->bind_param("is", $is_active, $type);
        $cmdFees->execute();
        $resultexamFees = $cmdFees->get_result();

        while ($exmFees = $resultexamFees->fetch_assoc()) {
            $assesment_fees = $exmFees['fees'];
        }

        $count = count($subject_codes);
        $finalFees = $count * $assesment_fees;

        $subjectcodes = implode(',', $subject_codes);

        $cmd22 = $con->prepare("SELECT ts.first_name as first_name, ts.middle_name as middle_name, ts.last_name as last_name, tes.seat_no as seat_no, tes.enrollnment_no as enrollnment_no,  tes.exam_sgpa as exam_sgpa, tes.exam_cgpa as exam_cgpa, tes.total_credit as total_credit, tes.total_credit_point as total_credit_point, tes.is_pass as is_pass, tes.total_backlog as backlog FROM tbl_students_2023 as ts LEFT JOIN tbl_exam_student as tes ON ts.enrollnment_no = tes.enrollnment_no WHERE tes.enrollnment_no = ? AND tes.exam_id = ? AND tes.is_active = ? AND tes.status = 3");
        $cmd22->bind_param("sii", $erNo, $exam_id, $is_active);
        $cmd22->execute();
        $result22 = $cmd22->get_result();

        if ($result22->num_rows == 0) {
            $response = array(
                'status' => 'No Data Found!'
            );
            http_response_code(404);
        } else {
            $row22 = $result22->fetch_assoc();
            $std_name = ucwords(strtolower($row22["first_name"])) . ' ' . ucwords(strtolower($row22["middle_name"])) . ' ' . ucwords(strtolower($row22["last_name"]));
            $ernumber = $row22['enrollnment_no'];
            $seat = $row22['seat_no'];
            $total_credit = $row22['total_credit'];
            $total_credit_point = $row22['total_credit_point'];
            $exam_sgpa = $row22['exam_sgpa'];
            $exam_cgpa = $row22['exam_cgpa'];
            $backlog = $row22['backlog'];
            $is_pass = $row22['is_pass'];
            $rsStatus = $row22['is_pass'];
        }

        $cmdFees = $con->prepare("INSERT INTO tbl_exam_reassement (`enrollnment_no`, `exam_id`, `seat_no`, `subject_code`, `assesment_type`, `exam_sgpa`, `exam_cgpa`, `total_credit`, `total_credit_point`, `is_pass`, `total_backlog`,`fee_amount`, `transaction_id`,`exam_status`)  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $cmdFees->bind_param("ssssssssssssss", $erNo, $exam_id, $seat, $subjectcodes, $assesment_type, $exam_sgpa, $exam_cgpa, $total_credit, $total_credit_point, $is_pass, $backlog, $finalFees, $txn_id, $rsStatus);
        // $cmdFees->execute();

        if ($cmdFees->execute()) {
            // Insertion successful
            $status_insert = 1;
        } else {
            // Insertion failed
            $status_insert = 0;
        }

        $response = array(
            'number_of_subject' => $count,
            'assesment_fees_amount' => $finalFees,
            'is_inserted' => $status_insert
        );
        // Set response headers to JSON
        header('Content-Type: application/json');

        // Output the response as JSON
        echo json_encode($response, JSON_PRETTY_PRINT);
    } else {
        echo "Invalid";
    }
}
