<?php include 'include/checklogin.php';


if (isset($_GET['stu_id'])) {
    $stu_id = $_GET['stu_id'];
} else {
    $stu_id = "";
}

$check_receipt_id_query = "SELECT receipt_id FROM tbl_admission_student WHERE receipt_id IS NOT NULL LIMIT 1";
$check_receipt_id_result = mysqli_query($con, $check_receipt_id_query);
if ($check_receipt_id_result && mysqli_num_rows($check_receipt_id_result) > 0) {
    // If receipt ID exists, fetch it
    $row = mysqli_fetch_assoc($check_receipt_id_result);
    $new_receipt_id = $row['receipt_id'];
} else {
    // If no receipt ID exists yet, generate a new one
    $latest_receipt_id_query = "SELECT MAX(CAST(SUBSTRING(receipt_id, 5) AS UNSIGNED)) AS max_id FROM tbl_admission_student";
    $latest_receipt_id_result = mysqli_query($con, $latest_receipt_id_query);
    if ($latest_receipt_id_result && mysqli_num_rows($latest_receipt_id_result) > 0) {
        $row = mysqli_fetch_assoc($latest_receipt_id_result);
        $latest_receipt_id = $row['max_id'];
        // Increment the receipt ID
        $new_id_number = ++$latest_receipt_id;
        // Format the new receipt ID
        $new_receipt_id = 'GMIU' . str_pad($stu_id, 3, '0', STR_PAD_LEFT);
    } else {
        // If no receipt exists yet, start from GMIT001
        $new_receipt_id = 'GMIU';
    }
}
$new_receipt_id = 'GMIU' . str_pad($stu_id, 3, '0', STR_PAD_LEFT);
// Update the database with the new receipt ID
$update_receipt_id_query = "UPDATE tbl_admission_student SET receipt_id = '$new_receipt_id' WHERE receipt_id IS NULL";
mysqli_query($con, $update_receipt_id_query);


$cmd = "Select stu.*,pro.name as program_name,level.name as level_name,faculty.shortname as faculty_shortname,clg.clg_name as college_name,faculty.name as faculty_name,stu.account_office_approve_reject_date as account_office_approve_reject_date, stu.transaction_id as transaction_id, stu.payment_id as payment_id from tbl_admission_student as stu 
LEFT JOIN tbl_program pro ON stu.program_id = pro.id 
  LEFT JOIN tbl_faculty faculty ON stu.faculty_id = faculty.id 
  LEFT JOIN tbl_level level ON stu.level_id = level.id 
  LEFT JOIN tbl_clg_name clg ON stu.faculty_id = clg.faculty_id and stu.level_id = clg.level_id
  where stu.id=? 
  
  ";
