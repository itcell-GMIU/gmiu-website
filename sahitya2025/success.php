<?php
// echo "<pre>";
// print_r($_POST);
include './dbconnect.php';
include './operations.php';


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

if (isset($_POST)) {
    $payment_status = $_POST['status'];
    $payment_response = json_encode($_POST);
    // $payment_date = $_POST['addedon'];
    $contact = $_POST['phone'];
    $payment_id = $_POST['easepayid'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $txnid = $_POST['txnid'];
    $amount = $_POST['amount'];
    $competitions = explode(',', $_POST['udf1']);
    $compSerialized = serialize($competitions);


    $stmt = $con->prepare("UPDATE `tbl_registers` SET `payment_status` = ? , `payment_response` = ?, `payment_date` = CURRENT_TIMESTAMP , `payment_id` = ?, competitions = ?, fee_amount = ? WHERE `mobile` = ?");
    $stmt->bind_param("ssssis", $payment_status, $payment_response, $payment_id, $compSerialized,$amount, $contact);
    $result1 = $stmt->execute();

    $getUserDetail = array("is_active" => 1, "mobile" => $contact);
    $recUser = $crud->readRecordsWithConditions("tbl_registers", $getUserDetail);
    if (is_array($recUser)) {
        foreach ($recUser as $rus) {
            $userId = $rus['id'];
            $userCompetition = $rus['competitions'];

            $comps = unserialize($userCompetition);

            foreach ($comps as $compid) {

                $insert_data = array(
                    "user_id" => $userId,
                    "competition_id" => $compid,
                );

                $uniqueColumns = array("user_id", "competition_id");
                $createResult = $crud->apicreateRecord("tbl_participants", $insert_data, $uniqueColumns);
            }
        }
    }


    if ($result1 && $_POST['status'] == "success") {
        $rid = $payment_id;
        $rid = md5($rid);

        setcookie("rid", $rid, time() + (86400 * 10), "/");

        echo "<script>alert('Successfull Registration'); window.location.href='reciept.php?rid=$rid';</script>";
        exit;

?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Receipt</title>
            <!-- Include Bootstrap CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

            <style>
                /* Custom CSS for Receipt */
                .receipt-container {
                    border: 1px solid #ccc;
                    padding: 20px;
                    margin: 20px;
                }

                .logo {
                    /* Add your logo image here */
                    max-width: 80px;
                }

                @media print {
                    .print-btn {
                        display: none;
                    }
                }

                .borderless table {
                    border-top-style: none;
                    border-left-style: none;
                    border-right-style: none;
                    border-bottom-style: none;
                }

                .table-borderless>tbody>tr>td,
                .table-borderless>tbody>tr>th,
                .table-borderless>tfoot>tr>td,
                .table-borderless>tfoot>tr>th,
                .table-borderless>thead>tr>td,
                .table-borderless>thead>tr>th {
                    border: none;
                }

                .pay-w {
                    width: 200px;
                }
            </style>
        </head>

        <body>
            <div class="container">
                <!-- Receipt Container -->
                <div class="receipt-container">
                    <!-- Logo and Institute Name -->
                    <div class="row w-100 text-center align-self-center p-0 m-0">
                        <img src="logo-single.jpg" alt="Logo" class="logo ml-auto">
                        <h2 class="mr-auto mt-2">Gyanmanjari Innovative University</h2>
                    </div>
                    <!-- Payment Receipt Header -->
                    <div class="text-center">
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Payment Receipt</p>
                    </div>

                    <table class="table table-bordered text-center">
                        <tbody>
                            <tr>
                                <th colspan="2">Sahitya Parishad</th>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td class="text-left"><?= $firstname ?></td>
                            </tr>
                            <tr>
                                <th>Contact No.:</th>
                                <td class="text-left"><?= $contact ?></td>
                            </tr>
                            <tr>
                                <th>Email :</th>
                                <td class="text-left"><?= $email ?></td>
                            </tr>
                            <tr>
                                <th>Category Name :</th>
                                <td class="text-left">

                                    <?php

                                    $crud->readSingleRecordColumn("tbl_registers", "competitions", ["is_active" => 1, "mobile" => $contact], $competitions);
                                    $comps = unserialize($competitions);

                                    foreach ($comps as $compid) {
                                        $crud->readSingleRecordColumn("tbl_competetion", "name", ["id" => $compid, "is_active" => 1], $compname);
                                        echo "⮞ " . $compname . "<br>";
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center mt-4 mb-3">
                        <h5><u>Payment Details</u></h5>
                    </div>
                    <!-- Payment Details -->
                    <table class="table table-borderless text-left">
                        <tbody>
                            <tr>
                                <td class="p-0 pay-w">Payment Id :</td>
                                <td class="p-0"><?= $payment_id ?></td>
                            </tr>
                            <tr>
                                <td class="p-0 pay-w">Paid Amount:</td>
                                <td class="p-0">Rs. <?= $amount ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Print Button -->
                <div class="text-center">
                    <a href="./index.php" class="btn btn-dark print-btn">Home</a>
                    <button class="btn btn-primary print-btn" onclick="window.print()">Print Receipt</button>
                </div>
            </div>

            <script>
                // Disable right-click
                document.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                });

                // Disable inspect mode
                document.onkeydown = function(e) {
                    if (
                        (e.key === 'F12' && e.ctrlKey === true) || // Ctrl+Shift+I
                        (e.key === 'U' && e.ctrlKey === true) || (e.key === 'F12' && e.ctrlKey === false) // Ctrl+U
                    ) {
                        return false;
                    }
                };
            </script>

            <script>
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }
            </script>
        </body>

        </html>
<?php
    } else {
        echo "<script>alert('Failed, Please Try Again!'); window.location.href='index.php';</script>";
    }
}
?>