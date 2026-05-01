<?php include './include/checklogin.php';

$stmt = $con->prepare("
    SELECT 
        pac.pacid as id,
        btr.student_id,
        btr.id AS btr_id,
        pac.studentName AS student_name,
        f.name as faculty_name,
        l.name as level_name,
        p.name as program_name,
        btr.new_mode,
        btr.new_quota,
        btr.hod_approval,
        btr.clusteradmin_approval,
        btr.account_approval,
        btr.student_section_approval,
        btr.is_active,
        btr.is_delete,
        btr.created_at,
        btr.updated_at
    FROM tbl_branch_transfer_requests AS btr
    INNER JOIN tbl_pac_form AS pac ON pac.student_id = btr.student_id
    LEFT JOIN tbl_faculty AS f ON f.id = btr.faculty_id
    LEFT JOIN tbl_level AS l ON l.id = btr.level_id
    LEFT JOIN tbl_program AS p ON p.id = btr.program_id
    WHERE btr.is_delete = 0
    ORDER BY btr.created_at DESC
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
                                <div class="card-header">
                                    <h3 class="card-title">PAC Form Details</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">

                                            <thead>
                                                <tr>
                                                    <th>PAC Form No</th>
                                                    <th>Student ID</th>
                                                    <th>Student Name</th>
                                                    <th>Requested Faculty</th>
                                                    <th>Requested Level</th>
                                                    <th>Requested Program</th>
                                                    <!--<th>Requested Quota</th>-->
                                                    <th>Requested Mode</th>
                                                    <th>Hod Approval</th>
                                                    <th>Cluster Admin Approval</th>
                                                    <th>Accounts Approval</th>
                                                    <th>Student Section Approval</th>
                                                    <th>View</th>
                                                    <!-- <th>View</th>
                                                    <th>Edit</th> -->
                                                    <!-- <th>Delete</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        $formatted_id = '2025/' . str_pad($row['id'], 4, '0', STR_PAD_LEFT);

                                                        echo "<td>" . htmlspecialchars($formatted_id) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['faculty_name']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['level_name']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['program_name']) . "</td>";
                                                        // echo "<td>" . htmlspecialchars($row['new_quota']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['new_mode']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['hod_approval']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['clusteradmin_approval']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['account_approval']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['student_section_approval']) . "</td>";
                                                        echo "<td><a href='detail_branch_request.php?id=" . $row['btr_id'] . "' class='btn btn-primary'>View</a></td>";
                                                        // echo "<td><a href='view_pac.php?id=" . urlencode($row['student_id']) . "' class='btn btn-info btn-sm'>View</a></td>";
                                                        // echo "<td><a href='edit_pac.php?id=" . urlencode($row['student_id']) . "' class='btn btn-warning btn-sm'>Edit</a></td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='10' class='text-center'>No records found.</td></tr>";
                                                }
                                                ?>
                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <th>PAC Form No</th>
                                                    <th>Student ID</th>
                                                    <th>Student Name</th>
                                                    <th>Requested Faculty</th>
                                                    <th>Requested Level</th>
                                                    <th>Requested Program</th>
                                                    <!--<th>Requested Quota</th>-->
                                                    <th>Requested Mode</th>
                                                    <th>Hod Approval</th>
                                                    <th>Cluster Admin Approval</th>
                                                    <th>Accounts Approval</th>
                                                    <th>Student Section Approval</th>
                                                    <th>View</th>
                                                    <!-- <th>View</th>
                                                    <th>Edit</th> -->
                                                    <!-- <th>Delete</th> -->
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