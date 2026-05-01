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
                            <h1 class="m-0">View Circular</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Circular</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i>View Circular</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="circular_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>Type</b></th>
                                            <th scope="row" style="color:black;"><b>Date</b></th>
                                            <th scope="row" style="color:black;"><b>file_name</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                      $status = 0;
                                      $cmd = $con->prepare("SELECT clr.id as clr_id, clr.file_name as clr_file, clr.title as title, clr.date as date , clr.type as type FROM tbl_circular as clr
                                                          WHERE clr.is_delete = ?");
                                      $cmd->bind_param("i", $status); // "si" -> "i" since you're only binding one parameter
                                      $cmd->execute();
                                      $result = $cmd->get_result();
                                      
                                      while ($row = $result->fetch_assoc()) {
                                          $clr_id = $row['clr_id'];
                                          $type = $row['type'];
                                          $clr_file = !empty($row['clr_file']) ? $row['clr_file'] : "<b>N/A</b>";
                                          $title = !empty($row['title']) ? $row['title'] : "<b>N/A</b>"; // Remove the extra '$' before 'title'
                                          $date = !empty($row['date']) ? $row['date'] : "<b>N/A</b>";    // Remove the extra '$' before 'date'
                                      
                                          
                                      ?>
                                      
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $clr_id; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $title; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $type; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $date; ?>
                                                </td>
                                                <td scope="row">
                                                    <a href="../uploads/circular/<?php echo $clr_file; ?>" target="_blank"><?php echo $clr_file; ?></a>
                                                </td>
                                                <td scope="row">
                                                     <?php if($role_id == 11) { ?>
                                                    <a href="circular_delete.php?id=<?php echo $clr_id ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                        <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>Type</b></th>
                                            <th scope="row" style="color:black;"><b>Date</b></th>
                                            <th scope="row" style="color:black;"><b>file_name</b></th>
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