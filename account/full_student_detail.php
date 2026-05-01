<?php
include './include/checklogin.php';

if (isset($_GET['stu_id'])) {
    $stu_id = $_GET['stu_id'];
} else {
    $stu_id = "";
}

//code for getting educational  details
$cmd = "Select eq.* from tbl_education_qualification as eq  where eq.student_id=? ";
$stmt = $con->prepare($cmd);
$stmt->bind_param("i", $stu_id);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result
if ($result->num_rows == 1) {
    
    $row = $result->fetch_assoc();
    $ssc_boardname =!empty($row['ssc_boardname']) ? $row['ssc_boardname'] : "N/A"; 
    $ssc_schoolname = !empty($row['ssc_schoolname']) ? $row['ssc_schoolname'] : "N/A"; 
    $ssc_percentage =!empty($row['ssc_percentage']) ? $row['ssc_percentage'] : "N/A";  
    $ssc_passingmonth =!empty($row['ssc_passingmonth']) ? $row['ssc_passingmonth'] : "N/A";
    $ssc_passingyear =!empty($row['ssc_passingyear']) ? $row['ssc_passingyear'] : "N/A";
    $hsc_stream =!empty($row['ssc_passingyear']) ? $row['ssc_passingyear'] : "N/A";
    $hsc_boardseatnumber =!empty($row['hsc_boardseatnumber']) ? $row['hsc_boardseatnumber'] : "N/A";
    $hsc_schoolname =!empty($row['hsc_schoolname']) ? $row['hsc_schoolname'] : "N/A";
    $hsc_percentage =!empty($row['hsc_percentage']) ? $row['hsc_percentage'] : "N/A";
    $hsc_passingstatus =!empty($row['hsc_passingstatus']) ? $row['hsc_passingstatus'] : "N/A";
    $hsc_passingmonth =!empty($row['hsc_passingmonth']) ? $row['hsc_passingmonth'] : "N/A";
    $hsc_passingyear =!empty($row['hsc_passingyear']) ? $row['hsc_passingyear'] : "N/A";
    $hsc_passingboard =!empty($row['hsc_passingboard']) ? $row['hsc_passingboard'] : "N/A";
    $gujcet_appear =!empty($row['gujcet_appear']) ? $row['gujcet_appear'] : "N/A";
    $gujcet_seatnumber =!empty($row['gujcet_seatnumber']) ? $row['gujcet_seatnumber'] : "N/A";
    $gujcet_applicationnumber =!empty($row['gujcet_applicationnumber']) ? $row['gujcet_applicationnumber'] : "N/A";
    $jee_appear =!empty($row['jee_appear']) ? $row['jee_appear'] : "N/A";
    $jee_seatnumber =!empty($row['jee_seatnumber']) ? $row['jee_seatnumber'] : "N/A";
    $jee_applicationnumber =!empty($row['jee_applicationnumber']) ? $row['jee_applicationnumber'] : "N/A";
    $neet_appear =!empty($row['neet_appear']) ? $row['neet_appear'] : "N/A";
    $neet_seatnumber =!empty($row['neet_seatnumber']) ? $row['neet_seatnumber'] : "N/A";
    $neet_applicationnumber =!empty( $row['neet_applicationnumber']) ?  $row['neet_applicationnumber'] : "N/A";
    $graduation_course =!empty($row['graduation_course']) ? $row['graduation_course'] : "N/A";
    $graduation_university =!empty($row['graduation_university']) ? $row['graduation_university'] : "N/A";
    $graduation_college_name =!empty( $row['graduation_college_name']) ?  $row['graduation_college_name'] : "N/A";
    $graduation_cpi =!empty( $row['graduation_cpi']) ?  $row['graduation_cpi'] : "N/A";
    $graduation_passing_status =!empty($row['graduation_passing_status']) ? $row['graduation_passing_status'] : "N/A";
    $graduation_passing_month =!empty($row['graduation_passing_month']) ? $row['graduation_passing_month'] : "N/A";
    $graduation_passing_year =!empty($row['graduation_passing_year']) ? $row['graduation_passing_year'] : "N/A";
    $gmcet_score =!empty($row['gmcet_score']) ? $row['gmcet_score'] : "N/A";
    $cmat_score =!empty($row['cmat_score']) ? $row['cmat_score'] : "N/A";
} else {
    $ssc_boardname = "N/A";
    $ssc_schoolname = "N/A";
    $ssc_percentage = "N/A";
    $ssc_passingmonth = "N/A";
    $ssc_passingyear = "N/A";
    $hsc_stream = "N/A";
    $hsc_boardseatnumber = "N/A";
    $hsc_schoolname = "N/A";
    $hsc_percentage = "N/A";
    $hsc_passingstatus = "N/A";
    $hsc_passingmonth = "N/A";
    $hsc_passingyear = "N/A";
    $hsc_passingboard = "N/A";
    $gujcet_appear = "N/A";
    $gujcet_seatnumber = "N/A";
    $gujcet_applicationnumber = "N/A";
    $jee_appear = "N/A";
    $jee_seatnumber = "N/A";
    $jee_applicationnumber = "N/A";
    $neet_appear = "N/A";
    $neet_seatnumber = "N/A";
    $neet_applicationnumber = "N/A";
    $graduation_course = "N/A";
    $graduation_university = "N/A";
    $graduation_college_name = "N/A";
    $graduation_cpi = "N/A";
    $graduation_passing_status = "N/A";
    $graduation_passing_month = "N/A";
    $graduation_passing_year = "N/A";
    $gmcet_score = "N/A";
    $cmat_score = "N/A";
}