$stmt = $con->prepare($cmd);
$stmt->bind_param("i", $stu_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $clg_name = $row['college_name'];
    $stu_first_name = !empty($row['first_name']) ? $row['first_name'] : "";
    $stu_middle_name = !empty($row['middle_name']) ? $row['middle_name'] : "";
    $stu_last_name = !empty($row['last_name']) ? $row['last_name'] : "";
    $stu_email = !empty($row['email']) ? $row['email'] : "";
    $stu_number = !empty($row['mobile_number']) ? $row['mobile_number'] : "";
    $mode = !empty($row['mode']) ? $row['mode'] : "";
    $payment_mode = !empty($row['payment_mode']) ? $row['payment_mode'] : "";
    $payment_status = !empty($row['payment_status']) ? $row['payment_status'] : "";
    $father_name = !empty($row['father_name']) ? $row['father_name'] : "";
    $mother_name = !empty($row['mother_name']) ? $row['mother_name'] : "";
    $parent_mobile_number = !empty($row['parent_mobile_number']) ? $row['parent_mobile_number'] : "";
    $parent_email_id = !empty($row['parent_email_id']) ? $row['parent_email_id'] : "";
    $permanent_address = !empty($row['permanent_address']) ? $row['permanent_address'] : "";
    $permanent_pincode = !empty($row['permanent_pincode']) ? $row['permanent_pincode'] : "";
    $address = !empty($row['address']) ? $row['address'] : "";
    $pincode = !empty($row['pincode']) ? $row['pincode'] : "";
    $city = !empty($row['city']) ? $row['city'] : "";
    $state = !empty($row['state']) ? $row['state'] : "";
    $permanent_city = !empty($row['permanent_city']) ? $row['permanent_city'] : "";
    $permanent_state = !empty($row['permanent_state']) ? $row['permanent_state'] : "";
    $token_amount = !empty($row['token_amount']) ? $row['token_amount'] : "";
    $payment_date_time = !empty($row['payment_date_time']) ? $row['payment_date_time'] : "";
    $gr_number = !empty($row['gr_number']) ? $row['gr_number'] : "";
    $stu_program_name = !empty($row['program_name']) ? $row['program_name'] : "";
    $stu_faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "";
    $stu_level_name = !empty($row['level_name']) ? $row['level_name'] : "";
    $stu_cluster_status = !empty($row['status']) ? $row['status'] : "";
    $account_office_approve_reject_date = !empty($row['account_office_approve_reject_date']) ? $row['account_office_approve_reject_date'] : "";
    $transaction_id = !empty($row['transaction_id']) ? $row['transaction_id'] : "";
    $payment_id = !empty($row['payment_id']) ? $row['payment_id'] : "";

} else {
    $stu_first_name = "";
    $stu_middle_name = "";
    $stu_last_name = "";
    $stu_email = "";
    $stu_number = "";
    $stu_faculty_id = "";
    $stu_level_id = "";
    $stu_program_id = "";
    $mode = "";
    $payment_mode = "";
    $adhar_number = "";
    $dob = "";
    $gender = "";
    $blood_group = "";
    $religion = "";
    $caste = "";
    $father_name = "";
    $mother_name = "";
    $parent_mobile_number = "";
    $parent_email_id = "";
    $father_occupation = "";
    $mother_occupation = "";
    $permanent_address = "";
    $permanent_pincode = "";
    $address = "";
    $pincode = "";
    $city = "";
    $state = "";
    $permanent_city = "";
    $permanent_state = "";
    $is_same_addr = "";
    $token_amount = "";
    $payment_date_time = "";
    $gr_number = "";
    $stu_program_name = "";
    $stu_faculty_name = "";
    $stu_faculty_shortname = "";
    $stu_level_name = "";
    $stu_cluster_status = "";
    $stu_admission_step = "";
    $comment = "";
    $account_office_status = "";
    $account_office_approve_reject_date = "";
    $transaction_id = "";
    $payment_id = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Receipt page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <style type="text/css">
        a,
        a:hover {
            color: #333333;
            text-decoration: none;
        }

        .logo-img {
            width: 78%;
        }


        .invoice-logo {
            width: 250px;
            height: 155px;
        }

        .side-text {
            font-size: 15.6px;
        }

        .gmiu h3 {
            text-transform: uppercase;
            font-weight: 550;
            font-size: 27.7px;
        }

        .padding-all {
            padding-bottom: 8px;
        }

        .header-right-content {
            text-align: left;
        }

        .well {
            font-size: 15.5;
            margin-top: 20px;
            height: 203px;
        }

        .rj {
            padding: 19px;
            margin-top: 10px;
            background-color: #fefbfb;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
        }

        .table>tbody>tr>td,
        .table>tbody>tr>th,
        .table>tfoot>tr>td,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>thead>tr>th {
            vertical-align: middle;
        }

        .amount-side {
            text-align: right;
        }


        .receipt-header {
            display: flex;
            /* justify-content: space-between; */
            align-items: center;
            margin: 5px 20px;
        }

        .panel-body {
            border: 1px solid black;
            margin-top: 50px;
            margin-left: auto;
            margin-right: auto;
        }

        .side-by-side-content {
            display: flex;
            justify-content: space-between;
        }

        @media print {
            .logo-img {
                width: 81.5%;
            }

            .logo-img {
                position: relative;
                top: -9px;
            }


            .invoice-logo {
                width: 250px;
                height: 155px;
            }

            .side-text {
                font-size: 15.6px;
            }

            .print-btn {
                display: none;
            }

            /* 
            .side-by-side-content {
                display: flex;
                flex-direction: row !important;
                justify-content: space-between;
            } */

            .gmiu h3 {
                text-transform: uppercase;
                font-weight: 550;
                font-size: 27.5px;
            }

            .print-right-side {
                position: relative;
                top: -122px;
                right: -600px;
            }


        }

        /* For Tablet View */
        @media screen and (min-device-width: 768px) and (max-device-width: 1024px) {

            .logo-img {
                width: 40%;
            }
        }

        /* For Mobile Portrait View */
        @media screen and (max-device-width: 480px) and (orientation: portrait) {

            .logo-img {
                width: 38%;
            }

            .well {
                margin-top: 20px;
                height: 203px;
            }

        }


        /* For Mobile Phones Portrait or Landscape View */
        @media screen and (max-device-width: 640px) {

            .well {
                margin-top: 20px;
                height: 315px;
            }

            .logo-img {
                width: 58%;
            }

            .receipt-header {
                flex-direction: column;
            }

            .side-by-side-content {
                flex-direction: column;

            }

        }

        @media screen and (max-device-width: 400px) {

            .logo-img {
                width: 58%;
                margin: 7px 15px;
            }

            .receipt-header {
                flex-direction: column !important;
            }
        }


        /* For iPhone 5 Portrait or Landscape View */
        @media (device-height: 568px) and (device-width: 320px) and (-webkit-min-device-pixel-ratio: 2) {
            .well {
                margin-top: 20px;
                height: 303px;
            }

            .receipt-header {
                flex-direction: column !important;
            }
        }

        /* For iPhone 6 and 6 plus Portrait or Landscape View */
        @media (min-device-height: 667px) and (min-device-width: 375px) and (-webkit-min-device-pixel-ratio: 3) {
            .gfg-div {
                width: 400px;
                height: 400px;
                background-color: darkgoldenrod;
                color: black;
            }

            .side-by-side-content {
                flex-direction: column !important;
            }
        }
    </style>
</head>
<?php
if ($payment_status == 'success') {
    // Show other details only if payment was successful
    ?>
<body>
    <div class="container bootdey" id="print">
        <div class="row invoice row-printable">
            <div class="col-md-10">

                <div class="panel plain" id="dash_0">

                    <div class="panel-body p30">
                        <div class="row">
                            <div class="receipt-header">
                                <div class="invoice-logo">
                                    <img class="logo-img" src="../website_assets/images/logo-single.jpg" alt="logo">
                                </div>

                                <div class="receipt-section">
                                    <ul class="list-unstyled header-right-content">
                                        <li class="side-text gmiu">
                                            <!-- <h3>Gyanmanjari Innovative University</h3> -->
                                            <h3 class="" style="margin-bottom: 0;"><?= $clg_name; ?></h3>
                                            <p>Constitute College of Gyanmanjari Innovative University</p>
                                        </li>
                                        <li class="side-text"><i class="fa-sharp fa-solid fa-location-dot"></i>
                                            Gyanmanjari Innovative University, Survey No.30, Sidasar <br> Road, Near
                                            Iscon Eleven, Bhavnagar Gujarat (India)
                                        </li>
                                        <li class="side-text"><i class="fa-light fa-solid fa-globe"></i>
                                            <a>www.gmiu.edu.in</a>
                                        </li>
                                        <li class="side-text"><i class="fa-sharp fa-solid fa-envelope"></i>
                                            <a>info@gmiu.edu.in</a>
                                        </li>
                                        <li class="side-text"><i class="fa-solid fa-phone"></i> <a>+91 9099951160</a>
                                            ,<a>+91 7574949494</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="invoice-details mt25">
                                    <div class="well">
                                        <h4 class="text-center"><b>RECEIPT</b></h4>
                                        <div class="side-by-side-content">
                                            <ul class="list-unstyled mb0" style="font-size: 16px;">
                                                <!-- <li class="padding-all"><strong>Ref. No: AD/2023-24/xxxx</strong></li> -->
                                                <li class="padding-all"><strong>GR Number:</strong>
                                                    <?php echo $gr_number; ?>
                                                </li>
                                                <li class="padding-all"><strong>Faculty Name:</strong>
                                                    <?php echo $stu_faculty_name; ?>
                                                </li>
                                                <li class="padding-all"><strong>Level:</strong>
                                                    <?php echo $stu_level_name; ?>
                                                </li>
                                                <li class="padding-all"><strong>Program:</strong>
                                                    <?php echo $stu_program_name; ?>
                                                </li>

                                            </ul>
                                            <ul class="list-unstyled mb0 print-right-side" style="margin-top: -11px;">

                                                <li class="padding-all"><strong>Date :
                                                        <?php
                                                        if ($payment_mode == "online") {
                                                            echo $payment_date_time;
                                                        } else {
                                                            echo $account_office_approve_reject_date;
                                                        }
                                                        ?>
                                                    </strong></li>
                                                <?php
                                                $year = date('Y');
                                                $nextYear = date('y', strtotime('+1 year'));
                                                $session = "$year-$nextYear";
                                                ?>
                                                <li class="padding-all">Session : <?php echo $session; ?></li>
                                                <li class="padding-all">Transaction ID :
                                                    <?php echo $transaction_id; ?>
                                                </li>
                                                <?php
                                                if (!empty($payment_mode)) {
                                                    if ($payment_mode == "online") {
                                                        echo "<li class='padding-all'>Payment ID :$payment_id </li>";
                                                    }
                                                }
                                                ?>
                                                <li class="padding-all">Receipt ID :
                                                    <?php echo $new_receipt_id; ?>
                                                </li>

                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <div class="invoice-to mt25">
                                    <ul class="list-unstyled" style="    padding-left: 14px; font-size: 16px;">
                                        <li style="margin-bottom: 10px; font-size: 18px;"><strong>Received with thanks
                                                from</strong></li>
                                        <li><strong>Student Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </strong>
                                            <?php echo $stu_last_name; ?>
                                            <?php echo $stu_first_name; ?>
                                        </li>
                                        <li><strong>Father Name
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;:</strong>
                                            <?php echo $stu_middle_name; ?>
                                        </li>
                                        <!-- <li><strong>Address&nbsp; &nbsp; &nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong>
                                                <?php echo $address; ?></li> -->
                                        <li><strong>Mobile Number &nbsp;&nbsp;&nbsp;:</strong>
                                            <?php echo $stu_number; ?>
                                        </li>
                                    </ul>
                                </div>

                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="col">Description</th>
                                            <th scope="col" class="amount-side">Amount</th>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <tr>

                                        </tr>
                                    </tbody>
                                </table>


                                <table class="table table-bordered rj">

                                    <tbody>
                                        <tr>
                                            <th scope="row">Amount Received <br> (in figures)</th>
                                            <td colspan="3">Rs.<b>
                                                    <?php echo $token_amount; ?>
                                                </b></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">In Words</th>
                                            <td colspan="3"> Rupees <b>
                                                    <?php
                                                    if ($token_amount == 5000) {
                                                        echo "Five Thousand";
                                                    } elseif ($token_amount == 10000) {
                                                        echo "Ten Thousand";
                                                    } elseif ($token_amount == 15000) {
                                                        echo "Fifteen Thousand";
                                                    } elseif ($token_amount == 2500) {
                                                        echo "Two Thousand Five Hundred";
                                                    } elseif ($token_amount == 12000) {
                                                        echo "Twelve Thousand";
                                                    }
                                                    ?>
                                                </b> Only
                                            </td>

                                        </tr>
                                        <tr>
                                            <th scope="row">Against</th>
                                            <td colspan="3">Tuition fees</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Payment Mode</th>
                                            <td colspan="3">
                                                <?php

                                                if (!empty($payment_mode)) {
                                                    if ($payment_mode == "online") {
                                                        echo "Online, Easebuzz";
                                                    } else if ($payment_mode == "offline") {
                                                        echo "Offline";
                                                    }
                                                } else {
                                                    echo "Pending";
                                                }

                                                ?>
                                            </td>
                                        </tr>
                                        <!--  <tr>
                                            <th scope="row">Narration</th>
                                            <td colspan="3">xxxxxxxx</td>
                                        </tr> -->
                                        <tr>
                                            <td colspan="4"><b>All disputes to Bhavnagar Jurisdiction</b> Only. <br>
                                                Fees once Paid, Will Not Be Refundable.</td>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="4">*This is provisional Admission.Final admission will be confirmed subject to approval by Admission committee/University.</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">*If at any stage of the admissions process, it is found that applicant does not meet the eligibility criteria as per ACPC or University rules or that the information furnished by him/her
                                                is incorrect, then such applications will be eliminated from admission process.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">*Applicants submitting the application form of any program/course to University are advised to have read the rules and policies related to eligibility,
                                                provisional admission, cancellation of admission and refund of fees.</td>
                                        </tr>

                                        <tr>
                                            <td colspan="4"><b>This is Computer Generated Receipt, No need of
                                                    signature.</b></td>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="4"><b>Generated on
                                                    <?php
                                                    $dateTime = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
                                                    echo $dateTime->format("d/m/y  H:i A");
                                                    ?>
                                                </b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button onclick="window.print()" class="print-btn"><i class="fa fa-print mr5"></i>Print</button>
                                <!-- <p class="text-center btn btn-default ml15" onclick="printDiv(print)"> Print</p> -->
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>


</body>
<?php } else {
    ?>
    <body>
       <div class="text-center" style="margin-top: 50px;">
        <div class="not-found-emoji">😕</div>
       <h3 style="color: #d9534f;">Payment Not Found</h3>
         <p>Please check the transaction or contact the accounts department.</p>
    </div>

    <style>
        .not-found-emoji {
            font-size: 60px;
            display: inline-block;
            animation: bounce 1.2s infinite;
            filter: hue-rotate(200deg) saturate(3);
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    </style>
    </body>
    <?php
}
?>
</html>