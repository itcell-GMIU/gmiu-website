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
                                    <h3 class="card-title">Branch Transfer Details</h3>
                                    <!-- <div class="d-flex ml-auto">
                                        <a href="pac_print.php?id=<?php echo $id; ?>"
                                            class="btn btn-sm btn-primary mr-1">Print</a>
                                    </div> -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr class='table-primary'>
                                                <td colspan='2'>
                                                    <strong>🎓 Current Student Information</strong>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $sql1 = "SELECT 
                                                    btr.id AS transfer_request_id,
                                                    btr.student_id,
                                                    s.token_amount,
                                                    pac.mode,
                                                    s.faculty_id,
                                                    f.name AS faculty_name,
                                                    s.program_id,
                                                    p.name AS program_name,
                                                    p.branch_code as branch_code,
                                                    s.level_id,
                                                    l.name AS level_name
                                                FROM tbl_branch_transfer_requests btr
                                                JOIN tbl_admission_student s ON btr.student_id = s.id
                                                JOIN tbl_pac_form pac ON btr.student_id = pac.student_id
                                                JOIN tbl_faculty f ON s.faculty_id = f.id
                                                JOIN tbl_program p ON s.program_id = p.id
                                                JOIN tbl_level l ON s.level_id = l.id
                                                WHERE btr.id = $id
                                                AND btr.is_active = 1
                                                AND btr.is_delete = 0;
                                                ";
                                            $result1 = $con->query($sql1);

                                            if ($result1->num_rows > 0) {
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    $facultyName1 = $row1['faculty_name'];
                                                    $levelName1 = $row1['level_name'];
                                                    $programInfo1 = $row1['program_name'] . " / " . $row1['branch_code'];


                                                    echo "<tr><td>Current Faculty</td><td>" . $facultyName1 . "</td></tr>";
                                                    echo "<tr><td>Current Level</td><td>" . $levelName1 . "</td></tr>";
                                                    echo "<tr><td>Current Program</td><td>" . $programInfo1 . "</td></tr>";
                                                    echo "<tr><td>New Mode</td><td>" . htmlspecialchars($row1['mode']) . "</td></tr>";
                                                    echo "<tr><td>Paid Token</td><td>" . htmlspecialchars($row1['token_amount']) . "</td></tr>";
                                                }

                                                echo "</tbody></table></td></tr>";

                                                // Faculty Remark
                                            } else {
                                                echo "<tr><td colspan='2'>No records found</td></tr>";
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Field</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

                                            $sql = "SELECT * FROM tbl_branch_transfer_requests WHERE id = $id AND is_active = 1 AND is_delete = 0";
                                            $result = $con->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {

                                                    echo "<tr class='table-active'><td colspan='2'><strong>🧑‍🎓 Student Information</strong></td></tr>";
                                                    echo "<tr><td>Student ID</td><td>" . htmlspecialchars($row['student_id']) . "</td></tr>";

                                                    // Faculty
                                                    $facultyName = "Not Applied For ";
                                                    if (!empty($row['faculty_id'])) {
                                                        $fid = (int) $row['faculty_id'];
                                                        $result1 = $con->query("SELECT name FROM tbl_faculty WHERE id = $fid");
                                                        if ($result1->num_rows > 0) {
                                                            $row1 = $result1->fetch_assoc();
                                                            $facultyName = $row1['name'];
                                                        }
                                                    }
                                                    echo "<tr><td>Faculty</td><td>" . $facultyName . "</td></tr>";

                                                    // Level
                                                    $levelName = "N/A";
                                                    if (!empty($row['level_id'])) {
                                                        $lid = (int) $row['level_id'];
                                                        $result2 = $con->query("SELECT name FROM tbl_level WHERE id = $lid");
                                                        if ($result2->num_rows > 0) {
                                                            $row2 = $result2->fetch_assoc();
                                                            $levelName = $row2['name'];
                                                        }
                                                    }
                                                    echo "<tr><td>Level</td><td>" . $levelName . "</td></tr>";

                                                    // Program
                                                    $programInfo = "N/A";
                                                    if (!empty($row['program_id'])) {
                                                        $pid = (int) $row['program_id'];
                                                        $result3 = $con->query("SELECT name, branch_code FROM tbl_program WHERE id = $pid");
                                                        if ($result3->num_rows > 0) {
                                                            $row3 = $result3->fetch_assoc();
                                                            $programInfo = $row3['name'] . " / " . $row3['branch_code'];
                                                        }
                                                    }
                                                    echo "<tr><td>Program</td><td>" . $programInfo . "</td></tr>";
                                                    echo "<tr><td>New Mode</td><td>" . htmlspecialchars($row['new_mode']) . "</td></tr>";
                                                    echo "<tr><td>Remaining Fee</td><td>" . htmlspecialchars($row['remaining_fee']) . "</td></tr>";

                                                    // Handwritten
                                                    echo "<tr><td>Handwritten File</td><td>";
                                                    if (!empty($row['handwritten_file'])) {
                                                        $path = '../followup_manager/uploads/handwritten/' . $row['handwritten_file'];
                                                        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                                            echo "<img src='$path' style='max-height: 80px; margin-right: 10px;' alt='Handwritten File'>";
                                                        }
                                                        echo "<a href='$path' target='_blank'>View File</a>";
                                                    }
                                                    echo "</td></tr>";
                                                    echo "<tr class='table-active'><td colspan='2'><strong>💵 Payment Details</strong></td></tr>";

                                                    // Receipt
                                                    echo "<tr><td>Receipt</td><td>";
                                                    if (!empty($row['receipt'])) {
                                                        $path = '../followup_manager/uploads/receipts/' . $row['receipt'];
                                                        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                                            echo "<img src='$path' style='max-height: 80px; margin-right: 10px;' alt='Receipt Image'>";
                                                        }
                                                        echo "<a href='$path' target='_blank'>View File</a>";
                                                    }
                                                    echo "</td></tr>";

                                                    // Passbook
                                                    echo "<tr><td>Passbook / Cheque</td><td>";
                                                    if (!empty($row['passbook_cheque'])) {
                                                        $path = '../followup_manager/uploads/passbook_cheques/' . $row['passbook_cheque'];
                                                        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                                            echo "<img src='$path' style='max-height: 80px; margin-right: 10px;' alt='Passbook Image'>";
                                                        }
                                                        echo "<a href='$path' target='_blank'>View File</a>";
                                                    }
                                                    echo "</td></tr>";

                                                    echo "<tr><td>Account Holder Name</td><td>" . htmlspecialchars($row['account_holder_name']) . "</td></tr>";
                                                    echo "<tr><td>Account Number</td><td>" . htmlspecialchars($row['account_number']) . "</td></tr>";
                                                    echo "<tr><td>IFSC Code</td><td>" . htmlspecialchars($row['ifsc_code']) . "</td></tr>";


                                                    // Approval Status Table
                                                    echo "<tr><td colspan='2'><strong>✅ Approval Status</strong></td></tr>";
                                                    echo "<tr><td colspan='2'>
                                                            <table class='table table-bordered table-sm mb-0'>
                                                                <thead class='thead-light'>
                                                                    <tr>
                                                                        <th>Role</th>
                                                                        <th>Status</th>
                                                                        <th>Remark</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>";

                                                    $roles = [
                                                        'HOD' => ['status' => $row['hod_approval'], 'remark' => $row['h_remark']],
                                                        'Cluster Admin' => ['status' => $row['clusteradmin_approval'], 'remark' => $row['c_remark']],
                                                        'Account' => ['status' => $row['account_approval'], 'remark' => $row['a_remark']],
                                                        'Student Section' => ['status' => $row['student_section_approval'], 'remark' => $row['s_remark']],
                                                    ];

                                                    foreach ($roles as $role => $info) {
                                                        $status = $info['status'];
                                                        $remark = $info['remark'];

                                                        // Status Icon
                                                        $icon = "⏳ Pending";
                                                        if ($status === 'approved') {
                                                            $icon = "✅ Approved";
                                                        } elseif ($status === 'rejected') {
                                                            $icon = "❌ Rejected";
                                                        }

                                                        echo "<tr>
                                                            <td>{$role}</td>
                                                            <td>{$icon}</td>
                                                            <td>" . (!empty($remark) ? htmlspecialchars($remark) : "<i>(empty)</i>") . "</td>
                                                        </tr>";
                                                    }

                                                    echo "</tbody></table></td></tr>";

                                                    // Faculty Remark
                                                    echo "<tr><td>Followup Manager Remark</td><td>" . (!empty($row['f_remark']) ? htmlspecialchars($row['f_remark']) : "<i>(empty)</i>") . "</td></tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='2'>No records found</td></tr>";
                                            }
                                            $con->close();
                                            ?>
                                        </tbody>
                                    </table>
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