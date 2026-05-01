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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['txndate'])  && isset($_POST['product_info'])) {
    $date = $_POST['txndate'];
    $prod_info = $_POST['product_info'];
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


        // print_r($transactions );
        foreach ($transactions as $transaction) {
            $txn = $transaction['txnid'];

            $txn_details = retrieveTransactionDetails($txn, $key, $salt);

            // print_r( $txn_details );
            $transaction_status = $transaction['status'];
            $transaction_product_info = $txn_details['productinfo'];

            if ($transaction_status == 'success') {
                // echo $txn_details['amount'].'<br>';

                if ($txn_details !== false && $txn_details['status'] == 'success') {
                    if ($txn_details['productinfo'] == 'Tuition Fee' || $txn_details['productinfo'] == 'Int Fee - Minor' || $txn_details['productinfo'] == 'Genius Programme Fees' || $txn_details['productinfo'] == 'Professonal Regulatory Charge' || $txn_details['productinfo'] == 'Student Section Fees') {

                        $txn_amount = $txn_details['amount'];   
                        $mode = $txn_details['mode'];
                        $easepayid = $txn_details['easepayid'];
                        $addedon = $txn_details['addedon'];

                        $total =  $total + $txn_amount;

                        $i++;

                        echo $i.' = '.$txn_amount.'<br>';
                    }
                }
            }
        }

        echo '<br> total ='.$total;
    }

    $con->commit(); // Commit transaction
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
        CURLOPT_POSTFIELDS => "merchant_key=$key&transaction_date=$date&merchant_email=accounts@gmiu.edu.in&hash=$txnHash&productinfo=Tution Feee&submerchant_id=",
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
