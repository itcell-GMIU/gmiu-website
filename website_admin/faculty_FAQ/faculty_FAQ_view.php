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
                            <h1 class="m-0">View FAQ List</h1>
                        </div><!-- /.col -->

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View FAQ</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i>View FAQ</b></h5>
                                </center>
                            </span>
                        </div> <!-- /.card-header -->

                        <!-- card-body -->
                        <div class="card-body">

                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="faculty_FAQ_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->

                            <!-- table-responsive -->
                            <div class="table-responsive">

                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty name</b></th>
                                            <th scope="row" style="color:black;"><b>Level name</b></th>
                                            <th scope="row" style="color:black;"><b>Document</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT 
                                        FAQ.id as FAQ_id, 
                                        faculty.name as faculty_name,
                                        level.name as level_name,
                                        FAQ.document as FAQ_document, 
                                        FAQ.is_active as FAQ_is_active 
                                    FROM tbl_faculty_faq as FAQ  
                                    LEFT JOIN tbl_faculty as faculty ON FAQ.faculty_id = faculty.id 
                                    LEFT JOIN tbl_level as level ON FAQ.level_id = level.id  
                                    WHERE FAQ.is_delete = ?");
                                        $cmd->bind_param("i", $status);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $FAQ_id = $row['FAQ_id'];
                                            $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                            $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                            $FAQ_document = !empty($row['FAQ_document']) ? $row['FAQ_document'] : "<b>N/A</b>";
                                           

                                            // Rest of your code remains the same


                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $FAQ_id; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo  $faculty_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo  $level_name; ?>
                                                </td>

                                                <td scope="row">
                                                    <a href='../uploads/faculty_FAQ/document/<?php echo $FAQ_document ?>' target="_blank"><?php echo $FAQ_document; ?></a>
                                                </td>

                                                <td scope="row">
                                                    <a href="faculty_FAQ_edit.php?id=<?php echo $row['FAQ_id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                      <?php if($role_id == 11) { ?>
                                                    <a href="faculty_FAQ_delete.php?id=<?php echo $row['FAQ_id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    <?php } ?>
                                                </td>

                                            </tr>

                                        <?php } ?>

                                    </tbody>

                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty name</b></th>
                                            <th scope="row" style="color:black;"><b>Level name</b></th>
                                            <th scope="row" style="color:black;"><b>Document</b></th>
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