<?php
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log');
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
                            <h1 class="m-0">View Bitly Multiple Post</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Bitly Multiple Post</li>
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
                                        <h5><b><i class="fas fa-book-reader"></i>View Bitly Multiple Post</b></h5>
                                    </center>
                                </span>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                               <!-- + ADD Button  -->
                               <a class="btn btn-primary" style="margin-left: 90%;" href="bitly_multiple_post_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                               <!-- + ADD Button End -->
                                <div class="table-responsive">
                                    <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                        <thead>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>ID</b></th>
                                                <th scope="row" style="color:black;"><b>Name</b></th>
                                                <th scope="row" style="color:black;"><b>File Name</b></th>
                                                <th scope="row" style="color:black;"><b>URL</b></th>
                                                <!-- <th scope="row" style="color:black;"><b>Date</b></th> -->
                                                <th scope="row" style="color:black;"><b>Manage</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $image= 'page';
                                            $status = 0;
                                            $cmd = $con->prepare("SELECT bitly.id as bitly_id, bitly.name as bitly_name, bitly.file as bitly_file, bitly.file_type as bitly_filetype FROM tbl_bitly_post as bitly  
                                            WHERE bitly.is_delete = ? and bitly.file_type = ?");
                                            $cmd->bind_param("is", $status, $image);
                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            if ($result->num_rows >= 1){
                                             
                                            while ($row = $result->fetch_assoc()) {
                                                $bitly_id = $row['bitly_id'];
                                                $bitly_name = $row['bitly_name'];
                                                $bitly_filetype = !empty($row['bitly_filetype']) ? $row['bitly_filetype'] : "<b>N/A</b>";
                                                $bitly_file = !empty($row['bitly_file']) ? $row['bitly_file'] : "<b>N/A</b>";

                                            ?>
                                                <tr align="center">
                                                    <td scope="row">
                                                        <?php echo $bitly_id; ?>
                                                    </td>
                                                    <td scope="row">
                                                        <?php echo $bitly_name; ?>
                                                    </td>

                                                    <td scope="row">
                                                    <?php
                                                   // Prepare and execute SQL query to fetch image file names
                                                   $type = "Bitly Multiple Post";
                                                   $cmd = $con->prepare("SELECT photos.file_name AS file_name FROM `tbl_site_photos` AS photos WHERE photos.type = ? AND photos.type_id = ?");
                                                   $cmd->bind_param("si", $type, $bitly_id);
                                                   $cmd->execute();
                                                   $photo_result = $cmd->get_result();

                                                    // Check if there are any images associated with the Faculty Development Program
                                                   if ($photo_result->num_rows > 0) {
                                                   // Loop through the result set and display each image
                                                   while ($row = $photo_result->fetch_assoc()) {
                                                   $file_name = $row['file_name'];
                                                   ?>
                                                    <a href="<?php echo "../uploads/bitly_post/" . $file_name; ?>" target="_blank">
                                                     <img src="../uploads/bitly_post/<?php echo $file_name; ?>" alt="" style="width: 100px;">
                                                     </a>
                                                    <?php
                                                    }
                                                    } else {
                                                   // If no images are found, display a message
                                                     echo "<p>No images found for this Faculty Development Program.</p>";
                                                     }
                                                 ?>
                                                        </td>
                                                    <td scope="row">
                                                                                                           
                                                            <a href="<?php echo $base_url_website."post/".$bitly_name.".php"; ?>" target="_blank"> <?php echo $base_url_website."post/".$bitly_name.".php"; ?></a>
                                                    </td>
                                                    

                                                    <td scope="row">
                                                    <a href="bitly_multiple_post_edit.php?id=<?php echo $bitly_id; ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                    
                                                     <?php if($role_id == 11) { ?>
                                                         <a href="bitly_multiple_post_delete.php?mid=<?php echo $bitly_id; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a> 
                                                         <?php } ?>
                                                         
                                                    </td>
                                                </tr>

                                            <?php } }?>

                                        </tbody>
                                        <tfoot>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>ID</b></th>
                                                <th scope="row" style="color:black;"><b>Name</b></th>
                                                <th scope="row" style="color:black;"><b>File Name</b></th>
                                                <th scope="row" style="color:black;"><b>URL</b></th>
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