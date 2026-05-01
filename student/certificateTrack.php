<?php
include 'include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
    
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View Certificate Request List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Certificate Request</li>
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
                                    <h5><b><i class="fas fa-book-reader"></i> View Certificate Request</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                        <th scope="row" style="color:black;"><b>SN</b></th>
                                            <th scope="row" style="color:black;"><b>Student Name</b></th>
                                            <th scope="row" style="color:black;"><b>Enrollment</b></th>
                                            <th scope="row" style="color:black;"><b>Certificate Type</b></th>
                                            <th scope="row" style="color:black;"><b>Request Date(YYYY/MM/DD)</b></th>
                                            <th scope="row" style="color:black;"><b>Generated Date(YYYY/MM/DD)</b></th>
                                            <th scope="row" style="color:black;"><b>Status</b></th>
                                            <th scope="row" style="color:black;"><b>Remark</b></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $SN=0;
                                        $status = 0;
                                        $cmd = $con->prepare("SELECT request.id as request_id, request.date as request_date, request.generated_date as generated_date,request.remark as remark ,request.certificate_id as certificate_id ,request.status as statue, request.student_id as student_id, certificate1.certificate_name as cf_name , student.first_name as first_name ,student.middle_name as middle_name ,student.last_name as last_name, student.semester as sem  , student.gr_number as gr_number FROM tbl_Certificate_request as Request  
                                            LEFT JOIN tbl_admission_student student ON request.student_id = student.id 
                                            LEFT JOIN tbl_certificate certificate1 ON request.certificate_id = certificate1.id
                                            WHERE request.is_delete = ? and request.student_id=? ");
                                        $cmd->bind_param("ii", $status, $student_id);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $SN=$SN+1;
                                            $request_date = !empty($row['request_date']) ? $row['request_date'] : "<b>N/A</b>";
                                            $generated_date = !empty($row['generated_date']) ? $row['generated_date'] : "<b>N/A</b>";
                                            $gr_number = !empty($row['gr_number']) ? $row['gr_number'] : "<b>N/A</b>";
                                            $status = !empty($row['statue']) ? $row['statue'] : "<b>N/A</b>";
                                            $cf_name = !empty($row['cf_name']) ? $row['cf_name'] : "<b>N/A</b>";
                                            $remarks = !empty($row['remark']) ? $row['remark'] : "<b>N/A</b>";

                                            $student_name = !empty($row['first_name'] . ' ' .  $row['middle_name'] . ' ' . $row['last_name']) ? ($row['first_name'] . ' ' .  $row['middle_name'] . ' ' . $row['last_name']) : "N/A";

                                        ?>
                                            <tr align="center">

                                               
                                            <td scope="row">
                                                    <?php echo $SN; ?>
                                                </td>
                                              

                                                <td scope="row">
                                                    <?php echo $student_name; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $gr_number; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $cf_name; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $request_date; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php if ($status == "Requested" || $status == "Rejected") {
                                                        echo "N/A";
                                                    } elseif ($status == "Generated") {
                                                        echo $generated_date;
                                                    }

                                                    ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $status; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $remarks; ?>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                        <th scope="row" style="color:black;"><b>SN</b></th>
                                        <th scope="row" style="color:black;"><b>Student Name</b></th>
                                            <th scope="row" style="color:black;"><b>Enrollment</b></th>
                                            <th scope="row" style="color:black;"><b>Certificate Type</b></th>
                                            <th scope="row" style="color:black;"><b>Request Date(YYYY/MM/DD)</b></th>
                                            <th scope="row" style="color:black;"><b>Generated Date(YYYY/MM/DD)</b></th>
                                            <th scope="row" style="color:black;"><b>Status</b></th>
                                            <th scope="row" style="color:black;"><b>Remark</b></th>
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
        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include 'include/importjs.php'; ?>
</body>

</html>