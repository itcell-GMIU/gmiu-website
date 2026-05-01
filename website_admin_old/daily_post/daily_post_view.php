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
                            <h1 class="m-0">View Daily Post List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active"> View Daily Post</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i> View Daily Post</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- + ADD Button  -->
                                <a class="btn btn-primary" style="margin-left: 90%;" href="daily_post_insert.php"><i class="fa-solid fa-plus"></i>Add</a>
                                <!-- + ADD Button End -->
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>View</b></th>
                                            <th scope="row" style="color:black;"><b>File Type</b></th>
                                            <th scope="row" style="color:black;"><b>Date</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT daily_post.id as daily_post_id, daily_post.file as daily_post_file, daily_post.file_type as daily_post_filetype ,daily_post.date as daily_post_date FROM tbl_daily_post as daily_post  
                                            WHERE daily_post.is_delete = ?");
                                        $cmd->bind_param("i", $status);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $daily_post_id = $row['daily_post_id'];
                                            $daily_post_file = !empty($row['daily_post_file']) ? $row['daily_post_file'] : "<b>N/A</b>";
                                            $daily_post_filetype = !empty($row['daily_post_filetype']) ? $row['daily_post_filetype'] : "<b>N/A</b>";
                                            $daily_post_date = !empty($row['daily_post_date']) ? $row['daily_post_date'] : "<b>N/A</b>";

                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $daily_post_id; ?>
                                                </td>

                                                <td scope="row" style="max-width:300px; overflow-x:scroll; display:flex; ">
                                                    <?php if ($daily_post_filetype == "image") {

                                                        // get file name from site photos
                                                        $status = 0;
                                                        $type = "daily_post";
                                                        $cmd = $con->prepare("SELECT photos.file_name as file_name  FROM `tbl_site_photos` as photos  where  photos.type = ? and photos.type_id = ?");
                                                        $cmd->bind_param("ss", $type, $daily_post_id);
                                                        $cmd->execute();
                                                        $result2 = $cmd->get_result();

                                                        while ($row = $result2->fetch_assoc()) {
                                                            $file_name  = !empty($row['file_name']) ? $row['file_name'] : "<b>N/A</b>";


                                                    ?>
                                                                <a href='<?php echo "../uploads/daily_post/" . $file_name ?>' target="_blank"><img src="../uploads/daily_post/<?php echo $file_name ?>" alt="" style="height: 200px; width:300px;"></a>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <a href='<?php echo $daily_post_file ?>' target="_blank"><?php echo $daily_post_file; ?></a>
                                                    <?php   }

                                                    ?>

                                                </td>
                                                <td scope="row">
                                                    <?php echo $daily_post_filetype; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $daily_post_date; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php if($role_id == 11  OR $role_id == 10) { ?>
                                                    <a href="daily_post_delete.php?daily_post_id=<?php echo $daily_post_id ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>View</b></th>
                                            <th scope="row" style="color:black;"><b>File Type</b></th>
                                            <th scope="row" style="color:black;"><b>Date</b></th>
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