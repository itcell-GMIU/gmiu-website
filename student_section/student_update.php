<?php
include 'include/checklogin.php';

if (isset($_POST["submit"])) {
    $student_id = $_POST['stu_id'];
    //return "hii";
    $adm_quota = isset($_POST['adm_quota']) ? mysqli_real_escape_string($con, $_POST['adm_quota']) : '';
    $u_first_name = isset($_POST['first_name']) ? mysqli_real_escape_string($con, $_POST['first_name']) : '';
    $u_middle_name = isset($_POST['middle_name']) ? mysqli_real_escape_string($con, $_POST['middle_name']) : '';
    $u_last_name = isset($_POST['last_name']) ? mysqli_real_escape_string($con, $_POST['last_name']) : '';
    $u_email = isset($_POST['email']) ? mysqli_real_escape_string($con, $_POST['email']) : '';
    $u_mobile_number = isset($_POST['mobile_number']) ? mysqli_real_escape_string($con, $_POST['mobile_number']) : '';
    $u_adhar_number = isset($_POST['adhar']) ? mysqli_real_escape_string($con, $_POST['adhar']) : '';
    $u_dob = isset($_POST['dob']) ? mysqli_real_escape_string($con, $_POST['dob']) : '';
    $u_gender = isset($_POST['gender']) ? mysqli_real_escape_string($con, $_POST['gender']) : '';
    $u_blood_group = isset($_POST['blood_group']) ? mysqli_real_escape_string($con, $_POST['blood_group']) : '';
    $u_religion = isset($_POST['religion']) ? mysqli_real_escape_string($con, $_POST['religion']) : '';
    $u_caste = isset($_POST['caste']) ? mysqli_real_escape_string($con, $_POST['caste']) : '';
    $u_father_name = isset($_POST['father']) ? mysqli_real_escape_string($con, $_POST['father']) : '';
    $u_mother_name = isset($_POST['mother']) ? mysqli_real_escape_string($con, $_POST['mother']) : '';
    $u_parent_mobile_number = isset($_POST['parents_number']) ? mysqli_real_escape_string($con, $_POST['parents_number']) : '';
    $u_parent_email_id = isset($_POST['parents_email']) ? mysqli_real_escape_string($con, $_POST['parents_email']) : '';
    $u_father_occupation = isset($_POST['father_occupation']) ? mysqli_real_escape_string($con, $_POST['father_occupation']) : '';
    $u_mother_occupation = isset($_POST['mother_occupation']) ? mysqli_real_escape_string($con, $_POST['mother_occupation']) : '';
    $u_permanent_address = isset($_POST['permanent_address']) ? mysqli_real_escape_string($con, $_POST['permanent_address']) : '';
    $u_permanent_pincode = isset($_POST['permanent_pincode']) ? mysqli_real_escape_string($con, $_POST['permanent_pincode']) : '';
    $u_address = isset($_POST['address']) ? mysqli_real_escape_string($con, $_POST['address']) : '';
    $u_pincode = isset($_POST['pincode']) ? mysqli_real_escape_string($con, $_POST['pincode']) : '';
    $u_city = isset($_POST['city']) ? mysqli_real_escape_string($con, $_POST['city']) : '';
    $u_state = isset($_POST['state']) ? mysqli_real_escape_string($con, $_POST['state']) : '';
    $u_permanent_city = isset($_POST['permanent_city']) ? mysqli_real_escape_string($con, $_POST['permanent_city']) : '';
    $u_permanent_state = isset($_POST['permanent_state']) ? mysqli_real_escape_string($con, $_POST['permanent_state']) : '';
    $_is_same_addr = isset($_POST['is_same_addr']) ? $_POST['is_same_addr'] : 0;
    $is_same_addr = mysqli_real_escape_string($con, $_is_same_addr);


    //validate data
    $u_first_name = validate_data($u_first_name);
    $u_middle_name = validate_data($u_middle_name);
    $u_last_name = validate_data($u_last_name);
    $u_email = validate_data($u_email);
    $u_mobile_number = validate_data($u_mobile_number);
    $u_adhar_number = validate_data($u_adhar_number);
    $u_dob = validate_data($u_dob);
    $u_gender = validate_data($u_gender);
    $u_blood_group = validate_data($u_blood_group);
    $u_religion = validate_data($u_religion);
    $u_caste = validate_data($u_caste);
    $u_father_name = validate_data($u_father_name);
    $u_mother_name = validate_data($u_mother_name);
    $u_permanent_address = validate_data($u_permanent_address);
    $u_permanent_pincode = validate_data($u_permanent_pincode);
    $u_address = validate_data($u_address);
    $u_city = validate_data($u_city);
    $u_state = validate_data($u_state);
    $u_permanent_city = validate_data($u_permanent_city);
    $u_permanent_state = validate_data($u_permanent_state);
    $is_same_addr = validate_data($is_same_addr);
    $admission_year = $year = date("Y");
    $step = 2;
    $basic_detail_status = 1;
    $stmt = $con->prepare("UPDATE `tbl_admission_student` SET city=?,state=?,permanent_city=?,permanent_state=?, first_name = ?,middle_name = ?,last_name = ?,email= ? ,adhar_number= ?,mobile_number= ?,dob=?,gender= ?, blood_group =?, religion = ?, caste = ?, father_name = ?, mother_name = ?, parent_mobile_number = ?, parent_email_id = ?, father_occupation = ?, mother_occupation = ?, permanent_address = ?, permanent_pincode = ?, address = ?, pincode = ?,admission_year = ?, step = ?,basic_detail_status = ?,is_same_addr=?, admission_quota=? WHERE id = ? ");
    $stmt->bind_param("ssssssssssssssssssssssssssiiisi", $u_city, $u_state, $u_permanent_city, $u_permanent_state, $u_first_name, $u_middle_name, $u_last_name, $u_email, $u_adhar_number, $u_mobile_number, $u_dob, $u_gender, $u_blood_group, $u_religion, $u_caste, $u_father_name, $u_mother_name, $u_parent_mobile_number, $u_parent_email_id, $u_father_occupation, $u_mother_occupation, $u_permanent_address, $u_permanent_pincode, $u_address, $u_pincode, $admission_year, $step, $basic_detail_status, $is_same_addr,$adm_quota, $student_id);
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
