<?php
include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
    <style>
        /* CSS styles */
.image-cell {
    display: flex;
    flex-wrap: wrap;
}

.image-container {
    width: calc(25% - 4px);  /* Adjust the width of the image container as needed */
    margin: 2px; /* Add spacing between images */
}

.thumbnail {
    width: 100%; /* Make the image fill its container */
    height: auto; /* Maintain aspect ratio */
}
 
  </style>
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
                            <h1 class="m-0">View Advance Laboratories</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Advance Laboratories </li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- International Cell list code -->

                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-globe"></i> View Advance Laboratories</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="advance_laboratories_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="mm" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>Description</b></th>
                                            <th scope="row" style="color:black;"><b>Advance Laboratories Image</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $type = 5;
                                       $cmd = $con->prepare("SELECT id,title,description FROM tbl_campus WHERE is_delete = ? AND type_id= 10");
                                       $cmd->bind_param("i", $status);
                                       $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $mm_id = $row['id'];
                                            
                                            $title = !empty($row['title']) ? $row['title'] : "<b>N/A</b>";
                                            $description = !empty($row['description']) ? $row['description'] : "<b>N/A</b>";
                                         ?>
                                            
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $mm_id; ?>
                                                </td>
                                               
                                                <td scope="row">
                                                    <?php echo $title; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo str_replace(array("\n", "\r"), '', $description) ?>
                                                </td>
                                            
                                              
                                                <td scope="row" class="image-cell">
                                                    <?php
                                                   // Prepare and execute SQL query to fetch image file names
                                                   $type = "advance_laboratories";
                                                   $cmd = $con->prepare("SELECT photos.file_name AS file_name FROM `tbl_site_photos` AS photos WHERE photos.type = ? AND photos.type_id = ?");
                                                   $cmd->bind_param("si", $type, $mm_id);
                                                   $cmd->execute();
                                                   $photo_result = $cmd->get_result();

                                                    // Check if there are any images associated with the Faculty Development Program
                                                   if ($photo_result->num_rows > 0) {
                                                   // Loop through the result set and display each image
                                                   while ($row = $photo_result->fetch_assoc()) {
                                                   $file_name = $row['file_name'];
                                                   ?>
                                                      <div class="image-container">
                                                    <a href="<?php echo "../uploads/advance_laboratories/" . $file_name; ?>" target="_blank">
                                                     <img src="../uploads/advance_laboratories/<?php echo $file_name; ?>" alt="" class="thumbnail" >
                                                     </a>
                                                   </div>
                                                    <?php
                                                    }
                                                    } else {
                                                   // If no images are found, display a message
                                                     echo "<p>No images found for this Advance Laboratories.</p>";
                                                     }
                                                 ?>
                                                 </td>


                                                <td scope="row">
                                                    <a href="advance_laboratories_edit.php?mm_id=<?php echo $mm_id ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                    
                                                     <?php if($role_id == 11) { ?>
                                                    <a href="advance_laboratories_delete.php?mm_id=<?php echo $mm_id; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                       <?php } ?>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>Project Exhibition Image</b></th>
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
