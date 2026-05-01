<?php
// Include the checklogin.php file
include '../include/checklogin.php';
include '../include/importsidebar.php';


$status = 0;
// If no program filter is applied, use the original query
$cmd2 = $con->prepare("SELECT staff.id as staff_id, 
                        staff.name as staff_name, 
                        staff.email as staff_email,
                        staff.password as staff_password,
                        staff.is_active as staff_is_active, 
                        srole.name as role_name 
                        FROM tbl_staff as staff
                        JOIN tbl_role as srole ON srole.id = staff.role_id 
                        WHERE staff.is_delete = ? 
                         AND staff.role_id IN ('8','51','54') ");
$cmd2->bind_param("i", $status);
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
                            <h1 class="m-0">View Staff Details</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Staff Details</li>
                            </ol>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div> <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">



                <!-- card -->
                <div class="card">

                    <!-- card-header -->
                    <div class="card-header">
                        <span>
                            <center>
                                <h5><b><i class="fas fa-book-reader"></i>View Staff Details</b></h5>
                            </center>
                        </span>
                    </div>
                    <!-- /.card-header -->

                    <!-- card-body -->
                    <div class="card-body">

                        <!-- + ADD Button  -->
                        <a class="btn btn-primary" style="margin-left: 90%;" href="staff_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                        <!-- + ADD Button End -->

                        <!-- table-responsive -->
                        <div class="table-responsive">

                            <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">

                                <thead>
                                    <tr align="center">
                                        <th scope="row" style="color:black;"><b>ID</b></th>
                                        <th scope="row" style="color:black;"><b>Role</b></th>
                                        <th scope="row" style="color:black;"><b>Staff Name</b></th>
                                        <th scope="row" style="color:black;"><b>Staff Email</b></th>
                                        <th scope="row" style="color: black;"><b>Password</b></th>
                                        <th scope="row" style="color:black;"><b>Status</b></th>
                                        <th scope="row" style="color:black;"><b>Manage</b></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $cmd2->execute();
                                    $result = $cmd2->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                        $staff_id = $row['staff_id'];
                                        $staff_role = $row['role_name'];
                                        $staff_name = !empty($row['staff_name']) ? $row['staff_name'] : "<b>N/A</b>";
                                        $staff_email = !empty($row['staff_email']) ? $row['staff_email'] : "<b>N/A</b>";
                                        $staff_password = !empty($row['staff_password']) ? $row['staff_password'] : "<b>N/A</b>";
                                        $staff_is_active = $row['staff_is_active'];

                                    ?>
                                        <tr align="center">
                                            <td scope="row">
                                                <?php echo $staff_id; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $staff_role; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $staff_name; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $staff_email; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $staff_password; ?>
                                            </td>
                                            </td>
                                            <td scope="row">
                                                <?php if ($staff_is_active) {
                                                    echo "Active";
                                                } else {
                                                    echo "Inactive";
                                                } ?>
                                            </td>
                                            <td scope="row">
                                                <a href="staff_edit.php?id=<?php echo $row['staff_id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                <?php if ($role_id == 11) { ?>
                                                    <a href="staff_delete.php?id=<?php echo $row['staff_id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>

                                <tfoot>
                                    <tr align="center">
                                        <th scope="row" style="color:black;"><b>ID</b></th>
                                        <th scope="row" style="color:black;"><b>Role</b></th>
                                        <th scope="row" style="color:black;"><b>Staff Name</b></th>
                                        <th scope="row" style="color:black;"><b>Staff Email</b></th>
                                        <th scope="row" style="color: black;"><b>Password</b></th>
                                        <th scope="row" style="color:black;"><b>Status</b></th>
                                        <th scope="row" style="color:black;"><b>Manage</b></th>
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