$cmd = "Select stu.*,pro.name as program_name,level.name as level_name,faculty.shortname as faculty_shortname,faculty.name as faculty_name from tbl_admission_student as stu LEFT JOIN tbl_program pro
ON stu.program_id = pro.id LEFT JOIN tbl_faculty faculty
ON stu.faculty_id = faculty.id LEFT JOIN tbl_level level
ON stu.level_id = level.id where stu.id=? ";
$stmt = $con->prepare($cmd);
$stmt->bind_param("i", $stu_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1) { 
    // get the mysqli result

    
                    $row = $result->fetch_assoc();
                    $stu_first_name =!empty($row['first_name']) ? $row['first_name'] :  "N/A";
                    $stu_middle_name =!empty($row['middle_name']) ? $row['middle_name'] :  "N/A";
                    $stu_last_name =!empty($row['last_name']) ? $row['last_name'] :  "N/A";
                    $stu_email =!empty($row['email']) ? $row['email'] :  "N/A";
                    $stu_number =!empty($row['mobile_number']) ? $row['mobile_number'] :  "N/A";
                    $stu_faculty_id =!empty($row['faculty_id']) ? $row['faculty_id'] :  "N/A";
                    $stu_level_id =!empty($row['level_id']) ? $row['level_id'] :  "N/A";
                    $stu_program_id =!empty($row['program_id']) ? $row['program_id'] :  "N/A";
                    $mode =!empty($row['mode']) ? $row['mode'] :  "N/A";
                    $payment_status =!empty($row['payment_status']) ? $row['payment_status'] :  "N/A";
                    $adhar_number =!empty($row['adhar_number']) ? $row['adhar_number'] :  "N/A";
                    $gender =!empty($row['gender']) ? $row['gender'] :  "N/A";
                    $dob =!empty($row['dob']) ? $row['dob'] :  "N/A";
                    $blood_group =!empty($row['blood_group']) ? $row['blood_group'] :  "N/A";
                    $religion =!empty($row['religion']) ? $row['religion'] :  "N/A";
                    $caste =!empty($row['caste']) ? $row['caste'] :  "N/A";
                    $father_name =!empty($row['father_name']) ? $row['father_name'] :  "N/A";
                    $mother_name =!empty($row['mother_name']) ? $row['mother_name'] :  "N/A";
                    $parent_mobile_number =!empty($row['parent_mobile_number']) ? $row['parent_mobile_number'] :  "N/A";
                    $parent_email_id =!empty($row['parent_email_id']) ? $row['parent_email_id'] :  "N/A";
                    $father_occupation =!empty($row['father_occupation']) ? $row['father_occupation'] :  "N/A";
                    $mother_occupation =!empty($row['mother_occupation']) ? $row['mother_occupation'] :  "N/A";
                    $permanent_address =!empty($row['permanent_address']) ? $row['permanent_address'] :  "N/A";
                    $permanent_pincode =!empty($row['permanent_pincode']) ? $row['permanent_pincode'] :  "N/A";
                    $address =!empty($row['address']) ? $row['address'] :  "N/A";
                    $pincode =!empty($row['pincode']) ? $row['pincode'] :  "N/A";
                    $city =!empty($row['city']) ? $row['city'] :  "N/A";
                    $state =!empty($row['state']) ? $row['state'] :  "N/A";
                    $permanent_city =!empty($row['permanent_city']) ? $row['permanent_city'] :  "N/A";
                    $permanent_state =!empty($row['permanent_state']) ? $row['permanent_state'] :  "N/A";
                    $is_same_addr =!empty($row['is_same_addr']) ? $row['is_same_addr'] :  "N/A";
                    $token_amount =!empty($row['token_amount']) ? $row['token_amount'] :  "N/A";
                    $payment_date_time =!empty($row['payment_date_time']) ? $row['payment_date_time'] :  "N/A";
                    $gr_number =!empty($row['gr_number']) ? $row['gr_number'] :  "N/A";
                    $stu_program_name =!empty($row['program_name']) ? $row['program_name'] :  "N/A";
                    $stu_faculty_name =!empty($row['faculty_name']) ? $row['faculty_name'] :  "N/A";
                    $stu_faculty_shortname =!empty($row['faculty_shortname']) ? $row['faculty_shortname'] :  "N/A";
                    $stu_level_name =!empty($row['level_name']) ? $row['level_name'] :  "N/A";
                    $stu_cluster_status =!empty($row['status']) ? $row['status'] :  "N/A";
                    $stu_admission_step =!empty($row['step']) ? $row['step'] :  "N/A";
                    $comment =!empty($row['comment']) ? $row['comment'] :  "N/A";
              

    }
    else
    {
                    $payment_status = "N/A";
                    $stu_first_name = "N/A";
                    $stu_middle_name = "N/A";
                    $stu_last_name = "N/A";
                    $stu_email = "N/A";
                    $stu_number = "N/A";
                    $stu_faculty_id = "N/A";
                    $stu_level_id = "N/A";
                    $stu_program_id = "N/A";
                    $mode = "N/A";
                    $adhar_number = "N/A";
                    $dob ="N/A";
                    $gender = "N/A";
                    $blood_group = "N/A";
                    $religion = "N/A";
                    $caste = "N/A";
                    $father_name = "N/A";
                    $mother_name = "N/A";
                    $parent_mobile_number = "N/A";
                    $parent_email_id = "N/A";
                    $father_occupation = "N/A";
                    $mother_occupation ="N/A";
                    $permanent_address = "N/A";
                    $permanent_pincode = "N/A";
                    $address ="N/A";
                    $pincode = "N/A";
                    $city = "N/A";
                    $state ="N/A";
                    $permanent_city = "N/A";
                    $permanent_state = "N/A";
                    $is_same_addr ="N/A";
                    $token_amount = "N/A";
                    $payment_date_time = "N/A";
                    $gr_number ="N/A";
                    $stu_program_name = "N/A";
                    $stu_faculty_name = "N/A";
                    $stu_faculty_shortname = "N/A";
                    $stu_level_name = "N/A";
                    $stu_cluster_status = "N/A";
                    $stu_admission_step ="N/A";
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>

    <link rel="stylesheet" href="../website_assets/css/final_review.css">
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
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View Full Student Detail</li>
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

                        <div class="table-responsive">
                            <table class="table table-bordered" id="table-resp">
                                <thead>
                                    <tr>
                                        <td colspan="6">
                                            <center>
                                                <h4> Submitted Details<h4>
                                            </center>
                                        </td>
                                        <!--   <td colspan="6">
                    <img src="https://th.bing.com/th/id/OIP.aNuVPko-fipxD4-hwuKSTQHaHl?pid=ImgDet&rs=1"
                        id="profile_img" class="rounded float-right" alt="...">
                </td> -->
                                    </tr>
                                </thead>
                                <thead>
                                    <tr>
                                        <th colspan="6" class="text-center bgChange">Student Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>First Name</th>
                                        <td>
                                            <?php echo $stu_first_name; ?>
                                        </td>
                                        <th>Middle Name</th>
                                        <td>
                                            <?php echo $stu_middle_name; ?>
                                        </td>
                                        <th>Last Name</th>
                                        <td>
                                            <?php echo $stu_last_name; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>
                                            <?php echo $gender; ?>
                                        </td>
                                        <th>Mobile Number</th>
                                        <td>
                                            <?php echo $stu_number; ?>
                                        </td>
                                        <th>Email </th>
                                        <td>
                                            <?php echo $stu_email; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Date Of Birth</th>
                                        <td>
                                            <?php echo $dob; ?>
                                        </td>
                                        <th>Blood Group</th>
                                        <td>
                                            <?php echo $blood_group; ?>
                                        </td>
                                        <th>Religion </th>
                                        <td>
                                            <?php echo $religion; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Category</th>
                                        <td>
                                            <?php echo $caste; ?>
                                        </td>

                                        <th>Adhar Card Number </th>
                                        <td>
                                            <?php echo $adhar_number; ?>
                                        </td>

                                        <th>GR Number</th>
                                        <td> <?php echo $gr_number; ?></td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th colspan="6" class="text-center bgChange">Parents Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Father Name</th>
                                        <td>
                                            <?php echo $father_name; ?>
                                        </td>
                                        <th>Mother Name</th>
                                        <td>
                                            <?php echo $mother_name; ?>
                                        </td>
                                        <th>Parents Mobile Number</th>
                                        <td>
                                            <?php echo $parent_mobile_number; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Father Occupation</th>
                                        <td>
                                            <?php echo $father_occupation; ?>
                                        </td>
                                        <th>Mother Occupation</th>
                                        <td>
                                            <?php echo $mother_occupation; ?>
                                        </td>
                                        <th>Parents Email</th>
                                        <td>
                                            <?php echo $parent_email_id; ?>
                                        </td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th colspan="6" class="text-center bgChange">Course Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Faculty</th>
                                        <td>
                                            <?php echo $stu_faculty_name; ?>
                                        </td>
                                        <th>Level</th>
                                        <td>
                                            <?php echo $stu_level_name; ?>
                                        </td>
                                        <th>Program</th>
                                        <td>
                                            <?php echo $stu_program_name; ?>
                                        </td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th colspan="6" class="text-center bgChange">Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Present Address</th>
                                        <!--  <td>Address</td> -->
                                        <td colspan="3">
                                            <?php echo $address; ?>
                                        </td>
                                        <th>Pincode</th>
                                        <td>
                                            <?php echo $pincode; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>State</th>
                                        <td colspan="2">
                                            <?php echo $state; ?>
                                        </td>
                                        <th>City</th>
                                        <td colspan="2">
                                            <?php echo $city; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Permanent Address</th>
                                        <!-- <td>Address</td> -->
                                        <td colspan="3">
                                            <?php echo $permanent_address; ?>
                                        </td>
                                        <th>Pincode</th>
                                        <td>
                                            <?php echo $permanent_pincode; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>State</th>
                                        <td colspan="2">
                                            <?php echo $permanent_state; ?>
                                        </td>
                                        <th>City</th>
                                        <td colspan="2">
                                            <?php echo $permanent_city; ?>
                                        </td>
                                    </tr>
                                </tbody>
                                <!-- Education Details -->
                                <thead>
                                    <tr>
                                        <th colspan="6" class="text-center bgChange">Education Details</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- 10th class -->
                                    <tr>
                                        <td colspan="6" class="sub_heading">SSC/10<sup>th</sup></td>
                                    </tr>
                                    <tr>
                                        <th>Board Name</th>
                                        <td colspan="2">
                                            <?php echo $ssc_boardname; ?>
                                        </td>
                                        <th>School Name</th>
                                        <td colspan="2">
                                            <?php echo $ssc_schoolname; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Aggregate Percentage</th>
                                        <td>
                                            <?php echo $ssc_percentage; ?>
                                        </td>
                                        <th>Passing Month</th>
                                        <td>
                                            <?php echo $ssc_passingmonth; ?>
                                        </td>
                                        <th>Passing Year</th>
                                        <td>
                                            <?php echo $ssc_passingyear; ?>
                                        </td>
                                    </tr>

                                    <!-- 12th class -->
                                    <tr>
                                        <td colspan="6" class="sub_heading">10+2 / HSC / PUC / 12<sup>th</sup></td>
                                    </tr>
                                    <tr>
                                        <th>Stream</th>
                                        <td>
                                            <?php echo $hsc_stream; ?>
                                        </td>
                                        <th>Board Name</th>
                                        <td>
                                            <?php echo $hsc_passingboard; ?>
                                        </td>
                                        <th> Seat Number</th>
                                        <td>
                                            <?php echo $hsc_boardseatnumber; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Passing Status</th>
                                        <td>
                                            <?php echo $hsc_passingstatus; ?>
                                        </td>
                                        <th>School Name</th>
                                        <td>
                                            <?php echo $hsc_schoolname; ?>
                                        </td>
                                        <th>Aggregate Percentage</th>
                                        <td>
                                            <?php echo $hsc_percentage; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Passing Month</th>
                                        <td colspan="2">
                                            <?php echo $hsc_passingmonth; ?>
                                        </td>
                                        <th>Passing Year</th>
                                        <td colspan="2">
                                            <?php echo $hsc_passingyear; ?>
                                        </td>
                                    </tr>


                                    <!-- Competitive Exam Details -->
                                    <tr>
                                        <td colspan="6" class="sub_heading">Competitive Exam Details</td>
                                    </tr>
                                    <tr>
                                        <th>GUJCET Appearance</th>
                                        <td>
                                            <?php echo $gujcet_appear; ?>
                                        </td>
                                        <th>Seat Number</th>
                                        <td>
                                            <?php echo $gujcet_seatnumber; ?>
                                        </td>
                                        <th>Application Number</th>
                                        <td>
                                            <?php echo $gujcet_applicationnumber; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>NEET Appearance</th>
                                        <td>
                                            <?php echo $neet_appear; ?>
                                        </td>
                                        <th>Seat Number</th>
                                        <td>
                                            <?php echo $neet_seatnumber; ?>
                                        </td>
                                        <th>Application Number</th>
                                        <td>
                                            <?php echo $neet_applicationnumber; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>JEE Appearance</th>
                                        <td>
                                            <?php echo $jee_appear; ?>
                                        </td>
                                        <th>Seat Number</th>
                                        <td>
                                            <?php echo $jee_seatnumber; ?>
                                        </td>
                                        <th>Application Number</th>
                                        <td>
                                            <?php echo $jee_applicationnumber; ?>
                                        </td>
                                    </tr>
                                </tbody>
                                <!-- Competitive Exam Details -->
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="sub_heading">Graduation Details</td>
                                    </tr>
                                    <tr>
                                        <th>Graduation Course</th>
                                        <td>
                                            <?php echo $graduation_course; ?>
                                        </td>
                                        <th>University Name</th>
                                        <td>
                                            <?php echo $graduation_university; ?>
                                        </td>
                                        <th>College Name</th>
                                        <td>
                                            <?php echo $graduation_college_name; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Graduation CPI</th>
                                        <td>
                                            <?php echo $graduation_cpi; ?>
                                        </td>
                                        <th>Passing Status</th>
                                        <td>
                                            <?php echo $graduation_passing_status; ?>
                                        </td>
                                        <th>Passing Month</th>
                                        <td>
                                            <?php echo  $graduation_passing_month; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Passing Year</th>
                                        <td>
                                            <?php echo $graduation_passing_year; ?>
                                        </td>
                                        <th>GMCET Score</th>
                                        <td>
                                            <?php echo $gmcet_score; ?>
                                        </td>
                                        <th>CMAT Score</th>
                                        <td>
                                            <?php echo $cmat_score; ?>
                                        </td>
                                    </tr>

                                </tbody>
                                <thead>
                                    <tr>
                                        <th colspan="6" class="text-center bgChange">Documents Uploaded</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th colspan="6">
                                            <ul>
                                                <?php
                        
                                $cmd = "Select stu_doc.* from tbl_student_document as stu_doc  where stu_doc.student_id=? ";
                                $stmt = $con->prepare($cmd);
                                $stmt->bind_param("i", $stu_id);
                                $stmt->execute();
                                $result = $stmt->get_result(); // get the mysqli result
                                if ($result->num_rows == 1) {
                                    
                                 $row = $result->fetch_assoc();
                                 if($row['photo'] != null || $row['photo']!= "")
                                 {
                                    $photo=$row['photo'];
                                     echo"<li> Photo :-<a href=$upload_document_url$stu_id/$photo> View</a></li>";
                                   
                                 }
                                 if($row['aadharcard'] != null || $row['aadharcard']!= "")
                                 {
                                    $aadharcard=$row['aadharcard'];
                                    echo"<li> Aadhar card :-<a href=$upload_document_url$stu_id/$aadharcard> View</a></li>";
                                     
                                 }
                                  if($row['parent_aadharcard'] != null || $row['parent_aadharcard']!= "")
                                 {
                                    $parent_aadharcard=$row['parent_aadharcard'];
                                    echo"<li> Parent Aadhar card :-<a href=$upload_document_url$stu_id/$parent_aadharcard> View</a></li>";
                                     
                                 }
                                  if($row['school_leaving'] != null || $row['school_leaving']!= "")
                                 {
                                    $school_leaving=$row['school_leaving'];
                                    echo"<li> School Leaving Certificate :-<a href=$upload_document_url$stu_id/$school_leaving> </li>";  
                                 }
                                  if($row['ssc_marksheet'] != null || $row['ssc_marksheet']!= "")
                                 {
                                    $ssc_marksheet=$row['ssc_marksheet'];
                                    echo"<li> SSC Marksheet :-<a href=$upload_document_url$stu_id/$school_leaving></li>";    
                                 }
                                  if($row['hsc_marksheet'] != null || $row['hsc_marksheet']!= "")
                                 {
                                    $hsc_marksheet=$row['hsc_marksheet'];
                                    echo"<li> HSC Marksheet :-<a href=$upload_document_url$stu_id/$hsc_marksheet></li>";
                                    
                                 }
                                  if($row['caste_certificate'] != null || $row['caste_certificate']!= "")
                                 {
                                    $caste_certificate=$row['caste_certificate'];
                                    echo"<li> Cast Certificate :-<a href=$upload_document_url$stu_id/$caste_certificate></li>";
                                    
                                 }
                                  if($row['gujcet_result'] != null || $row['gujcet_result']!= "")
                                 {
                                    $gujcet_result=$row['gujcet_result'];
                                    echo"<li> Gujcet Result :-<a href=$upload_document_url$stu_id/$gujcet_result></li>";
                                    
                                 }
                                  if($row['jee_result'] != null || $row['jee_result']!= "")
                                 {
                                    $jee_result=$row['jee_result'];
                                    echo"<li> JEE Result :-<a href=$upload_document_url$stu_id/$jee_result></li>";
                                    
                                 }
                                  if($row['neet_result'] != null || $row['neet_result']!= "")
                                 {
                                    $neet_result=$row['neet_result'];
                                    echo"<li> NEET Result :-<a href=$upload_document_url$stu_id/$neet_result></li>";
                                    
                                 }
                                  if($row['graduation_marksheet'] != null || $row['graduation_marksheet']!= "")
                                 {
                                    $graduation_marksheet=$row['graduation_marksheet'];
                                    echo"<li>Graduation Marksheets :-<a href=$upload_document_url$stu_id/$graduation_marksheet></li>";
                                    
                                 }
                                  if($row['migration_certificate'] != null || $row['migration_certificate']!= "")
                                 {
                                    $migration_certificate=$row['migration_certificate'];
                                    echo"<li> Migration Certificate :-<a href=$upload_document_url$stu_id/$migration_certificate></li>";
                                    
                                 }
                                 if($row['other_documents'] != null || $row['other_documents']!= "")
                                 {
                                    $other_documents=$row['other_documents'];
                                    echo" <li> Other Documents :-<a href=$upload_document_url$stu_id/$other_documents></li>";
                                    
                                 }
                                ?>

                                                <?php  }
                                else
                                {?>
                                                <li>N/A </li>
                                                <?php  }
                                ?>
                                            </ul>
                                        </th>
                                    </tr>
                                </tbody>

                            </table>
                            <button onclick="window.print()"><i class="fa fa-print mr5"></i>Print</button>

                        </div>





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