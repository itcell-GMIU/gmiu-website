<?php
include '../../database/connect.php';
include '../../common/validation.php';
include '../../common/globalvariable.php';
include './inc.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['exam_id']) && isset($data['erNo'])) {
        $exam_id = $data['exam_id'];
        $enrollnment_no = $data['erNo'];

        $is_approved = 1;
        
        $one = 1;
        $zero = 0;

        $cmdDLT = $con->prepare("DELETE FROM tbl_exam_reassement WHERE is_active = ? AND status = ? AND enrollnment_no = ? AND exam_id = ?");
        $cmdDLT->bind_param("ssss",  $one, $zero,$enrollnment_no, $exam_id);
        $cmdDLT->execute();

        $cmdFees = $con->prepare("SELECT * FROM tbl_exam_fees_settings WHERE is_active = ?");
        $cmdFees->bind_param("i", $is_approved);
        $cmdFees->execute();
        $resultexamFees = $cmdFees->get_result();

        while ($exmFees = $resultexamFees->fetch_assoc()) {
            if ($exmFees['type'] == "reassesment_fees") {
                $reassesment_fees = $exmFees['fees'];
            } elseif ($exmFees['type'] == "recheck_fees") {
                $recheck_fees = $exmFees['fees'];
            }
        }

        $cmdSUB = $con->prepare("SELECT * FROM tbl_final_exam_results WHERE enrollnment_no = ? AND exam_id = ? AND is_approved = ?  AND is_reassesment = 0");
        $cmdSUB->bind_param("ssi", $enrollnment_no, $exam_id, $is_approved);
        $cmdSUB->execute();
        $resultexamSUB = $cmdSUB->get_result();

        $exam_results = array(); // Initialize array to store exam results

        while ($exmSUB = $resultexamSUB->fetch_assoc()) {
            $cmdSUBFetch = $con->prepare("SELECT subject_name, credit FROM tbl_subject_master WHERE subject_code = ?");
            $cmdSUBFetch->bind_param("s", $exmSUB['subject_code']);
            $cmdSUBFetch->execute();
            $resultexamSUBFetch = $cmdSUBFetch->get_result();
            $exmSUBFetch = $resultexamSUBFetch->fetch_assoc();
            $subject_name = $exmSUBFetch['subject_name'];

            // Add each row of data to the exam_results array
            $exam_results[] = array(
                'subject_code' => strtoupper($exmSUB['subject_code']),
                'subject_name' => strtoupper($subject_name),
                'gradeFINAL' => strtoupper($exmSUB['gradeFINAL'] ?? '-'),
            );
        }

        $reassesment_status = 0;
        $recheck_status = 0;

        $cmdASSESSMENT = $con->prepare("SELECT assesment_type FROM `tbl_exam_reassement` WHERE enrollnment_no = ? AND exam_id = ? AND is_active = 1");
        $cmdASSESSMENT->bind_param("si", $enrollnment_no, $exam_id);
        $cmdASSESSMENT->execute();
        $resultASSESSMENT = $cmdASSESSMENT->get_result();

        while ($rowASS = $resultASSESSMENT->fetch_assoc()) {
            if($rowASS['assesment_type'] == 1){
                $recheck_status = 1;
            }elseif($rowASS['assesment_type'] == 2){
                $reassesment_status = 1;
            }
        }
        
        $cmd = $con->prepare("SELECT reassesment_start FROM `tbl_exam_form` WHERE id = ?");
        $cmd->bind_param("i", $exam_id);
        $cmd->execute();
        $result = $cmd->get_result();

        while ($row = $result->fetch_assoc()) {
            $reassessment_date = $row['reassesment_start'];
        }
        
        $date = new DateTime($reassessment_date);
        $date->modify('+8 days');
        $end_date = $date->format('Y-m-d');

        if($exam_id == 160){
            $end_date = '2024-09-11';
        }

        $response = array(
            'recheck_sub' => $exam_results,
            'recheck_fees' => $recheck_fees,
            'reassesment_fees' => $reassesment_fees,
            'assesment_end_date' => $end_date,
            'is_reassesment' => $reassesment_status,
            'is_recheck' => $recheck_status
        );
        // Set response headers to JSON
        header('Content-Type: application/json');

        // Output the response as JSON
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
}
