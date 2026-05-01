<?php
include 'include/checklogin.php';
if (isset($_GET['eid'])) {
    $exam_id = $_GET['eid'];
}

if($pr_image == "N/A" || $signature == "N/A"){
    $_SESSION['status'] = "Please Update Your Photo And Signature!";
    $_SESSION['status_code'] = "error";
    echo "<script>setTimeout(function(){window.location='editProfile.php'},100)</script>";
}

// disable hall ticket for account rejected students
// $cmd= "select account_status from tbl_exam_student where enrollnment_no='$er_no'";
// $result1= mysqli_query($con,$cmd) or die(mysqli_error($con));
// $row1=mysqli_fetch_array($result1);
// $account_status=$row1['account_status'];
// if($account_status == 2)
// {
//     $_SESSION['status'] = "Please Contact Account Session!";
//     $_SESSION['status_code'] = "error";
//     echo "<script>alert('Please Contact Account Session!')</script>";
//     echo "<script>setTimeout(function(){window.location='editProfile.php'},100)</script>";
// }
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
            /* border: 1px solid #ccc; */
            padding: 20px;
            margin: 20px;
        }

        .logo {
            /* Add your logo image here */
            max-width: 95px;
            margin: 1px;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }


        .p-h {
            height: 45px;
            display: flex;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Receipt Container -->
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

            $cmdstd = $con->prepare("SELECT seat_no FROM tbl_exam_student WHERE exam_id = ? AND enrollnment_no = ? ");
            $cmdstd->bind_param("is", $exam_id, $er_no);
            $cmdstd->execute();
            $resultstd = $cmdstd->get_result();

            while ($stdr = $resultstd->fetch_assoc()) {
                $seat_no = $stdr['seat_no'];
            }

        ?>
            <div class="receipt-container">
                <div class="row">
                    <div class="col-2 text-center border-dark border-left border-top border-bottom">
                        <img src="<?= $website_assets_url ?>images/logo-single.jpg" alt="Logo" class="logo mt-1 mb-1 ml-auto" style="z-index: 1;">
                    </div>
                    <div class="col-8 text-center border border-dark">
                        <div class="row mt-2">
                            <h2 class="mx-auto">Gyanmanjari Innovative University</h2>
                        </div>
                        <div class="row">
                            <h4 class="mx-auto">-:: HALL TICKET ::-</h4>
                        </div>
                    </div>
                    <div class="col-2 border-right border-top border-bottom border-dark">
                        <div class="row h-50">
                            <h6 class="mx-auto my-auto">Seat Number</h6>
                        </div>
                        <div class="row">
                            <h6 class="mx-auto  my-2"><?= $seat_no ?></h6>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1 text-center border-left border-bottom border-dark">
                    </div>
                    <div class="col-10 text-center border-bottom p-h border-dark" style="height: 55px;">
                        <div class="row m-2">
                            <h5 class="mx-auto text-uppercase"><?= $exam_name ?></h5>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="row h-100 border-bottom border-right border-dark">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-10 text-center border-right  border-left border-dark">
                        <div class="row border-bottom border-dark">
                            <div class="col-2 border-right p-h border-dark">
                                <h6 class="mx-auto">Name :</h6>
                            </div>
                            <div class="col-10 p-h">
                                <h6 class="text-left font-weight-normal "><?= $first_name . ' ' . $middle_name . ' ' . $last_name ?></h6>
                            </div>
                        </div>
                        <div class="row border-bottom border-dark">
                            <div class="col-2 border-right p-h border-dark">
                                <h6 class="mx-auto">Enrollment :</h6>
                            </div>
                            <div class="col-4 border-right p-h border-dark">
                                <h6 class="text-left font-weight-normal"><?= $er_no ?></h6>
                            </div>
                            <div class="col-2 border-right p-h border-dark">
                                <h6 class="mx-auto">Branch :</h6>
                            </div>
                            <div class="col-4 p-h">
                                <h6 class="text-left font-weight-normal"><?= $program_name ?></h6>
                            </div>
                        </div>
                        <div class="row border-bottom border-dark">
                            <div class="col-2 border-right p-h border-dark">
                                <h6 class="mx-auto">Institute :</h6>
                            </div>
                            <div class="col-10 p-h">
                                <h6 class="text-left font-weight-normal"><?= $clg_name ?></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 border-right p-h border-dark">
                                <h6 class="mx-auto">Center :</h6>
                            </div>
                            <div class="col-10 p-h">
                                <h6 class="text-left font-weight-normal"><?= $clg_name ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 border-right text-center border-dark">
                        <img src="../website_assets/images/std_profile/<?= $pr_image ?>" alt="Photo" class="m-1" style="height: 120px; width: 100%;">
                        <div class="row border-top border-dark">
                            <img src="../website_assets/images/std_signature/<?= $signature ?>" alt="Signature" class="m-1" style="height: 50px; width: 100%;">
                        </div>
                    </div>
                    <div class="col-12 p-0 text-center">
                        <table class="table w-100 border-collapse" style="border:1px solid black;">
                            <tbody>
                                <tr>
                                    <td style="width: 126px;border:1px solid black;">Subject :</td>
                                    <?php
                                    $cmd2 = $con->prepare("SELECT `subject_code`, `subject_name` FROM `tbl_student_subjects` WHERE `enrollnment_no`= ? and `semester`= ? ");
                                    $cmd2->bind_param("si", $er_no, $semester_ex);
                                    $cmd2->execute();
                                    $result2 = $cmd2->get_result();
                                    while ($row2 = $result2->fetch_assoc()) {
                                        $subject_codes = $row2['subject_code'];
                                        $subject_name = $row2['subject_name'];
                                        $subjectnameArray = explode(', ',  $subject_name);
                                        $subjectArray = explode(', ',  $subject_codes);
                                        foreach ($subjectArray as $subject_code) {
                                            $examtt = $con->prepare("SELECT `subject_code` FROM `tbl_exam_timetable` WHERE `subject_code`= ? and `sub_type`= 'theory' ");
                                            $examtt->bind_param("s", $subject_code);
                                            $examtt->execute();
                                            $examttres = $examtt->get_result();
                                            while ($rowtt = $examttres->fetch_assoc()) {
                                                $subject_c = $rowtt['subject_code'];
                                            }
                                            if ($examttres->num_rows > 0) {
                                    ?>
                                                <td style="border:1px solid black;"><?= $subject_c ?></td>
                                        <?php }
                                        } ?>
                                </tr>
                                <tr>
                                    <td style="border:1px solid black;">Date :</td>
                                    <?php
                                        $subject_codes = $row2['subject_code'];
                                        $subject_name = $row2['subject_name'];
                                        $subjectnameArray = explode(', ',  $subject_name);
                                        $subjectArray = explode(', ',  $subject_codes);
                                        foreach ($subjectArray as $subject_code) {
                                            $examtt = $con->prepare("SELECT `date` FROM `tbl_exam_timetable` WHERE `subject_code`= ? and `sub_type`= 'theory' ");
                                            $examtt->bind_param("s", $subject_code);
                                            $examtt->execute();
                                            $examttres = $examtt->get_result();
                                            while ($rowtt = $examttres->fetch_assoc()) {
                                                $subject_date = $rowtt['date'];
                                                $sdate = new DateTime($subject_date);
                                                $subject_date = $sdate->format("d-m-Y");
                                            }
                                            if ($examttres->num_rows > 0) {
                                    ?>
                                            <td style="border:1px solid black;"><?= $subject_date ?></td>
                                    <?php }
                                        } ?>
                                </tr>
                                <tr>
                                    <td style="border:1px solid black;">Time :</td>
                                    <?php
                                        $subject_codes = $row2['subject_code'];
                                        $subject_name = $row2['subject_name'];
                                        $subjectnameArray = explode(', ',  $subject_name);
                                        $subjectArray = explode(', ',  $subject_codes);
                                        foreach ($subjectArray as $subject_code) {
                                            $examtt = $con->prepare("SELECT `start_time`, `end_time` FROM `tbl_exam_timetable` WHERE `subject_code`= ? and `sub_type`= 'theory' ");
                                            $examtt->bind_param("s", $subject_code);
                                            $examtt->execute();
                                            $examttres = $examtt->get_result();
                                            while ($rowtt = $examttres->fetch_assoc()) {
                                                $start_time = $rowtt['start_time'];
                                                $end_time = $rowtt['end_time'];
                                                $start_time = date("h:i A", strtotime($start_time));
                                                $end_time = date("h:i A", strtotime($end_time));
                                            }
                                            if ($examttres->num_rows > 0) {
                                    ?>
                                            <td style="border:1px solid black;"><?= $start_time . ' To ' . $end_time ?></td>
                                <?php }
                                        }
                                    } ?>
                                </tr>
                                <tr>
                                    <td style="border:1px solid black;">Signature of Invigilator</td>
                                    <td style="border:1px solid black;"></td>
                                    <td style="border:1px solid black;"></td>
                                    <td style="border:1px solid black;"></td>
                                    <td style="border:1px solid black;"></td>
                                    <td style="border:1px solid black;"></td>
                                    <td style="border:1px solid black;"></td>
                                    <td style="border:1px solid black;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="text-left mt-5">
                    <p style="text-align:justify"><strong><span style="font-size:15px"><span style="font-family:Arial,Helvetica,sans-serif"><span dir="ltr" lang="EN-IN">Note :</span></span></span></strong></p>
                    <ul>
                        <li>Students will have to take their seats in exam hall before 30 minutes of exam start time.</li>
                        <li>Students will be allowed to enter in the exam hall only up to 10 minutes after the exam start time.</li>
                        <li>Students will be allowed to leave the examination hall only after an hour of exam start time.</li>
                        <li>Students are informed to visit GMIU website regularly for various exam related information.</li>
                    </ul>

                </div>
                <div class="row ">
                    <div class="col-8"></div>
                    <div class="col-4" style="height: 100px; display: flex; align-items: end; justify-content: center;">
                        <div class="text-center">
                            <div class="row">
                                <img class="mx-auto" src="<?=$website_assets_url ?>images/signature/vdu-sign.png" style="width:100px;">
                            </div>
                            <p class="border-top">Controller Of Examination</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Print Button -->
            <div class="text-center m-5">
                <a class="btn btn-info print-btn" href="examform.php"><i class="fa fa-arrow-left"></i> Back</a>
                <button class="btn btn-primary print-btn" onclick="window.print()"><i class="fa fa-print"></i> Print Receipt</button>
            </div>
        <?php
        } ?>
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