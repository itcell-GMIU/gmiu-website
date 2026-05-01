<?php

include '../include/checklogin.php';
set_time_limit(0);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (isset($_GET['url_faculty_id']) && $_GET['url_faculty_id'] != "") {

    $url_faculty_id = mysqli_real_escape_string($con, $_GET['url_faculty_id']);
    $url_faculty_id = validate_data($url_faculty_id);
    // if (isset($_GET['url_faculty_id'])) {
    $url_faculty_id = $_GET['url_faculty_id'];
    $query = "SELECT name as faculty_name FROM tbl_faculty WHERE id= $url_faculty_id";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $faculty_name = $row['faculty_name'];
    } else {
        $faculty_name = "";
    }
} else {
    $faculty_name = "";
    $url_faculty_id = "";
}
if (isset($_GET['url_level_id']) && $_GET['url_level_id'] != "") {
    $url_level_id = mysqli_real_escape_string($con, $_GET['url_level_id']);
    $url_level_id = validate_data($url_level_id);
    $query = "SELECT name as level_name FROM tbl_level WHERE id= $url_level_id";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $level_name = $row['level_name'];
    } else {
        $level_name = "";
    }
} else {
    $url_level_id = "";
    $level_name = "";
}
if (isset($_GET['url_program_id']) && $_GET['url_program_id'] != "") {
    $url_program_id = mysqli_real_escape_string($con, $_GET['url_program_id']);
    $url_program_id = validate_data($url_program_id);
    $query = "SELECT name as program_name FROM tbl_program WHERE id= $url_program_id";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $program_name = $row['program_name'];
    } else {
        $program_name = "";
    }
} else {
    $url_program_id = "";
    $program_name = "";
}
if (isset($_GET['url_staff_id']) && $_GET['url_staff_id'] != "") {
    $url_staff_id = mysqli_real_escape_string($con, $_GET['url_staff_id']);
    $url_staff_id = validate_data($url_staff_id);
    $query = "SELECT name as staff_name FROM tbl_staff WHERE id= $url_staff_id";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $staff_name = $row['staff_name'];
    } else {
        $staff_name = "";
    }
} else {
    $url_staff_id = "";
    $staff_name = "";
}

if (isset($_GET['url_call_status']) && $_GET['url_call_status'] != "") {
    $url_call_status = mysqli_real_escape_string($con, $_GET['url_call_status']);
    $url_call_status = validate_data($url_call_status);
    $query = "SELECT call_title as call_status_name FROM tbl_call_status WHERE id= $url_call_status";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $call_status_name = $row['call_status_name'];
    } else {
        $call_status_name = "";
    }
} else {
    $url_call_status = "";
    $call_status_name = "";
}

