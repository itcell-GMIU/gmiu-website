<?php
// Include the checklogin.php file
include '../include/checklogin.php';



$cmd2 = $con->prepare("SELECT * From tbl_subscribers");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> <!-- /.Preloader -->


    <!-- wrapper -->
    <div class="wrapper">

        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>
        <!-- Navbar -->


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
                            <h1 class="m-0">View subscriber Details</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View subscriber Details</li>
                            </ol>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div> <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">

                <!-- container-fluid -->


                <!-- card -->
                <div class="card">

                    <!-- card-header -->
                    <div class="card-header">
                        <span>
                            <center>
                                <h5><b><i class="fas fa-book-reader"></i>View subscriber Details</b></h5>
                            </center>
                        </span>
                    </div>
                    <!-- /.card-header -->

                    <!-- card-body -->
                    <div class="card-body">
                      
                        <!-- table-responsive -->
                        <div class="table-responsive">

                            <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">

                                <thead>
                                    <tr align="center">
                                        <th scope="row" style="color:black;"><b>SN</b></th>
                                        <th scope="row" style="color:black;"><b>subscriber Email</b></th>                                      
                                        <th scope="row" style="color:black;"><b>Subscribe AT</b></th>                                      
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php                                 
                                    $cmd2->execute();
                                    $result = $cmd2->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                        $sr = $row['id'];
                                        $subscriber_email = !empty($row['email']) ? $row['email'] : "<b>N/A</b>";
                                        $subscribed_at = !empty($row['subscribed_at']) ? $row['subscribed_at'] : "<b>N/A</b>";
                                        
                                    ?>
                                        <tr align="center">
                                            <td scope="row">
                                                <?php echo $sr; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $subscriber_email; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $subscribed_at; ?>
                                            </td>                                           
                                        </tr>
                                    <?php } ?>
                                </tbody>

                                <tfoot>
                                   <tr align="center">
                                        <th scope="row" style="color:black;"><b>SN</b></th>
                                        <th scope="row" style="color:black;"><b>subscriber Email</b></th>                                      
                                        <th scope="row" style="color:black;"><b>Subscribe AT</b></th>                                      
                                    </tr>
                                </tfoot>

                            </table>
                        </div> <!-- /.table-responsove -->
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