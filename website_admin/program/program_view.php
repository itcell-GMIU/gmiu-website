<?php
// Include the checklogin.php file
include '../include/checklogin.php';
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
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
                            <a class="btn btn-primary" style="margin-left: 90%;" href="program_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->

                            <!-- table-responsive -->
                            <div class="table-responsive">

                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">

                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Shortable No</b></th>
                                            <th scope="row" style="color:black;"><b>Branch Code</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level Name</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Short Name</b></th>
                                            <th scope="row" style="color:black;"><b>Intake</b></th>
                                            <th scope="row" style="color:black;"><b>Duration</b></th>
                                            <th scope="row" style="color:black;"><b>Status</b></th>
                                            <th scope="row" style="color:black;"><b>Meta Description</b></th>
                                            <th scope="row" style="color:black;"><b>Meta Keywords</b></th>
                                            <th scope="row" style="color:black;"><b>Page Title</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT pro.id as program_id, pro.branch_code , pro.short_no as short_no, pro.name as program_name, pro.shortname as program_shortname, pro.intake as program_intake, pro.duration as program_duration, pro.is_active as program_is_active, 
                                                   pro.meta_description , pro.meta_keywords , pro.pageTitle , 
                                                    faculty.name as faculty_name, level.name as level_name, level.id as level_id FROM tbl_program as pro
                                                    LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id 
                                                    LEFT JOIN tbl_level level ON pro.level_id = level.id WHERE pro.is_delete = ?");
                                        $cmd->bind_param("i", $status);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $level_id = $row['level_id'];
                                            $program_id = $row['program_id'];
                                            $short_no = $row['short_no'];
                                            $branch_code = $row['branch_code'];
                                            $program_description = !empty($row['program_description']) ? $row['program_description'] : "<b>N/A</b>";
                                            $program_intake = !empty($row['program_intake']) ? $row['program_intake'] : "<b>N/A</b>";
                                            $program_duration = !empty($row['program_duration']) ? $row['program_duration'] : "<b>N/A</b>";
                                            $meta_description = !empty($row['meta_description']) ? $row['meta_description'] : "<b>N/A</b>";
                                            $meta_keywords = !empty($row['meta_keywords']) ? $row['meta_keywords'] : "<b>N/A</b>";
                                            $pageTitle = !empty($row['pageTitle']) ? $row['pageTitle'] : "<b>N/A</b>";
                                            $program_shortname = !empty($row['program_shortname']) ? $row['program_shortname'] : "<b>N/A</b>";
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
                                                    <?php echo $short_no; ?>
                                                </td>
                                                 <td scope="row">
                                                    <?php echo $branch_code; ?>
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
                                                    <?php echo $program_shortname; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $program_intake; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $program_duration; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php if ($program_is_active) {
                                                        echo "Active";
                                                    } else {
                                                        echo "Inactive";
                                                    } ?>
                                                </td>
                                                 <td scope="row">
                                                    <?php echo $meta_description; ?>
                                                </td>
                                                 <td scope="row">
                                                    <?php echo $meta_keywords; ?>
                                                </td>
                                                 <td scope="row">
                                                    <?php echo $pageTitle; ?>
                                                </td>
                                                <td scope="row">
                                                    <a href="program_edit.php?program_id=<?php echo $row['program_id'] ?>&level_id=<?php echo $level_id ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                      <?php if($role_id == 11) { ?>
                                                    <a href="program_delete.php?program_id=<?php echo $row['program_id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>

                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                             <th scope="row" style="color:black;"><b>Shortable No</b></th>
                                             <th scope="row" style="color:black;"><b>Branch Code</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level Name</b></th>
                                            <th scope="row" style="color:black;"><b>Name</b></th>
                                            <th scope="row" style="color:black;"><b>Short Name</b></th>
                                            <th scope="row" style="color:black;"><b>Intake</b></th>
                                            <th scope="row" style="color:black;"><b>Duration</b></th>
                                            <th scope="row" style="color:black;"><b>Status</b></th>
                                            <th scope="row" style="color:black;"><b>Meta Description</b></th>
                                            <th scope="row" style="color:black;"><b>Meta Keywords</b></th>
                                            <th scope="row" style="color:black;"><b>Page Title</b></th>
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