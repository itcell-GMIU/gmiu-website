<?php
// Include the checklogin.php file
include '../include/checklogin.php';
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

        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>

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
                            <h1 class="m-0">View Faculty List</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Faculty</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div> <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <!-- container-fluid -->
                <div class="container-fluid">

                    <!-- card -->
                    <div class="card">
                        <!-- card-header -->
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>View Faculty</b></h5>
                                </center>
                            </span>
                        </div> <!-- /.card-header -->

                        <!-- card-body -->
                        <div class="card-body">

                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="faculty_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->

                            <!-- table-responsive -->
                            <div class="table-responsive">

                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Shortname</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Status</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT faculty.id as faculty_id, faculty.shortname as faculty_shortname, faculty.name as faculty_name, faculty.description as faculty_description, faculty.is_active as faculty_is_active FROM tbl_faculty as faculty WHERE `is_delete` = ?");
                                        $cmd->bind_param("i", $status);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $faculty_id = $row['faculty_id'];
                                            $faculty_shortname = !empty($row['faculty_shortname']) ? $row['faculty_shortname'] : "<b>N/A</b>";
                                            $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                            $faculty_description = !empty($row['faculty_description']) ? $row['faculty_description'] : "<b>N/A</b>";
                                            $faculty_is_active = $row['faculty_is_active'];
                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $faculty_id; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $faculty_shortname; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $faculty_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php if ($faculty_is_active) {
                                                        echo "Active";
                                                    } else {
                                                        echo "Inactive";
                                                    } ?>
                                                </td>
                                                <td scope="row">
                                                    <a href="faculty_edit.php?id=<?php echo $row['faculty_id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                      <?php if($role_id == 11) { ?>
                                                    <a href="faculty_delete.php?id=<?php echo $row['faculty_id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>

                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Shortname</b></th>
                                            <th scope="row" style="color: black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Status</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div> <!-- /.table-responsive -->
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