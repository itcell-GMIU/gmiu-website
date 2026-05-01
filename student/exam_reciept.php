<?php
include 'include/checklogin.php';
if (isset($_GET['eid'])) {
    $exam_id = $_GET['eid'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Receipt</title>
    <!-- Include Bootstrap CSS -->
    <?php include 'include/importhead.php'; ?>
    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
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
            <div class="row w-100 text-right align-center p-0 m-0">
                <img src="../website_assets/images/logo-single.jpg" alt="Logo" class="logo ml-auto">
                <h2 class="mr-auto">Gyanmanjari Innovative University</h2>
            </div>
            <!-- Payment Receipt Header -->
            <div class="text-center" style="transform: translateY(-40px);">
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Payment Receipt</p>
            </div>
            <?php
            $cmd = $con->prepare("SELECT `id`, `faculty_id`, `level_id`, `program_id`, `semester`, `type`, `subject_code`, `session`, `start_date`, `end_date`, `year`, `subject_fee` FROM `tbl_exam_form` WHERE `is_active` = 1 AND `faculty_id` =? AND `level_id` =? AND `program_id`= ? AND `id` = ?");
            $cmd->bind_param("iiii", $faculty_id, $level_id, $program_id, $exam_id);
            $cmd->execute();
            $result = $cmd->get_result();
            while ($row = $result->fetch_assoc()) {
                $semester_ex = $row['semester'];
                $subject_fee = $row['subject_fee'];
                $exam_session = $row['session'];
                if ($row['type'] == "regular") {
                    $exam_type = "REGULAR";
                } else {
                    $exam_type = "REMEDIAL";
                }

                $cmd33 = "SELECT * FROM tbl_clg_name WHERE is_delete = '0' and is_active='1' and FIND_IN_SET('$faculty_id', faculty_id) > 0";
                $stmt33 = $con->prepare($cmd33);
                $stmt33->execute();
                $result33 = $stmt33->get_result();

                if ($result33->num_rows > 0) {
                    while ($row33 = $result33->fetch_assoc()) {
                        $clg_name =  $row33['clg_name'];
                    }
                }

                $exam_name = $clg_name . ' ' . $program_name . ' SEMESTER ' . $semester_ex . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year'];

            ?>
                <!-- Faculty Name -->
                <div class="text-center">
                    <p class="m-1 text-uppercase"><?= $clg_name ?></p>
                </div>

                <div class="text-center">
                    <p class="text-uppercase"><?= $exam_name ?></p>
                </div>


                <table class="table table-bordered text-center">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td><?php echo $first_name . ' ' . $middle_name . ' ' . $last_name; ?></td>
                        </tr>
                        <tr>
                            <th>Enrolement No.:</th>
                            <td><?= $er_no ?></td>
                        </tr>
                        <tr>
                            <th>Branch:</th>
                            <td><?= $program_name ?></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Table for Items -->
                <table class="table table-bordered text-center mt-5">
                    <thead>
                        <tr>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cmd2 = $con->prepare("SELECT `subject_code`, `subject_name` FROM `tbl_student_subjects` WHERE `enrollnment_no`= ? and `semester`= ? ");
                        $cmd2->bind_param("si", $er_no, $semester_ex);
                        $cmd2->execute();
                        $result2 = $cmd2->get_result();
                        $i = 1;
                        while ($row2 = $result2->fetch_assoc()) {
                            $subject_codes = $row2['subject_code'];
                            $subject_name = $row2['subject_name'];
                            $subjectArray = explode(', ',  $subject_codes);
                            $subjectnameArray = explode(', ',  $subject_name);
                            foreach ($subjectArray as $subject) {
                                $sub_name = current($subjectnameArray);
                        ?>
                                <tr class="p-0">
                                    <td class="p-1"><?= $subject ?></td>
                                    <td class="p-1"><?= $sub_name ?></td>
                                </tr>
                        <?php
                                if (next($subjectnameArray) === false) {
                                    reset($subjectnameArray);
                                }
                            }
                        }
                        $cmd3 = $con->prepare("SELECT `transaction_id`,`fee_amount`, `payment_date` FROM `tbl_exam_student` WHERE `exam_id`= ? AND `enrollnment_no` = ?");
                        $cmd3->bind_param("is", $exam_id, $er_no);
                        $cmd3->execute();
                        $result3 = $cmd3->get_result();
                        while ($row3 = $result3->fetch_assoc()) {
                            $transaction_id = $row3['transaction_id'];
                            $fee_amount = $row3['fee_amount'];
                            $payment_date = $row3['payment_date'];
                            $payment_date = date("d/m/Y h:i A", strtotime($payment_date));
                        }
                        ?>
                    </tbody>
                </table>
                <div class="text-center mt-4 mb-3">
                    <h5><u>Payment Details</u></h5>
                </div>
                <!-- Payment Details -->
                <table class="table table-borderless text-left">
                    <tbody>
                        <tr>
                            <td class="p-0 pay-w">GMIU Transaction ID:</td>
                            <td class="p-0"><?= $transaction_id ?></td>
                        </tr>
                        <tr>
                            <td class="p-0 pay-w">Paid Amount:</td>
                            <td class="p-0"><?= $fee_amount ?> <i class="fa fa-inr" style="font-size: 15px;"></i></td>
                        </tr>
                        <tr>
                            <td class="p-0 pay-w">Transaction Date:</td>
                            <td class="p-0"><?= $payment_date ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-left mt-5">
                    <?php
                    $cmd = $con->prepare("SELECT instructions FROM tbl_exam_assets");
                    $cmd->execute();
                    $result = $cmd->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $exp_description = $row['instructions'];
                    }
                    ?>
                    <?= $exp_description?>
                </div>
        </div>
    <?php
            }
    ?>
    <!-- Print Button -->
    <div class="text-center m-5">
        <a class="btn btn-info print-btn" href="examform.php"><i class="fa fa-arrow-left"></i> Back</a>
        <button class="btn btn-primary print-btn" onclick="window.print()"><i class="fa fa-print"></i> Print Receipt</button>
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
        // Your encryption key - you should keep this secret.
        var encryptionKey = "YourSecretKey";

        // The file path you want to encrypt
        var originalPath = "/path/to/your/file.txt";

        // Encrypt the file path
        var encryptedPath = CryptoJS.AES.encrypt(originalPath, encryptionKey).toString();

        // Display the encrypted file path
        document.getElementById("encryptedPath").textContent = encryptedPath;

        // To decrypt the path later if needed, you can use:
        // var decryptedPath = CryptoJS.AES.decrypt(encryptedPath, encryptionKey).toString(CryptoJS.enc.Utf8);
        // console.log(decryptedPath);
    </script>
</body>

</html>