<?php
// Include the checklogin.php file
include '../include/checklogin.php';
include '../include/importsidebar.php';


// Check if a program filter has been applied

// If no program filter is applied, use the original query



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

    <!-- Preloader  -->
     <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> 
    <!-- Preloader -->


    <!-- wrapper -->
    <div class="wrapper">

        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php';
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        ?>
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
                            <h1 class="m-0">View Student Details</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Student Details</li>
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
                                <h5><b><i class="fas fa-book-reader"></i>View Student Details</b></h5>
                            </center>
                        </span>
                    </div>
                    <!-- /.card-header -->

                    <!-- card-body -->
                    <div class="card-body">

                        <!-- + ADD Button  -->
                        <!-- <a class="btn btn-primary" style="margin-left: 90%;" href="staff_insert.php"><i class="fa-solid fa-plus"></i> Add</a> -->
                        <!-- + ADD Button End -->

                        <!-- table-responsive -->
                        <div class="table-responsive" align="center">

                            <table id="acedemic" class="dataTableLoad table table-bordered table-striped " >
                            
                                <thead>
                                    <tr align="center">
                                        <th scope="row" style="color:black;"><b>SN</b></th>
                                        <th scope="row" style="color:black;"><b>Student Name</b></th>
                                        <th scope="row" style="color:black;"><b>Student Contact</b></th>
                                        <th scope="row" style="color:black;"><b>Parent contact</b></th>
                                        <th scope="row" style="color:black;"><b>medium</b></th>
                                        <th scope="row" style="color:black;"><b>Standard</b></th>
                                        <th scope="row" style="color:black;"><b>School</b></th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    
                                    $sr = 0;
                                    $cmd2 = $con->prepare("SELECT id, Name, Mobile, ParentMobile, Medium,std, BoardSeat, School
                                    FROM student_data1");
                                    $cmd2->execute();
                                    $result = $cmd2->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                        $id = $row['id'];
                                        $Name = !empty($row['Name']) ? $row['Name'] : "<b>N/A</b>";
                                        $Mobile = !empty($row['Mobile']) ? $row['Mobile'] : "<b>N/A</b>";
                                        $ParentMobile = !empty($row['ParentMobile']) ? $row['ParentMobile'] : "<b>N/A</b>";
                                        $Medium = !empty($row['Medium']) ? $row['Medium'] : "<b>N/A</b>";
                                        $std = !empty($row['std']) ? $row['std'] : "<b>N/A</b>";
                                        $BoardSeat = !empty($row['BoardSeat']) ? $row['BoardSeat'] : "<b>N/A</b>";
                                        $School = !empty($row['School']) ? $row['School'] : "<b>N/A</b>";
                                        // Additional variables specific to your needs can be added here
                                        // Incrementing a counter variable
                                        $sr = $sr + 1;
                                    ?>
                                        <tr align="center">

                                            <td scope="row">
                                                <?php echo $sr; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $Name; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $Mobile; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $ParentMobile; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $Medium; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $std; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $School; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>

                                <tfoot>
                                <tr align="center">
                                        <th scope="row" style="color:black;"><b>SN</b></th>
                                        <th scope="row" style="color:black;"><b>Student Name</b></th>
                                        <th scope="row" style="color:black;"><b>Student Contact</b></th>
                                        <th scope="row" style="color:black;"><b>Parent contact</b></th>
                                        <th scope="row" style="color:black;"><b>medium</b></th>
                                        <th scope="row" style="color:black;"><b>Standard</b></th>
                                        <th scope="row" style="color:black;"><b>School</b></th>
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
<!-- <script>
    document.getElementById("applyFilter").addEventListener("click", function() {
        // Get the selected program filter value
        var programFilter = document.getElementById("programFilter").value;

        // Redirect to the current page with the program filter as a query parameter
        window.location.href = "staff_view.php?programFilter=" + programFilter;
    });
</script> -->