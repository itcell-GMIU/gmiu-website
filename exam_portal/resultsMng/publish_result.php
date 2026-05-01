<?php
// Include the checklogin.php file
include '../include/checklogin.php';
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
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
    </div>
    <!-- wrapper -->
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
                            <h1 class="m-0">Publish Result</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Publish Result</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!--   Program list code  -->

                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>Publish Result</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- + ADD Button End -->
                            <table id="acedemic" class="dataTableLoad table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr align="center">
                                        <th style="color:black;"><b>Id</b></th>
                                        <th style="color:black;"><b>Exam Name</b></th>
                                        <th style="color:black;"><b>Sem</b></th>
                                        <th style="color:black;"><b>Date</b></th>
                                        <th style="color:black; width:200px;"><b>Late Fee</b></th>
                                        <th style="color:black;"><b>Total Student</b></th>
                                        <th style="color:black;"><b>Status</b></th>
                                        <th style="color:black;"><b>Action</b></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $status = 0;
                                    $cmd = $con->prepare("SELECT
                                            std.id as id, 
                                            std.faculty_id as faculty_id, 
                                            std.level_id as level_id, 
                                            std.program_id as program_id, 
                                            std.semester as semester, 
                                            std.is_active as std_is_active, 
                                            std.type as type,
                                            std.session as session, 
                                            std.start_date as start_date, 
                                            std.end_date as end_date, 
                                            std.hallticket_status as hallticket_status, 
                                            std.pr_hallticket_status as pr_hallticket_status, 
                                            std.result_status as result_status,
                                            std.year as year,
                                            std.late_fee as late_fee,
                                            faculty.name as faculty_name,
                                            level.name as level_name,
                                            program.name as program_name,
                                            clg.clg_name as college_name
                                        FROM tbl_exam_form as std
                                        LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id
                                        LEFT JOIN tbl_level level ON std.level_id = level.id
                                        LEFT JOIN tbl_program program ON std.program_id = program.id
                                        LEFT JOIN tbl_clg_name clg ON std.faculty_id = clg.faculty_id AND std.level_id = clg.level_id
                                        WHERE std.is_delete = ?");
                                    $cmd->bind_param("i", $status);
                                    $cmd->execute();
                                    $result = $cmd->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $level_id = $row['level_id'];
                                        $program_id = $row['program_id'];
                                        $id = $row['id'];
                                        $hallticket_status = $row['hallticket_status'];
                                        $result_status = $row['result_status'];
                                        $PRhallticket_status = $row['pr_hallticket_status'];
                                        $semester = $row['semester'];
                                        $clg_name = $row['college_name'];

                                        $start_date = $row['start_date'];
                                        $stdate = new DateTime($start_date);
                                        $start_date = $stdate->format("d-m-Y");

                                        $end_date = $row['start_date'];
                                        $eddate = new DateTime($end_date);
                                        $end_date = $eddate->format("d-m-Y");

                                        $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                        $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                        $Syllabus = !empty($row['Syllabus']) ? $row['Syllabus'] : "<b>N/A</b>";
                                        $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                        $sem = !empty($row['semester']) ? $row['semester'] : "<b>N/A</b>";
                                        $std_is_active = $row['std_is_active'];
                                        $exam_type = $row['type'];
                                        $exam_session = $row['session'];
                                        if ($row['type'] == "regular") {
                                            $exam_type = "REGULAR";
                                        } else {
                                            $exam_type = "REMEDIAL";
                                        }
                                    ?>
                                        <tr align="center">
                                            <td scope="row">
                                                <?php echo $id; ?>
                                            </td>
                                            <td scope="row" class="text-uppercase" style="width:250px;">
                                                <?php echo $clg_name . ' ' . $level_name . ' ' . $program_name . ' ' . 'SEMESTER -' . ' ' . $semester . ' ' . $exam_type . ' ' . $exam_session . ' - ' . $row['year']; ?>
                                            </td>

                                            <td scope="row">
                                                <?php echo $sem; ?>
                                            </td>

                                            <td scope="row" style="width:150px;">
                                                <?php echo $start_date . ' To ' . $end_date; ?>
                                            </td>

                                            <td scope="row">
                                                <?php
                                                $jsonData = $row['late_fee'];

                                                // Decode the JSON data into a PHP array
                                                $dataArray = json_decode($jsonData, true);

                                                // Check if the decoding was successful
                                                if ($dataArray !== null) {
                                                    // Iterate through the entries
                                                    foreach ($dataArray as $entry) {
                                                        $startingDate = $entry['starting_date'];
                                                        $sdate = new DateTime($startingDate);
                                                        $startingDate = $sdate->format("d-m-Y");

                                                        $endingDate = $entry['ending_date'];
                                                        $edate = new DateTime($endingDate);
                                                        $endingDate = $edate->format("d-m-Y");

                                                        $lateFeeAmount = $entry['late_fee_amount'];


                                                        // Use these variables for each entry
                                                        echo "Date: $startingDate To <br> $endingDate";
                                                        echo "<br> Late Fee Amount: $lateFeeAmount<br>";
                                                        echo "<br>"; // Add a line break between entriess
                                                    }
                                                } else {
                                                    echo "No Late Fee.";
                                                }
                                                ?>
                                            </td>

                                            <td scope="row">
                                                <?php
                                                $id_count = $con->query("SELECT id FROM tbl_exam_student WHERE exam_id = $id");
                                                $std_count = mysqli_num_rows($id_count);
                                                echo $std_count;
                                                ?>
                                            </td>

                                            <td scope="row">
                                                <?php if ($std_is_active == 1) {
                                                    echo "Active";
                                                } else {
                                                    echo "Inactive";
                                                } ?>
                                            </td>
                                            <td scope="row">
                                                <?php if ($result_status == 1) {
                                                    echo '<span class="badge badge-success">Published</span>
                                                    <hr>
                                                    <a href="update_result.php?id='.$row['id'].'" class="btn btn-info text-nowrap"><i class="fas fa-refresh"></i> Publish</a>
                                                ';
                                                } elseif ($result_status == 0) { ?>
                                                    <a href="update_result.php?id=<?php echo $row['id'] ?>" class="btn btn-success text-nowrap"><i class="fas fa-bullhorn"></i> Publish</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                                <tfoot>
                                    <tr align="center">
                                        <th style="color:black;"><b>Id</b></th>
                                        <th style="color:black;"><b>Exam Name</b></th>
                                        <th style="color:black;"><b>Sem</b></th>
                                        <th style="color:black;"><b>Date</b></th>
                                        <th style="color:black;"><b>Late Fee</b></th>
                                        <th style="color:black;"><b>Total Student</b></th>
                                        <th style="color:black;"><b>Status</b></th>
                                        <th style="color:black;"><b>Action</b></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div><!-- /.container-fluid -->
                </div>
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
    <!-- footer -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>