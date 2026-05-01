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
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
    </div>
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
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View Student Corner</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Student Corner</li>
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
                                        <h5><b><i class="fas fa-book-reader"></i>View Student Corner</b></h5>
                                    </center>
                                </span>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- + ADD Button  -->
                               <a class="btn btn-primary" style="margin-left: 90%;" href="student_corner_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                               <!-- + ADD Button End -->
                                <div class="table-responsive">
                                    <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                        <thead>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>Id</b></th>
                                                <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                                <th scope="row" style="color:black;"><b>Level Name</b></th>
                                                <th scope="row" style="color:black;"><b>Program Name</b></th>
                                                <th scope="row" style="color:black;"><b>Sem</b></th>
                                                <th scope="row" style="color:black;"><b>Subject Code</b></th>
                                                <th scope="row" style="color:black;"><b>subject_name</b></th>
                                                <th scope="row" style="color:black;"><b>subject_short_name</b></th>
                                                <th scope="row" style="color:black;"><b>lectures</b></th>
                                                <th scope="row" style="color:black;"><b>tutorial</b></th>
                                                <th scope="row" style="color:black;"><b>practical</b></th>
                                                <th scope="row" style="color:black;"><b>credit</b></th>
                                                <th scope="row" style="color:black;"><b>syllabus</b></th>
                                                <th scope="row" style="color:black;"><b>Status</b></th>
                                                <th scope="row" style="color:black;"><b>Action</b></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                           
                                        $status = 0;

                                        // Explode the $level_id string into an array of individual level IDs
                                        $level_ids_array = explode(',', $level_id);

                                        // Create a placeholder string for the IN clause in SQL
                                        $level_placeholder = str_repeat('?,', count($level_ids_array) - 1) . '?';


                                         //   $placeholders = implode(',', array_fill(0, count($level_id), '?'));
                                            if($role_id == 8){
                                                $cmd = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.sem as sem, std.Syllabus as Syllabus, std.subject_code as subject_code, std.subject_name as subject_name, std.subject_short_name as subject_short_name, std.lectures as lectures, std.tutorial as tutorial, std.practical as practical, std.credit as credit, std.is_active as std_is_active, 
                                                faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_std_corner as std
                                                LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id 
                                                LEFT JOIN tbl_level level ON std.level_id = level.id 
                                                LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.is_delete = ? and std.faculty_id = ? and std.level_id IN ($level_placeholder) and std.program_id = ?");
                                              // Bind parameters with the IN clause using a loop
                                              $params = array_merge([$status, $faculty_id], $level_ids_array,[$program_id]);
                                              $types = str_repeat('i', count($params));
                                              $bind_params = [$types];
                                              foreach ($params as &$param) {
                                                $bind_params[] = &$param; // Pass each parameter by reference
                                            }

                                            call_user_func_array([$cmd, 'bind_param'], $bind_params);
                                            }else{
                                                $cmd = $con->prepare("SELECT std.id as id, std.faculty_id as faculty_id, std.level_id as level_id, std.program_id as program_id, std.sem as sem, std.Syllabus as Syllabus, std.subject_code as subject_code, std.subject_name as subject_name, std.subject_short_name as subject_short_name, std.lectures as lectures, std.tutorial as tutorial, std.practical as practical, std.credit as credit, std.is_active as std_is_active, 
                                            faculty.name as faculty_name,level.name as level_name ,program.name as program_name FROM tbl_std_corner as std
                                            LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id 
                                            LEFT JOIN tbl_level level ON std.level_id = level.id 
                                            LEFT JOIN tbl_program program ON std.program_id = program.id WHERE std.is_delete = ?");
                                             $cmd->bind_param("i", $status);
                                            }
                                           
                                           
                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $level_id = $row['level_id'];
                                                $program_id = $row['program_id'];
                                                $id = $row['id'];


                                                $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                                $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                                $Syllabus = !empty($row['Syllabus']) ? $row['Syllabus'] : "<b>N/A</b>";
                                                $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";            
                                                $sem = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                                                $subject_code = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                                                $subject_name = !empty($row['subject_name']) ? $row['subject_name'] : "<b>N/A</b>";
                                                $subject_short_name = !empty($row['subject_short_name']) ? $row['subject_short_name'] : "<b>N/A</b>";
                                                $lectures = !empty($row['lectures']) ? $row['lectures'] : "<b>N/A</b>";
                                                $tutorial = !empty($row['tutorial']) ? $row['tutorial'] : "<b>N/A</b>";
                                                $practical = !empty($row['practical']) ? $row['practical'] : "<b>N/A</b>";
                                                $credit = !empty($row['credit']) ? $row['credit'] : "<b>N/A</b>";
                                                $std_is_active = $row['std_is_active'];

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
                                                    <?php echo $sem; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $subject_code; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $subject_name; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $subject_short_name; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $lectures; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $tutorial; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $practical; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $credit; ?>
                                                </td>
                                                <td scope="row">
                                                <a href="../uploads/Syllabus/<?php echo $Syllabus; ?>" target="_blank"><?php echo $Syllabus;?></a>

                                            </td>

                                                <td scope="row">
                                                    <?php if ($std_is_active) {
                                                            echo "Active";
                                                        } else {
                                                            echo "Inactive";
                                                        } ?>
                                                </td>
                                                <td scope="row">
                                                    <a href="student_corner_edit.php?id=<?php echo $row['id'] ?>"
                                                        class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                          <?php if($role_id == 11) { ?>
                                                    <a href="student_corner_delete.php?id=<?php echo $row['id'] ?>"
                                                        class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
                                                <th scope="row" style="color:black;"><b>Sem</b></th>
                                                <th scope="row" style="color:black;"><b>Subject Code</b></th>
                                                <th scope="row" style="color:black;"><b>subject_name</b></th>
                                                <th scope="row" style="color:black;"><b>subject_short_name</b></th>
                                                <th scope="row" style="color:black;"><b>lectures</b></th>
                                                <th scope="row" style="color:black;"><b>tutorial</b></th>
                                                <th scope="row" style="color:black;"><b>practical</b></th>
                                                <th scope="row" style="color:black;"><b>credit</b></th>
                                                <th scope="row" style="color:black;"><b>syllabus</b></th>
                                                <th scope="row" style="color:black;"><b>Status</b></th>
                                                <th scope="row" style="color:black;"><b>Action</b></th>
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
     <!-- footer -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>