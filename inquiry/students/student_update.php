<?php
// Include the checklogin.php file
include '../include/checklogin.php';


if (isset($_POST['submit_std'])) {
    $inq_id = $_POST["id"];
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
    $gender = mysqli_real_escape_string($con, $_POST["gender"]);
    $last_exam_status = mysqli_real_escape_string($con, $_POST["last_exam_status"]);
    $is_online = mysqli_real_escape_string($con, $_POST["is_online"]);


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
    $last_exam_status = validate_data($last_exam_status);
 
    $mobileQuery = $con->prepare("SELECT mobile_number FROM tbl_inquiry_student WHERE mobile_number = ?");
    $mobileQuery->bind_param("s", $mobile_number);
    $mobileQuery->execute();
    $mobileResult =  $mobileQuery->get_result();

    // if (mysqli_num_rows($mobileResult) > 0) {
    //     // Email already exists, display an error message
    //     $_SESSION['status'] = "Mobile Number Already Exist";
    //     $_SESSION['status_code'] = "error";
    //     echo "<script>setTimeout(function(){window.location='student_view.php'},1000)</script>";
    // } else {
        $stmt = $con->prepare("UPDATE `tbl_inquiry_student` SET  `last_exam_status`=? ,`last_exam`=?, `first_name`=?, `middle_name`=?, `last_name`=?, `gender`=?,  `mobile_number`=?, `mobile_number2`=?, `email`=?, `faculty_id`=?, `level_id`=?, `program_id`=?, `last_exam_marks`=?, `is_online`=? WHERE `id`=?");
        $stmt->bind_param("iisssssssssiisi",$last_exam_status ,$last_exam, $first_name, $middle_name, $last_name, $gender, $mobile_number, $second_mobile_number, $email, $faculty_id, $level_id, $program_id, $last_exam_marks, $is_online, $inq_id);
        $result = $stmt->execute();
        if ($result) {
            if ($result) {
                //Sweet Alert of Success Message
                $_SESSION['status'] = "Student Inquiry Update Successfully";
                $_SESSION['status_code'] = "success";

                echo "<script>setTimeout(function(){window.location='student_view.php'},1000);</script>";
            } else {
                //Sweet Alert of Error Message
                $_SESSION['status'] = "Student Inquiry Update Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='student_view.php'},1000)</script>";
            }
        }
    }
//}
