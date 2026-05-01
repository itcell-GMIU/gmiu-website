<?php
// Include the checklogin.php file
include '../include/checklogin.php';
include '../include/importsidebar.php';


$role_id1 = "13,14,15,16";
$status = 0;

// Check if a program filter has been applied

// If no program filter is applied, use the original query
$cmd2 = $con->prepare("SELECT `id`, `call_type`, `call_title` FROM `tbl_call_status`");

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
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
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
                            <h1 class="m-0">View Call Status</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Call Status</li>
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
                                <h5><b><i class="fas fa-book-reader"></i>View Call Status</b></h5>
                            </center>
                        </span>
                    </div>
                    <!-- /.card-header -->

                    <!-- card-body -->
                    <div class="card-body">

                        <!-- + ADD Button  -->
                        <a class="btn btn-primary" style="margin-left: 90%;" href="call_status_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                        <!-- + ADD Button End -->

                        <!-- table-responsive -->
                        <div class="table-responsive">

                            <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">

                                <thead>
                                    <tr align="center">
                                        <th scope="row" style="color:black;"><b>SN</b></th>
                                        <th scope="row" style="color:black;"><b>Call Type</b></th>
                                        <th scope="row" style="color:black;"><b>Title</b></th>
                                        <!-- <th scope="row" style="color:black;"><b>Staff Email</b></th>
                                        <th scope="row" style="color:black;"><b>Password</b></th>
                                        <th scope="row" style="color:black;"><b>Status</b></th> -->
                                     <?php if ($role_id == 12) {?>
                                           <th scope="row" style="color:black;"><b>Manage</b></th>
                                    <?php } ?> 
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $sr = 0;
                                    $cmd2->execute();
                                    $result = $cmd2->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                        $call_type = $row['call_type'];
                                        $call_title = $row['call_title'];
                                        // $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                        // $staff_name = !empty($row['staff_name']) ? $row['staff_name'] : "<b>N/A</b>";
                                        // $staff_email = !empty($row['staff_email']) ? $row['staff_email'] : "<b>N/A</b>";
                                        // $staff_mobile_number = !empty($row['staff_mobile_number']) ? $row['staff_mobile_number'] : "<b>N/A</b>";
                                        // $staff_shortname = !empty($row['staff_shortname']) ? $row['staff_shortname'] : "<b>N/A</b>";
                                        // $pass = !empty($row['pass']) ? $row['pass'] : "<b>N/A</b>";
                                        // $staff_is_active = $row['staff_is_active'];
                                        $sr = $sr + 1;
                                    ?>
                                        <tr align="center">

                                            <td scope="row">
                                                <?php echo $sr; ?>
                                            </td>
                                            <td scope="row">
                                                   <?php
                                                    if ($call_type == 1) {
                                                        echo "Call Status";
                                                    } elseif ($call_type == 2) {
                                                        echo "Call Rating";
                                                    }
                                                    ?>
                                           </td>
                                            <td scope="row">
                                                <?php echo $call_title; ?>
                                            </td>
                                            <!-- <td scope="row">
                                                <?php //echo $staff_email; ?>
                                            </td>
                                            <td scope="row">
                                                <?php // echo $pass; ?>
                                            </td>
                                            <td scope="row">
                                                <?php //if ($staff_is_active) {
                                                   // echo "Active";
                                                //} else {
                                                   // echo "Inactive";
                                                //} ?>
                                            </td> -->
                                          <?php if ($role_id == 12) {?>   
                                          <td scope="row">
                                                <!-- <a href="staff_edit.php?id=<?php //echo $row['staff_id'] 
                                                                                ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a> -->
                                                <a href="call_status_delete.php?id=<?php echo $row['id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                            </td>
                                         <?php } ?> 
                                        </tr>
                                    <?php } ?>

                                </tbody>

                                <tfoot>
                                    <tr align="center">
                                        <th scope="row" style="color:black;"><b>SN</b></th>
                                        <th scope="row" style="color:black;"><b>Staff Name</b></th>
                                        <th scope="row" style="color: black;"><b>Staff Contact</b></th>
                                        <!-- <th scope="row" style="color: black;"><b>Staff Email</b></th>
                                        <th scope="row" style="color:black;"><b>Password</b></th>
                                        <th scope="row" style="color:black;"><b>Status</b></th> -->
                                      <?php if ($role_id == 12) {?>      <th scope="row" style="color:black;"><b>Manage</b></th>     <?php } ?> 
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
<script>
    document.getElementById("applyFilter").addEventListener("click", function() {
        // Get the selected program filter value
        var programFilter = document.getElementById("programFilter").value;

        // Redirect to the current page with the program filter as a query parameter
        window.location.href = "staff_view.php?programFilter=" + programFilter;
    });
</script>