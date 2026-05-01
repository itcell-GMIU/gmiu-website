<?php
include '../include/checklogin.php';
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
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
                            <h1 class="m-0">View Daily Tasks</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Daily Tasks</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Daily Tasks list code -->
                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-tasks"></i> View Daily Tasks</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="dailytask_add.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="daily_tasks" class="dataTableLoad table table-bordered table-striped">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <!-- <th scope="row" style="color:black;"><b>Staff ID</b></th> -->
                                            <th scope="row" style="color:black;"><b>Task Date</b></th>
                                            <th scope="row" style="color:black;"><b>Time Slot</b></th>
                                            <th scope="row" style="color:black;"><b>Description</b></th>
                                            <th scope="row" style="color:black;"><b>Photo</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                       $status = 0;
                                       $role_id = // get the role_id from the session or another source
                                       
                                       // Base query
                                       $query = "SELECT id, task_date, time_slot, task_description, photo_path FROM tbl_daily_task WHERE is_delete = ?";
                                       
                                       // Modify query based on role_id
                                       if ($role_id == 22) {
                                           // Show all staff data
                                           $query .= "";
                                       } else{
                                           // Show only data for a specific staff member
                                           $query .= " AND staff_id = ?";
                                       }
                                       
                                       // Prepare and execute the query
                                       $cmd = $con->prepare($query);
                                     
                                       
                                       if ($role_id == 22) {
                                           $cmd->bind_param("i", $status);
                                       } else {
                                            $cmd->bind_param("ii", $status, $staff_id);
                                       }
                                       
                                       
                                       $cmd->execute();
                                       $result = $cmd->get_result();
                                       
                                       while ($row = $result->fetch_assoc()) {
                                           $id = $row['id'];
                                           // $staff_id = $row['staff_id']; // Commented out as it's not used
                                           $task_date = $row['task_date'];
                                           $time_slot = $row['time_slot'];
                                           $task_description = $row['task_description'];
                                           $photo_path = $row['photo_path'];
                                           // Process the fetched data
                                       
                                        ?>
                                            <tr align="center">
                                                <?php //echo  $role_id; ?> 
                                                <td scope="row"><?php echo $id; ?></td>
                                                <!-- <td scope="row"><?php //echo $staff_id; ?></td> -->
                                                <td scope="row"><?php echo $task_date; ?></td>
                                                <td scope="row"><?php echo $time_slot; ?></td>
                                                <td scope="row"><?php echo $task_description; ?></td>
                                               
                                                <td scope="row">
                                                    <?php
                                                   // Prepare and execute SQL query to fetch image file names
                                                   $type = "dailytask_add";
                                                   $cmd = $con->prepare("SELECT photos.file_name AS file_name FROM `tbl_inquiry_photos` AS photos WHERE photos.type = ? AND photos.type_id = ?");
                                                   $cmd->bind_param("si", $type, $id);
                                                   $cmd->execute();
                                                   $photo_result = $cmd->get_result();

                                                    // Check if there are any images associated with the Faculty Development Program
                                                   if ($photo_result->num_rows > 0) {
                                                   // Loop through the result set and display each image
                                                   while ($row = $photo_result->fetch_assoc()) {
                                                   $file_name = $row['file_name'];
                                                   ?>
                                                    <a href="<?php echo "../uploads/task_images/" . $file_name; ?>" target="_blank">
                                                     <img src="../uploads/task_images/<?php echo $file_name; ?>" alt="" style="width: 100px;">
                                                     </a>
                                                    <?php
                                                    }
                                                    } else {
                                                   // If no images are found, display a message
                                                     echo "<p>No images found.</p>";
                                                     }
                                                 ?>
                                                 </td>

                                                <td scope="row">
                                                    <a href="dailytask_update.php?id=<?php echo $id ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="dailytask_delete.php?id=<?php echo $id ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <!-- <th scope="row" style="color:black;"><b>Staff ID</b></th> -->
                                            <th scope="row" style="color:black;"><b>Task Date</b></th>
                                            <th scope="row" style="color:black;"><b>Time Slot</b></th>
                                            <th scope="row" style="color:black;"><b>Description</b></th>
                                            <th scope="row" style="color:black;"><b>Photo</b></th>
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
