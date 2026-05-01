<?php
include '../include/checklogin.php';

// Database connection check
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
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
                            <h1 class="m-0">View Event Report</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Event Report</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- Faculty list code -->
                    <div class="card mb-3">
                        <div class="card">
                            <div class="card-header">
                                <span>
                                    <center>
                                        <h5><b><i class="fas fa-book-reader"></i> View Event Report</b></h5>
                                    </center>
                                </span>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="table-responsive">
                                    <a class="btn btn-primary" style="margin-left: 90%;" href="event_report_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                                    <!-- + ADD Button End -->
                                    <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                        <thead>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>ID</b></th>
                                                <th scope="row" style="color:black;"><b>Event Name</b></th>
                                                <th scope="row" style="color:black;"><b>Event Date</b></th>
                                                <th scope="row" style="color:black;"><b>Event Description</b></th>
                                                <th scope="row" style="color:black;"><b>Report</b></th>
                                                <th scope="row" style="color:black;"><b>Manage</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $status = 0;

                                            // Assuming the correct ID column is `id`
                                            $cmd = $con->prepare("SELECT 
                                                event.id as id, 
                                                event.date as date,
                                                event.event_name as event_name, 
                                                event.event_description as event_detail, 
                                                event.report as report,
                                                event.event_year as event_year 
                                            FROM tbl_event_report as event 
                                            WHERE event.is_delete = ?");
                                            $cmd->bind_param("i", $status);
                                            $cmd->execute();
                                            $result = $cmd->get_result();

                                            while ($row = $result->fetch_assoc()) {
                                                $event_id = $row['id']; // Adjusted to the correct column name
                                                $report = !empty($row['report']) ? $row['report'] : "<b>N/A</b>";
                                                $date = !empty($row['date']) ? $row['date'] : "<b>N/A</b>";
                                                $event_name = !empty($row['event_name']) ? $row['event_name'] : "<b>N/A</b>";
                                                $event_detail = !empty($row['event_detail']) ? nl2br($row['event_detail']) : "<b>N/A</b>"; // Using nl2br
                                            ?>
                                                <tr align="center">
                                                    <td scope="row">
                                                        <?php echo $event_id; ?>
                                                    </td>
                                                    
                                                    <td scope="row">
                                                        <?php echo $event_name; ?>
                                                    </td>

                                                    <td scope="row">
                                                        <?php echo $date; ?>
                                                    </td>

                                                    <td scope="row">
                                                        <?php echo $event_detail; ?>
                                                    </td>


                                                    <td scope="row">
                                                        <a href='../uploads/event_report/report/<?php echo $report ?>' target="_blank"> <?php echo $report; ?></a>
                                                    </td>

                                                    <td scope="row">
                                                        <a href="event_report_edit.php?id=<?php echo $event_id ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                           <?php if($role_id == 11) { ?>
                                                        <a href="event_report_delete.php?id=<?php echo $event_id ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                           <?php } ?>
                                                    </td>
                                                </tr>

                                            <?php } ?>

                                        </tbody>
                                        <tfoot>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>ID</b></th>
                                                <th scope="row" style="color:black;"><b>Event Name</b></th>
                                                <th scope="row" style="color:black;"><b>Event Date</b></th>
                                                <th scope="row" style="color:black;"><b>Event Description</b></th>
                                                <th scope="row" style="color:black;"><b>Report</b></th>
                                                <th scope="row" style="color:black;"><b>Manage</b></th>
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
