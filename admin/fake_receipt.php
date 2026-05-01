<?php
// Fetch all students from DB
include 'include/checklogin.php'; // your DB connection file

$query = "SELECT id,first_name, middle_name, last_name, mobile_number, token_amount, transaction_id, payment_id, receipt_id, created_at 
          FROM tbl_admission_student_design 
          ORDER BY receipt_id ASC";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Print All Receipts</title>
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; }
        /*.container { margin-bottom: 50px; border: 3px solid #000; padding: 20px; }*/
        .invoice-details, .invoice-to, .table-bordered { border-color: #000 !important; }
        h3 { font-weight: bold; }
        .print-btn { background: #000; color: white; padding: 8px 15px; border: none; margin-top: 10px; }
        @media print {
            .print-btn { display: none; }
            body { -webkit-print-color-adjust: exact !important; }
        }
            a,
        a:hover {
            color: #333333;
            text-decoration: none;
        }

        .logo-img {
            width: 78%;
        }


        /*.invoice-logo {*/
        /*    width: 250px;*/
        /*    height: 155px;*/
        /*}*/
        
                    .invoice-logo {
                width: 250px;*/
                height: 155px;  
                overflow: hidden;
            }

            .invoice-logo img {
                max-width: 100%;   
                height: auto;     
                display: block;  
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
            border: 2px solid black;
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
                top: 0px;
            }


            /*.invoice-logo {*/
            /*    width: 250px;*/
            /*    height: 155px;*/
            /*}*/

            .invoice-logo {
                width: 250px;*/
                height: 155px;  
                overflow: hidden;
            }

            .invoice-logo img {
                max-width: 100%;   
                height: auto;     
                display: block;  
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
         @media print {
        .print-btn { display: none; }
        body { -webkit-print-color-adjust: exact !important; }
        .container { page-break-after: always; } /* 🔹 Ensures each receipt is on new page */
    }
    </style>
</head>
<body>

<?php while($row = mysqli_fetch_assoc($result)) { 
    $id = $row['id'];
    $stu_first_name = $row['first_name'];
    $stu_middle_name = $row['middle_name'];
    $stu_last_name = $row['last_name'];
    $stu_number = $row['mobile_number'];
    $token_amount = $row['token_amount'];
    $transaction_id = $row['transaction_id'];
    $payment_id = $row['payment_id'];
    $new_receipt_id = $row['receipt_id'];
    $payment_date_time = date("d/m/Y", strtotime($row['created_at']));
?>
<div class="container bootdey">
    <div class="row invoice row-printable">
        <div class="col-md-10">
            <div class="panel plain">
                <div class="panel-body p30">
                    <div class="row">
                        <div class="receipt-header">
                            <div class="invoice-logo">
                                <img class="logo-img" src="../website_assets/images/logo-fake-min.png" alt="logo">
                            </div>
                            <div class="receipt-section">
                                <ul class="list-unstyled header-right-content">
                                    <li class="side-text gmiu">
                                        <h3 style="margin-bottom: 0;">Gyanmanjari Institute of Design</h3>
                                        <p>Constitute College of Gyanmanjari Innovative University</p>
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
                                           <li class="padding-all"><strong>GR Number:</strong> <?= "2024FOD200" . $id ?></li>
                                            <li class="padding-all" style="text-transform:uppercase"><strong>Faculty Name:</strong> Institute of Design</li>
                                            <li class="padding-all" style="text-transform:uppercase"><strong>Level:</strong> Under Graduation</li>
                                            <li class="padding-all" style="text-transform:uppercase"><strong>Program:</strong> Bachelor Of Design in Textile </li>
                                        </ul>
                                        <ul class="list-unstyled mb0 print-right-side" style="margin-top: -11px;">
                                            <li class="padding-all"><strong>Date :</strong> <?= $payment_date_time; ?></li>
                                            <li class="padding-all"><strong>Session :</strong> <?= date("Y",strtotime("-1 year")) . "-" . date("y"); ?></li>
                                            <!--<li class="padding-all"><strong>Transaction ID :</strong> <?= $transaction_id; ?></li>-->
                                            <!--<li class="padding-all"><strong>Payment ID :</strong> <?= $payment_id; ?></li>-->
                                            <li class="padding-all"><strong>Receipt ID :</strong> <?= $new_receipt_id; ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="invoice-to mt25">
                                <ul class="list-unstyled" style="padding-left: 14px; font-size: 16px;">
                                    <li style="margin-bottom: 10px; font-size: 18px;"><strong>Received with thanks from</strong></li>
                                    <li><strong>Student Name :</strong> <?= $stu_first_name . " " . $stu_middle_name; ?></li>
                                    <li><strong>Father Name :</strong> <?= $stu_last_name; ?></li>
                                    <li><strong>Mobile Number :</strong> <?= $stu_number; ?></li>
                                </ul>
                            </div>

                            <table class="table table-bordered">
                                <tr>
                                    <th>Amount Received (in figures)</th>
                                    <td>Rs. <b>145000</b></td>
                                </tr>
                                <tr>
                                    <th>In Words</th>
                                    <td>Rupees One Lakh Forty Five Thousand Only</td>
                                </tr>
                                <tr>
                                    <th>Against</th>
                                    <td>Tuition Fees</td>
                                </tr>
                                <tr>
                                    <th>Payment Mode</th>
                                    <td>Offline</td>
                                </tr>
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
                                    <td colspan="2"><b>This is Computer Generated Receipt, No signature required.</b></td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<button onclick="window.print()" class="print-btn">Print All Receipts</button>

</body>
</html>
