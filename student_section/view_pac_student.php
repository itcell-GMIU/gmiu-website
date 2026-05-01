<?php
ini_set('max_execution_time', 300); // 5 minutes
include './include/checklogin.php';

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (isset($_GET['url_level_id']) && !empty($_GET['url_level_id'])) {
    $url_level_id = mysqli_real_escape_string($con, $_GET['url_level_id']);
    $url_level_id = validate_data($url_level_id);

    $query = "SELECT name as level_name FROM tbl_level WHERE id = $url_level_id";
    $result = $con->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $level_name = $row['level_name'];
    } else {
        $level_name = "";
    }
} else {
    $url_level_id = "";
    $level_name = "";
}

if (isset($_GET['url_for']) && !empty($_GET['url_for'])) {
    $url_for = mysqli_real_escape_string($con, $_GET['url_for']);
    $url_for = validate_data($url_for);
} else {
    $url_for = "";
}

if (isset($_GET['url_faculty_id']) && !empty($_GET['url_faculty_id'])) {
    $url_faculty_id = mysqli_real_escape_string($con, $_GET['url_faculty_id']);
    $url_faculty_id = validate_data($url_faculty_id);

    $query = "SELECT name as faculty_name FROM tbl_faculty WHERE id = $url_faculty_id";
    $result = $con->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $faculty_name = $row['faculty_name'];
    } else {
        $faculty_name = "";
    }
} else {
    $faculty_name = "";
    $url_faculty_id = "";
}


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
                            <h1 class="m-0">View Student</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Student</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Default box -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="far fa-hand-pointer"></i>
                            <span> <b>Select Faculty to View Students</b></span>
                        </div>
                        <form method="GET" action="">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-label-group">
                                                <input type="hidden" name="url_for" value="<?php echo $url_for; ?>">
                                                <select id="faculty_id" name="url_faculty_id"
                                                    class="browser-default custom-select"
                                                    style="color:black; border-color:#325d88; border-width:2px"
                                                    required>
                                                    <option value="">---Select Faculty---</option>
                                                    <?php
                                                    $query = "SELECT * FROM tbl_faculty WHERE is_active = 1 and is_delete=0";
                                                    $result = $con->query($query);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-label-group">
                                                <select name="url_level_id" id="level_id"
                                                    class="browser-default custom-select"
                                                    style="color:black; border-color:#325d88; border-width:2px"
                                                    required>
                                                    <option value="">---Select Level---</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="submit" class="btn btn-primary btn-block" id="export"
                                                style="float:center" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--   student list code  -->
                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>
                                            <?php echo $faculty_name . "-" . $level_name; ?>
                                            Students </b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Student Id</b></th>
                                            <th scope="row" style="color:black;"><b>Inquiry Id</b></th>
                                            <th scope="row" style="color:black;"><b>Form No</b></th>
                                            <th scope="row" style="color:black;"><b>Student Gr Number</b></th>
                                            <th scope="row" style="color: black;"><b>Program Name</b></th>
                                            <th scope="row" style="color: black;"><b>Student Name</b></th>
                                            <th scope="row" style="color:black;"><b>View</b></th>
                                            <th scope="row" style="color:black;"><b>View Full Detail</b></th>
                                            <th scope="row" style="color:black;"><b>View PAC Detail</b></th>
                                            <th scope="row" style="color:black;"><b>Fill PAC Form</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cmd = "SELECT 
                                                    stu.password,
                                                    stu.admission_status,
                                                    stu.id,
                                                    stu.gr_number,
                                                    stu.comment,
                                                    stu.program_id,
                                                    stu.first_name,
                                                    stu.middle_name,
                                                    stu.last_name,
                                                    stu.email,
                                                    stu.mobile_number,
                                                    stu.status,
                                                    stu.payment_status,
                                                    stu.payment_mode,
                                                    stu.account_office_status,
                                                    stu.created_at,
                                                    pro.name AS program_name,
                                                    level.name AS level_name,
                                                    faculty.name AS faculty_name,
                                                    inq.inq_student_id, 
                                                    CASE 
                                                        WHEN form.is_delete = 0 THEN form.formno 
                                                        ELSE NULL 
                                                    END AS formno
                                                FROM 
                                                    tbl_admission_student AS stu
                                                LEFT JOIN 
                                                    tbl_program pro ON stu.program_id = pro.id
                                                LEFT JOIN 
                                                    tbl_faculty faculty ON stu.faculty_id = faculty.id
                                                LEFT JOIN 
                                                    tbl_level level ON stu.level_id = level.id
                                                LEFT JOIN 
                                                    tbl_inquiry_student inq ON stu.id = inq.admission_student_id
                                                LEFT JOIN
                                                    tbl_pac_form form ON stu.id = form.student_id 
                                                WHERE 
                                                    stu.is_active = 1 
                                                    AND stu.is_delete = 0
                                                    AND stu.id = form.student_id 
                                                   ORDER BY form.formno ASC"; // Fixed payment_status reference
                                        // AND stu.payment_status = 'success'"; // Fixed payment_status reference
                                        
                                        // Append dynamic conditions correctly
                                        if (!empty($url_faculty_id)) {
                                            $cmd .= " AND stu.faculty_id = '$url_faculty_id'";
                                        }
                                        if (!empty($url_level_id)) {
                                            $cmd .= " AND stu.level_id = '$url_level_id'";
                                        }

                                        // Prepare, execute, and fetch results
                                        $stmt = $con->prepare($cmd);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        $rows = $result->num_rows;
                                        if ($rows > 0) {

                                            while ($row = $result->fetch_assoc()) {
                                                $stu_id = $row['id'];
                                                $inq_id = $row['inq_student_id'];
                                                $form_no = "2025 / " . str_pad($row['formno'], 4, "0", STR_PAD_LEFT);
                                                $stu_gr_number = $row['gr_number'];
                                                $stu_program_id = $row['program_id'];
                                                $stu_first_name = $row['first_name'];
                                                $stu_middle_name = $row['middle_name'];
                                                $stu_last_name = $row['last_name'];
                                                $stu_program_name = $row['program_name'];
                                                ?>
                                                <tr align="center">
                                                    <td scope="row"><?php echo $stu_id; ?></td>
                                                    <td scope="row"><?php echo $inq_id; ?></td>
                                                    <td scope="row"><?php echo $form_no; ?></td>
                                                    <td scope="row"><?php echo $stu_gr_number; ?></td>
                                                    <td scope="row"><?php echo $stu_program_name; ?></td>
                                                    <td scope="row">
                                                        <?php echo $stu_first_name . " " . $stu_middle_name . " " . $stu_last_name; ?>
                                                    </td>
                                                    <td scope="row"><a
                                                            href="view_student_detail.php?stu_id=<?php echo $stu_id; ?>"
                                                            style="color:blue;" target="_blank"><button type="button"
                                                                class="btn btn-success">View</button></a></td>
                                                    <td scope="row"><a
                                                            href="full_student_detail.php?stu_id=<?php echo $stu_id; ?>"
                                                            style="color:blue;" target="_blank"><button type="button"
                                                                class="btn btn-success">View</button></a></td>
                                                    <td scope="row"><a href="show_pac.php?id=<?php echo $row['formno']; ?>"
                                                            style="color:blue;" target="_blank"><button type="button"
                                                                class="btn btn-success">View</button></a></td>
                                                    <?php
                                                    $query_count = "SELECT COUNT(*) as count FROM tbl_pac_form WHERE student_id = ?  AND is_delete = 0";
                                                    $stmt_count = $con->prepare($query_count);
                                                    $student_id_param = $stu_id;
                                                    $stmt_count->bind_param("i", $student_id_param);
                                                    $stmt_count->execute();
                                                    $stmt_count->bind_result($total_count);
                                                    $stmt_count->fetch();
                                                    $stmt_count->close();
                                                    if ($total_count > 0) {
                                                        $query_pacid = "SELECT pacid FROM tbl_pac_form WHERE student_id = ? AND is_delete = 0";
                                                        $stmt_pacid = $con->prepare($query_pacid);
                                                        $student_id_param = $stu_id;
                                                        $stmt_pacid->bind_param("i", $student_id_param);
                                                        $stmt_pacid->execute();
                                                        $stmt_pacid->bind_result($pacid);
                                                        if ($stmt_pacid->fetch()) {
                                                            ?>
                                                            <td scope="row"><a href="edit_pac.php?id=<?php echo $pacid; ?>"
                                                                    style="color:blue;">
                                                                    <button type="button" class="btn btn-primary">Edit</button></a></td>
                                                            <?php
                                                        }
                                                        $stmt_pacid->close();
                                                    } else {
                                                        ?>
                                                        <td scope="row"><a href="pac_form.php?stu_id=<?php echo $stu_id; ?>"
                                                                style="color:blue;">
                                                                <button type="button" class="btn btn-info">Fill</button></a></td>
                                                        <?php
                                                    }
                                                    ?>
                                                </tr>
                                            <?php }
                                        } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Student Id</b></th>
                                            <th scope="row" style="color:black;"><b>Inquiry Id</b></th>
                                            <th scope="row" style="color:black;"><b>Form No</b></th>
                                            <th scope="row" style="color:black;"><b>Student Gr Number</b></th>
                                            <th scope="row" style="color: black;"><b>Program Name</b></th>
                                            <th scope="row" style="color: black;"><b>First Name</b></th>
                                            <th scope="row" style="color:black;"><b>View</b></th>
                                            <th scope="row" style="color:black;"><b>View Full Detail</b></th>
                                            <th scope="row" style="color:black;"><b>View PAC Detail</b></th>
                                            <th scope="row" style="color:black;"><b>Fill PAC Form</b></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <?php
                    //  }                    
                    ?>
                </div>
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
<script type="text/javascript">
    $('#faculty_id').on('change', function () {
        var path = '<?php echo "$base_url_api"; ?>';
        var faculty_id = this.value;
        $.ajax({
            url: path + 'level.php',
            type: "POST",
            data: {
                faculty_data: faculty_id
            },
            success: function (result) {
                $('#level_id').html(result);

                // console.log(result);
            }
        })
    });
</script>