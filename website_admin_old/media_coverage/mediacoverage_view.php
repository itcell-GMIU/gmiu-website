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
                            <h1 class="m-0">View Media Coverage</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Media Coverage</li>
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
                                        <h5><b><i class="fas fa-book-reader"></i>View Media Coverage</b></h5>
                                    </center>
                                </span>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                               <!-- + ADD Button  -->
                               <a class="btn btn-primary" style="margin-left: 90%;" href="mediacoverage_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                               <!-- + ADD Button End -->
                                <div class="table-responsive">
                                    <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                        <thead>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>ID</b></th>
                                                <th scope="row" style="color:black;"><b>File Name</b></th>
                                                <th scope="row" style="color:black;"><b>File Type</b></th>
                                                <th scope="row" style="color:black;"><b>Alt Text</b></th>
                                                <th scope="row" style="color:black;"><b>Faculty</b></th>
                                                <th scope="row" style="color:black;"><b>Level</b></th>
                                                <th scope="row" style="color:black;"><b>Program</b></th>
                                                <th scope="row" style="color:black;"><b>is common</b></th>
                                                <!-- <th scope="row" style="color:black;"><b>Date</b></th> -->
                                                <th scope="row" style="color:black;"><b>Manage</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $status = 0;
                                            $cmd = $con->prepare("SELECT 
                                                                    mediacoverage.id AS mediacoverage_id,
                                                                    mediacoverage.is_common_reel,
                                                                    mediacoverage.file AS mediacoverage_file,
                                                                    mediacoverage.file_type AS mediacoverage_filetype,
                                                                    mediacoverage.alt_text AS alt_text,
                                                                    program.name AS program_name,
                                                                    faculty.name AS faculty_name,
                                                                    level.name AS level_name
                                                                FROM 
                                                                    tbl_media_coverage AS mediacoverage
                                                                LEFT JOIN 
                                                                    tbl_program AS program ON mediacoverage.program_id = program.id
                                                                LEFT JOIN 
                                                                    tbl_faculty AS faculty ON mediacoverage.faculty_id = faculty.id
                                                                LEFT JOIN 
                                                                    tbl_level AS level ON mediacoverage.level_id = level.id
                                                                WHERE 
                                                                    mediacoverage.is_delete = ?
                                                                ");
                                            $cmd->bind_param("i", $status);
                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            if ($result->num_rows >= 1){
                                             
                                            while ($row = $result->fetch_assoc()) {
                                                $mediacoverage_id = $row['mediacoverage_id'];
                                                $mediacoverage_filetype = !empty($row['mediacoverage_filetype']) ? $row['mediacoverage_filetype'] : "<b>N/A</b>";
                                                $mediacoverage_file = !empty($row['mediacoverage_file']) ? $row['mediacoverage_file'] : "<b>N/A</b>";
                                                   $alt_text = !empty($row['alt_text']) ? $row['alt_text'] : "<b>N/A</b>";


                                            ?>
                                                <tr align="center">
                                                    <td scope="row">
                                                        <?php echo $mediacoverage_id; ?>
                                                    </td>

                                                    <td scope="row">
                                                    <?php if ($mediacoverage_filetype == "image") {
?>
                                                        <a href='../uploads/media_coverage/<?php echo $mediacoverage_file; ?>' target="_blank"><img src="../uploads/media_coverage/<?php echo $mediacoverage_file ?>" alt="media_coverage" width="120px"></a>
                                               <?php     }
                                                    else
                                                    {?>
                                                        <a href='<?php echo $mediacoverage_file; ?>' target="_blank"><?php echo $mediacoverage_file ?></a>

                                                 <?php   }
                                                 ?>
                                                        </td>
                                                    <td scope="row">
                                                        <?php echo $mediacoverage_filetype; ?>
                                                    </td>
                                                     <td scope="row">
                                                        <?php echo $alt_text; ?>
                                                    </td>
                                                 <!-- Faculty -->
                                                    <td scope="row"><?php echo !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>"; ?></td>
                                                    
                                                    <!-- Level -->
                                                    <td scope="row"><?php echo !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>"; ?></td>
                                                    
                                                    <!-- Program -->
                                                    <td scope="row"><?php echo !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>"; ?></td>
                                                
                                                    <!-- is_common -->
                                                    <td scope="row">
                                                        <?php echo ($row['is_common_reel'] == 1) ? "Yes" : "No"; ?>
                                                    </td>
                                                    <td scope="row">
                                                         <!-- Edit Button -->
                                                        <a href="mediacoverage_edit.php?mediacoverage_id=<?php echo $row['mediacoverage_id']; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                        <?php if($role_id == 11 OR $role_id == 10) { ?>
                                                        <a href="mediacoverage_delete.php?mediacoverage_id=<?php echo $row['mediacoverage_id']; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                            <?php } }?>

                                        </tbody>
                                        <tfoot>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>ID</b></th>
                                                <th scope="row" style="color:black;"><b>File Name</b></th>
                                                <th scope="row" style="color:black;"><b>File Type</b></th>
                                                  <th scope="row" style="color:black;"><b>Alt Text</b></th>
                                                <th scope="row" style="color:black;"><b>Faculty</b></th>
                                                <th scope="row" style="color:black;"><b>Level</b></th>
                                                <th scope="row" style="color:black;"><b>Program</b></th>
                                                <th scope="row" style="color:black;"><b>is common</b></th>
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