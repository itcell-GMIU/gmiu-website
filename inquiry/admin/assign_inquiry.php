<?php
// Include necessary files
include '../include/checklogin.php';
// include '../include/importsidebar.php';

// Query to get inquiry assignments from tbl_faculty_assign_log
$cmd2 = $con->prepare(" SELECT 
                        log.id AS log_id, 
                        log.assign_by, 
                        log.staff_id, 
                        log.starting_id, 
                        log.ending_id, 
                        log.total, 
                        log.created_at, 
                        assigner.name AS assign_by_name, 
                        assignee.name AS staff_name
                            FROM tbl_faculty_assign_log log
                            LEFT JOIN tbl_staff assigner ON log.assign_by = assigner.id
                            LEFT JOIN tbl_staff assignee ON log.staff_id = assignee.id
                            WHERE log.total IS NOT NULL; ");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> <!-- /.Preloader -->


    <!-- wrapper -->
    <div class="wrapper">

        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php';
        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);
        ?>
        <!-- Navbar -->


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <!-- container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row mb-2">

                        <!-- col -->
                        <div class="col-sm-6">
                            <h1 class="m-0">View Assigned Inquiries</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Assigned Inquiries</li>
                            </ol>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div> <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">

                <!-- container-fluid -->

                <!-- card -->
                <div class="card">

                    <!-- card-header -->
                    <div class="card-header">
                        <span>
                            <center>
                                <h5><b><i class="fas fa-book-reader"></i> Assigned Inquiries</b></h5>
                            </center>
                        </span>
                    </div>
                    <!-- /.card-header -->

                    <!-- card-body -->
                    <div class="card-body">

                        <!-- table-responsive -->
                        <div class="table-responsive">

                            <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">

                                <thead>
                                    <tr align="center">
                                        <th scope="row" style="color:black;"><b>SN</b></th>
                                        <th scope="row" style="color:black;"><b>Assigned By</b></th>
                                        <th scope="row" style="color:black;"><b>Starting ID</b></th>
                                        <th scope="row" style="color:black;"><b>Ending ID</b></th>
                                        <th scope="row" style="color:black;"><b>Staff ID</b></th>
                                        <th scope="row" style="color:black;"><b>Staff Name</b></th>
                                        <th scope="row" style="color:black;"><b>Total Inquiries</b></th>
                                        <th scope="row" style="color:black;"><b>Created At</b></th>
                                       
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $sr = 0;
                                    $cmd2->execute();
                                    $result = $cmd2->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                        $log_id = $row['log_id'];
                                        $assign_by_name = !empty($row['assign_by_name']) ? $row['assign_by_name'] : "<b>N/A</b>";
                                        $starting_id = !empty($row['starting_id']) ? $row['starting_id'] : "<b>N/A</b>";
                                        $ending_id = !empty($row['ending_id']) ? $row['ending_id'] : "<b>N/A</b>";
                                        $staff_id_assign = !empty($row['staff_id']) ? $row['staff_id'] : "<b>N/A</b>";
                                        $staff_id_name = !empty($row['staff_name']) ? $row['staff_name'] : "<b>N/A</b>";
                                        $total = !empty($row['total']) ? $row['total'] : "<b>N/A</b>";
                                        $created_at = !empty($row['created_at']) ? $row['created_at'] : "<b>N/A</b>";
                                        $sr = $sr + 1;
                                    ?>
                                        <tr align="center">

                                            <td scope="row">
                                                <?php echo $sr; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $assign_by_name; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $starting_id; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $ending_id; ?>
                                            </td>
                                             <td scope="row">
                                                <?php echo $staff_id_assign; ?>
                                            </td>
                                             <td scope="row">
                                                <?php echo $staff_id_name; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $total; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $created_at; ?>
                                            </td>
                                          
                                        </tr>
                                    <?php } ?>

                                </tbody>

                                <tfoot>
                                    <tr align="center">
                                        <th scope="row" style="color:black;"><b>SN</b></th>
                                        <th scope="row" style="color:black;"><b>Assigned By</b></th>
                                        <th scope="row" style="color:black;"><b>Starting ID</b></th>
                                        <th scope="row" style="color:black;"><b>Ending ID</b></th>
                                        <th scope="row" style="color:black;"><b>Staff ID</b></th>
                                         <th scope="row" style="color:black;"><b>Staff Name</b></th>
                                        <th scope="row" style="color:black;"><b>Total Inquiries</b></th>
                                        <th scope="row" style="color:black;"><b>Created At</b></th>
                                       
                                    </tr>
                                </tfoot>

                            </table>
                        </div> <!-- /.table-responsove -->
                    </div> <!-- /.card-body -->
                </div> <!-- /.card -->
        </div><!-- /.container-fluid -->
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->

    <!-- footer -->
    <?php include '../include/importfooter.php'; ?>
    <!-- /.footer -->

    </div> <!-- ./wrapper -->

    <!-- Import JavaScript -->
    <?php include '../include/importjs.php'; ?>

</body>

</html>
