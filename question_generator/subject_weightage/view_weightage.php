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
                            <h1 class="m-0">View Subject Weightage</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Subject Weightage</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i>View Subject Weightage</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="insert_weightage.php"><i class="fa-solid fa-plus"></i> Add</a>
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
                                            <!-- <th scope="row" style="color:black;"><b>Chapter</b></th>
                                            <th scope="row" style="color:black;"><b>Chapter Weightage</b></th>
                                            <th scope="row" style="color:black;"><b>BL Level</b></th>
                                            <th scope="row" style="color:black;"><b>BL Weight</b></th> -->
                                            <th scope="row" style="color:black;"><b>Action</b></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $status = 0;

                                        // Prepare and execute the SQL query to fetch distinct subjects
                                        $cmd = $con->prepare("SELECT std.id as id, 
                                        corner.faculty_id as faculty_id, 
                                        corner.level_id as level_id, 
                                        corner.program_id as program_id, 
                                        corner.sem as sem, 
                                        std.subject_code as subject_code, 
                                        faculty.name as faculty_name, 
                                        level.name as level_name, 
                                        program.name as program_name 
                                        FROM tbl_weightage as std
                                        LEFT JOIN tbl_std_corner_exam AS corner ON std.subject_code = corner.id
                                        LEFT JOIN tbl_faculty AS faculty ON corner.faculty_id = faculty.id 
                                        LEFT JOIN tbl_level AS level ON corner.level_id = level.id 
                                        LEFT JOIN tbl_program AS program ON corner.program_id = program.id 
                                        WHERE std.is_delete = ? 
                                        GROUP BY std.subject_code");



                                        $cmd->bind_param("i", $status);

                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $faculty_id = $row['faculty_id'];
                                            $level_id = $row['level_id'];
                                            $program_id = $row['program_id'];
                                            $id = $row['id'];

                                            $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                            $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                            $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                            $sem = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                                            $subject_code = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                                            $chapter = !empty($row['chapter']) ? $row['chapter'] : "<b>N/A</b>";
                                            $chapter_weight = !empty($row['chapter_weight']) ? $row['chapter_weight'] : "<b>N/A</b>";


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
                                                    <?php
                                                    $cmd2 = $con->prepare("SELECT subject_code , subject_name from tbl_std_corner_exam where id = $subject_code ");
                                                    $cmd2->execute();
                                                    $result1 = $cmd2->get_result();
                                                    while ($row = $result1->fetch_assoc()) {
                                                        $subject_code1 = !empty($row['subject_code']) ? $row['subject_code'] : "<b>N/A</b>";
                                                        $subject_name = !empty($row['subject_name']) ? $row['subject_name'] : "<b>N/A</b>";
                                                        echo $subject_code1;
                                                    ?>
                                                </td>
                                                <td scope="row">
                                                <?php
                                                        $subject_name = !empty($row['subject_name']) ? $row['subject_name'] : "<b>N/A</b>";
                                                        echo $subject_name;
                                                    }
                                                ?>


                                                </td>

                                                <!-- <td scope="row">
                                                    <?php //echo $chapter;
                                                    ?>
                                                </td>

                                                <td scope="row">
                                                    <?php //echo $chapter_weight;
                                                    ?>
                                                </td> -->


                                                <td scope="row">
                                                    <a href="view_subject_weightage.php?id=<?php echo $subject_code ?>" class="btn btn-success"><i class="fas fa-eye"></i></a>
                                                    <a href="edit_weightage.php?id=<?php echo $subject_code ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="delete_weightage.php?id=<?php echo $subject_code ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
                                            <!-- <th scope="row" style="color:black;"><b>Chapter</b></th>
                                            <th scope="row" style="color:black;"><b>Chapter Weightage</b></th>
                                            <th scope="row" style="color:black;"><b>BL Level</b></th>
                                            <th scope="row" style="color:black;"><b>BL Weight</b></th> -->
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