<?php
include '../../../database/connect.php';
include '../../../common/validation.php';
include '../../../common/globalvariable.php';
include '../inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['erNo']) && isset($data['exam_id'])) {

        $enrNo = $data['erNo'];
        $exam_id = $data['exam_id'];

        // Prepare and execute the SQL query to fetch all exam details
        $stmt = $con->prepare("SELECT tf.semester as semester, tf.late_fee as late_fee,tf.type as type, te.id as id, te.status as status, te.account_status as account_status, te.payment_status as payment_status, tf.hallticket_status as hallticket_status, tf.pr_hallticket_status as pr_hallticket_status, te.transaction_id as transaction_id, te.payment_date as payment_date, tf.subject_fee as subject_fee
        FROM tbl_exam_student as te 
        LEFT JOIN tbl_exam_form as tf ON tf.id = te.exam_id 
        WHERE te.is_active = 1 AND te.exam_id = ? AND te.enrollnment_no = ?
        ");
        $stmt->bind_param("is", $exam_id, $enrNo);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any rows are returned
        if ($result->num_rows > 0) {

            while ($examDetails = $result->fetch_assoc()) {
                $exmLatefees = $examDetails['late_fee'];
                $semester = $examDetails['semester'];
                $transaction_id = $examDetails['transaction_id'];
                $hallticket_status = $examDetails['hallticket_status'];
                $pr_hallticket_status = $examDetails['pr_hallticket_status'];
                $account_status = $examDetails['account_status'];
                $payment_status = $examDetails['payment_status'];
                $payment_date = $examDetails['payment_date'];
                $status = $examDetails['status'];
                $subject_fee = $examDetails['subject_fee'];
                $exam_type = $examDetails['type'];
            }

            $subjectData = []; // Initialize an array to store subject code and name pairs

            if ($exam_type == 'regular') {
                $cmd2 = $con->prepare("SELECT `subject_code`, `subject_name` FROM `tbl_student_subjects` WHERE `enrollnment_no`= ? and `semester`= ? ");
                $cmd2->bind_param("si", $enrNo, $semester);
                $cmd2->execute();
                $result2 = $cmd2->get_result();
                $i = 1;
                while ($row2 = $result2->fetch_assoc()) {
                    $subject_codes = $row2['subject_code'];
                    $subject_name = $row2['subject_name'];

                    // Explode subject codes and names into arrays
                    $subjectArray = explode(', ', $subject_codes);
                    $subjectnameArray = explode(', ', $subject_name);

                    // Associate each subject code with its corresponding name
                    foreach ($subjectArray as $subject) {
                        // Use array_shift() to remove the first element from $subjectnameArray and assign it to $subject_name
                        $subject_name = array_shift($subjectnameArray);
                        $i++;
                        // Store code-name pair
                        $subjectData[] = ['code' => $subject, 'name' => $subject_name];
                    }
                }
            } elseif ($exam_type == 'remedial') {

                $stmtred = $con->prepare("SELECT subject_code FROM tbl_exam_results WHERE enrollnment_no = ? AND exam_id = ?");
                $stmtred->bind_param("si", $enrNo, $exam_id);
                $stmtred->execute();
                $resultred = $stmtred->get_result();
                $i = 1;
                while ($rowred = $resultred->fetch_assoc()) {

                    $subject = $rowred["subject_code"];

                    $query = "SELECT subject_name FROM tbl_exam_timetable WHERE subject_code = '$subject'";
                    $result = $con->query($query);

                    if ($result->num_rows > 0) {
                        // Fetch the single row
                        $row = $result->fetch_assoc();
                        $subject_name = $row['subject_name'];
                    }

                    $i++;
                    // Store code-name pair
                    $subjectData[] = ['code' => $subject, 'name' => $subject_name];
                }
            }

            // Now $subjectData contains an array of associative arrays, each containing a subject code and its corresponding name

            $form_fee = $subject_fee * ($i - 1);

            //late fees
            // Decode the JSON data
            $late_fee_data = json_decode($exmLatefees, true);

            // Get the current date
            $current_date = date('Y-m-d');

            $late_fee = 0;

            // Loop through the late fee entries and check if the current date is within the range
            foreach ($late_fee_data as $entry) {
                $starting_date = $entry['starting_date'];
                $ending_date = $entry['ending_date'];
                $late_fee_amount = $entry['late_fee_amount'];

                if ($current_date >= $starting_date && $current_date <= $ending_date) {
                    $late_fee = $late_fee_amount;
                    break; // Break the loop once a match is found      
                }
            }
            $total_fees = intval($late_fee) + intval($form_fee);


            $dateexpc = 0;
            foreach ($late_fee_data as $entry) {
                $dateexpc++;
            }
            $arraycount =  $dateexpc - 1;

            // Get the last fetch end_date
            $last_fetch_end_date = $late_fee_data[$arraycount]['ending_date'];

            // Check if the current date is greater than the last fetch end_date
            if ($current_date > $last_fetch_end_date) {
                // Show expired
                $expired = 0;
            } elseif ($current_date <= $last_fetch_end_date) {
                // Show Not expired
                $expired = 1;
            }

            $response = array(
                'late_fee' => $exmLatefees,
                'semester' => $semester,
                'hallticket_status' => $hallticket_status,
                'pr_hallticket_status' => $pr_hallticket_status,
                'account_status' => $account_status,
                'payment_status' => $payment_status,
                'status' => $status,
                'transaction_id' => $transaction_id,
                'total_fees' => $total_fees,
                'form_fee' => $form_fee,
                'payment_date' => $payment_date,
                'late_fee_amount' => intval($late_fee),
                'form_date_status' => $expired,
                'student_subject' => $subjectData
            );

            // Return exam details as JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            // No exams found
            http_response_code(404);
            echo json_encode(["error" => "NO EXAMS FOUND"]); // Response content in uppercase
        }
    }
}
