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
                            <h1 class="m-0">View Time Table List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Time Table</li>
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

                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>View Time Table</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="timetable_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Sem</b></th>
                                            <th scope="row" style="color:black;"><b>Image</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT tt.id as tt_id, tt.img_name as img_name , faculty.name as faculty_name,level.name as level_name ,program.name as program_name, sem.sem as sem FROM tbl_timetable as tt  
                                            LEFT JOIN tbl_faculty faculty ON tt.faculty_id = faculty.id 
                                            LEFT JOIN tbl_level level ON tt.level_id = level.id
                                            LEFT JOIN tbl_program program ON tt.program_id = program.id 
                                            LEFT JOIN tbl_sem sem ON tt.sem_id = sem.id  
                                            WHERE tt.is_delete = ?");
                                        $cmd->bind_param("i", $status);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $tt_id = $row['tt_id'];
                                            $img_name = !empty($row['img_name']) ? $row['img_name'] : "<b>N/A</b>";
                                            $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                            $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                            $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                            $sem = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $tt_id; ?>
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
                                                    <?php echo $sem; ?>
                                                </td>

                                                <td scope="row">
                                                <a href="<?php echo "../uploads/timetable/" . $img_name; ?>" target="_blank"><img
                                                        src='<?php echo "../uploads/timetable/" . $img_name; ?>' alt=""
                                                        style="width: 200px;"></a>
                                                       
                                                </td>

                                                <td scope="row">
                                                  
                                                    <a href="timetable_delete.php?tt_id=<?php echo $row['tt_id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                   
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                        <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Sem</b></th>
                                            <th scope="row" style="color:black;"><b>Image</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
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