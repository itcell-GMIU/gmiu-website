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
                            <h1 class="m-0">View Achievements</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Achievements</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i>View Achievements</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="achievement_insert.php"><i
                                    class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Image</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Type</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("
                                            SELECT ach.id as ach_id, ach.program_id as program_id, ach.type as type
                                            FROM tbl_achievement as ach
                                            WHERE ach.is_delete = ?
                                        ");
                                        $cmd->bind_param("i", $status);
                                        $cmd->execute();
                                        $result = $cmd->get_result();

                                        while ($row = $result->fetch_assoc()) {
                                            $ach_id = $row['ach_id'];
                                            $program_ids = $row['program_id'];
                                            $achievement_type = !empty($row['type']) ? $row['type'] : "<b>N/A</b>";

                                            // --- Fetch program name + level using FIND_IN_SET ---
                                            $program_display = [];
                                            $cmd2 = $con->prepare("
                                                SELECT p.name AS program_name, l.name AS level_name 
                                                FROM tbl_program p 
                                                LEFT JOIN tbl_level l ON p.level_id = l.id 
                                                WHERE FIND_IN_SET(p.id, ?)
                                            ");
                                            $cmd2->bind_param("s", $program_ids);
                                            $cmd2->execute();
                                            $res2 = $cmd2->get_result();
                                            while ($row2 = $res2->fetch_assoc()) {
                                                $pname = $row2['program_name'];
                                                $lname = $row2['level_name'];
                                                $program_display[] = $pname . " (" . $lname . ")";
                                            }

                                            $program_name = !empty($program_display) ? implode(', ', $program_display) : "<b>N/A</b>";
                                        ?>
                                            <tr align="center">
                                                <td scope="row"><?php echo $ach_id; ?></td>

                                                <td scope="row" style="max-width:300px; overflow-x:auto; display:flex;">
                                                    <?php
                                                    $type = "achievement";
                                                    $cmd1 = $con->prepare("SELECT file_name FROM `tbl_site_photos` WHERE type = ? AND type_id = ?");
                                                    $cmd1->bind_param("ss", $type, $ach_id);
                                                    $cmd1->execute();
                                                    $result2 = $cmd1->get_result();
                                                    while ($row1 = $result2->fetch_assoc()) {
                                                        $file_name  = !empty($row1['file_name']) ? $row1['file_name'] : "<b>N/A</b>";
                                                    ?>
                                                        <a href='<?php echo "../uploads/achievement/" . $file_name ?>' target="_blank">
                                                            <img src="../uploads/achievement/<?php echo $file_name ?>" alt="" style="height: 200px; width:300px;">
                                                        </a>
                                                    <?php } ?>
                                                </td>

                                                <td scope="row"><?php echo $program_name; ?></td>
                                                <td scope="row"><?php echo $achievement_type; ?></td>

                                                <td scope="row">
                                                    <a href="achievement_edit.php?ach_id=<?php echo $ach_id; ?>" class="btn btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <?php if ($role_id == 11) { ?>
                                                        <a href="achievement_delete.php?ach_id=<?php echo $ach_id; ?>" class="btn btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>



                                    </tbody>
                                    <tfoot>
                                        <tr align="center">

                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Image</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Type</b></th>
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

</html