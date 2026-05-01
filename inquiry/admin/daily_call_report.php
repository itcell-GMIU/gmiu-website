<?php
// ini_set('max_execution_time', 300); // 5 minutes
// Ensure user is logged in
include "../include/checklogin.php";

// Fetch staff members with role IDs 13, 15, and 16 with pagination
// Fetch filter values from the URL (GET request)
$faculty_id = isset($_GET['faculty_id']) ? $_GET['faculty_id'] : '';
$level_id = isset($_GET['level_id']) ? $_GET['level_id'] : '';
$program_id = isset($_GET['program_id']) ? $_GET['program_id'] : '';
echo $faculty_id . $level_id . $program_id;
// Modify the query to filter staff based on selected values
$query_conditions = " WHERE role_id IN (13, 15, 16) AND is_delete = 0";

if (!empty($faculty_id)) {
    $query_conditions .= " AND faculty_id = '$faculty_id'";
}
if (!empty($level_id)) {
    $query_conditions .= " AND level_id = '$level_id'";
}
if (!empty($program_id)) {
    $query_conditions .= " AND program_id = '$program_id'";
}

$staff_query = mysqli_query($con, "SELECT id, name FROM tbl_staff" . $query_conditions);
// $staff_query = mysqli_query($con, "SELECT id, name FROM tbl_staff WHERE role_id IN (13, 15, 16) and is_delete = 0 ");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- header -->
    <?php include '../include/importhead.php'; ?>
    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
    <title>Daily Inquiry Report</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>

    <!-- wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Daily Call Report</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Daily Call Report</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <!-- Report Card -->
                    <div class="card">
                        <div class="card-header">
                            <center>
                                <h5><b><i class="fas fa-book-reader"></i> View Student Inquiry</b></h5>
                                <p><strong>Report Date:</strong> <?php echo date('F j, Y'); ?></p>
                            </center>
                        </div>
                        <!-- Filter Form -->
                            <form method="GET" action="">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col-md-3">
                                                        <div class="form-label-group">
                                                         
                                                            <select id="faculty_id" name="faculty_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px">
                                                                <option value="">---Select Faculty---</option>

                                                                <?php
                                                                $query = "SELECT * FROM tbl_faculty WHERE is_active = 1 and is_delete=0";
                                                                $result = $con->query($query);
                                                                if ($result->num_rows > 0) {
                                                                    while ($row = $result->fetch_assoc()) {
                                                                        $selected = ($url_faculty_id == $row['id']) ? "selected" : "";
                                                                        //echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
                                                                ?>
                                                                        <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
                                                                            <?php echo $row['name']; ?>
                                                                        </option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-label-group">
                                                            <select name="level_id" id="level_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px">
                                                                <option value="">---Select Level---</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-label-group">
                                                            <select name="program_id" id="program_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px">
                                                                <option value="">---Select Program---</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="submit" class="btn btn-primary btn-block" id="export" style="float:center" />

                                                    </div>
                                                     <div class="col-md-1">
                                                        <!-- Clear Filter Button -->
                                                        <a href="daily_call_report.php" class="btn btn-danger btn-block">Clear</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </form>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Staff Name</th>
                                            <th>Total Assigned Students</th>
                                            <th>Completed Call Students</th>
                                            <th>Today's Completed Call Students</th>
                                            <th>Pending Call Students</th>
                                            <th>Follow Up Call Students</th>
                                            <th>Today's Follow Up Call Students</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($staff = mysqli_fetch_assoc($staff_query)): ?>
                                            <?php
                                            $staff_id = $staff['id'];

                                            // Query to gather the required data for each staff member
                                            $total_assigned_students = mysqli_num_rows(mysqli_query($con, "SELECT id FROM tbl_inquiry_student WHERE staff_id = '$staff_id' AND is_delete = '0' AND is_admission_confirm = '0'"));
                                            // $completed_call_students = mysqli_num_rows(mysqli_query($con, "SELECT id FROM tbl_call_history WHERE staff_id = '$staff_id'"));
                                             $completed_call_students = mysqli_num_rows(mysqli_query($con, "SELECT DISTINCT inq_student_id  FROM tbl_call_history WHERE staff_id = '$staff_id'"));
                                           
                                            $todays_completed_call_students = mysqli_num_rows(mysqli_query($con, "SELECT id FROM tbl_call_history WHERE staff_id = '$staff_id' AND DATE(call_datetime) = DATE(NOW())"));
                                            $pending_call_students = mysqli_num_rows(mysqli_query($con, "SELECT s.id AS student_count FROM tbl_inquiry_student s LEFT JOIN tbl_inquiry_remarks r ON s.inq_student_id = r.inq_student_id WHERE ((r.inq_student_id IS NULL OR r.staff_id = '$staff_id' AND r.is_followup_need = '0')) AND s.staff_id = '$staff_id' AND s.is_delete = 0 AND s.is_admission_confirm = '0'"));
                                            $follow_up_call_students = mysqli_num_rows(mysqli_query($con, "SELECT pro.first_name FROM tbl_inquiry_student AS pro LEFT JOIN tbl_inquiry_remarks R ON pro.inq_student_id = R.inq_student_id WHERE pro.staff_id = '$staff_id' AND R.is_followup_need = '1' AND pro.is_admission_confirm = '0' AND pro.is_delete = 0 GROUP BY pro.id"));
                                            $todays_follow_up_call_students = mysqli_num_rows(mysqli_query($con, "SELECT R.inq_student_id, pro.first_name FROM tbl_inquiry_student AS pro LEFT JOIN tbl_inquiry_remarks R ON pro.inq_student_id = R.inq_student_id WHERE DATE(R.follow_up_date) = DATE(NOW()) AND R.staff_id = '$staff_id' AND R.is_followup_need = '1' AND pro.is_admission_confirm = '0' AND pro.is_delete = 0"));
                                            ?>
                                            <tr>
                                                <td><?= $staff['name'] ?></td>
                                                <td><?= $total_assigned_students ?></td>
                                                <td><?= $completed_call_students ?></td>
                                                <td><?= $todays_completed_call_students ?></td>
                                                <td><?= $pending_call_students ?></td>
                                                <td><?= $follow_up_call_students ?></td>
                                                <td><?= $todays_follow_up_call_students ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>

                                    <tfoot>
                                        <tr align="center">
                                            <th>Staff Name</th>
                                            <th>Total Assigned Students</th>
                                            <th>Completed Call Students</th>
                                            <th>Today's Completed Call Students</th>
                                            <th>Pending Call Students</th>
                                            <th>Follow Up Call Students</th>
                                            <th>Today's Follow Up Call Students</th>
                                        </tr>
                                    </tfoot>
                                </table>
                               

                            </div>


                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include '../include/importfooter.php'; ?>
    </div>

    <?php include '../include/importjs.php'; ?>

</body>
<script type="text/javascript">
    $('#faculty_id').on('change', function() {
        var path = '<?php echo "$base_url_api"; ?>';
        var faculty_id = this.value;
        // alert("hii");
        $.ajax({
            url: path + 'level.php',
            type: "POST",
            data: {
                faculty_data: faculty_id
            },
            success: function(result) {
                $('#level_id').html(result);

                // console.log(result);
            }
        })
    });
    $('#level_id').on('change', function() {
        var path = '<?php echo "$base_url_api"; ?>';
        var level_id = this.value;
        var faculty_id = $("select#faculty_id option:checked").val();
        /*  alert(level_id); */

        $.ajax({
            url: path + 'program.php',
            type: "POST",
            data: {
                level_data: level_id,
                faculty_data: faculty_id
            },
            cache: false,
            success: function(data) {
                $('#program_id').html(data);
                // console.log(data);
            }
        })
    });
    $('#clear-filter').on('click', function() {
    $('#faculty_id').val('');
    $('#level_id').val('');
    $('#program_id').val('');
});

</script>

</html>