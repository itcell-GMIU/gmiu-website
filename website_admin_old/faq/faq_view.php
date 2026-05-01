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
                            <h1 class="m-0"> View FAQ Content</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active"> View FAQ Content</li>
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
                    <div class="card mb-3">
                        <div class="card">
                            <div class="card-header">
                                <span>
                                    <center>
                                        <h5><b><i class="fas fa-book-reader"></i> View FAQ Content</b></h5>
                                    </center>
                                </span>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">


                                <div class="table-responsive">
                                    <a class="btn btn-primary" style="margin-left: 90%;" href="faq_insert.php"><i class="fa-solid fa-plus"></i> Add </a>
                                    <!-- + ADD Button End -->
                                    <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                        <thead>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>ID</b></th>
                                                <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                                <th scope="row" style="color:black;"><b>Level</b></th>
                                                <!--<th scope="row" style="color:black;"><b>Description</b></th>-->
                                                <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $status = 0;

                                            $cmd = $con->prepare("SELECT level.name as level, faq.id as faq_id, faq.faq_description as faq_description,
                                               faculty.name as faculty_name,faq.faculty_id as faculty_id, faq.level_id as level_id
                                                FROM tbl_faq_management as faq 
                                                LEFT JOIN tbl_faculty faculty ON faq.faculty_id = faculty.id 
                                                LEFT JOIN tbl_level level ON faq.level_id = level.id
                                                WHERE faq.is_delete = ?");
                                            $cmd->bind_param("i", $status);

                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $faq_id = $row['faq_id'];
                                                $faq_description = !empty($row['faq_description']) ? $row['faq_description'] : "<b>N/A</b>";
                                                $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                                $level = !empty($row['level']) ? $row['level'] : "<b>N/A</b>";

                                            ?>
                                                <tr align="center">
                                                    <td scope="row">
                                                        <?php echo $faq_id; ?>
                                                    </td>

                                                    <td scope="row">
                                                        <?php echo $faculty_name; ?>
                                                    </td>
                                                    <td scope="row">
                                                        <?php echo $level; ?>
                                                    </td>
                                                    <!--<td scope="row">-->
                                                    <!--    <?php //echo $faq_description; ?>-->
                                                    <!--</td>-->

                                                    <td scope="row">
                                                        <a href="faq_edit.php?faq_id=<?php echo $row['faq_id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                          <?php if($role_id == 11) { ?>
                                                        <a href="faq_delete.php?faq_id=<?php echo $row['faq_id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
                                                <!--<th scope="row" style="color:black;"><b>Description</b></th>-->
                                                <th scope="row" style="color:black;"><b>Manage</b></th>
                                            </tr>
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