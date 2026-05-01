<?php
include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"> View FAQ Content</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active"> View FAQ Content</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!--   Faculty list code  -->
                    <!--   Login Attempts View -->
                 <!-- Email Error Logs View -->
<div class="card mb-3">
    <div class="card">
        <div class="card-header">
            <center>
                <h5><b><i class="fas fa-envelope-open-text"></i> Email Error Logs</b></h5>
            </center>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table id="emailErrorLog" class="dataTableLoad table table-bordered table-striped">
                    <thead>
                        <tr align="center">
                            <th style="color:black;"><b>ID</b></th>
                            <th style="color:black;"><b>Student ID</b></th>
                            <th style="color:black;"><b>First Name</b></th>
                            <th style="color:black;"><b>Last Name</b></th>
                            <th style="color:black;"><b>Email</b></th>
                            <th style="color:black;"><b>Mail Status</b></th>
                            <th style="color:black;"><b>Mobile</b></th>
                            <th style="color:black;"><b>Faculty ID</b></th>
                            <th style="color:black;"><b>Level ID</b></th>
                            <th style="color:black;"><b>Program ID</b></th>
                            <th style="color:black;"><b>Created At</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cmd = $con->prepare("SELECT `id`, `admission_student_id`, `first_name`, `last_name`, `email`, `mail_status`, `mobile_number`, `faculty_id`, `level_id`, `program_id`, `created_at` FROM `tbl_email_error_log`");
                        $cmd->execute();
                        $result = $cmd->get_result();

                        while ($row = $result->fetch_assoc()) {
                            echo '<tr align="center">';
                            echo '<td>' . $row['id'] . '</td>';
                            echo '<td>' . htmlspecialchars($row['admission_student_id']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['first_name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['last_name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                            echo '<td>' . $row['mail_status'] .'</td>';
                            echo '<td>' . htmlspecialchars($row['mobile_number']) . '</td>';
                            echo '<td>' . $row['faculty_id'] . '</td>';
                            echo '<td>' . $row['level_id'] . '</td>';
                            echo '<td>' . $row['program_id'] . '</td>';
                            echo '<td>' . $row['created_at'] . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr align="center">
                            <th style="color:black;"><b>ID</b></th>
                            <th style="color:black;"><b>Student ID</b></th>
                            <th style="color:black;"><b>First Name</b></th>
                            <th style="color:black;"><b>Last Name</b></th>
                            <th style="color:black;"><b>Email</b></th>
                            <th style="color:black;"><b>Mail Status</b></th>
                            <th style="color:black;"><b>Mobile</b></th>
                            <th style="color:black;"><b>Faculty ID</b></th>
                            <th style="color:black;"><b>Level ID</b></th>
                            <th style="color:black;"><b>Program ID</b></th>
                            <th style="color:black;"><b>Created At</b></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


                    <!-- /.card-body -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include '../include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include '../include/importjs.php'; ?>
</body>

</html>