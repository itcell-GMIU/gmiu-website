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
                            <h1 class="m-0">View Event Reports</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Event Reports</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- Event reports list code -->
                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i> View Event Reports</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="event_report_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="reportTable" class="dataTableLoad table table-bordered table-striped">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Report Name</b></th>
                                            <th scope="row" style="color:black;"><b>Company Name</b></th>
                                            <th scope="row" style="color:black;"><b>Location</b></th>
                                            <th scope="row" style="color:black;"><b>Date</b></th>
                                            <th scope="row" style="color:black;"><b>Report File</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // SQL query to fetch data from tbl_event where unique_id is 'form_2'
                                        $sql = "SELECT id, report_ename, company_name, location, date, report FROM tbl_event WHERE unique_id = 'form_2'";
                                        $result = $con->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr align='center'>";
                                                echo "<td>" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                echo "<td>" . htmlspecialchars($row['report_ename'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                echo "<td>" . htmlspecialchars($row['company_name'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                echo "<td>" . htmlspecialchars($row['location'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                echo "<td>" . htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8') . "</td>";
                                                echo "<td><a href='" . htmlspecialchars($row['report'], ENT_QUOTES, 'UTF-8') . "' target='_blank'>View Report</a></td>";
                                                echo "<td>";
                                                echo "<a href='event_report_edit.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "' class='btn btn-primary btn-sm'>Edit</a> ";
                                                   if($role_id == 11) {
                                                echo "<a href='event_report_delete.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "' class='btn btn-danger btn-sm'>Delete</a>";
                                                   }
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7' align='center'>No reports found</td></tr>";
                                        }
                                        ?>
                                    </tbody>

                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Report Name</b></th>
                                            <th scope="row" style="color:black;"><b>Company Name</b></th>
                                            <th scope="row" style="color:black;"><b>Location</b></th>
                                            <th scope="row" style="color:black;"><b>Date</b></th>
                                            <th scope="row" style="color:black;"><b>Report File</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </tfoot>
                                </table>
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
