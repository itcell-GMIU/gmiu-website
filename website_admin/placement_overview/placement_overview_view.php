<?php
include '../include/checklogin.php';
echo $level_id;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!--<div id="preloader">-->
    <!--    <div id="status">&nbsp;-->

    <!--    </div>-->
    <!--</div>-->
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
                            <h1 class="m-0">View Placement Overview List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Placement Overview</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!--   Program list code  -->

                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>View Placement Overview</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="placement_overview_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Id</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level Name</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Year</b></th>
                                            <th scope="row" style="color:black;"><b>Registered Students</b></th>
                                            <th scope="row" style="color:black;"><b>Placed Students</b></th>
                                            <th scope="row" style="color:black;"><b>Placement Rate</b></th>
                                            <th scope="row" style="color:black;"><b>Highest Package</b></th>
                                            <th scope="row" style="color:black;"><b>Average Package</b></th>
                                            <th scope="row" style="color:black;"><b>Number of Companies Visited</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $status = 0;
                                        if($role_id == 8)
                                        {
                                            $cmd = $con->prepare("SELECT placement.id as id,placement.faculty_id as faculty_id,placement.level_id as level_id,placement.program_id as program_id, placement.placement_rat as placement_rat,placement.placed_students as placed_students,placement.registered_students as registered_students , placement.highest_package as highest_package,placement.average_package as average_package,placement.year as year,placement.is_active as program_is_active, placement.companies_visited as companies_visited,
                                            faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_placement_overview as placement
                                            LEFT JOIN tbl_faculty faculty ON placement.faculty_id = faculty.id 
                                            LEFT JOIN tbl_level level ON placement.level_id = level.id 
                                            LEFT JOIN tbl_program program ON placement.program_id = program.id WHERE placement.is_delete = ? and placement.faculty_id = ?  AND placement.level_id IN ($level_id)  and placement.program_id = ?");
                                        $cmd->bind_param("iii", $status, $faculty_id ,$program_id);

                                        }else{
                                        $cmd = $con->prepare("SELECT placement.id as id,placement.faculty_id as faculty_id,placement.level_id as level_id,placement.program_id as program_id, placement.placement_rat as placement_rat,placement.placed_students as placed_students,placement.registered_students as registered_students , placement.highest_package as highest_package,placement.average_package as average_package,placement.year as year,placement.is_active as program_is_active, placement.companies_visited as companies_visited,
                                            faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_placement_overview as placement
                                            LEFT JOIN tbl_faculty faculty ON placement.faculty_id = faculty.id 
                                            LEFT JOIN tbl_level level ON placement.level_id = level.id 
                                            LEFT JOIN tbl_program program ON placement.program_id = program.id WHERE placement.is_delete = ?");
                                        $cmd->bind_param("i", $status);
                                    }
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $level_id2 = $row['level_id'];
                                            $program_id = $row['program_id'];
                                            $id = $row['id'];
                                            $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                            $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                            $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                            $year = !empty($row['year']) ? $row['year'] : "<b>N/A</b>";
                                            $average_package = !empty($row['average_package']) ? $row['average_package'] : "<b>N/A</b>";
                                            $highest_package = !empty($row['highest_package']) ? $row['highest_package'] : "<b>N/A</b>";
                                            $placement_rat = !empty($row['placement_rat']) ? $row['placement_rat'] : "<b>N/A</b>";
                                            $placed_students = !empty($row['placed_students']) ? $row['placed_students'] : "<b>N/A</b>";
                                            $registered_students = !empty($row['registered_students']) ? $row['registered_students'] : "<b>N/A</b>";
                                            $companies_visited = !empty($row['companies_visited']) ? $row['companies_visited'] : "<b>N/A</b>";

                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $id; ?>
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
                                                    <?php echo $year; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $average_package; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $highest_package; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $placement_rat; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $placed_students; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $registered_students; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $companies_visited; ?>
                                                </td>

                                                <td scope="row">
                                                    <a href="placement_overview_edit.php?id=<?php echo $row['id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                      <?php if($role_id == 11) { ?>
                                                    <a href="placement_overview_delete.php?id=<?php echo $row['id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Id</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level Name</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Year</b></th>
                                            <th scope="row" style="color:black;"><b>Registered Students</b></th>
                                            <th scope="row" style="color:black;"><b>Placed Students</b></th>
                                            <th scope="row" style="color:black;"><b>Placement Rate</b></th>
                                            <th scope="row" style="color:black;"><b>Highest Package</b></th>
                                            <th scope="row" style="color:black;"><b>Average Package</b></th>
                                            <th scope="row" style="color:black;"><b>Number of Companies Visited</b></th>
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