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
                            <h1 class="m-0">View Bitly Post</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Bitly Post</li>
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
                                        <h5><b><i class="fas fa-book-reader"></i>View Bitly Post</b></h5>
                                    </center>
                                </span>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                               <!-- + ADD Button  -->
                               <a class="btn btn-primary" style="margin-left: 90%;" href="bitly_post_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                               <!-- + ADD Button End -->
                                <div class="table-responsive">
                                    <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                        <thead>
                                            <tr align="center">
                                                <th scope="row" style="color:black;"><b>ID</b></th>
                                                <th scope="row" style="color:black;"><b>File Name</b></th>
                                                <th scope="row" style="color:black;"><b>File Type</b></th>
                                                <!-- <th scope="row" style="color:black;"><b>Date</b></th> -->
                                                <th scope="row" style="color:black;"><b>Manage</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $status = 0;
                                            $cmd = $con->prepare("SELECT bitly.id as bitly_id, bitly.file as bitly_file, bitly.file_type as bitly_filetype FROM tbl_bitly_post as bitly  
                                            WHERE bitly.is_delete = ?");
                                            $cmd->bind_param("i", $status);
                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            if ($result->num_rows >= 1){
                                             
                                            while ($row = $result->fetch_assoc()) {
                                                $bitly_id = $row['bitly_id'];
                                                $bitly_filetype = !empty($row['bitly_filetype']) ? $row['bitly_filetype'] : "<b>N/A</b>";
                                                $bitly_file = !empty($row['bitly_file']) ? $row['bitly_file'] : "<b>N/A</b>";

                                            ?>
                                                <tr align="center">
                                                    <td scope="row">
                                                        <?php echo $bitly_id; ?>
                                                    </td>

                                                    <td scope="row">
                                                    <?php if ($bitly_filetype == "image") {
?>
                                                        <a href='../uploads/bitly_post/<?php echo $bitly_file; ?>' target="_blank"><img src="../uploads/bitly_post/<?php echo $bitly_file ?>" alt="Bitly Post" width="120px"></a>
                                               <?php     }
                                                    else
                                                    {?>
                                                        <a href='../uploads/bitly_post/<?php echo $bitly_file; ?>' target="_blank"><?php echo $bitly_file ?></a>

                                                 <?php   }
                                                 ?>
                                                        </td>
                                                    <td scope="row">
                                                        <?php echo $bitly_filetype; ?>
                                                    </td>
                                                    

                                                    <td scope="row">
                                                         <?php if($role_id == 11) { ?>
                                                        <a href="bitly_post_delete.php?id=<?php echo $row['bitly_id']; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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