<?php
include 'include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>
    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Exam Form</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Exam Form</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <section class="content">
                <div class="card">
                    <div class="card-header bg-danger">
                        <div class="row">
                            <div class="h4 mx-auto h-100 my-auto">Exam Form dashboard</div>
                        </div>
                    </div>
                    <div class="card-body">
                         <p class="text-center bg-warning border border-dark"> 
                           Before filling out your exam form, check and update your personal information in the <a class="text-primary" href='editProfile.php'><i class="fa fa-edit"></i> Edit Profile</a>
                         </p>
                        <table class="table table-bordered table-responsive">
                            <thead class="thead">
                                <tr class="text-center">
                                    <th>Sr.No</th>
                                    <th style="width: 500px;">Detail</th>
                                    <th>Sem</th>
                                    <th class="text-nowrap">Exam Form Status (By Institute)</th>
                                    <th class="text-nowrap">Payment Last Date (For Student)</th>
                                    <th class="text-nowrap">Late Fee</th>
                                    <th class="text-nowrap">Payment Detail</th>
                                    <th class="text-nowrap">Payment Status & GMIU Reference No.</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                <?php
                                $cmd = $con->prepare("SELECT `id`, `faculty_id`, `level_id`, `program_id`, `semester`, `type`, `subject_code`, `session`, `start_date`, `end_date`, `year`, `late_fee`,`hallticket_status` FROM `tbl_exam_form` WHERE `is_active` = 1 AND `faculty_id` =? AND `level_id` =? AND `program_id`= ? AND `semester` = ?");
                                $cmd->bind_param("iiis", $faculty_id, $level_id, $program_id,$sem);
                                $cmd->execute();
                                $result = $cmd->get_result();
                                $i = 1;
                                if ($result->num_rows === 0) {
                                    // No data found, display a "No Data" row
                                    echo '<tr class="text-center"><td colspan="9">No Exam Form Found!</td></tr>';
                                } else {
                                    while ($row = $result->fetch_assoc()) {
                                        $exam_session = $row['session'];
                                        $semester_ex = $row['semester'];
                                        $late_fee_json = $row['late_fee'];
                                        $hallticket_status = $row['hallticket_status'];
                                        
                                        if ($row['type'] == "regular") {
                                            $exam_type = "REGULAR";
                                        } else {
                                            $exam_type = "REMEDIAL";
                                        }
                                        //exam name varible
                                        $exam_name = $faculty_name . ' ' . $program_name . ' SEMESTER ' . $semester_ex . ' <br> ' . $exam_type . ' ' . $row['session'] . ' - ' . $row['year'];

                                        $data[] = $row['subject_code'];
                                        $formattedData = implode(",", $data);
                                        $exam_id = $row['id'];
                                        $cmd2 = $con->prepare("SELECT `id`, `status`, `account_status`, `payment_status`, `transaction_id`, `payment_date` FROM `tbl_exam_student` WHERE `is_active` = 1 AND `exam_id` = ? AND `enrollnment_no` = ? ");
                                        $cmd2->bind_param("is", $exam_id, $er_no);
                                        $cmd2->execute();
                                        $result1 = $cmd2->get_result();
                                        while ($row1 = $result1->fetch_assoc()) {
                                            $exam_status = $row1['status'];
                                            $account_status = $row1['account_status'];

                                            $payment_status = $row1['payment_status'];
                                            $transaction_id = $row1['transaction_id'];
                                            $payment_date = $row1['payment_date'];
                                            $payment_date_new = date("d/m/Y h:i A", strtotime($payment_date));
                                            
                                            // expired date code
                                            $late_fee_data = json_decode($late_fee_json, true);

                                            // Get the current date
                                            $current_date = date('Y-m-d');

                                            $dateexpc = 0;
                                            foreach ($late_fee_data as $entry) {
                                                $dateexpc++;
                                            }
                                            $arraycount =  $dateexpc-1;

                                            // Get the last fetch end_date
                                            $last_fetch_end_date = $late_fee_data[$arraycount]['ending_date'];

                                            // Check if the current date is greater than the last fetch end_date
                                            if ($current_date > $last_fetch_end_date) {
                                                // Show expired
                                                $expired = 1;
                                            }elseif ($current_date <= $last_fetch_end_date) {
                                                // Show Not expired
                                                $expired = 0;
                                            }
                                            
                                            
                                            
                                            if ($exam_status == 0 || $account_status == 0) {
                                                $echo_status = '<span class="badge badge-info">Pending</span>';
                                                $form_status = '<p class="text-info">Not Eligible!</p>';
                                            } elseif ($exam_status == 1 && $account_status == 1) {
                                                $echo_status = '<span class="badge badge-success">Approved</span>';
                                            } elseif ($exam_status == 2 || $account_status == 2) {
                                                $form_status = '<p class="text-danger">Not Eligible!</p>';
                                                $echo_status = '<span class="badge badge-danger">Rejected</span>';
                                            } elseif ($exam_status == 3) {
                                                $echo_status = '<span class="badge badge-success">Form Filled</span>';
                                            }

                                            if ($payment_status == "success") {
                                                $pay_status = '<span class="badge badge-success">Successful</span>';
                                            }elseif ($payment_status == "failure") {
                                                $pay_status = '<span class="badge badge-danger">Failed</span>';
                                            }elseif ($payment_status == "userCancelled") {
                                                $pay_status = '<span class="badge badge-danger">User Cancelled</span>';
                                            } else {
                                                $pay_status = '<span class="badge badge-info">Pending</span>';
                                            }

                                            if ($transaction_id == NULL) {
                                                $transaction_id = "";
                                            }

                                            if ($payment_date == NULL) {
                                                $payment_date_new = "";
                                            }
                                        }
                                ?>
                                        <tr class="text-center">
                                            <td><?= $i ?></td>
                                            <td class="text-uppercase"><?php
                                                                        echo $exam_name;
                                                                        ?></td>

                                            <td><?= $row['semester'] ?></td>
                                            <td><?= $echo_status ?></td>
                                            <td><?= date("d/m/Y", strtotime($row['start_date'])) ?> To <?= date("d/m/Y", strtotime($row['end_date'])) ?></td>
                                            <td class="text-nowrap"><?php
                                                $jsonData = $row['late_fee'];

                                                // Decode the JSON data into a PHP array
                                                $dataArray = json_decode($jsonData, true);

                                                // Check if the decoding was successful
                                                if ($dataArray !== null) {
                                                    // Iterate through the entries
                                                    foreach ($dataArray as $entry) {
                                                        $startingDate = $entry['starting_date'];
                                                        $sdate = new DateTime($startingDate);
                                                        $startingDate = $sdate->format("d-m-Y");

                                                        $endingDate = $entry['ending_date'];
                                                        $edate = new DateTime($endingDate);
                                                        $endingDate = $edate->format("d-m-Y");

                                                        $lateFeeAmount = $entry['late_fee_amount'];


                                                        // Use these variables for each entry
                                                        echo "$startingDate To $endingDate";
                                                        echo "<br> Late Fee : $lateFeeAmount <br>";
                                                        echo "<br>"; // Add a line break between entriess
                                                    }
                                                } else {
                                                    echo "No Late Fee.";
                                                }
                                                ?>
                                            </td>
                                            <td><?php
                                                if ($payment_date != NULL) {
                                                    echo "Payment Done On ";
                                                    echo $payment_date_new;
                                                } else {
                                                    echo "---";
                                                }
                                                ?></td>
                                            <td><?= $pay_status ?><br>
                                                <?= $transaction_id ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($exam_status == 1 && $account_status == 1 && $expired == 0) { ?>
                                                    <a href="examform_payment.php?eid=<?= $exam_id ?>" class="btn btn-primary text-nowrap" style="width: 100px;">Go To Form</a>
                                            </td>
                                        <?php
                                                } elseif ($exam_status == 3) {
                                        ?>
                                            <a href="exam_reciept.php?eid=<?= $exam_id ?>" class="btn btn-success text-nowrap" style="width: 100px;"><i class="fa fa-file"></i> Receipt</a>
                                            <hr>
                                        <?php
                                                    if ($hallticket_status == 1 && $account_status == 1) {
                                            ?>
                                                <a href="exam_hall_ticket.php?eid=<?= $exam_id ?>" class="btn btn-info text-nowrap" style="width: 110px;"><i class="fa fa-file"></i> Hall Ticket</a>
                                        <?php
                                            }elseif ($account_status == 2) {
                                                    echo '<p class="text-danger">Meet Account Section For Hall Ticket Approval!</p>';
                                                }
                                                } elseif ($exam_status == 1 && $expired == 1) {
                                                    echo '<p class="text-danger">Filling Date Expired!</p>';
                                                }
                                        ?>
                                        </tr>
                                <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                         <p class="text-center bg-info border border-dark mt-3"> 
                          If the payment status is not reflected successfully, kindly wait for 24 hours. The payment status will be updated successfully after this 24-hour period.
                         </p>
                        <p class="text-center bg-light border border-dark mt-3"> 
                            For your queries, please contact: <a href='mailto:itcell@gmiu.edu.in'>itcell@gmiu.edu.in</a>
                         </p>
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
</body>

</html>