if (isset($_GET['url_call_rating']) && $_GET['url_call_rating'] != "") {
    $url_call_rating = mysqli_real_escape_string($con, $_GET['url_call_rating']);
    $url_call_rating = validate_data($url_call_rating);
    $query = "SELECT call_title as call_rating_name FROM tbl_call_status WHERE id= $url_call_rating";
    // Correct the table name to the appropriate table for call_rating
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $call_rating_name = $row['call_rating_name'];
    } else {
        $call_rating_name = "";
    }
} else {
    $url_call_rating = "";
    $call_rating_name = "";
}

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
                            <h1 class="m-0">Called Student List</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Called Student List</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->


            <section class="content">

                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- jquery validation -->
                            <div class="card mb-3">
                                <div class="card-header">

                                    <i class="far fa-hand-pointer"></i>

                                    <span> <b>Select Faculty to Call Report</b></span>

                                </div>
                                <form method="GET" action="">
                                    <div class="card-body">
                                        <div class="form-group">
                                            
                                            <div class="form-row">
                                                
                                                <div class="col-md-2">
                                                    <div class="form-label-group">
                                                        <?php if ($role_id != 14) { ?>
                                                            <select id="faculty_id" name="url_faculty_id" class="browser-default custom-select">
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
                                                <div class="col-md-2">
                                                    <div class="form-label-group">
                                                        <select name="url_level_id" id="level_id" class="browser-default custom-select">
                                                            <option value="">---Select Level---</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-label-group">
                                                        <select name="url_program_id" id="program_id" class="browser-default custom-select">
                                                            <option value="">---Select Program---</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class=" form-group col-sm-3">
                                                            <select class="form-control" name="url_call_status" id="url_call_status">
                                                                <option value="">---Select Call Status---</option>
                                                                <?php
                                                                $cmd = "SELECT * FROM tbl_call_status WHERE call_type = '1'";
                                                                $stmt = $con->prepare($cmd);
                                                                $stmt->execute();
                                                                $result = $stmt->get_result();
                                                                while ($row = $result->fetch_assoc()) {
                                                                ?>
                                                                    <option value="<?php echo $row['id'] ?>">
                                                                        <?php echo $row['call_title'] ?></option>
                                                                <?php } ?>

                                                            </select>
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <select class="form-control" name="url_call_rating" id="url_call_status">
                                                            <option value="">---Select Call Ratings---</option>
                                                            <?php
                                                            $cmd = "SELECT * FROM tbl_call_status WHERE call_type = '2'";
                                                            $stmt = $con->prepare($cmd);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();
                                                            while ($row = $result->fetch_assoc()) {
                                                            ?>
                                                                <option value="<?php echo $row['id'] ?>">
                                                                    <?php echo $row['call_title'] ?></option>
                                                            <?php } ?>

                                                        </select>
                                                    </div>
                                                <?php } ?>
                                                <div class="form-group col-sm-2">
                                                    <select class="form-control" name="url_staff_id" id="staff_id">
                                                        <option value="">---Select Staff Name---</option>
                                                        <?php
                                                        $stmt = $con->prepare("SELECT id, name FROM tbl_staff WHERE is_delete = '0' AND is_active = '1' AND role_id = '15'");
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();

                                                        while ($row = $result->fetch_assoc()) {
                                                            $selected = ($url_staff_id == $row['id']) ? "selected" : "";
                                                        ?>
                                                            <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
                                                                <?php echo $row['name']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>

                                                </div>


                                                <div class="col-md-2">
                                                    <input type="submit" class="btn btn-primary btn-block" id="export" style="float:center" />

                                                </div>
                                                </div>
                                            </div>

                                        </div>

                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (right) -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->


                <div class="container-fluid">

                    <!--   Faculty list code  -->
                    <div class="card">
                        <div class="card-header">


                            <span>
                                <center>
                                    <h5><b><i class="fa-solid fa-phone-volume"></i> Called Student List</b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Student ID</b></th>
                                            <th scope="row" style="color:black;"><b>Student Name</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level Name</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number 1</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number 2</b></th>
                                            <th scope="row" style="color:black;"><b>Caller Name</b></th>
                                            <th scope="row" style="color:black;"><b>Called Date</b></th>
                                            <th scope="row" style="color:black;"><b>Call Status</b></th>
                                            <th scope="row" style="color:black;"><b>Call Ratings</b></th>
                                            <th scope="row" style="color:black;"><b>FollowUp Needed</b></th>
                                            <th scope="row" style="color:black;"><b>FollowUp Date</b></th>
                                            <th scope="row" style="color:black;"><b>FollowUp Remark</b></th>
                                            <th scope="row" style="color:black;"><b>Remarks</b></th>
                                            <th scope="row" style="color:black;"><b>View Student detail</b></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $status = "1";
                                       
                                        $cmd = "SELECT CS.call_title AS call_status_title, R.followup_why_input as followup_why_input,
                                                CR.call_title AS call_rating_title, R.follow_up_date as followup_date, R.is_followup_need as followup, R.call_status as call_status,  R.remark_date as date, staff.name as staff_name, faculty.name as faculty_name, level.name as level_name, program.name as program_name, S.mobile_number as mobile_number, S.mobile_number2 as mobile_number2, S.id AS id, R.inq_student_id AS student_id, CONCAT(S.first_name, ' ', S.last_name) AS student_name, R.remarks AS call_remarks FROM tbl_inquiry_remarks R JOIN tbl_inquiry_student S ON R.inq_student_id = S.inq_student_id 
                                                LEFT JOIN tbl_faculty faculty ON S.faculty_id = faculty.id 
                                                LEFT JOIN tbl_level level ON S.level_id = level.id 
                                                LEFT JOIN tbl_program program ON S.program_id = program.id
                                                LEFT JOIN tbl_staff staff ON R.staff_id = staff.id 
                                                LEFT JOIN tbl_call_status CS ON R.call_status = CS.id
                                                LEFT JOIN tbl_call_status CR ON R.call_rating = CR.id
                                                WHERE R.is_active = '1'  AND R.is_delete = '0'  ";
                                        if ($role_id == "14") {
                                            $cmd .= " AND S.faculty_id = '$faculty_id' AND S.level_id = '$level_id' AND S.program_id = '$program_id'";
                                        }
                                        if ($url_faculty_id != "") {
                                             $cmd .= " AND S.faculty_id = '$url_faculty_id'";
                                        }
                                        if ($url_level_id != "") {
                                            // $cmd .= " AND S.level_id = '$url_level_id'";
                                        }
                                        if ($url_program_id != "") {
                                            // $cmd .= " AND S.program_id = '$url_program_id'";
                                        }
                                        if ($url_staff_id != "") {
                                            // $cmd .= " AND R.staff_id = '$url_staff_id'";
                                        }
                                        if ($url_call_rating != "") {
                                            // $cmd .= " AND R.call_rating = '$url_call_rating'";
                                        }
                                        if ($url_call_status != "") {
                                            // $cmd .= " AND R.call_status = '$url_call_status'";
                                        }
                                       
                                        $cmd = $con->prepare($cmd); // Bind values to placeholders
                                        $cmd->execute();
                                        
                                        

                                        $result = $cmd->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $student_id = $row['student_id'];
                                            $student_name = !empty($row['student_name']) ? $row['student_name'] : "<b>N/A</b>";
                                            $call_remarks = !empty($row['call_remarks']) ? $row['call_remarks'] : "<b>N/A</b>";
                                            $mobile_number = !empty($row['mobile_number']) ? $row['mobile_number'] : "<b>N/A</b>";
                                            $mobile_number2 = !empty($row['mobile_number2']) ? $row['mobile_number2'] : "<b>N/A</b>";
                                            $program_name = !empty($row['program_name']) ? $row['program_name'] : "<b>N/A</b>";
                                            $faculty_name = !empty($row['faculty_name']) ? $row['faculty_name'] : "<b>N/A</b>";
                                            $level_name = !empty($row['level_name']) ? $row['level_name'] : "<b>N/A</b>";
                                            $staff_name = !empty($row['staff_name']) ? $row['staff_name'] : "<b>N/A</b>";
                                            $date = !empty($row['date']) ? $row['date'] : "<b>N/A</b>";
                                            $call_status = !empty($row['call_status']) ? $row['call_status'] : "<b>N/A</b>";
                                            $followup =  !empty($row['followup ']) ? $row['followup '] : "<b>N/A</b>";
                                            $followup_date =  !empty($row['followup_date ']) ? $row['followup_date '] : "<b>N/A</b>";
                                            $followup_why_input =  $row['followup_why_input'];
                                            $call_status_title = !empty($row['call_status_title']) ? $row['call_status_title'] : "<b>N/A</b>";
                                            $call_rating_title = !empty($row['call_rating_title']) ? $row['call_rating_title'] : "<b>N/A</b>";

                                            if ($followup == 1) {
                                                $followup1 = "Yes";
                                            } else {
                                                $followup1 = "No";
                                            }

                                            // $faculty_is_active = $row['faculty_is_active'];
                                        ?>
                                            <tr align="center">
                                                <td scope="row">
                                                    <?php echo $student_id; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $student_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $faculty_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $level_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $program_name; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $mobile_number; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $mobile_number2; ?>
                                                </td>

                                                <td scope="row">
                                                    <?php echo $staff_name; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $date; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $call_status_title ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $call_rating_title ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $followup1; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $followup_date; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo htmlspecialchars_decode($followup_why_input) ; ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $call_remarks; ?>
                                                </td>
                                                <td scope="row">
                                                    <a href="view_student_detail.php?id=<?php echo $row['id'] ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Student ID</b></th>
                                            <th scope="row" style="color:black;"><b>Student Name</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                            <th scope="row" style="color:black;"><b>Level Name</b></th>
                                            <th scope="row" style="color:black;"><b>Program Name</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number 1</b></th>
                                            <th scope="row" style="color:black;"><b>Mobile Number 2</b></th>
                                            <th scope="row" style="color:black;"><b>Caller Name</b></th>
                                            <th scope="row" style="color:black;"><b>Called Date</b></th>
                                            <th scope="row" style="color:black;"><b>Call Status</b></th>
                                            <th scope="row" style="color:black;"><b>Call Ratings</b></th>
                                            <th scope="row" style="color:black;"><b>FollowUp Needed</b></th>
                                            <th scope="row" style="color:black;"><b>FollowUp Date</b></th>
                                            <th scope="row" style="color:black;"><b>FollowUp Remark</b></th>
                                            <th scope="row" style="color:black;"><b>Remarks</b></th>
                                            <th scope="row" style="color:black;"><b>View Student detail</b></th>
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
<script>
    $(document).ready(function() {
        //call for listing the dropdown and select by default
        load_level();
        load_program();
    });

    function load_level() {
        var path = '<?php echo $base_url_api; ?>';
        var faculty_id = <?php echo $url_faculty_id; ?>;
        var level_id = <?php echo $url_level_id; ?>;
        var api_for = "dashboard";
        $.ajax({
            url: path + 'level.php',
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_id: level_id,
                api_for: api_for
            },
            success: function(result) {
                $('#level_id').html(result);
            }
        });

    }

    function load_program() {
        var path = '<?php echo $base_url_api; ?>';
        var faculty_id = <?php echo $url_faculty_id; ?>;
        var level_id = <?php echo $url_level_id; ?>;
        var program_id = <?php echo $url_program_id; ?>;
        var api_for = "dashboard";
        $.ajax({
            url: path + 'program.php',
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_data: level_id,
                program_id: program_id,
                api_for: api_for
            },
            success: function(result) {
                $('#program_id').html(result);
            }
        });

    }
</script>
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
</script>


</html>