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
                            <!-- <h1 class="m-0">Payment History</h1> -->
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Payment History</li>
                            </ol>
                        </div><!-- /.col -->
                    </div>

                </div>
            </div>
            <section class="content">
                <div class="card text-center">
                    <div class="card-header">
                        <p class="font-weight-bold m-0 p-0">Your Transactions</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ApplicationName</th>
                                    <th>MerchantOrderNo</th>
                                    <th>TransactionID</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>TransactionDate</th>
                                    <th>Session</th>
                                    <th>Course</th>
                                    <th>Sem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cmd2 = $con->prepare("SELECT * FROM `tbl_exam_student` WHERE `is_active` = 1 AND `enrollnment_no` = ?");
                                $cmd2->bind_param("s", $er_no);
                                $cmd2->execute();
                                $result1 = $cmd2->get_result();
                                while ($row1 = $result1->fetch_assoc()) {
                                    $exam_status = $row1['status'];
                                    $examID = $row1['exam_id'];
                                    $amount = $row1['fee_amount'];
                                    $account_status = $row1['account_status'];
                                    $ApplicationName = "Exam Form";
                                    $payment_status = $row1['payment_status'];
                                    $transaction_id = $row1['transaction_id'];
                                    $payment_date = $row1['payment_date'];
                                    $payment_id = $row1['payment_id'];
                                    $payment_date_new = date("d/m/Y h:i A", strtotime($payment_date));
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
                                    } elseif ($payment_status == "failure") {
                                        $pay_status = '<span class="badge badge-danger">Failed</span>';
                                    } elseif ($payment_status == "userCancelled") {
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

                                    $cmd3 = $con->prepare("SELECT * FROM `tbl_exam_form` WHERE `is_active` = 1 AND `id` = ?");
                                    $cmd3->bind_param("i", $examID);
                                    $cmd3->execute();
                                    $result3 = $cmd3->get_result();
                                    while ($row3 = $result3->fetch_assoc()) {
                                        $session = $row3['session'];
                                        $exyear = $row3['year'];
                                        $pr_id = $row3['program_id'];
                                        $exsem = $row3['semester'];

                                        $cmd4 = $con->prepare("SELECT * FROM `tbl_program` WHERE `is_active` = 1 AND `id` = ?");
                                        $cmd4->bind_param("i", $pr_id);
                                        $cmd4->execute();
                                        $result4 = $cmd4->get_result();
                                        while ($row4 = $result4->fetch_assoc()) {
                                            $p_name = $row4['name'];
                                        }

                                    }
                                ?>
                                    <tr>
                                        <td><?= $ApplicationName ?></td>
                                        <td><?= $transaction_id ?></td>
                                        <td><?= $payment_id ?></td>
                                        <td><?= $pay_status ?></td>
                                        <td><i class="fa fa-inr" style="font-size: 13px;"></i> <?= $amount ?></td>
                                        <td class="text-nowrap"><?= $payment_date_new ?></td>
                                        <td class="text-nowrap text-uppercase"><?= $session.'-'.$exyear ?></td>
                                        <td><?= $p_name ?></td>
                                        <td><?= $exsem ?></td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
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