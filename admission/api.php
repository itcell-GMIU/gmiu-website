<?php
include 'include/checklogin.php';

$api_for = isset($_POST['api_for']) ? $_POST['api_for'] : "";
$api_for = mysqli_real_escape_string($con, $api_for);
if ($api_for == "token_fee") {
    $program_id = isset($_POST['program_id']) ? $_POST['program_id'] : "";
    $program_id = mysqli_real_escape_string($con, $program_id);
    $admission_mode = isset($_POST['admission_mode']) ? $_POST['admission_mode'] : "";
    $admission_mode = mysqli_real_escape_string($con, $admission_mode);
    /*  echo $admission_mode;
    exit(); */
    $is_active = 1;
    $is_delete = 0;
    if ($admission_mode == "regular") {
        $cmd = "Select sem1, sem2, sem3, sem4, sem5, sem6, sem7, sem8, pro.id as program_id,pro.token as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
    } else if ($admission_mode == "genius") {
        $cmd = "Select  sem1, sem2, sem3, sem4, sem5, sem6, sem7, sem8, pro.id as program_id,pro.token_genius as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
    } else if ($admission_mode == "minor") {
        $cmd = "Select  sem1, sem2, sem3, sem4, sem5, sem6, sem7, sem8, pro.id as program_id,pro.token_minor as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
    }
    /*    else if($admission_mode=="international")
    {
        $cmd = "Select pro.id as program_id,pro.international_token as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
    }
    else if($admission_mode=="integrated")
    {
        $cmd = "Select pro.id as program_id,pro.integrated_token as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
    } */ else {
        $cmd = "Select sem1, sem2, sem3, sem4, sem5, sem6, sem7, sem8, pro.id as program_id,pro.token as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";
    }

    $stmt = $con->prepare($cmd);
    $stmt->bind_param("iii", $program_id, $is_active, $is_delete);

    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;

    if ($count > 0) {
        $fetch = $result->fetch_assoc();

        $cmd1 = "Select pro.token_genius as genius_token,pro.token_minor as minor_token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";


        $stmt1 = $con->prepare($cmd1);
        $stmt1->bind_param("iii", $program_id, $is_active, $is_delete);

        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $fetch11 = $result1->fetch_assoc();
        
        $regular_token = isset($fetch['token']) ? (float)$fetch['token'] : 0;
        $minor_token = isset($fetch11['minor_token']) ? (float)$fetch11['minor_token'] : 0;
        
        // Default token to use (will be shown to frontend)
        $used_token = ($admission_mode == "minor" && $minor_token > 0) ? $minor_token : $regular_token;
        
        // Check which semester to apply the token to
        if (empty($fetch['sem1']) || $fetch['sem1'] == 0 || $fetch['sem1'] == null) {
            if (!empty($fetch['sem3']) && $fetch['sem3'] != 0 && $fetch['sem3'] != null) {
                // Apply token to sem3
                $fetch['original_sem3'] = $fetch['sem3'];
                $fetch['sem3'] = $fetch['sem3'] - $regular_token;
                $fetch['used_token'] = $used_token;
            } else {
                // sem3 also has no fee, so skip this record               
                $fetch['sem3'] = $fetch['sem3'];
                $fetch['used_token'] = $used_token;
            }
        } else {
            // Apply token to sem1
            $fetch['original_sem1'] = $fetch['sem1'];
            $fetch['sem1'] = $fetch['sem1'] - $regular_token;
            $fetch['used_token'] = $used_token;
        }

        // $fetch["sem1"] = $fetch['sem1'];
        $fetch["sem2"] = $fetch['sem2'];
        $fetch["sem3"] = $fetch['sem3'];
        $fetch["sem4"] = $fetch['sem4'];
        $fetch["sem5"] = $fetch['sem5'];
        $fetch["sem6"] = $fetch['sem6'];
        $fetch["sem7"] = $fetch['sem7'];
        $fetch["sem8"] = $fetch['sem8'];

        if (empty($fetch11['genius_token']) || $fetch11['genius_token'] == "" || $fetch11['genius_token'] == 0 || $fetch11['genius_token'] == null) {
            $fetch["genius_mode_status"] = "no";
        } else {
            $fetch["genius_mode_status"] = "yes";
        }
        if (empty($fetch11['minor_token']) || $fetch11['minor_token'] == "" || $fetch11['minor_token'] == 0 || $fetch11['minor_token'] == null) {
            $fetch["minor_mode_status"] = "no";
        } else {
            $fetch["minor_mode_status"] = "yes";
        }

        if (empty($fetch['token']) || $fetch['token'] == "" || $fetch['token'] == 0 || $fetch['token'] == null) {

            $cmd1 = "Select pro.id as program_id,pro.token as token FROM tbl_program as pro where pro.id=? AND is_active =? AND is_delete=? ";


            $stmt1 = $con->prepare($cmd1);
            $stmt1->bind_param("iii", $program_id, $is_active, $is_delete);

            $stmt1->execute();
            $result1 = $stmt1->get_result();
            $count1 = $result1->num_rows;

            if ($count1 > 0) {
                $fetch1 = $result1->fetch_assoc();
                $fetch1["genius_mode_status"] = "no";
                $fetch1["minor_mode_status"] = "no";

                print_r(json_encode($fetch1));
            }
        } else {
            print_r(json_encode($fetch));
        }
    } else {
        echo "ss";
    }
}  elseif ($api_for == "add_basic_detail") {
    //return "hii";
    $u_first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $u_middle_name = mysqli_real_escape_string($con, $_POST['middle_name']);
    $u_last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $u_email = mysqli_real_escape_string($con, $_POST['email']);
    $u_mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number']);
    $u_adhar_number = mysqli_real_escape_string($con, $_POST['adhar']);
    $u_dob = mysqli_real_escape_string($con, $_POST['dob']);
    $u_gender = mysqli_real_escape_string($con, $_POST['gender']);
    $u_blood_group = mysqli_real_escape_string($con, $_POST['blood_group']);
    $u_religion = mysqli_real_escape_string($con, $_POST['religion']);
    $u_caste = mysqli_real_escape_string($con, $_POST['caste']);
    $u_father_name = mysqli_real_escape_string($con, $_POST['father']);
    $u_mother_name = mysqli_real_escape_string($con, $_POST['mother']);
    $u_parent_mobile_number = mysqli_real_escape_string($con, $_POST['parents_number']);
    $u_parent_email_id = mysqli_real_escape_string($con, $_POST['parents_email']);
    $u_father_occupation = mysqli_real_escape_string($con, $_POST['father_occupation']);
    $u_mother_occupation = mysqli_real_escape_string($con, $_POST['mother_occupation']);
    $u_permanent_address = mysqli_real_escape_string($con, $_POST['permanent_address']);
    $u_permanent_pincode = mysqli_real_escape_string($con, $_POST['permanent_pincode']);
    $u_address = mysqli_real_escape_string($con, $_POST['address']);
    $u_pincode = mysqli_real_escape_string($con, $_POST['pincode']);
    $u_city = mysqli_real_escape_string($con, $_POST['city']);
    $u_state = mysqli_real_escape_string($con, $_POST['state']);
    $u_permanent_city = mysqli_real_escape_string($con, $_POST['permanent_city']);
    $u_permanent_state = mysqli_real_escape_string($con, $_POST['permanent_state']);
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
    $stmt = $con->prepare("UPDATE `tbl_admission_student` SET city=?,state=?,permanent_city=?,permanent_state=?, first_name = ?,middle_name = ?,last_name = ?,email= ? ,adhar_number= ?,mobile_number= ?,dob=?,gender= ?, blood_group =?, religion = ?, caste = ?, father_name = ?, mother_name = ?, parent_mobile_number = ?, parent_email_id = ?, father_occupation = ?, mother_occupation = ?, permanent_address = ?, permanent_pincode = ?, address = ?, pincode = ?,admission_year = ?, step = ?,basic_detail_status = ?,is_same_addr=? WHERE id = ? ");
    $stmt->bind_param("ssssssssssssssssssssssssssiiii", $u_city, $u_state, $u_permanent_city, $u_permanent_state, $u_first_name, $u_middle_name, $u_last_name, $u_email, $u_adhar_number, $u_mobile_number, $u_dob, $u_gender, $u_blood_group, $u_religion, $u_caste, $u_father_name, $u_mother_name, $u_parent_mobile_number, $u_parent_email_id, $u_father_occupation, $u_mother_occupation, $u_permanent_address, $u_permanent_pincode, $u_address, $u_pincode, $admission_year, $step, $basic_detail_status, $is_same_addr, $student_id);
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
    echo json_encode($response);
} else if ($api_for == "add_update_education_detail") {
    
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
    $cmd->bind_param("i", $student_id);
    $cmd->execute();
    $ex = $cmd->get_result();
    if ($ex->num_rows == 0) {
        //insert code
        $stmt = $con->prepare("INSERT INTO `tbl_education_qualification`(student_id, ssc_boardname, ssc_schoolname, ssc_percentage, ssc_passingmonth, ssc_passingyear, hsc_stream, hsc_boardseatnumber, hsc_schoolname, hsc_percentage, hsc_passingstatus, hsc_passingmonth, hsc_passingyear, hsc_passingboard, gujcet_appear, gujcet_seatnumber, gujcet_applicationnumber, jee_appear, jee_seatnumber, jee_applicationnumber, neet_appear, neet_seatnumber, neet_applicationnumber, graduation_course, graduation_university, graduation_college_name, graduation_cpi, graduation_passing_status, graduation_passing_month, graduation_passing_year, gmcet_score, cmat_score, created_by)
                                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("issdiisssdsiisssissississsdsiiddi", $student_id, $ssc_boardname, $ssc_schoolname, $ssc_percentage, $ssc_passingmonth, $ssc_passingyear, $hsc_stream, $hsc_boardseatnumber, $hsc_schoolname, $hsc_percentage, $hsc_passingstatus, $hsc_passingmonth, $hsc_passingyear, $hsc_passingboard, $gujcet_appear, $gujcet_seatnumber, $gujcet_applicationnumber, $jee_appear, $jee_seatnumber, $jee_applicationnumber, $neet_appear, $neet_seatnumber, $neet_applicationnumber, $graduation_course, $graduation_university, $graduation_college_name, $graduation_cpi, $graduation_passing_status, $graduation_passing_month, $graduation_passing_year, $gmcet_score, $cmat_score, $student_id);
        $result = $stmt->execute();
        if ($result) {
            //if inserted successfully update the step and education detail status
            $step = 3;
            $education_detail_status = 1;
            $stmt = $con->prepare("UPDATE `tbl_admission_student` SET education_detail_status = ? , step = ? WHERE id = ? ");
            $stmt->bind_param("iii", $education_detail_status, $step, $student_id);
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
        $stmt->bind_param("ssdiisssdsiisssissississsdsiiddii", $ssc_boardname, $ssc_schoolname, $ssc_percentage, $ssc_passingmonth, $ssc_passingyear, $hsc_stream, $hsc_boardseatnumber, $hsc_schoolname, $hsc_percentage, $hsc_passingstatus, $hsc_passingmonth, $hsc_passingyear, $hsc_passingboard, $gujcet_appear, $gujcet_seatnumber, $gujcet_applicationnumber, $jee_appear, $jee_seatnumber, $jee_applicationnumber, $neet_appear, $neet_seatnumber, $neet_applicationnumber, $graduation_course, $graduation_university, $graduation_college_name, $graduation_cpi, $graduation_passing_status, $graduation_passing_month, $graduation_passing_year, $gmcet_score, $cmat_score, $student_id, $student_id);
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
    }
    echo json_encode($response);
} else if ($api_for == "final_submit") {
    $admission_step = 5;
    $admission_status = "submitted";
    $cluster_status = "submitted";
    
    $stmt = $con->prepare("UPDATE `tbl_admission_student` SET admission_status=?, status = ? , step = ? WHERE id = ? ");
    $stmt->bind_param("ssii", $admission_status,$cluster_status, $admission_step, $student_id);
    $result = $stmt->execute();
    if ($result) {
        $response = [
            'status' => 200,
            'message' => 'Step Updated Successfully!'
        ];
    } else {
        $response = [
            'status' => 400,
            'message' => $con->error
        ];
    }
    echo json_encode($response);
} else if ($api_for == "check_all_step_complete") {
    $cmd = "Select stu.payment_status,stu.basic_detail_status,stu.payment_detail_status,stu.education_detail_status,stu.document_detail_status FROM tbl_admission_student as stu where stu.id=? ";
    $stmt = $con->prepare($cmd);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $basic_detail_status = $row['basic_detail_status'];
        $payment_status = $row['payment_status'];
        $education_detail_status = $row['education_detail_status'];
        $document_detail_status = $row['document_detail_status'];
        if ($basic_detail_status == 0) {
            $response = [
                'status' => 400,
                'message' => "Please Fill Up All Basic Detail"
            ];
        } else if ($payment_status != "success") {
            $response = [
                'status' => 400,
                'message' => "Please Complete Payment"
            ];
        } else if ($education_detail_status == 0) {
            $response = [
                'status' => 400,
                'message' => "Please Complete Education Detail"
            ];
        } else if ($document_detail_status == 0) {

            $stmt = $con->prepare("SELECT stu_doc.* FROM `tbl_student_document` as stu_doc WHERE student_id = ? ");
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {

                $row = $result->fetch_assoc();
                if ($row['photo'] == null || $row['photo'] == "") {
                    $response = [
                        'status' => 400,
                        'message' => 'Please Upload Photo',

                    ];
                } else if ($row['aadharcard'] == null || $row['aadharcard'] == "") {
                    $response = [
                        'status' => 400,
                        'message' => 'Please Upload Aadhar Card',

                    ];
                } else if ($row['parent_aadharcard'] == null || $row['parent_aadharcard'] == "") {
                    $response = [
                        'status' => 400,
                        'message' => 'Please Upload Parent Aadhar Card',

                    ];
                } else {
                    $response = [
                        'status' => 200,
                        'message' => "All Document Uploaded"
                    ];
                }
            } else {
                $response = [
                    'status' => 400,
                    'message' => 'Please Upload all required Document',

                ];
            }
        } else {
            $response = [
                'status' => 200,
                'message' => "All step Completed"
            ];
        }
    } else {
        $response = [
            'status' => 400,
            'message' => "No data Found"
        ];
    }
    echo json_encode($response);
}