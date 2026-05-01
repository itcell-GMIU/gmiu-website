<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../dbconnect.php';
include '../../operations.php';
// include '../../common/validation.php';

function send_mail($to, $subject, $message)
{
    $from = "youthfest@gmiu.edu.in";
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

    $check = mail($to, $subject, $message, $headers);

    if ($check) {
        return true;
    } else {
        $error = error_get_last();
        $error_message = $error['message'];
        //echo "An error occurred while sending the email: $error_message";
        return $error_message;
    }
}

$mail_sent = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $data = json_decode(file_get_contents('php://input'), true);


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

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['txndate'])) {
        $date = date("d-m-Y", strtotime($_POST['txndate']));
        $key = "CRGPBR3D4U";
        $salt = "N0YMYUUEXZ";
        $merchant_email = "accounts@gmiu.edu.in";
        $total = 0;
        $status_updation = 0;
        $i = 0;


        // echo $date;
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
                    // $existing_status = checkExistingStatus($enrNo);

                    // if ($existing_status != 3) {
                    // Retrieve detailed transaction information from Easebuzz API
                    $txn_details = retrieveTransactionDetails($txn, $key, $salt);


                    if ($txn_details !== false && $txn_details['status'] == 'success' && $txn_details['productinfo'] == 'sahitya2025') {
                        // print_r($txn_details);
                        // echo "<hr>";

                        $txn_amount = $txn_details['amount'];
                        $mode = $txn_details['mode'];
                        $easepayid = $txn_details['easepayid'];
                        $addedon = $txn_details['addedon'];
                        $mobile_no = $txn_details['phone'];
                        $status = "success";

                        $json_data_pay = json_encode($txn_details);

                        $cmdFees = $con->prepare("UPDATE tbl_registers SET transaction_id = ?, payment_mode = ?, payment_id = ?, payment_status = ?, payment_response = ?, payment_date = ? WHERE mobile = ?");
                        $cmdFees->bind_param("sssssss", $txn, $mode, $easepayid, $status, $json_data_pay, $addedon, $mobile_no);
                        if ($cmdFees->execute()) {

                            // insert compitition relation data
                            $getUserDetail = array("is_active" => 1, "mobile" => $mobile_no);
                            $recUser = $crud->readRecordsWithConditions("tbl_registers", $getUserDetail);
                            if (is_array($recUser)) {
                                foreach ($recUser as $rus) {
                                    $email = $rus['email'];
                                    $userId = $rus['id'];
                                    $userCompetition = $rus['competitions'];
                                    $firstname = $rus['name'];

                                    $subject = "Successful  Registration";
                                    $message = '<!DOCTYPE html>
                        <html>

                        <head>
                        <title>Youthfest</title>
                        </head>

                        <body style="font-family: Arial, sans-serif; background-color: #f2f2f2; margin: 0; padding: 10px;">
                        <div
                        style="max-width: 600px; margin: 10px auto; background-color: #ffffff; padding: 30px; border-radius: 6px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                        <h1 style="color: #003366; font-size: 24px; margin-bottom: 20px; text-align: center;"><b>Youthfest 2025</b></h1>

                        <hr>

                        <p style="margin-bottom: 20px; font-size: 16px;">Hello ';
                                    $message .= $firstname;
                                    $message .=  '<b>';
                                    $message .= '</b>,</p>

                        <h4 style="color: green; font-size: 20px; margin-bottom: 10px;">Congratulations! Your ';

                                    $message .= 'Registration is Complete.</h4>';
                                    $message .= '<p style="margin-bottom: 20px; font-size: 16px;">Participated In : <br>';

                                    // Extracting games from comma-separated string
                                    $crud->readSingleRecordColumn("tbl_registers", "competitions", ["is_active" => 1, "mobile" => $mobile_no], $competitions);
                                    $comps = unserialize($competitions);

                                    foreach ($comps as $compid) {
                                        $crud->readSingleRecordColumn("tbl_competetion", "name", ["id" => $compid, "is_active" => 1], $compname);
                                        $message .=  "⮞ " . $compname . "<br>";

                                        $insert_data = array(
                                            "user_id" => $userId,
                                            "competition_id" => $compid,
                                        );
                                        $uniqueColumns = array("user_id", "competition_id");
                                        $createResult = $crud->apicreateRecord("tbl_participants", $insert_data, $uniqueColumns);
                                    }
                                    // Close the paragraph tag
                                    $message .= '</p>';


                                    $message .= '
                    <div style="text-align: left;">
                        <p style="margin-bottom: 0; font-size: 16px;">Best Regards,</p>
                        <p style="margin-bottom: 0; font-size: 16px;">GMIU</p>
                    </div>

                    </div>
                    </body>

                    </html>';

                                    $headers = 'MIME-Version: 1.0' . "\r\n";
                                    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                                    $headers .= 'From: ' . "\r\n" .
                                        'Reply-To: ' . "\r\n" .
                                        'X-Mailer: PHP/' . phpversion();

                                    // echo $message;
                                    // if (send_mail($email, $subject, $message)) {
                                    //     $mail_sent++;
                                    // }
                                }
                            }

                            // Insertion successful
                            $total += $txn_amount;
                            // $status_updation = 1;
                            $i = $i + 1;
                        }
                    }
                }
            }

            $con->commit(); // Commit transaction
        }
        // echo $total;

        // echo $status_updation . " <hr>";
        echo "Total Amount Received: " . $total . " <hr>";
        echo "is any update ? : " . $i;
        // header('Content-Type: application/json');
        // echo json_encode(["error" => "success"]);
    }
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <input type="date" name="txndate" id="">
        <button type="submit">Submit</button>
    </form>
</body>

</html>