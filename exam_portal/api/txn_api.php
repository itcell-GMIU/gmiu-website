<?php
include '../../database/connect.php';
include '../../common/validation.php';
include '../../common/globalvariable.php';
include './operation.php';

// $allowed_ips = array('3.7.50.30', '192.168.73.17', '192.168.73.43', '103.206.136.226', '117.247.54.20', '103.206.136.181', '43.250.159.197','136.232.127.118','103.206.136.27');

// // Check if the request originates from an allowed IP address
// if (!in_array($_SERVER['REMOTE_ADDR'], $allowed_ips)) {
//     http_response_code(403); // Forbidden
//     exit("Access Forbidden");
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['txndate'])) {
    $date = $_POST['txndate'];
    $key = "CRGPBR3D4U";
    $salt = "N0YMYUUEXZ";
    $merchant_email = "accounts@gmiu.edu.in";
    $total = 0;
    $status_updation = 0;
    $i = 0;

    // Fetch transactions from the Easebuzz API
    $transactions = fetchTransactions($date, $key, $salt, $merchant_email);

    if ($transactions !== false) {
        $con->begin_transaction(); // Start transaction

        foreach ($transactions as $transaction) {
            $transaction_status = $transaction['status'];

            if ($transaction_status == 'success') {
                $txn = $transaction['txnid'];

                // Check if udf5 is already processed
                $enrNo = $transaction['udf5'];
                $existing_status = checkExistingStatus($enrNo);

                if ($existing_status != 3) {
                    // Retrieve detailed transaction information from Easebuzz API
                    $txn_details = retrieveTransactionDetails($txn, $key, $salt);

                    if ($txn_details !== false && $txn_details['status'] == 'success' && $txn_details['udf2'] == 'exam_fees') {
                        $examId = $txn_details['udf6'];
                        $txn_amount = $txn_details['amount'];
                        $mode = $txn_details['mode'];
                        $easepayid = $txn_details['easepayid'];
                        $addedon = $txn_details['addedon'];
                        $status = 3;

                        $total += $txn_amount;

                        $cmdFees = $con->prepare("UPDATE tbl_exam_student SET transaction_id = ?, status = ?, payment_mode = ?, payment_id = ?, payment_status = ?, payment_response = ?, payment_date = ? WHERE enrollnment_no = ? AND exam_id = ? AND status != 3");
                        $cmdFees->bind_param("sssssssss", $txn, $status, $mode, $easepayid, $transaction_status, json_encode($txn_details), $addedon, $enrNo, $examId);
                        if ($cmdFees->execute()) {
                            // Insertion successful
                            $status_updation = 1;
                            $i++;
                        } else {
                            // Insertion failed
                            $status_updation = 0;
                        }
                        // echo '<br>'.$enrNo.'<br>'.$examId.'<hr>';
                        // $status_updation = 1;
                        // $i++;
                    }
                }
            }
        }

        $con->commit(); // Commit transaction
    }

    echo $status_updation . " <hr>";
    echo "Total Amount Received: " . $total . " <hr>";
    echo $i;
}

function fetchTransactions($date, $key, $salt, $merchant_email)
{
    $curl = curl_init();
    $txnHash = hash('sha512', $key . '|' . $merchant_email . '|' . $date . '|' . $salt . '');

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://dashboard.easebuzz.in/transaction/v1/retrieve/date",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "merchant_key=$key&transaction_date=$date&merchant_email=accounts@gmiu.edu.in&hash=$txnHash&submerchant_id=",
        CURLOPT_HTTPHEADER => [
            "Accept: application/json",
            "Content-Type: application/x-www-form-urlencoded"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
        return false;
    } else {
        $data = json_decode($response, TRUE);
        if (isset($data['status']) && is_array($data['transactions'])) {
            return $data['transactions'];
        } else {
            return false;
        }
    }
}

function retrieveTransactionDetails($txn, $key, $salt)
{
    $curl = curl_init();
    $txnHash = hash('sha512', $key . '|' . $txn . '|' . $salt . '');

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://dashboard.easebuzz.in/transaction/v2/retrieve",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "txnid=$txn&key=$key&hash=$txnHash",
        CURLOPT_HTTPHEADER => [
            "Accept: application/json",
            "Content-Type: application/x-www-form-urlencoded"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
        return false;
    } else {
        $data = json_decode($response, TRUE);
        if (isset($data['msg'])) {
            return $data['msg'];
        } else {
            return false;
        }
    }
}

function checkExistingStatus($enrNo)
{
    global $con;
    $status = 0;

    $cmd = $con->prepare("SELECT status FROM tbl_exam_student WHERE enrollnment_no = ? ORDER BY id DESC LIMIT 1");
    $cmd->bind_param("s", $enrNo);
    $cmd->execute();
    $cmd->bind_result($status);
    $cmd->fetch();
    $cmd->close();

    return $status;
}
