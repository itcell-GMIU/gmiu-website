<?php
include "../include/checklogin.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../include/importhead.php"; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include "../include/importcss.php"; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include "../include/importnav.php"; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include "../include/importsidebar.php"; ?>

        <!-- Content Wrapper. Contains page content -->  
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View Global Exposure List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Global Exposure</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- Global Exposure list code -->

                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-globe"></i> View Global Exposure</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button  -->
                            <a class="btn btn-primary" style="margin-left: 90%;" href="global_exposure_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                            <!-- + ADD Button End -->
                            <div class="table-responsive">
                                <table id="global_exposure" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>Image</b></th>
                                            <th scope="row" style="color:black;"><b>Description</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       $status = 0;
                                       $type = 4;
                                       $cmd = $con->prepare(
                                           "SELECT id, title, img_name, description FROM tbl_international_cell WHERE is_delete = ? AND type_id= ?"
                                       );
                                       $cmd->bind_param("ii", $status, $type);
                                       $cmd->execute();
                                       $result = $cmd->get_result();
                                       while ($row = $result->fetch_assoc()) {

                                           $ic_id = $row["id"];
                                           $title = !empty($row["title"])
                                               ? $row["title"]
                                               : "<b>N/A</b>";
                                           $img_name = !empty($row["img_name"])
                                               ? $row["img_name"]
                                               : "<b>N/A</b>";
                                           $description = !empty(
                                               $row["description"]
                                           )
                                               ? $row["description"]
                                               : "<b>N/A</b>";
                                           ?>
   
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $ic_id; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $title; ?>
                                                </td>

                                                <td scope="row">
                                                
                                                    <a href="<?php echo "../uploads/international_cell/" .
                                                        $img_name; ?>" target="_blank">
                                                        <img src='<?php echo "../uploads/international_cell/" .
                                                            $img_name; ?>' alt="" style="width: 200px;">
                                                    </a>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $description; ?>
                                                </td>

                                                <td scope="row">
                                                    <a href="global_exposure_edit.php?ic_id=<?php echo $ic_id; ?>" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="global_exposure_delete.php?ic_id=<?php echo $ic_id; ?>" class="btn btn-danger"><i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                        <?php
                                       }
                                       ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>ID</b></th>
                                            <th scope="row" style="color:black;"><b>Title</b></th>
                                            <th scope="row" style="color:black;"><b>Image</b></th>
                                            <th scope="row" style="color:black;"><b>Description</b></th>
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
    <?php include "../include/importfooter.php"; ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include "../include/importjs.php"; ?>
</body>

</html>
