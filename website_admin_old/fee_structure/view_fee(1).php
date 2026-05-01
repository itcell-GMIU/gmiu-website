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
                            <h1 class="m-0">View Program List</h1>
                        </div><!-- /.col -->

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Program</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i>View Program</b></h5>
                                </center>
                            </span>
                        </div> <!-- /.card-header -->

                        <!-- card-body -->
                        <div class="card-body">

                            <!-- + ADD Button  -->
                            <!--<a class="btn btn-primary" style="margin-left: 90%;" href="program_insert.php"><i-->
                            <!--        class="fa-solid fa-plus"></i> Add</a>-->
                            <!-- + ADD Button End -->

                            <!-- table-responsive -->
                            <div class="table-responsive">

                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">

                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level Name</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Token</b></th>
                                            <th scope="row" style="color:black;"><b>Sem - 1</b></th>
                                            <th scope="row" style="color:black;"><b>Sem - 2</b></th>
                                            <th scope="row" style="color:black;"><b>Sem - 3</b></th>
                                            <th scope="row" style="color:black;"><b>Sem - 4</b></th>
                                            <th scope="row" style="color:black;"><b>Sem - 5</b></th>
                                            <th scope="row" style="color:black;"><b>Sem - 6</b></th>
                                            <th scope="row" style="color:black;"><b>Sem - 7</b></th>
                                            <th scope="row" style="color:black;"><b>Sem - 8</b></th>
                                            <th scope="row" style="color:black;"><b>Year Fee</b></th>
                                            <th scope="row" style="color:black;"><b>Status</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT pro.id as program_id, pro.name as program_name, pro.token as program_token,
                                                    pro.remaining_fee as remaining_fee , pro.yearfee as yearfee, sem1,sem2,sem3,sem4,sem5,sem6,sem7,sem8, pro.is_active as program_is_active, 
                                                    faculty.name as faculty_name, level.name as level_name, level.id as level_id FROM tbl_program as pro
                                                    LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id 
                                                    LEFT JOIN tbl_level level ON pro.level_id = level.id WHERE pro.is_delete = ?");
                                        $cmd->bind_param("i", $status);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $level_id = $row['level_id'];
                                            $program_id = $row['program_id'];
                                            $program_token = !empty($row['program_token']) ? $row['program_token'] : "<b>N/A</b>";
                                            $remaining_fee = !empty($row['remaining_fee']) ? $row['remaining_fee'] : "<b>N/A</b>";
                                            $yearfee = !empty($row['yearfee']) ? $row['yearfee'] : "<b>N/A</b>";
                                            $sem1 = !empty($row['sem1']) ? $row['sem1'] : "<b>N/A</b>";
                                            $sem2 = !empty($row['sem2']) ? $row['sem2'] : "<b>N/A</b>";
                                            $sem3 = !empty($row['sem3']) ? $row['sem3'] : "<b>N/A</b>";
                                            $sem4 = !empty($row['sem4']) ? $row['sem4'] : "<b>N/A</b>";
                                            $sem5 = !empty($row['sem5']) ? $row['sem5'] : "<b>N/A</b>";
                                            $sem6 = !empty($row['sem6']) ? $row['sem6'] : "<b>N/A</b>";
                                            $sem7 = !empty($row['sem7']) ? $row['sem7'] : "<b>N/A</b>";
                                            $sem8 = !empty($row['sem8']) ? $row['sem8'] : "<b>N/A</b>";
                                            $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                            $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                            $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                            $program_is_active = $row['program_is_active'];

                                            ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $program_id; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $faculty_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $level_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $program_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $program_token; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $sem1; ?>
                                                </td>
                                                 <td scope="row">
                                                    <?php echo $sem2; ?>
                                                </td>
                                                 <td scope="row">
                                                    <?php echo $sem3; ?>
                                                </td>
                                                 <td scope="row">
                                                    <?php echo $sem4; ?>
                                                </td>
                                                 <td scope="row">
                                                    <?php echo $sem5; ?>
                                                </td>
                                                 <td scope="row">
                                                    <?php echo $sem6; ?>
                                                </td>
                                                 <td scope="row">
                                                    <?php echo $sem7; ?>
                                                </td>
                                                 <td scope="row">
                                                    <?php echo $sem8; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $yearfee; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php if ($program_is_active) {
                                                        echo "Active";
                                                    } else {
                                                        echo "Inactive";
                                                    } ?>
                                                </td>
                                                <td scope="row">
                                                    <a href="update_fee.php?program_id=<?php echo $row['program_id'] ?>&level_id=<?php echo $level_id ?>"
                                                        class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                    <?php if ($role_id == 11) { ?>
                                                        <a href="program_delete.php?program_id=<?php echo $row['program_id'] ?>"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>

                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level Name</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Token</b></th>
                                            <th scope="row" style="color:black;"><b>Sem - 1</b></th>
                                            <th scope="row" style="color:black;"><b>Sem - 2</b></th>
                                            <th scope="row" style="color:black;"><b>Sem - 3</b></th>
                                            <th scope="row" style="color:black;"><b>Sem - 4</b></th>
                                            <th scope="row" style="color:black;"><b>Sem - 5</b></th>
                                            <th scope="row" style="color:black;"><b>Sem - 6</b></th>
                                            <th scope="row" style="color:black;"><b>Sem - 7</b></th>
                                            <th scope="row" style="color:black;"><b>Sem - 8</b></th>
                                            <th scope="row" style="color:black;"><b>Year Fee</b></th>
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

    </div>
    <!-- ./wrapper -->

    <!-- Import JavaScript -->
    <?php include '../include/importjs.php'; ?>

</body>

</html>

<!-- UPDATE `tbl_program` SET `yearfee` = `regular`; -->