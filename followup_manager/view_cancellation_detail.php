<?php include './include/checklogin.php'; ?>
<?php $id = $_GET['id']; ?>

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
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View All Details</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View All Details</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-gmiu">
                                <div class="card-header d-flex">
                                    <h3 class="card-title">View Cancellation Details</h3>
                                    <!-- <div class="d-flex ml-auto">
                                        <a href="pac_print.php?id=<?php echo $id; ?>"
                                            class="btn btn-sm btn-primary mr-1">Print</a>
                                    </div> -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <?php
                                    // Fetch cancellation data once
                                    $cancellationQuery = "SELECT
                                                            tcr.*,
                                                            tas.first_name,
                                                            tas.middle_name,
                                                            tas.last_name,
                                                            tf.name AS faculty_name,
                                                            tl.name AS level_name,
                                                            tp.name AS program_name,
                                                            tas.admission_status,
                                                            tas.account_office_status,
                                                            tas.token_amount,
                                                            tas.payment_mode,
                                                            tas.payment_status,
                                                            tas.gr_number
                                                        FROM
                                                            tbl_cancellation_requests AS tcr
                                                        JOIN tbl_admission_student AS tas ON tcr.student_id = tas.id
                                                        JOIN tbl_faculty AS tf ON tf.id = tas.faculty_id
                                                        JOIN tbl_level AS tl ON tl.id = tas.level_id
                                                        JOIN tbl_program AS tp ON tp.id = tas.program_id
                                                        WHERE tcr.id = $id";

                                    $cancellationResult = $con->query($cancellationQuery);
                                    $cancel = $cancellationResult && $cancellationResult->num_rows > 0 ? $cancellationResult->fetch_assoc() : null;
                                    ?>

                                    <?php if ($cancel): ?>
                                        <!-- Table 1: Cancellation Request Details -->
                                        <table class="table table-bordered table-striped mb-4">
                                            <thead>
                                                <tr>
                                                    <th colspan="4" class="bg-primary text-center">📄 Cancellation Request
                                                        Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>Student Id</th>
                                                    <td><?= $cancel['student_id'] ?></td>
                                                    <th>PAC Id</th>
                                                    <td><?= $cancel['pac_id'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <td><?= htmlspecialchars($cancel['first_name'] . ' ' . $cancel['middle_name'] . ' ' . $cancel['last_name']) ?>
                                                    </td>
                                                    <th>Faculty</th>
                                                    <td><?= htmlspecialchars($cancel['faculty_name']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Level</th>
                                                    <td><?= htmlspecialchars($cancel['level_name']) ?></td>
                                                    <th>Program</th>
                                                    <td><?= htmlspecialchars($cancel['program_name']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Admission Status</th>
                                                    <td><?= htmlspecialchars($cancel['admission_status']) ?></td>
                                                    <th>Account Office Status</th>
                                                    <td><?= htmlspecialchars($cancel['account_office_status']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Token Amount</th>
                                                    <td><?= htmlspecialchars($cancel['token_amount']) ?></td>
                                                    <th>Payment Mode</th>
                                                    <td><?= htmlspecialchars($cancel['payment_mode']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Payment Status</th>
                                                    <td><?= htmlspecialchars($cancel['payment_status']) ?></td>
                                                    <th>GR Number</th>
                                                    <td><?= htmlspecialchars($cancel['gr_number']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Handwritten File</th>
                                                    <td colspan="2">
                                                        <?php
                                                        if (!empty($cancel['handwritten_file'])) {
                                                            $file = $base_url_followup_manager . 'uploads/handwritten/' . $cancel['handwritten_file'];
                                                            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'])) {
                                                                if ($ext === 'pdf') {
                                                                    echo "<a href='$file' target='_blank'>View PDF</a>";
                                                                } else {
                                                                    echo "<img src='$file' style='max-height: 80px; margin-right: 10px;' alt='Handwritten File'>";
                                                                    echo "<a href='$file' target='_blank'>View File</a>";
                                                                }
                                                            }
                                                        } else {
                                                            echo "N/A";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><strong>Followup Remark</strong></td>
                                                    <td colspan="2">
                                                        <?= !empty($cancel['followup_remark']) ? nl2br(htmlspecialchars($cancel['followup_remark'])) : "<i>(empty)</i>" ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!-- Table 2: Approval Status -->
                                        <table class="table table-bordered table-sm mb-4">
                                            <thead>
                                                <tr>
                                                    <th colspan="3" class="bg-primary text-center">✅ Approval Status</th>
                                                </tr>
                                                <tr class="thead-light">
                                                    <th>Role</th>
                                                    <th>Status</th>
                                                    <th>Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $roles = [
                                                    'HOD' => ['status' => $cancel['hod_status'], 'remark' => $cancel['hod_remark'], 'at' => $cancel['hod_at']],
                                                    'Cluster Admin' => ['status' => $cancel['cluster_status'], 'remark' => $cancel['cluster_remark'], 'at' => $cancel['cluster_at']],
                                                    'Account' => ['status' => $cancel['account_status'], 'remark' => $cancel['account_remark'], 'at' => $cancel['account_at']],
                                                    'Eligibility Section' => ['status' => $cancel['eligibility_status'], 'remark' => $cancel['eligibility_remark'], 'at' => $cancel['eligibility_at']],
                                                ];

                                                foreach ($roles as $role => $info):
                                                    $icon = "⏳ Pending";
                                                    if ($info['status'] === 'approved')
                                                        $icon = "✅ Approved";
                                                    elseif ($info['status'] === 'rejected')
                                                        $icon = "❌ Rejected";
                                                    ?>
                                                    <tr>
                                                        <td><?= $role ?></td>
                                                        <td><?= $icon ?></td>
                                                        <td><?= !empty($info['remark']) ? nl2br(htmlspecialchars($info['remark'])) : "<i>(empty)</i>" ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>

                                                <?php if ($cancel['is_refund_required'] !== null && $cancel['is_refund_required'] !== ''): ?>
                                                    <tr>
                                                        <td>Refund Status</td>
                                                        <td><?= $cancel['is_refund_required'] == 1 ? '✅ Approved' : '❌ Rejected' ?>
                                                        </td>
                                                        <td>N/A</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>

                                        <?php if ($cancel['is_refund_required'] != null && $cancel['is_refund_required'] != '' && $cancel['is_refund_required'] != 0): ?>
                                            <table class="table table-bordered table-striped mb-4">
                                                <tbody>
                                                    <tr>
                                                        <th colspan="4" class="bg-primary text-center">💵 Refund Detail</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Refund Amount</th>
                                                        <td><?= $cancel['refund_amount'] ?></td>
                                                        <th>Bank Name</th>
                                                        <td><?= $cancel['bank_name'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Account Number</th>
                                                        <td><?= $cancel['account_number'] ?></td>
                                                        <th>IFSC code</th>
                                                        <td><?= $cancel['ifsc_code'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2">Fee Receipt File</th>
                                                        <td colspan="2"><?php
                                                        if (!empty($cancel['fee_receipt_file'])) {
                                                            $file = $base_url_admin . 'uploads/fee_receipt_file/' . $cancel['fee_receipt_file'];
                                                            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf'])) {
                                                                if ($ext === 'pdf') {
                                                                    echo "<a href='$file' target='_blank'>View PDF</a>";
                                                                } else {
                                                                    echo "<img src='$file' style='max-height: 80px; margin-right: 10px;' alt='Handwritten File'>";
                                                                    echo "<a href='$file' target='_blank'>View File</a>";
                                                                }
                                                            }
                                                        } else {
                                                            echo "N/A";
                                                        }
                                                        ?></td>
                                                    </tr>
                                                </tbody>
                                            <?php endif; ?>
                                        </table>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <!-- ./wrapper -->
        <?php include 'include/importjs.php'; ?>
        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>


</body>

</html>