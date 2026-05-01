<?php
include 'include/checklogin.php';
if (isset($_POST['submit'])) {
    $cancel_reason = mysqli_real_escape_string($con, $_POST['cancel_reason']);


    //validate data
    $cancel_reason = validate_data($cancel_reason);

    if (!file_exists("uploads/" . $student_id)) {
        mkdir("uploads/" . $student_id, 0777, true);
    }

    $targetDirectory = "uploads/" . $student_id . "/";
    $file_upload_status = upload_single_file($_FILES["fee_receipt"], $targetDirectory, 0);
    if ($file_upload_status['status'] == 200) {
        $file_name = $file_upload_status['message'];
        $stmt = $con->prepare("UPDATE `tbl_student_document` SET  fee_receipt = ? WHERE student_id = ? ");
        $stmt->bind_param("si", $file_name, $student_id);
        $result = $stmt->execute();
    }

    $file_name11 = $_FILES["application"];
    $targetDirectory = "uploads/" . $student_id . "/";
    $file_upload_status = upload_single_file($_FILES["application"], $targetDirectory, 0);
    if ($file_upload_status['status'] == 200) {
        $file_name = $file_upload_status['message'];
        $stmt = $con->prepare("UPDATE `tbl_student_document` SET  application = ? WHERE student_id = ? ");
        $stmt->bind_param("si", $file_name, $student_id);
        $result = $stmt->execute();
    }

    $admission_status = "cancel_request";
    $stmt = $con->prepare("UPDATE `tbl_admission_student` SET  cancel_reason = ?,admission_status=? WHERE id = ? ");
    $stmt->bind_param("ssi", $cancel_reason, $admission_status, $student_id);
    $result = $stmt->execute();
    if ($result) {
        $_SESSION['status'] = "Cancel Request Sent Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='cancel_admission.php'},1000);</script>";
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='cancel_admission.php'},1000)</script>";
    }
}

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>
</head>
<style>
    .badge {
        border-radius: 4px;
    }

    .tab-pane {
        position: relative;
        padding: 20px;
        border-radius: 9px;
        margin: 25px 0;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.13);
    }
</style>

<body>
    <!-- Preloader -->
    <!-- <div id="preloader">
    <div id="status">&nbsp;</div>
</div> -->
    <?php include 'include/importheader.php'; ?>

    <!-- Start Welcome Area section -->
    <section class="Welcome-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 Welcome-area-text">
                    <div class="row">
                        <div class="col-sm-12 section-header-box">
                            <div class="section-header section-header-l">
                                <h2>Cancel Admission Request & Refund</h2>
                            </div><!-- ends: .section-header -->
                        </div>
                    </div>
                    <div class="tab-pane">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <!-- <th scope="col">#</th> -->
                                        <!-- <th scope="col" colspan="2" valign='center' align='center'>Person Details</th> -->
                                        <!-- <th scope="col">Last</th> -->
                                        <!-- <th scope="col">Handle</th> -->
                                        <td colspan="2" class="dp"><b>Cancel Admission Request</b>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="center"><b>GR Number</b></td>
                                        <td>
                                            <?php echo $gr_number; ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="center"><b>Name</b></td>
                                        <td>
                                            <?php echo "$stu_first_name" . " " . "$stu_middle_name" . " " . "$stu_last_name"; ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="center"><b>Faculty</b></td>
                                        <td>
                                            <?php echo $stu_faculty_name; ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="center"><b>Level</b></td>
                                        <td>
                                            <?php echo $stu_level_name; ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="center"><b>Program</b></td>
                                        <td>
                                            <?php echo $stu_program_name; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center"><b>Payment Status</b></td>
                                        <td><?php echo strtoupper($payment_status);  ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center"><b>Amount Paid</b></td>
                                        <td><?php echo $token_amount;  ?>
                                        </td>
                                    </tr>

                                    <?php
                                    if ($stu_admission_status == "cancel_request") {
                                    ?>
                                        <tr>
                                            <td class="center"><b>Note</b></td>
                                            <td><b>
                                                    Your admission cancellation is currently being processed..</b></td>
                                        </tr>


                                    <?php    } elseif ($stu_admission_status == "cancel_approved") {
                                    ?>
                                        <tr>
                                            <td class="center"><b>Note</b></td>
                                            <td><b>
                                                    Your admission cancellation is Approved..</b></td>
                                        </tr>
                                    <?php   } elseif ($stu_admission_status == "cancel_rejected") {
                                    ?>
                                        <tr>
                                            <td class="center"><b>Note</b></td>
                                            <td><b>
                                                    Your admission cancellation is Rejected</b></td>
                                        </tr>
                                    <?php   } else {
                                    ?>
                                        <tr>
                                            <td class="center"><b>Cancel reason<span style="color: red;">*</span></b></td>
                                            <td><textarea name="cancel_reason" rows="4" cols="70" required></textarea></td>
                                        </tr>
                                        <tr>
                                            <td class="center"><b>Fee Receipt<span style="color: red;">*</span></b></td>
                                            <td><input type="file" name="fee_receipt" rows="5" cols="70" required></input></td>
                                        </tr>
                                        <tr>
                                            <td class="center"><b>Application</b></td>
                                            <td><input type="file" name="application" rows="6" cols="70" ></input></td>
                                        </tr>

                                        <tr>
                                            <th scope="row"></th>
                                            <td><input type="submit" name="submit" value="Submit"></td>
                                        </tr>
                                    <?php    }
                                    ?>


                                </tbody>
                            </table>
                        </form>
                    </div>
                </div><!-- Ends: . -->
                <!-- Ends: . -->
            </div>
        </div>
    </section><!-- Ends: . -->
    <!-- ./ End Welcome Area section -->


    <!-- ./ End Instraction Area section -->

    <!-- Footer Area section -->
    <?php include 'include/importfooter.php'; ?>
    <!-- ./ End Footer Area-->

    <!-- ============================
    JavaScript Files
    ============================= -->
    <?php include 'include/importjs.php'; ?>
</body>

</html>