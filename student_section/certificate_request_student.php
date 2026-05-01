<?php
include 'include/checklogin.php';
$cf_id = isset($_GET['url_for']) ? $_GET['url_for'] : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'include/importnav.php'; ?>
        <?php include 'include/importsidebar.php'; ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">View Certificate Request List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Certificate Request</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="far fa-hand-pointer"></i>
                            <span><b>Select Faculty to View Students</b></span>
                        </div>
                        <form method="get" action="">
                            <input type="hidden" value="<?php echo $cf_id; ?>" name="url_for">

                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-3">
                                            <div class="form-label-group">
                                                <label for="status" style="display: block; margin-bottom: 5px;">Filter by Status:</label>
                                                <div style="display: flex; align-items: center;">

                                                    <select id="status" name="status" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px; margin-right: 10px;">
                                                        <option value="all">All</option>
                                                        <option value="Requested">Requested</option>
                                                        <option value="Generated">Generated</option>
                                                        <option value="Rejected">Rejected</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <br>
                                            <button id="apply-filter" class="btn btn-primary">Apply Filter</button>
                                        </div>
                                        <div class="col-md-9">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Main content -->
                    <!-- Faculty list code -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i> View Certificate Request</b></h5>
                                </center>
                            </span>
                        </div>
                        <div class="card-body">



                            <div id="filteredTableContainer">
                                <table class="dataTableLoad table table-bordered table-hover">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>SN</b></th>
                                            <th scope="row" style="color:black;"><b>Student Name</b></th>
                                            <th scope="row" style="color:black;"><b>Enrollment</b></th>
                                            <th scope="row" style="color:black;"><b>Sem</b></th>
                                            <th scope="row" style="color:black;"><b>Certificate Type</b></th>
                                            <th scope="row" style="color:black;"><b>Request Date</b></th>
                                            <th scope="row" style="color:black;"><b>Generated Date</b></th>
                                            <th scope="row" style="color:black;"><b>Status</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                            <th scope="row" style="color:black;"><b>Remark</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $SN = 0;
                                        $status1 = 0;
                                        $s = "Requested";
                                        $statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
                                        if ($statusFilter !== 'all') {

                                            $cmd = $con->prepare("SELECT request.id as request_id, request.date as request_date, request.remark as remark, request.generated_date as generated_date, request.certificate_id as certificate_id ,request.status as statue, request.student_id as student_id, certificate1.certificate_name as cf_name , student.first_name as first_name ,student.middle_name as middle_name ,student.last_name as last_name, student.semester as sem  , student.gr_number as gr_number FROM tbl_Certificate_request as Request  
                                            LEFT JOIN tbl_admission_student student ON request.student_id = student.id 
                                            LEFT JOIN tbl_certificate certificate1 ON request.certificate_id = certificate1.id
                                            WHERE request.is_delete = ?  AND request.certificate_id = ? AND request.status = ? ");
                                            $cmd->bind_param("iis", $status1, $cf_id, $statusFilter);
                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $SN = $SN + 1;
                                                $request_id = !empty($row['request_id']) ? $row['request_id'] : "<b>N/A</b>";
                                                $sem = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                                                $request_date = !empty($row['request_date']) ? $row['request_date'] : "<b>N/A</b>";
                                                $generated_date = !empty($row['generated_date']) ? $row['generated_date'] : "<b>N/A</b>";
                                                $gr_number = !empty($row['gr_number']) ? $row['gr_number'] : "<b>N/A</b>";
                                                $status = !empty($row['statue']) ? $row['statue'] : "<b>N/A</b>";
                                                $cf_name = !empty($row['cf_name']) ? $row['cf_name'] : "<b>N/A</b>";
                                                $remark = !empty($row['remark']) ? $row['remark'] : "<b>N/A</b>";
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
                                                        <?php echo $sem; ?>
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

                                                    <?php if ($status == "Requested") { ?>
                                                        <td scope="row">
                                                            <a href="certificate_approve.php?request_id=<?php echo $row['request_id'] ?>" class="btn btn-success"><i class="fas fa-light fa-check"></i></a>
                                                            <a href="certificate_reject.php?request_id=<?php echo $row['request_id'] ?>" class="btn btn-danger"><i class="fas fa-solid fa-xmark"></i></a>
                                                        </td>
                                                    <?php } elseif ($status == "Generated") {
                                                    ?>
                                                        <td scope="row">
                                                            <a target="_blank" href="certificate_generate.php?request_id=<?php echo $row['request_id'] ?>" class="btn btn-success"><i class="fas fa-solid fa-file-arrow-down"></i></a>
                                                        </td>
                                                    <?php } elseif ($status == "Rejected") { ?>
                                                        <td scope="row">
                                                            <?php
                                                            echo "Request is Rejected"; ?>
                                                        </td><?php
                                                            } ?>


                                                    <td scope="row">
                                                        <?php if ($status == "Requested" || $status == "Generated") {
                                                            echo "N/A";
                                                        } elseif ($status == "Rejected") {
                                                            echo $remark;
                                                        } ?>
                                                </tr>

                                            <?php }
                                        } else {
                                            echo $statusFilter;
                                            $cmd = $con->prepare("SELECT request.id as request_id, request.date as request_date, request.remark as remark, request.generated_date as generated_date, request.certificate_id as certificate_id ,request.status as statue, request.student_id as student_id, certificate1.certificate_name as cf_name , student.first_name as first_name ,student.middle_name as middle_name ,student.last_name as last_name, student.semester as sem  , student.gr_number as gr_number FROM tbl_Certificate_request as Request  
                                                    LEFT JOIN tbl_admission_student student ON request.student_id = student.id 
                                                    LEFT JOIN tbl_certificate certificate1 ON request.certificate_id = certificate1.id
                                                    WHERE request.is_delete = ?  AND request.certificate_id = ? ");
                                            $cmd->bind_param("ii", $status1, $cf_id);
                                            $cmd->execute();
                                            $result = $cmd->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $SN = $SN + 1;
                                                $request_id = !empty($row['request_id']) ? $row['request_id'] : "<b>N/A</b>";
                                                $sem = !empty($row['sem']) ? $row['sem'] : "<b>N/A</b>";
                                                $request_date = !empty($row['request_date']) ? $row['request_date'] : "<b>N/A</b>";
                                                $generated_date = !empty($row['generated_date']) ? $row['generated_date'] : "<b>N/A</b>";
                                                $gr_number = !empty($row['gr_number']) ? $row['gr_number'] : "<b>N/A</b>";
                                                $status = !empty($row['statue']) ? $row['statue'] : "<b>N/A</b>";
                                                $cf_name = !empty($row['cf_name']) ? $row['cf_name'] : "<b>N/A</b>";
                                                $remark = !empty($row['remark']) ? $row['remark'] : "<b>N/A</b>";
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
                                                        <?php echo $sem; ?>
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

                                                    <?php if ($status == "Requested") { ?>
                                                        <td scope="row">
                                                            <a href="certificate_approve.php?request_id=<?php echo $row['request_id'] ?>" class="btn btn-success"><i class="fas fa-light fa-check"></i></a>
                                                            <a href="certificate_reject.php?request_id=<?php echo $row['request_id'] ?>" class="btn btn-danger"><i class="fas fa-solid fa-xmark"></i></a>
                                                        </td>
                                                    <?php } elseif ($status == "Generated") {
                                                    ?>
                                                        <td scope="row">
                                                            <a target="_blank" href="certificate_generate.php?request_id=<?php echo $row['request_id'] ?>" class="btn btn-success"><i class="fas fa-solid fa-file-arrow-down"></i></a>
                                                        </td>
                                                    <?php } elseif ($status == "Rejected") { ?>
                                                        <td scope="row">
                                                            <?php
                                                            echo "Request is Rejected"; ?>
                                                        </td><?php
                                                            } ?>


                                                    <td scope="row">
                                                        <?php if ($status == "Requested" || $status == "Generated") {
                                                            echo "N/A";
                                                        } elseif ($status == "Rejected") {
                                                            echo $remark;
                                                        } ?>
                                                </tr>

                                        <?php }
                                        } ?>




                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>SN</b></th>
                                            <th scope="row" style="color:black;"><b>Student Name</b></th>
                                            <th scope="row" style="color:black;"><b>Enrollment</b></th>
                                            <th scope="row" style="color:black;"><b>Sem</b></th>
                                            <th scope="row" style="color:black;"><b>Certificate Type</b></th>
                                            <th scope="row" style="color:black;"><b>Request Date</b></th>
                                            <th scope="row" style="color:black;"><b>Generated Date</b></th>
                                            <th scope="row" style="color:black;"><b>Status</b></th>
                                            <th scope="row" style="color:black;"><b>Manage</b></th>
                                            <th scope="row" style="color:black;"><b>Remark</b></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>


                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </section>
        </div>
        <?php include 'include/importfooter.php'; ?>
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>
    <?php include 'include/importjs.php'; ?>
</body>
<script>
    document.getElementById('apply-filter').addEventListener('click', function() {
        var selectedStatus = document.getElementById('status').value;
        var urlFor = '<?php echo isset($cf_id) ? $cf_id : ""; ?>';
        var redirectURL = 'view_certificate_request.php?url_for=' + urlFor + '&status=' + selectedStatus;
        window.location.href = redirectURL;
    });
</script>



</html>