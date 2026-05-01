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
    <div id="preloader">
        <div id="status">&nbsp;

        </div>
    </div>
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
                            <h1 class="m-0">View Projects</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Projects</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i>View Projects</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="our_project_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Project Title</b></th>
                                            <th scope="row" style="color:black;"><b>Description</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;
                                        if ($role_id == 8) {

                                            // Explode the $level_id string into an array of individual level IDs
                                            $level_ids_array = explode(',', $level_id);

                                            // Create a placeholder string for the IN clause in SQL
                                            $level_placeholder = str_repeat('?,', count($level_ids_array) - 1) . '?';

                                            // Modify your SQL query to use the IN clause for level_id
                                            $cmd = $con->prepare("SELECT exp.id as exp_id, exp.faculty_id as faculty_id, exp.level_id as level_id, exp.program_id as program_id, exp.title1 as program_is_active, exp.is_active as program_is_active,
                    faculty.name as faculty_name, level.name as level_name, (SELECT GROUP_CONCAT(name SEPARATOR ', ') FROM tbl_program WHERE FIND_IN_SET(id, exp.program_id)) as program_name FROM tbl_our_project as exp 
                    LEFT JOIN tbl_faculty faculty ON exp.faculty_id = faculty.id 
                    LEFT JOIN tbl_level level ON exp.level_id = level.id
                    WHERE exp.is_delete = ? and exp.faculty_id = ? and exp.level_id IN ($level_placeholder) and exp.program_id = ?");

                                            // Bind parameters with the IN clause using a loop
                                            $params = array_merge([$status, $faculty_id], $level_ids_array, [$program_id]);
                                            $types = str_repeat('i', count($params));
                                            $bind_params = [$types];

                                            foreach ($params as &$param) {
                                                $bind_params[] = &$param; // Pass each parameter by reference
                                            }

                                            call_user_func_array([$cmd, 'bind_param'], $bind_params);
                                        } else {
                                            $cmd = $con->prepare("SELECT exp.id as exp_id, exp.faculty_id as faculty_id, exp.level_id as level_id, exp.program_id as program_id,exp.is_active as program_is_active, exp.title1 as title1,exp.description as description,  
                                                                faculty.name as faculty_name, level.name as level_name, (SELECT GROUP_CONCAT(name SEPARATOR ', ') FROM tbl_program WHERE FIND_IN_SET(id, exp.program_id)) as program_name FROM tbl_our_project as exp 
                                                                LEFT JOIN tbl_faculty faculty ON exp.faculty_id = faculty.id 
                                                                LEFT JOIN tbl_level level ON exp.level_id = level.id
                                                                WHERE exp.is_delete = ?");
                                            $cmd->bind_param("i", $status);
                                        }

                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $exp_id = $row['exp_id'];
                                            $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                            $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                            $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                            $title1 = !empty($row['title1']) ? $row['title1'] : "<b>N/A</b>";
                                            $description = !empty($row['description']) ? $row['description'] : "<b>N/A</b>";


                                            // $faculty_is_active = $row['faculty_is_active'];
                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $exp_id; ?>
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
                                                    <?php echo $title1; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $description; ?>
                                                </td>

                                                <td scope="row">
                                                    <a href="our_project_edit.php?exp_id=<?php echo $exp_id ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                      <?php if($role_id == 11) { ?>
                                                    <a href="our_project_delete.php?exp_id=<?php echo $exp_id ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    <?php } ?>
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
                                            <th scope="row" style="color:black;"><b>Project Title</b></th>
                                            <th scope="row" style="color:black;"><b>Description</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>

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