<?php
include 'include/checklogin.php';
if (isset($_GET['eid'])) {
    $exam_id = $_GET['eid'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>
    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
    <style>
        .form_error_message {
            color: red;
        }

        span.error {
            color: #a94442;
            padding: 10px;
        }

        .square {
            height: auto;
            width: auto;
            border: 0.3px solid #727272;
            padding: 10px;
            border-radius: 5px;
        }

        .box-title .caption span {
            /* color: black; */
            /* text-decoration: underline; */
            font-size: 21px;
            padding: 0 0 10px;
            font-family: "Open Sans", sans-serif;
            color: #727272;
            line-height: 24px;
        }

        /* .box-form .form-body {
        padding: 20px !important;
    } */
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" id="main_form">
            <div class="content-header">
            </div>
            <section class="content">
                <div class="card">
                    <div class="card-header bg-danger">
                        <div class="row">
                            <div class="h4 mx-auto h-100 my-auto">Exam Form Payment dashboard</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-center text-danger bg-warning border border-dark">If you find any missing subject or any other abnormality in subject or its component, please contact to your respected college before pay the exam–fee.</p>
                        <div class="table-responsive">

                            <table class="table table-bordered ">
                                <?php
                                $cmd = $con->prepare("SELECT `id`, `faculty_id`, `level_id`, `program_id`, `semester`, `type`, `session`, `start_date`, `end_date`, `year`, `subject_fee`, `late_fee` FROM `tbl_exam_form` WHERE `is_active` = 1 AND `faculty_id` =? AND `level_id` =? AND `program_id`= ? AND `id` = ?");
                                $cmd->bind_param("iiii", $faculty_id, $level_id, $program_id, $exam_id);
                                $cmd->execute();
                                $result = $cmd->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    $semester_ex = $row['semester'];
                                    $subject_fee = $row['subject_fee'];
                                    $late_fee_json = $row['late_fee'];
                                    if ($row['type'] == "regular") {
                                        $exam_type = "REGULAR";
                                    } else {
                                        $exam_type = "REMEDIAL";
                                    }

                                    $exam_name = $faculty_name . ' ' . $program_name . ' SEMESTER ' . $semester_ex . ' <br> ' . $exam_type . ' ' . $row['session'] . ' - ' . $row['year'];
                                ?>
                                    <thead class="thead">
                                        <tr class="text-center bg-light">
                                            <th>Exam :</th>
                                            <th colspan="7" class="text-uppercase"><?= $exam_name ?></th>
                                        </tr>
                                        <tr class="text-center">
                                            <th>Sr.No</th>
                                            <th>Subject Code</th>
                                            <th>Subject Name</th>
                                            <th>E</th>
                                            <th>M</th>
                                            <th>I</th>
                                            <th>V</th>
                                            <th>Sem</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        <?php

                                        $cmd2 = $con->prepare("SELECT `subject_code`, `subject_name` FROM `tbl_student_subjects` WHERE `enrollnment_no`= ? and `semester`= ? ");
                                        $cmd2->bind_param("si", $er_no, $semester_ex);
                                        $cmd2->execute();
                                        $result2 = $cmd2->get_result();
                                        $i = 1;
                                        while ($row2 = $result2->fetch_assoc()) {
                                            $subject_codes = $row2['subject_code'];
                                            $subject_name = $row2['subject_name'];
                                            $subjectnameArray = explode(', ',  $subject_name);
                                            $subjectArray = explode(', ',  $subject_codes);
                                            foreach ($subjectArray as $subject) {
                                                // Use a counter for the subject name array to keep track of matching names.
                                                $sub_name = current($subjectnameArray);

                                        ?>
                                                <tr class="text-center">
                                                    <td><?= $i ?></td>
                                                    <td><?= $subject ?></td>
                                                    <td><?= $sub_name ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><?= $semester_ex ?></td>
                                                </tr>
                                    <?php

                                                $i++;
                                                // Move to the next subject name, or reset to the beginning if there are no more names.
                                                if (next($subjectnameArray) === false) {
                                                    reset($subjectnameArray);
                                                }
                                            }
                                        }
                                        $form_fee = $subject_fee * ($i - 1);

                                        //late fees
                                        // Decode the JSON data
                                        $late_fee_data = json_decode($late_fee_json, true);

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
                                            // after expiry of date 
                                            // if ($current_date >= $starting_date && $current_date >= $ending_date) {
                                            //     $late_fee = $late_fee_amount;
                                            //     break; // Break the loop once a match is found
                                            // }
                                        }

                                        $total_fees = $late_fee + $form_fee;
                                        
                                        //update amount on table 
                                        $stmt = $con->prepare("UPDATE `tbl_exam_student` SET `fee_amount` = ? WHERE `exam_id` = ? AND `enrollnment_no` = ?");
                                        $stmt->bind_param("iis",$total_fees, $exam_id, $er_no);
                                        $result1 = $stmt->execute();
                                    }
                                    ?>
                                    </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-4">
                            <p class="p-0 m-0">Exam Form Amount : <i class="fa fa-inr" style="font-size: 12px;"></i> <?= $form_fee ?></p>
                            <!-- <p class="p-0 m-0">Penalty/Termextension Amount : <b>0</b></p> -->
                            <p class="p-0 m-0">Late Fees : <i class="fa fa-inr" style="font-size: 12px;"></i> <?= $late_fee ?></p>
                            <p>Total Fee Amount : <i class="fa fa-inr" style="font-size: 12px;"></i> <b><?= $total_fees ?><i></i></b></p>
                        </div>
                        <form method="post" id="paymentForm">
                            <div class="text-center border border-dark">
                                <div class="my-auto">
                                    <input type="checkbox" name="sub_check" id="sub_check" required>
                                    <label for="sub_check" class="m-0"> I have verified above Subjects/Subject Codes and I confirm the same.</label>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a href="examform.php" class="btn btn-info"><i class="fa fa-arrow-left"></i> Previous Page</a>
                                <input type="text" name="fees_amount" value="<?= $total_fees ?>" hidden>
                                <input type="text" name="ex_id" value="<?= $exam_id ?>" hidden>
                                <button type="submit" name="submit" class="btn btn-success ml-2"><i class="fa fa-credit-card-alt"></i> Pay Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include 'include/importjs.php'; ?>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://ebz-static.s3.ap-south-1.amazonaws.com/easecheckout/easebuzz-checkout.js"></script>
    <script>
        $('#paymentForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'pay.php',
                type: "post",
                data: $('#paymentForm').serialize(),
                success: function(data) {
                    var easebuzzCheckout = new EasebuzzCheckout('CRGPBR3D4U', 'prod');
                    var access_key = JSON.parse(data).data;
                    var options = {
                        access_key: access_key, // access key received via Initiate Payment
                        onResponse: (response) => {
                            // var pid = response.easepayid;
                            // var txnid = response.txnid;
                            // var surl = response.surl;
                            $.ajax({
                                url: 'checkout.php',
                                type: 'post',
                                data: {
                                    "response": response
                                },
                                success: function(data) {

                                    // location.reload();
                                    window.location.href = 'examform.php';
                                    $('#preloader').hide();

                                },
                                fail: function(xhr, textStatus, errorThrown) {
                                    alert('request failed');
                                }
                            });
                        },
                        theme: "#AB400C" // color hex
                    } 
                    easebuzzCheckout.initiatePayment(options);
                }
            })
        });
    </script>

</body>

</html>