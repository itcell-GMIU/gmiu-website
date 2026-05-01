<?php include './include/checklogin.php';

$stmt = $con->prepare("
    SELECT 
        cr.id,
        cr.student_id,
        pac.pacid,
        pac.studentName AS student_name,
        f.name AS faculty_name,
        l.name AS level_name,
        p.name AS program_name,
        cr.followup_remark AS reason,
        cr.hod_status,
        cr.cluster_status,
        cr.account_status,
        cr.eligibility_status,
        cr.created_at
    FROM tbl_cancellation_requests AS cr
    INNER JOIN tbl_pac_form AS pac ON pac.student_id = cr.student_id
    INNER JOIN tbl_admission_student AS ads ON ads.id = cr.student_id
    LEFT JOIN tbl_faculty AS f ON f.id = ads.faculty_id
    LEFT JOIN tbl_level AS l ON l.id = ads.level_id
    LEFT JOIN tbl_program AS p ON p.id = ads.program_id
    WHERE cr.is_delete = 0
    ORDER BY cr.created_at DESC
");

$stmt->execute();
$result = $stmt->get_result();

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
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Cancellation Requests</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Cancellation Requests</li>
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
                                <div class="card-header">
                                    <h3 class="card-title">View Cancellation Requests</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">

                                            <thead>
                                                <tr>
                                                    <th>Request ID</th>
                                                    <th>Student ID</th>
                                                    <th>PAC ID</th>
                                                    <th>Student Name</th>
                                                    <th>Faculty</th>
                                                    <th>Program</th>
                                                    <th>Reason</th>
                                                    <th>HOD Status</th>
                                                    <th>Cluster Admin Status</th>
                                                    <th>Accounts Status</th>
                                                    <th>Eligibility Status</th>
                                                    <th>Created At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                                                        echo "<td>" . str_pad($row['pacid'], 4, '0', STR_PAD_LEFT) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['faculty_name']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['program_name']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['reason']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['hod_status']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['cluster_status']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['account_status']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['eligibility_status']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                                                        echo "<td><a href='view_cancellation_detail.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>View</a></td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='12' class='text-center'>No cancellation requests found.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Request ID</th>
                                                    <th>Student ID</th>
                                                    <th>PAC ID</th>
                                                    <th>Student Name</th>
                                                    <th>Faculty</th>
                                                    <th>Program</th>
                                                    <th>Reason</th>
                                                    <th>HOD Status</th>
                                                    <th>Cluster Admin Status</th>
                                                    <th>Accounts Status</th>
                                                    <th>Eligibility Status</th>
                                                    <th>Created At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <!-- ./wrapper -->

        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>

    <?php include 'include/importjs.php'; ?>
</body>

</html>