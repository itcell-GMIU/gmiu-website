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
                            <h1 class="m-0">View E-Brochure List</h1>
                        </div><!-- /.col -->

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View E-Brochure</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i>View E-Brochure</b></h5>
                                </center>
                            </span>
                        </div> <!-- /.card-header -->

                        <!-- card-body -->
                        <div class="card-body">

                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="faculty_brochure_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
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
                                        brochure.id as brochure_id, 
                                        faculty.name as faculty_name,
                                        level.name as level_name,
                                        brochure.document as brochure_document, 
                                        brochure.is_active as brochure_is_active 
                                    FROM tbl_faculty_brochure as brochure  
                                    LEFT JOIN tbl_faculty as faculty ON brochure.faculty_id = faculty.id 
                                    LEFT JOIN tbl_level as level ON brochure.level_id = level.id  
                                    WHERE brochure.is_delete = ?");
                                        $cmd->bind_param("i", $status);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $brochure_id = $row['brochure_id'];
                                            $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                            $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                            $brochure_document = !empty($row['brochure_document']) ? $row['brochure_document'] : "<b>N/A</b>";

                                            // Rest of your code remains the same


                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $brochure_id; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo  $faculty_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo  $level_name; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php if ($brochure_document == "document") {
                                                    ?>
                                                        <a href='../uploads/faculty_brochure/document/<?php echo $brochure_document ?>' target="_blank"><img src="../uploads/faculty_brochure/document/<?php echo $brochure_document ?>" alt="" style="width: 200px;"></a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a href='../uploads/faculty_brochure/document/<?php echo $brochure_document ?>' target="_blank"><?php echo $brochure_document; ?></a>
                                                    <?php   }

                                                    ?>
                                                </td>

                                                <td scope="row">
                                                    <a href="faculty_brochure_edit.php?id=<?php echo $row['brochure_id'] ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                      <?php if($role_id == 11) { ?>
                                                    <a href="faculty_brochure_delete.php?id=<?php echo $row['brochure_id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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