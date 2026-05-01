<?php
include "../include/checklogin.php";
if (isset($_GET["id"])) {


    $inq_id = $_GET["id"];




    $status = 0;
    $cmd = $con->prepare("SELECT pro.id as id, pro.inq_student_id as inq_student_id, pro.first_name as first_name, pro.middle_name as middle_name, pro.last_name as last_name, pro.gender as gender, pro.dob as dob, pro.mobile_number as mobile_number, pro.mobile_number2 as mobile_number2, pro.email as email, pro.faculty_id as faculty_id, pro.level_id as level_id, pro.program_id as program_id, pro.last_exam as last_exam, pro.last_exam_marks as last_exam_mark, pro.is_online as is_online, faculty.name as faculty_name, level.name as level_name, program.name as program_name FROM tbl_inquiry_student as pro LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id LEFT JOIN tbl_level level ON pro.level_id = level.id LEFT JOIN tbl_program program ON pro.program_id = program.id WHERE pro.is_delete = ? AND pro.id = ?");
    $cmd->bind_param("ii", $status, $inq_id);
    $cmd->execute();
    $result = $cmd->get_result();

    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $inq_student_id = $row['inq_student_id'];
        $first_name  = $row['first_name'];
        $middle_name = $row['middle_name'];
        $last_name = $row['last_name'];
        $gender = $row['gender'];
        $dob = $row['dob'];
        $mobile_number = $row['mobile_number'];
        $mobile_number2 = $row['mobile_number2'];
        $email = $row['email'];
        $faculty_id = $row['faculty_id'];
        $level_id = $row['level_id'];
        $program_id = $row['program_id'];
        $last_exam = $row['last_exam'];
        $last_exam_mark = $row['last_exam_mark'];
        $is_online = $row['is_online'];
    }
}


