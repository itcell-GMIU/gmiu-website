<?php
include 'include/checklogin.php';

if (isset($_POST["submit"])) {
    
    $stu_id = mysqli_real_escape_string($con, $_POST['stu_id']);

    $ssc_boardname = isset($_POST['ssc_boardname']) ? $_POST['ssc_boardname'] : "";
    $ssc_schoolname = isset($_POST['ssc_schoolname']) ? $_POST['ssc_schoolname'] : "";
    $ssc_percentage = isset($_POST['ssc_percentage']) ? $_POST['ssc_percentage'] : "";
    $ssc_passingmonth = isset($_POST['ssc_passingmonth']) ? $_POST['ssc_passingmonth'] : "";
    $ssc_passingyear = isset($_POST['ssc_passingyear']) ? $_POST['ssc_passingyear'] : "";
    $hsc_stream = isset($_POST['hsc_stream']) ? $_POST['hsc_stream'] : "";
    $hsc_boardseatnumber = isset($_POST['hsc_boardseatnumber']) ? $_POST['hsc_boardseatnumber'] : "";
    $hsc_schoolname = isset($_POST['hsc_schoolname']) ? $_POST['hsc_schoolname'] : "";
    $hsc_percentage = isset($_POST['hsc_percentage']) ? $_POST['hsc_percentage'] : "";
    $hsc_passingstatus = isset($_POST['hsc_passingstatus']) ? $_POST['hsc_passingstatus'] : "";
    $hsc_passingmonth = isset($_POST['hsc_passingmonth']) ? $_POST['hsc_passingmonth'] : "";
    $hsc_passingyear = isset($_POST['hsc_passingyear']) ? $_POST['hsc_passingyear'] : "";
    $hsc_passingboard = isset($_POST['hsc_passingboard']) ? $_POST['hsc_passingboard'] : "";
    $gujcet_appear = isset($_POST['gujcet_appear']) ? $_POST['gujcet_appear'] : "";
    $gujcet_seatnumber = isset($_POST['gujcet_seatnumber']) ? $_POST['gujcet_seatnumber'] : "";
    $gujcet_applicationnumber = isset($_POST['gujcet_applicationnumber']) ? $_POST['gujcet_applicationnumber'] : "";
    $jee_appear = isset($_POST['jee_appear']) ? $_POST['jee_appear'] : "";
    $jee_seatnumber = isset($_POST['jee_seatnumber']) ? $_POST['jee_seatnumber'] : "";
    $jee_applicationnumber = isset($_POST['jee_applicationnumber']) ? $_POST['jee_applicationnumber'] : "";
    $neet_appear = isset($_POST['neet_appear']) ? $_POST['neet_appear'] : "";
    $neet_seatnumber = isset($_POST['neet_seatnumber']) ? $_POST['neet_seatnumber'] : "";
    $neet_applicationnumber = isset($_POST['neet_applicationnumber']) ? $_POST['neet_applicationnumber'] : "";
    $graduation_course = isset($_POST['graduation_course']) ? $_POST['graduation_course'] : "";
    $graduation_university = isset($_POST['graduation_university']) ? $_POST['graduation_university'] : "";
    $graduation_college_name = isset($_POST['graduation_college_name']) ? $_POST['graduation_college_name'] : "";
    $graduation_cpi = isset($_POST['graduation_cpi']) ? $_POST['graduation_cpi'] : "";
    $graduation_passing_status = isset($_POST['graduation_passing_status']) ? $_POST['graduation_passing_status'] : "";
    $graduation_passing_month = isset($_POST['graduation_passing_month']) ? $_POST['graduation_passing_month'] : "";
    $graduation_passing_year = isset($_POST['graduation_passing_year']) ? $_POST['graduation_passing_year'] : "";
    $gmcet_score = isset($_POST['gmcet_score']) ? $_POST['gmcet_score'] : "";
    $cmat_score = isset($_POST['cmat_score']) ? $_POST['cmat_score'] : "";

    $ssc_boardname = mysqli_real_escape_string($con, $ssc_boardname);
    $ssc_schoolname = mysqli_real_escape_string($con, $ssc_schoolname);
    $ssc_percentage = mysqli_real_escape_string($con, $ssc_percentage);
    $ssc_passingmonth = mysqli_real_escape_string($con, $ssc_passingmonth);
    $ssc_passingyear = mysqli_real_escape_string($con, $ssc_passingyear);
    $hsc_stream = mysqli_real_escape_string($con, $hsc_stream);
    $hsc_boardseatnumber = mysqli_real_escape_string($con, $hsc_boardseatnumber);
    $hsc_schoolname = mysqli_real_escape_string($con, $hsc_schoolname);
    $hsc_percentage = mysqli_real_escape_string($con, $hsc_percentage);
    $hsc_passingstatus = mysqli_real_escape_string($con, $hsc_passingstatus);
    $hsc_passingboard = mysqli_real_escape_string($con, $hsc_passingboard);
    $gujcet_appear = mysqli_real_escape_string($con, $gujcet_appear);
    $gujcet_seatnumber = mysqli_real_escape_string($con, $gujcet_seatnumber);
    $gujcet_applicationnumber = mysqli_real_escape_string($con, $gujcet_applicationnumber);
    $jee_appear = mysqli_real_escape_string($con, $jee_appear);
    $jee_seatnumber = mysqli_real_escape_string($con, $jee_seatnumber);
    $jee_applicationnumber = mysqli_real_escape_string($con, $jee_applicationnumber);
    $neet_appear = mysqli_real_escape_string($con, $neet_appear);
    $neet_seatnumber = mysqli_real_escape_string($con, $neet_seatnumber);
    $neet_applicationnumber = mysqli_real_escape_string($con, $neet_applicationnumber);
    $graduation_course = mysqli_real_escape_string($con, $graduation_course);
    $graduation_university = mysqli_real_escape_string($con, $graduation_university);
    $graduation_college_name = mysqli_real_escape_string($con, $graduation_college_name);
    $graduation_cpi = mysqli_real_escape_string($con, $graduation_cpi);
    $graduation_passing_status = mysqli_real_escape_string($con, $graduation_passing_status);
    $graduation_passing_month = mysqli_real_escape_string($con, $graduation_passing_month);
    $graduation_passing_year = mysqli_real_escape_string($con, $graduation_passing_year);
    $gmcet_score = mysqli_real_escape_string($con, $gmcet_score);
    $cmat_score = mysqli_real_escape_string($con, $cmat_score);

    //validate data
    $ssc_boardname = validate_data($ssc_boardname);
    $ssc_schoolname = validate_data($ssc_schoolname);
    $ssc_percentage = validate_data($ssc_percentage);
    $ssc_passingmonth = validate_data($ssc_passingmonth);
    $ssc_passingyear = validate_data($ssc_passingyear);
    $hsc_stream = validate_data($hsc_stream);
    $hsc_boardseatnumber = validate_data($hsc_boardseatnumber);
    $hsc_schoolname = validate_data($hsc_schoolname);
    $hsc_percentage = validate_data($hsc_percentage);
    $hsc_passingstatus = validate_data($hsc_passingstatus);
    $hsc_passingboard = validate_data($hsc_passingboard);
    $gujcet_appear = validate_data($gujcet_appear);
    $gujcet_seatnumber = validate_data($gujcet_seatnumber);
    $gujcet_applicationnumber = validate_data($gujcet_applicationnumber);
    $jee_appear = validate_data($jee_appear);
    $jee_seatnumber = validate_data($jee_seatnumber);
    $jee_applicationnumber = validate_data($jee_applicationnumber);
    $neet_appear = validate_data($neet_appear);
    $neet_seatnumber = validate_data($neet_seatnumber);
    $neet_applicationnumber = validate_data($neet_applicationnumber);
    $graduation_course = validate_data($graduation_course);
    $graduation_university = validate_data($graduation_university);
    $graduation_college_name = validate_data($graduation_college_name);
    $graduation_cpi = validate_data($graduation_cpi);
    $graduation_passing_status = validate_data($graduation_passing_status);
    $graduation_passing_month = validate_data($graduation_passing_month);
    $graduation_passing_year = validate_data($graduation_passing_year);
    $gmcet_score = validate_data($gmcet_score);
    $cmat_score = validate_data($cmat_score);

    //select 
    $cmd = $con->prepare("SELECT edu_qual.id from tbl_education_qualification as edu_qual
       WHERE edu_qual.student_id= ? AND edu_qual.is_active=1 AND edu_qual.is_delete=0");
    $cmd->bind_param("i", $stu_id);
    $cmd->execute();
    $ex = $cmd->get_result();
    if ($ex->num_rows == 0) {
        //insert code
        $stmt = $con->prepare("INSERT INTO `tbl_education_qualification`(student_id, ssc_boardname, ssc_schoolname, ssc_percentage, ssc_passingmonth, ssc_passingyear, hsc_stream, hsc_boardseatnumber, hsc_schoolname, hsc_percentage, hsc_passingstatus, hsc_passingmonth, hsc_passingyear, hsc_passingboard, gujcet_appear, gujcet_seatnumber, gujcet_applicationnumber, jee_appear, jee_seatnumber, jee_applicationnumber, neet_appear, neet_seatnumber, neet_applicationnumber, graduation_course, graduation_university, graduation_college_name, graduation_cpi, graduation_passing_status, graduation_passing_month, graduation_passing_year, gmcet_score, cmat_score, created_by)
                                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("issdiisssdsiisssissississsdsiiddi", $stu_id, $ssc_boardname, $ssc_schoolname, $ssc_percentage, $ssc_passingmonth, $ssc_passingyear, $hsc_stream, $hsc_boardseatnumber, $hsc_schoolname, $hsc_percentage, $hsc_passingstatus, $hsc_passingmonth, $hsc_passingyear, $hsc_passingboard, $gujcet_appear, $gujcet_seatnumber, $gujcet_applicationnumber, $jee_appear, $jee_seatnumber, $jee_applicationnumber, $neet_appear, $neet_seatnumber, $neet_applicationnumber, $graduation_course, $graduation_university, $graduation_college_name, $graduation_cpi, $graduation_passing_status, $graduation_passing_month, $graduation_passing_year, $gmcet_score, $cmat_score, $stu_id);
        $result = $stmt->execute();
        if ($result) {
            //if inserted successfully update the step and education detail status
            $step = 3;
            $education_detail_status = 1;
            $stmt = $con->prepare("UPDATE `tbl_admission_student` SET education_detail_status = ? , step = ? WHERE id = ? ");
            $stmt->bind_param("iii", $education_detail_status, $step, $stu_id);
            $result = $stmt->execute();
            if ($result) {
                $response = [
                    'status' => 200,
                    'message' => 'Record Updated Successfully!'
                ];
            } else {
                $response = [
                    'status' => 400,
                    'message' => $con->error
                ];
            }
        } else {
            $response = [
                'status' => 400,
                'message' => $con->error
            ];
        }
    } else {
        //update code
        $stmt = $con->prepare("UPDATE `tbl_education_qualification` SET ssc_boardname = ?,ssc_schoolname = ?,ssc_percentage= ? ,ssc_passingmonth= ?,ssc_passingyear= ?,hsc_stream=?,hsc_boardseatnumber= ?, hsc_schoolname =?, hsc_percentage = ?, hsc_passingstatus = ?, hsc_passingmonth = ?, hsc_passingyear = ?, hsc_passingboard = ?, gujcet_appear = ?, gujcet_seatnumber = ?, gujcet_applicationnumber = ?, jee_appear = ?, jee_seatnumber = ?, jee_applicationnumber = ?, neet_appear = ?,neet_seatnumber = ?, neet_applicationnumber = ?,graduation_course = ?,graduation_university=?,graduation_college_name = ?,graduation_cpi = ?, graduation_passing_status = ?,graduation_passing_month = ?,graduation_passing_year=?,gmcet_score = ?,cmat_score = ?,updated_by = ? WHERE student_id = ? ");
        $stmt->bind_param("ssdiisssdsiisssissississsdsiiddii", $ssc_boardname, $ssc_schoolname, $ssc_percentage, $ssc_passingmonth, $ssc_passingyear, $hsc_stream, $hsc_boardseatnumber, $hsc_schoolname, $hsc_percentage, $hsc_passingstatus, $hsc_passingmonth, $hsc_passingyear, $hsc_passingboard, $gujcet_appear, $gujcet_seatnumber, $gujcet_applicationnumber, $jee_appear, $jee_seatnumber, $jee_applicationnumber, $neet_appear, $neet_seatnumber, $neet_applicationnumber, $graduation_course, $graduation_university, $graduation_college_name, $graduation_cpi, $graduation_passing_status, $graduation_passing_month, $graduation_passing_year, $gmcet_score, $cmat_score, $stu_id, $stu_id);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['status'] = "Student Information Updated Successfully";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='view_student.php'},1000);</script>";
        } else {
            $_SESSION['status'] = "Student Information Update Failed";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.location='student_edit.php'},1000)</script>";
        }
    }
}
