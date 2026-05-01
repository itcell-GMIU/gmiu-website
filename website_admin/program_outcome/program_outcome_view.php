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
                            <h1 class="m-0">View Program Outcome List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Program Outcome</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i>View Program Outcome</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="program_outcome_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Id</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level Name</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>status</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        if ($role_id == 8) {
                                            $status = 0;
                                            $cmd = $con->prepare("
SELECT 
    pro.id,
    pro.faculty_id,
    pro.level_id,
    pro.program_id,
    pro.title as program_title,
    pro.is_active as program_is_active,

    faculty.name as faculty_name,
    level.name as level_name,

    GROUP_CONCAT(program.name SEPARATOR ', ') as program_name

FROM tbl_program_outcome as pro

LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id 
LEFT JOIN tbl_level level ON pro.level_id = level.id 
LEFT JOIN tbl_program program ON FIND_IN_SET(program.id, pro.program_id)

WHERE 
    pro.is_delete = ? 
    AND pro.faculty_id = ? 
    AND pro.level_id IN($level_id)
    AND FIND_IN_SET(?, pro.program_id)

GROUP BY pro.id
");

                                            $cmd->bind_param("iii", $status, $faculty_id, $program_id);
                                        } else {
                                            $status = 0;
                                            $cmd = $con->prepare("
SELECT 
    pro.id,
    pro.faculty_id,
    pro.level_id,
    pro.program_id,
    pro.title as program_title,
    pro.is_active as program_is_active,

    faculty.name as faculty_name,
    level.name as level_name,

    GROUP_CONCAT(program.name SEPARATOR ', ') as program_name

FROM tbl_program_outcome as pro

LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id 
LEFT JOIN tbl_level level ON pro.level_id = level.id 
LEFT JOIN tbl_program program ON FIND_IN_SET(program.id, pro.program_id)

WHERE pro.is_delete = ?

GROUP BY pro.id
");

                                            $cmd->bind_param("i", $status);
                                        }
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $level_id = $row['level_id'];
                                            $program_id = $row['program_id'];
                                            $id = $row['id'];

                                            $program_intake = !empty($row['program_intake']) ? $row['program_intake'] : "<b>N/A</b>";
                                            $program_title = !empty($row['program_title']) ? $row['program_title'] : "<b>N/A</b>";
                                            $program_shortname = !empty($row['program_shortname']) ? $row['program_shortname'] : "<b>N/A</b>";
                                            $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                            $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                            $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                            $program_is_active = $row['program_is_active'];

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
                                                    <?php echo $program_title; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php if ($program_is_active) {
                                                        echo "Active";
                                                    } else {
                                                        echo "Inactive";
                                                    } ?>
                                                </td>
                                                <td scope="row">
                                                    <a href="program_outcome_edit.php?id=<?php echo $row['id'] ?>"
                                                        class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                    <?php if ($role_id == 11) { ?>
                                                        <a href="program_outcome_delete.php?id=<?php echo $row['id'] ?>"
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
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>status</b></th>
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
    <!-- footer -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>