if (isset($_POST['submit_std'])) {
    $last_exam = mysqli_real_escape_string($con, $_POST['exam']);
    $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $first_name =  mysqli_real_escape_string($con, $_POST["first_name"]);
    $middle_name = mysqli_real_escape_string($con, $_POST["middle_name"]);
    $last_name = mysqli_real_escape_string($con, $_POST["last_name"]);
    // $dob = mysqli_real_escape_string($con, $_POST["dob"]);
    $mobile_number = mysqli_real_escape_string($con, $_POST["mobile_number"]);
    $second_mobile_number = mysqli_real_escape_string($con, $_POST["second_mobile_number"]);
    $email = $_POST['email'];
    $followup = $_POST['followup'];
    $followUpDate = $_POST['followUpDate'];
    $gender = mysqli_real_escape_string($con, $_POST["gender"]);

    // validate Data$program_id = validate_data($program_id);
    $level_id = validate_data($level_id);
    $faculty_id = validate_data($faculty_id);
    $first_name = validate_data($first_name);
    $middle_name = validate_data($middle_name);
    $last_name = validate_data($last_name);
    // $dob = validate_data($dob);
    $mobile_number = validate_data($mobile_number);
    $second_mobile_number = validate_data($second_mobile_number);
    $email = validate_data($email);
    $gender = validate_data($gender);
    $is_online = 0;

    $stmt = $con->prepare("UPDATE `tbl_inquiry_student` SET `last_exam`=?, `first_name`=?, `middle_name`=?, `last_name`=?, `gender`=?,  `mobile_number`=?, `mobile_number2`=?, `email`=?, `faculty_id`=?, `level_id`=?, `program_id`=?, `last_exam_marks`=?, `is_online`=? WHERE `id`=?");
    $stmt->bind_param("ssssssssssiisi", $last_exam, $first_name, $middle_name, $last_name, $gender, $mobile_number, $second_mobile_number, $email, $faculty_id, $level_id, $program_id, $last_exam_marks, $is_online, $inq_id);
    $result = $stmt->execute();
    if ($result) {
        if ($result) {
            //Sweet Alert of Success Message
            $_SESSION['status'] = "Student Inquiry Inserted Successfully";
            $_SESSION['status_code'] = "success";

            echo "<script>setTimeout(function(){window.location=''},1000);</script>";
        } else {
            //Sweet Alert of Error Message
            $_SESSION['status'] = "Student Inquiry Insertion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location=''},1000)</script>";
        }
    }
}
if (isset($_POST['submit_remark'])) {
    $followup = $_POST['followUp'];
    $followUpDate = $_POST['followUpDate'];
    $remarks =  $_POST['remarks'];
    $call_status = mysqli_real_escape_string($con, $_POST['callStatus']);
    $call_rating = mysqli_real_escape_string($con, $_POST['callRating']);
    $followup_why_input = mysqli_real_escape_string($con, $_POST['followup_why_input']);

    $date = date("Y-m-d");
    // Format the date as needed

    $is_sms_sended = 0;
    $is_wp_msg_sended = 0;
    $stmt = $con->prepare("INSERT INTO `tbl_inquiry_remarks` (`inq_student_id`, `followup_why_input`, `is_followup_need`, `follow_up_date`, `remarks`, `is_sms_sended`, `is_wp_msg_sended`, `call_status`, `call_rating`, `staff_id`, `remark_date`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");


    // Assuming $inq_student_id and $followUpDate are integers and $followup is a string
    $stmt->bind_param("ssissiissss", $inq_student_id, $followup_why_input, $followup, $followUpDate, $remarks, $is_sms_sended, $is_wp_msg_sended, $call_status, $call_rating, $staff_id, $date);

    $result = $stmt->execute();


    $sql = "INSERT INTO `tbl_call_history` (`staff_id`, `inq_student_id`) VALUES (?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("is", $staff_id, $inq_student_id);
    $stmt->execute();

    $updateSql = "UPDATE `tbl_inquiry_student` SET `call_count` = `call_count` + 1 WHERE `id` = ?";
    $updateStmt = $con->prepare($updateSql);
    $updateStmt->bind_param("i", $inq_id);
    $updateStmt->execute();

    if ($followup == 0) {
        $updateSql = "UPDATE `tbl_inquiry_student` SET  `staff_id` = null WHERE `id` = ?";
        $updateStmt = $con->prepare($updateSql);
        $updateStmt->bind_param("i", $inq_id);
        $updateStmt->execute();
    }
    if ($result) {
        if ($result) {
            //Sweet Alert of Success Message
            $_SESSION['status'] = "Student Remark Inquiry Inserted Successfully ";
            $_SESSION['status_code'] = "success";

            echo "<script>setTimeout(function(){window.location='completed_calls.php'},1000);</script>";
        } else {
            //Sweet Alert of Error Message
            $_SESSION['status'] = "Student Remark Inquiry Insertion Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location=''},1000)</script>";
        }
    }

    // if ($result && $call_status == '2') {
    //     if ($result) {
    //         //Sweet Alert of Success Message
    //         $_SESSION['status'] = "Student Remark Inquiry Inserted Successfully";
    //         $_SESSION['status_code'] = "success";

    //         echo "<script>setTimeout(function(){window.location='view_followup.php'},1000);</script>";
    //     } else {
    //         //Sweet Alert of Error Message
    //         $_SESSION['status'] = "Student Remark Inquiry Insertion Failed";
    //         $_SESSION['status_code'] = "error";
    //         echo "<script>setTimeout(function(){window.location=''},1000)</script>";
    //     }
    // }
    // if ($result && $call_status == '3') {
    //     if ($result) {
    //         //Sweet Alert of Success Message
    //         $_SESSION['status'] = "Student Remark Inquiry Inserted Successfully";
    //         $_SESSION['status_code'] = "success";

    //         echo "<script>setTimeout(function(){window.location='view_assing_student.php'},1000);</script>";
    //     } else {
    //         //Sweet Alert of Error Message
    //         $_SESSION['status'] = "Student Remark Inquiry Insertion Failed";
    //         $_SESSION['status_code'] = "error";
    //         echo "<script>setTimeout(function(){window.location=''},1000)</script>";
    //     }
    // }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

    <!-- CKeditor custom script -->
    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>
    <!-- /.CKeditor custom script -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
    </div>
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
                            <h1 class="m-0">Inquiry Student</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Inquiry Student</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <!----------------------------------------------------------- student detail form  --------------------------------------------------------------------->
                <div class="card card-gmiu">
                    <div class="card-header">
                        <h3 class="card-title">Student Details</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body" style="display: block;">

                        <form id="quickForm" name="std_details" method="POST">
                            <div class="card-body">

                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label for="name">First Name<span style="color: red;">*</span></label>
                                        <input type="text" name="first_name" value="<?php echo $first_name ?>" class="form-control" id="title_id" placeholder="Enter First Name" required readonly>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="name">Middle Name<span style="color: red;">*</span></label>
                                        <input type="text" name="middle_name" value="<?php echo $middle_name ?>" class="form-control" id="title_id" placeholder="Enter Middle Name" required readonly>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="name">Last Name<span style="color: red;">*</span></label>
                                        <input type="text" name="last_name" value="<?php echo $last_name ?>" class="form-control" id="title_id" placeholder="Enter Last Name" required readonly>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="gender">Gender<span style="color: red;">*</span></label>
                                        <select name="gender" id="gender" value="<?php echo $gender ?>" class="form-control" required readonly>
                                            <option value="">---Select Gender---</option>
                                            <option value="male" <?php if ($gender == "male") {
                                                                        echo "selected";
                                                                    } ?>>Male</option>
                                            <option value="female" <?php if ($gender == "female") {
                                                                        echo "selected";
                                                                    } ?>>Female</option>
                                        </select>
                                    </div>
                                    <!-- <div class="form-group col-sm-3">
                                        <label for="name">Date Of Birth<span style="color: red;">*</span></label>
                                        <input type="date" name="dob" value="<?php //echo $dob 
                                                                                ?>" class="form-control" id="title_id" placeholder="Enter Date Of Birth" required>
                                    </div> -->
                                    <div class="form-group col-sm-3">
                                        <label for="name">Mobile Number<span style="color: red;">*</span></label>
                                        <input type="number" name="mobile_number" value="<?php echo $mobile_number ?>" class="form-control" id="title_id" placeholder="Enter Mobile Number" required readonly>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="name">Mobile Number 2</label>
                                        <input type="number" name="second_mobile_number" value="<?php echo $mobile_number2 ?>" class="form-control" id="title_id" placeholder="Enter Mobile Number 2">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="name">Email<span style="color: red;">*</span></label>
                                        <input type="email" name="email" value="<?php echo $email ?>" class="form-control" id="title_id" placeholder="Enter Email" required readonly>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="gender">Last Exam</label>
                                        <select name="exam" id="exam" class="form-control" required>
                                            <option value="">---Select Exam---</option>
                                            <option value="1" <?php if ($last_exam == "1") echo "selected"; ?>>SSC</option>
                                            <option value="2" <?php if ($last_exam == "2") echo "selected"; ?>>HSC(A)</option>
                                            <option value="3" <?php if ($last_exam == "3") echo "selected"; ?>>HSC(B)</option>
                                            <option value="4" <?php if ($last_exam == "4") echo "selected"; ?>>UG</option>
                                            <option value="5" <?php if ($last_exam == "5") echo "selected"; ?>>HSC(COMMERCE)</option>
                                            <option value="6" <?php if ($last_exam == "6") echo "selected"; ?>>HSC(ARTS)</option>
                                            <option value="7" <?php if ($last_exam == "7") echo "selected"; ?>>POST GRADUATION (PG)</option>
                                            <option value="8" <?php if ($last_exam == "8") echo "selected"; ?>>ITI</option>
                                            <option value="9" <?php if ($last_exam == "9") echo "selected"; ?>>DIPLOMA</option>
                                        </select>
                                    </div>
                                    <hr class="w-100">
                                    <!-- Choose Intersted Fields  -->
                                    <div class="form-group col-sm-4">
                                        <label>Select Faculty</label>
                                        <select class="form-control" name="faculty_id" id="faculty_id" required>
                                            <option value="">---Select Faculty---</option>
                                            <?php
                                            $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                            $stmt = $con->prepare($cmd);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                            ?>
                                                <option value="<?php echo $row['id'] ?>" <?php if ($faculty_id == $row['id']) {
                                                                                                echo "selected";
                                                                                            } ?>>
                                                    <?php echo $row['name'] ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Select Level</label>
                                        <select name="level_id" id="level_id" class="form-control">
                                            <option value="">---Select Level---</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Select Program</label>
                                        <select name="program_id" id="program_id" class="form-control">
                                            <option value="">---Select Program---</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" name="submit_std" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card card-gmiu">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6 align-self-center">
                                <h3 class="card-title">Call & Remarks</h3>
                            </div>
                            <div class="col-sm-6 text-right">
                                <a href="tel:<?= $mobile_number ?>" class="btn btn-light"><i class="fa fa-phone"></i>
                                    Call</a>
                                <a href="mail:<?= $email ?>" class="btn btn-info"><i class="fa fa-envelope"></i>
                                    Email</a>
                                <button type="button" class="btn btn-primary" id="sendSMS"><i class="fa fa-message"></i>
                                    Send SMS</button>
                                <button type="button" class="btn btn-success" id="sendWhatsApp"><i class="fa fa-brands fa-whatsapp"></i> Send WhatsApp</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form id="quickForm" name="remarks" method="POST">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="name">Remark<span style="color: red;">*</span></label>
                                    <textarea name="remarks" class="ckeditor" id="remarks" required></textarea>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="gender">Call status<span style="color: red;">*</span></label>
                                    <select class="form-control" name="callStatus" id="callStatus" required>
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
                                    <label for="gender">Call Ratings<span style="color: red;">*</span></label>
                                    <select class="form-control" name="callRating" id="callRating" required>
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
                                <div class="form-group col-sm-3">
                                    <label> Follow-up needed ? </label>
                                    <span style="color: red;">*</span>
                                    <label>
                                        <input type="radio" name="followUp" value="1" onclick="showDatePicker()" required> Yes
                                    </label>
                                    <label>
                                        <input type="radio" name="followUp" value="0" onclick="hideDatePicker()"> No
                                    </label>
                                </div>
                                <div id="datePickerContainer" style="display: none;" class="form-group col-sm-3">
                                    <label for="followUpDate">Follow-up Date and Time: </label>
                                    <input type="datetime-local" id="followUpDate" name="followUpDate">
                                </div>

                                <div class="form-group col-sm-12" id="followup_why" style="display: none;">
                                    <label for="why">Why Follow Up Is Not Needed?<span style="color: red;">*</span></label>
                                    <textarea name="followup_why_input" class="ckeditor" id="followup_why_input"></textarea>

                                </div>

                                <!-- <div class="form-group col-sm-3">
                                        <div id="outcomeDropdown" style="display: none;"> 
                                            <label for="gender">Call outcome<span style="color: red;">*</span></label>
                                            <select name="outcome" id="outcome" class="form-control">
                                                <option value="">---Select outcome---</option>
                                                <option value="success">Success</option>
                                                <option value="failure">Failure</option>
                                              
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-3">

                                        <div id="missedReasonsDropdown" style="display: none;"> 
                                            <label for="gender">Call outcome<span style="color: red;">*</span></label>
                                            <select name="missedReason" id="missedReason" class="form-control">
                                                <option value="">---Select missed reason---</option>
                                                <option value="no-answer">No Answer</option>
                                                <option value="busy">Busy</option>
                                            </select>
                                        </div>
                                    </div> -->
                                <div class=" form-group  text-right" class="form-group col-sm-3">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">
                                        click to view old Remarks
                                    </button>
                                </div>
                                <div class="modal fade" id="modal-lg" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content ">
                                            <div class="modal-header">
                                                <h4 class="modal-title">old Remarks</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">x</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                                    <thead>
                                                        <tr align="center">
                                                            <th scope="row" style="color:black;"><b>Inquiry ID</b>
                                                            </th>
                                                            <th scope="row" style="color:black;"><b>Inquiry Staff</b>
                                                            </th>
                                                            <th scope="row" style="color:black;"><b>Inquiry Date</b>
                                                            </th>
                                                            <th scope="row" style="color:black;"><b>Call Status</b>
                                                            </th>
                                                            <th scope="row" style="color:black;"><b>Call Ranking</b>
                                                            </th>
                                                            <th scope="row" style="color:black;"><b>Remarks</b></th>
                                                        </tr>
                                                    </thead><?php
                                                            $status = 0;

                                                            $cmd = $con->prepare("SELECT CS.call_title AS call_status_title, CR.call_title AS call_rating_title, pro.id as id, pro.remark_date as date, staff.name as name ,pro.staff_id as staff_id, pro.remarks as remarks, pro.inq_student_id as inq_student_id , pro.call_status as call_status FROM tbl_inquiry_remarks as pro 
                                                              LEFT JOIN tbl_staff staff ON pro.staff_id = staff.id 
                                                              LEFT JOIN tbl_call_status CS ON pro.call_status = CS.id
                                                              LEFT JOIN tbl_call_status CR ON pro.call_rating = CR.id
                                                              WHERE pro.is_delete = ? AND pro.inq_student_id = ?");
                                                            $cmd->bind_param("is", $status, $inq_student_id);
                                                            $cmd->execute();
                                                            $result = $cmd->get_result();
                                                            while ($row = $result->fetch_assoc()) {
                                                                $id = $row['id'];
                                                                $inq_student_id = $row['inq_student_id'];
                                                                $date = $row['date'];
                                                                $staff_id = $row['staff_id'];
                                                                $staff_name = $row['name'];
                                                                $remarks = $row['remarks'];
                                                                $call_status_title = !empty($row['call_status_title']) ? $row['call_status_title'] : "<b>N/A</b>";
                                                                $call_rating_title = !empty($row['call_rating_title']) ? $row['call_rating_title'] : "<b>N/A</b>";
                                                                // Additional variables can be added here based on your database columns.
                                                            ?>
                                                        <tbody>
                                                            <tr align="center">
                                                                <td scope="row">
                                                                    <?php echo  $inq_student_id; ?>
                                                                </td>
                                                                <td scope="row">
                                                                    <?php echo  $staff_name; ?>
                                                                </td>
                                                                <td scope="row">
                                                                    <?php echo  $date; ?>
                                                                </td>
                                                                <td scope="row">
                                                                    <?php echo $call_status_title ?>
                                                                </td>
                                                                <td scope="row">
                                                                    <?php echo $call_rating_title ?>
                                                                </td>
                                                                <td scope="row">
                                                                    <?php echo  $remarks; ?>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    <?php
                                                            }                                                       ?>
                                                    <tfoot>
                                                        <tr align="center">
                                                            <th scope="row" style="color:black;"><b>Inquiry ID</b>
                                                            </th>
                                                            <th scope="row" style="color:black;"><b>Inquiry Staff</b>
                                                            </th>
                                                            <th scope="row" style="color:black;"><b>Inquiry Date</b>
                                                            </th>
                                                            <th scope="row" style="color:black;"><b>Call Status</b>
                                                            </th>
                                                            <th scope="row" style="color:black;"><b>Call Ranking</b>
                                                            </th>
                                                            <th scope="row" style="color:black;"><b>Remarks</b></th>
                                                        </tr>
                                                    </tfoot>

                                                </table>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" name="submit_remark" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
                    </div>
                    </form>
                </div>

        </div>

    </div>
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


    <style>
        #datePickerContainer {
            display: none;
        }
    </style>
    <script>
        $(document).ready(function() {
            //call for listing the dropdown and select by default
            load_level();
            load_program();
        });

        function load_level() {
            var path = '<?php echo $base_url_api; ?>';
            var faculty_id = <?php echo $faculty_id; ?>;
            var level_id = <?php echo $level_id; ?>;
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
            var faculty_id = <?php echo $faculty_id; ?>;
            var level_id = <?php echo $level_id; ?>;
            var program_id = <?php echo $program_id; ?>;
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
                }
            })
        });
    </script>
    <script>
        function showDatePicker() {
            document.getElementById('datePickerContainer').style.display = 'block';
            document.getElementById('followup_why').style.display = 'none';

        }

        function hideDatePicker() {
            document.getElementById('datePickerContainer').style.display = 'none';
            document.getElementById('followup_why').style.display = 'block';

        }
    </script>




    <script>
        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("readonly", "readonly")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle Send SMS button click
            $("#sendSMS").click(function() {
                var mobileNumber = "<?php echo $mobile_number ?>"; // Get the mobile number from PHP
                var inq_id = "<?php echo $inq_id ?>";
                // Perform an AJAX request to send an SMS
                $.ajax({
                    type: "POST",
                    url: "send_sms.php", // Replace with your PHP script to send SMS
                    data: {
                        mobileNumber: mobileNumber,
                        inq_id: inq_id
                    },
                    success: function(response) {
                        if (response === "success") {
                            alert("SMS message sent successfully.");
                        } else {
                            alert("Failed to send SMS message.");
                        }
                    },
                    error: function() {
                        alert("Failed to send SMS.");
                    }
                });
            });

            // Handle Send WhatsApp button click
            $("#sendWhatsApp").click(function() {
                var mobileNumber = "<?php echo $mobile_number ?>"; // Get the mobile number from PHP
                var inq_id = "<?php echo $inq_id ?>";

                // Perform an AJAX request to send a WhatsApp message
                $.ajax({
                    type: "POST",
                    url: "send_wp.php", // Replace with your PHP script to send WhatsApp messages
                    data: {
                        mobileNumber: mobileNumber,
                        inq_id: inq_id
                    },
                    success: function(response) {
                        if (response === "success") {
                            alert("WhatsApp message sent successfully.");
                        } else {
                            alert("Failed to send WhatsApp message.");
                        }
                    },
                    error: function() {
                        alert("Error occurred during the AJAX request.");
                    }
                });
            });

        });
    </script>
    <!-- jQuery library -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Initialize Bootstrap functionality -->
    <script>
        // Initialize tooltip component
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        // Initialize popover component
        $(function() {
            $('[data-toggle="popover"]').popover()
        })
    </script>
    <!-- <script>
    function showDropdown() {
        var callStatusDropdown = document.getElementById("callStatus");
        var outcomeDropdown = document.getElementById("outcomeDropdown"); // Updated ID
        var missedReasonsDropdown = document.getElementById("missedReasonsDropdown"); // Updated ID

        if (callStatusDropdown.value === "1") {
            outcomeDropdown.style.display = "block";
            outcomeDropdown.required = true;
            missedReasonsDropdown.style.display = "none";
            missedReasonsDropdown.required = false;
        } else if (callStatusDropdown.value === "2") {
            outcomeDropdown.style.display = "none";
            outcomeDropdown.required = false;
            missedReasonsDropdown.style.display = "block";
            missedReasonsDropdown.required = true;
        } else {
            outcomeDropdown.style.display = "none";
            outcomeDropdown.required = false;
            missedReasonsDropdown.style.display = "none";
            missedReasonsDropdown.required = false;
        }
    }
</script> -->


</body>

</html>