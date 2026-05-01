<?php
include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>
    <!-- /.header -->

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <!-- /.Preloader -->

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
                            <h1 class="m-0">View Placement List</h1>
                        </div><!-- /.col -->

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Placement List</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i>View Placement List</b></h5>
                                </center>
                            </span>
                        </div> <!-- /.card-header -->

                        <!-- card-body -->
                        <div class="card-body">

                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="placement_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
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
                                            <th scope="row" style="color:black;"><b>Student Name</b></th>
                                            <th scope="row" style="color:black;"><b>Year</b></th>
                                            <th scope="row" style="color:black;"><b>Status</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        if($role_id == 8)
                                        {

                                            $status = 0;
                                        $cmd = $con->prepare("SELECT placement.id as placement_id,placement.student_name as placement_student_name, placement.year as placement_year,placement.is_active as placement_is_active, faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_placement as placement  
                                        LEFT JOIN tbl_faculty faculty ON placement.faculty_id = faculty.id 
                                        LEFT JOIN tbl_level level ON placement.level_id = level.id
                                        LEFT JOIN tbl_program program ON placement.program_id = program.id  WHERE placement.is_delete = ? and placement.faculty_id = ? and placement.level_id = ?   and placement.program_id = ?");
                                        $cmd->bind_param("iiii", $status, $faculty_id ,$level_id ,$program_id);
                                        }else{
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT placement.id as placement_id,placement.student_name as placement_student_name, placement.year as placement_year,placement.is_active as placement_is_active, faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_placement as placement  
                                        LEFT JOIN tbl_faculty faculty ON placement.faculty_id = faculty.id 
                                        LEFT JOIN tbl_level level ON placement.level_id = level.id
                                        LEFT JOIN tbl_program program ON placement.program_id = program.id  WHERE placement.is_delete = ?");
                                        $cmd->bind_param("i", $status);
                                        }
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $placement_id = $row['placement_id'];
                                            $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                            $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                            $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                            $placement_student_name = !empty($row['placement_student_name']) ? $row['placement_student_name'] : "<b>N/A</b>";
                                            $placement_year = !empty($row['placement_year']) ? $row['placement_year'] : "<b>N/A</b>";
                                            $placement_is_active = $row['placement_is_active'];
                                        ?>
                                            <tr align="center">
                                            <td scope="row">
                                                        <?php echo $placement_id; ?>
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
                                                        <?php echo $placement_student_name; ?>
                                                    </td>
                                                    <td scope="row">
                                                        <?php echo $placement_year; ?>
                                                    </td>
                                                    <td scope="row">
                                                    <?php if ($placement_is_active) {
                                                        echo "Active";
                                                    } else {
                                                        echo "Inactive";
                                                    } ?>
                                                </td>
                                                <td scope="row">
                                                    <a href="placement_edit.php?placement_id=<?php echo $row['placement_id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                      <?php //if($role_id == 11) { ?>
                                                    <a href="placement_delete.php?placement_id=<?php echo $row['placement_id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    <?php //} ?>
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
                                            <th scope="row" style="color:black;"><b>Student Name</b></th>
                                            <th scope="row" style="color:black;"><b>Year</b></th>
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