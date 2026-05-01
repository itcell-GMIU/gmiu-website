<?php
include './include/checklogin.php';

if (isset($_GET['stu_id'])) {
    $stu_id = mysqli_real_escape_string($con, $_GET['stu_id']);
    $stu_id = validate_data($stu_id);
} else {
    $stu_id = "";
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
                            <h1 class="m-0">View All Details</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View All Details</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i> Payment Details</b></h5>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="techevent" class="dataTableLoad table table-bordered table-hover">
                                    <thead>
                                        <tr align="center">

                                            <th scope="row" style="color:black;"><b>Transaction Id & Payment Id</b>
                                            </th>
                                            <th scope="row" style="color:black;"><b>Payment Status</b></th>
                                            <th scope="row" style="color:black;"><b>Faculty</b></th>
                                            <th scope="row" style="color:black;"><b>Level</b></th>
                                            <th scope="row" style="color:black;"><b>Program</b></th>
                                            <th scope="row" style="color:black;"><b>Mode</b></th>
                                            <th scope="row" style="color:black;"><b>Payment Mode</b></th>
                                            <th scope="row" style="color:black;"><b>Token Amount </b></th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        // $cmd = "SELECT ``,`payment_id`,`faculty_id`, `level_id`, `program_id`, `mode`, `token_amount`, `payment_status`,`payment_mode` FROM `tbl_admission_student` WHERE id = ?";
                                        
                                        $cmd = "Select stu.transaction_id,stu.payment_id,stu.faculty_id,stu.level_id,stu.program_id,stu.mode,stu.token_amount,stu.payment_status,stu.payment_mode,pro.name as program_name,level.name as level_name,faculty.name as faculty_name from tbl_admission_student as stu LEFT JOIN tbl_program pro
                                    ON stu.program_id = pro.id LEFT JOIN tbl_faculty faculty
                                    ON stu.faculty_id = faculty.id LEFT JOIN tbl_level level
                                    ON stu.level_id = level.id Where stu.id = ? AND stu.is_active=1 AND stu.is_delete=0";
                                        $stmt = $con->prepare($cmd);
                                        $stmt->bind_param("i", $stu_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        if ($result->num_rows != 0) {
                                            $row = $result->fetch_assoc();
                                            $stu_transaction_id = $row['transaction_id'];
                                            $stu_payment_id = $row['payment_id'];
                                            $stu_faculty_id = $row['faculty_id'];
                                            $stu_level_id = $row['level_id'];
                                            $stu_program_id = $row['program_id'];
                                            $stu_mode = $row['mode'];
                                            $stu_token_amount = $row['token_amount'];
                                            $stu_payment_status = $row['payment_status'];
                                            $stu_payment_mode = $row['payment_mode'];
                                            $stu_program_name = $row['program_name'];
                                            $stu_level_name = $row['level_name'];
                                            $stu_faculty_name = $row['faculty_name'];


                                            ?>
                                            <tr align="center">
                                                <td scope="row"><?php echo $stu_transaction_id; ?>
                                                    <?php echo "," . "<br>"; ?>
                                                    <?php echo $stu_payment_id; ?>
                                                </td>
                                                <td scope="row"><?php echo $stu_payment_status; ?></td>
                                                <td scope="row"><?php echo $stu_faculty_name; ?></td>
                                                <td scope="row"><?php echo $stu_level_name; ?></td>
                                                <td scope="row"><?php echo $stu_program_name; ?></td>
                                                <td scope="row"><?php echo $stu_mode; ?></td>
                                                <td scope="row"><?php echo $stu_payment_mode; ?></td>
                                                <td scope="row"><?php echo $stu_token_amount; ?></td>


                                            </tr>
                                            <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->

                    </div>


                    <!-- basic details view -->
                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i> Basic Details</b></h5>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="techevent" class="dataTableLoad table table-bordered table-hover">
                                    <thead>
                                        <tr align="center">


                                            <th scope="row" style="color:black;"><b>Gender</b></th>
                                            <th scope="row" style="color:black;"><b>Contact</b></th>
                                            <th scope="row" style="color:black;"><b>DOB</b></th>
                                            <th scope="row" style="color:black;"><b>Blood Group</b></th>
                                            <th scope="row" style="color:black;"><b>Religion</b></th>
                                            <th scope="row" style="color:black;"><b>Category</b></th>
                                            <th scope="row" style="color:black;"><b>Adhar Card Number</b></th>
                                            <th scope="row" style="color:black;"><b>Father Name</b></th>
                                            <th scope="row" style="color:black;"><b>Mother Name</b></th>
                                            <th scope="row" style="color:black;"><b>Father Occupation</b></th>
                                            <th scope="row" style="color:black;"><b>Mother Occupation</b></th>
                                            <th scope="row" style="color:black;"><b>Parent Contact</b></th>
                                            <th scope="row" style="color:black;"><b>Address</b></th>
                                            <th scope="row" style="color:black;"><b>Permanent Address</b></th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $cmd = "SELECT `first_name`, `middle_name`, `last_name`, `email`, `adhar_number`, `mobile_number`, `dob`, `gender`, `blood_group`, `religion`, `caste`, `father_name`, `mother_name`, `father_occupation`, `mother_occupation`, `parent_mobile_number`, `parent_email_id`,`pincode`, `address`,`permanent_address`, `permanent_pincode`,`payment_status` FROM `tbl_admission_student` WHERE id = ?";
                                        $stmt = $con->prepare($cmd);
                                        $stmt->bind_param("i", $stu_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result->num_rows != 0) {
                                            $row = $result->fetch_assoc();
                                            $stu_email = $row['email'];
                                            $stu_mobile_number = $row['mobile_number'];
                                            $stu_payment_status = $row['payment_status'];
                                            $stu_adhar_number = $row['adhar_number'];
                                            $stu_adhar_number = $row['adhar_number'];
                                            $stu_dob = $row['dob'];
                                            $stu_gender = $row['gender'];
                                            $stu_blood_group = $row['blood_group'];
                                            $stu_religion = $row['religion'];
                                            $stu_caste = $row['caste'];
                                            $stu_father_name = $row['father_name'];
                                            $stu_mother_name = $row['mother_name'];
                                            $stu_parent_mobile_number = $row['parent_mobile_number'];
                                            $stu_parent_email_id = $row['parent_email_id'];
                                            $stu_father_occupation = $row['father_occupation'];
                                            $stu_mother_occupation = $row['mother_occupation'];
                                            $stu_permanent_address = $row['permanent_address'];
                                            $stu_permanent_pincode = $row['permanent_pincode'];
                                            $stu_address = $row['address'];
                                            $stu_pincode = $row['pincode'];

                                            ?>
                                            <tr align="center">

                                                <td scope="row"><?php echo $stu_gender; ?></td>
                                                <td scope="row"><?php echo $stu_email; ?>
                                                    <?php echo "<br>"; ?>
                                                    <?php echo $stu_mobile_number; ?>
                                                </td>
                                                <td scope="row"><?php echo $stu_dob; ?></td>
                                                <td scope="row"><?php echo $stu_blood_group; ?></td>
                                                <td scope="row"><?php echo $stu_religion; ?></td>
                                                <td scope="row"><?php echo $stu_caste; ?></td>
                                                <td scope="row"><?php echo $stu_adhar_number; ?></td>
                                                <td scope="row"><?php echo $stu_father_name; ?></td>
                                                <td scope="row"><?php echo $stu_mother_name; ?></td>
                                                <td scope="row"><?php echo $stu_father_occupation; ?></td>
                                                <td scope="row"><?php echo $stu_mother_occupation; ?></td>
                                                <td scope="row"><?php echo $stu_parent_email_id; ?>
                                                    <?php echo "<br>"; ?>
                                                    <?php echo $stu_parent_mobile_number; ?>
                                                </td>
                                                <td scope="row"><?php echo $stu_address; ?>
                                                    <?php echo "<br>"; ?>
                                                    <?php echo $stu_pincode; ?>
                                                </td>
                                                <td scope="row"><?php echo $stu_permanent_address; ?>
                                                    <?php echo "<br>"; ?>
                                                    <?php echo $stu_permanent_pincode; ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->


                    <!-- Education details view -->
                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>Education Details</b></h5>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="techevent" class="dataTableLoad table table-bordered table-hover">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>SSC Bord Name</b></th>
                                            <th scope="row" style="color:black;"><b>SSC School Name</b></th>
                                            <th scope="row" style="color:black;"><b>SSC Aggregate Percentage </b></th>
                                            <th scope="row" style="color:black;"><b>SSC Passing Month & Year</b></th>
                                            <th scope="row" style="color:black;"><b>HSC Stream</b></th>
                                            <th scope="row" style="color:black;"><b>HSC Bord Name</b></th>
                                            <th scope="row" style="color:black;"><b>Hsc Seat Number</b></th>

                                            <th scope="row" style="color:black;"><b>HSC Passing Status</b></th>
                                            <th scope="row" style="color:black;"><b>HSC School Name</b></th>
                                            <th scope="row" style="color:black;"><b>HSC Aggregate Percentage</b></th>
                                            <th scope="row" style="color:black;"><b>HSC Passing Month & Year</b></th>
                                            <th scope="row" style="color:black;"><b>GUJCET Seat Number</b></th>
                                            <th scope="row" style="color:black;"><b>GUJCET Application Number</b></th>
                                            <th scope="row" style="color:black;"><b>JEE Seat Number</b></th>
                                            <th scope="row" style="color:black;"><b>JEE Application Number</b></th>
                                            <th scope="row" style="color:black;"><b>NEET Seat Number</b></th>
                                            <th scope="row" style="color:black;"><b>NEET Application Number</b></th>
                                            <th scope="row" style="color:black;"><b>Graduation Course</b></th>
                                            <th scope="row" style="color:black;"><b>Graduation University</b></th>
                                            <th scope="row" style="color:black;"><b>Graduation College Name</b></th>
                                            <th scope="row" style="color:black;"><b>Graduation CPI/CGPA</b></th>
                                            <th scope="row" style="color:black;"><b>Graduation Passing Status</b></th>
                                            <th scope="row" style="color:black;"><b>Graduation Passing Month & Year</b>
                                            </th>
                                            <th scope="row" style="color:black;"><b>GMCET Score</b></th>
                                            <th scope="row" style="color:black;"><b>CMAT Score</b></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cmd = "SELECT `ssc_boardname`, `ssc_schoolname`, `ssc_percentage`, `ssc_passingmonth`, `ssc_passingyear`, `hsc_stream`, `hsc_boardseatnumber`, `hsc_schoolname`, `hsc_percentage`, `hsc_passingstatus`, `hsc_passingmonth`, `hsc_passingyear`, `hsc_passingboard`, `gujcet_seatnumber`, `gujcet_applicationnumber`, `jee_seatnumber`, `jee_applicationnumber`, `neet_seatnumber`, `neet_applicationnumber`, `graduation_course`, `graduation_university`, `graduation_college_name`, `graduation_cpi`, `graduation_passing_status`, `graduation_passing_month`, `graduation_passing_year`, `gmcet_score`, `cmat_score` FROM `tbl_education_qualification` WHERE student_id = ?";
                                        $stmt = $con->prepare($cmd);
                                        $stmt->bind_param("i", $stu_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        if ($result->num_rows != 0) {
                                            $row = $result->fetch_assoc();

                                            $stu_ssc_boardname = $row['ssc_boardname'];
                                            $stu_ssc_schoolname = $row['ssc_schoolname'];
                                            $stu_ssc_percentage = $row['ssc_percentage'];
                                            $stu_ssc_passingmonth = $row['ssc_passingmonth'];
                                            $stu_ssc_passingyear = $row['ssc_passingyear'];
                                            $stu_hsc_stream = $row['hsc_stream'];
                                            $stu_hsc_boardseatnumber = $row['hsc_boardseatnumber'];
                                            $stu_hsc_schoolname = $row['hsc_schoolname'];
                                            $stu_hsc_percentage = $row['hsc_percentage'];
                                            $stu_hsc_passingstatus = $row['hsc_passingstatus'];
                                            $stu_hsc_passingmonth = $row['hsc_passingmonth'];
                                            $stu_hsc_passingyear = $row['hsc_passingyear'];
                                            $stu_hsc_passingboard = $row['hsc_passingboard'];
                                            $stu_gujcet_seatnumber = $row['gujcet_seatnumber'];
                                            $stu_gujcet_applicationnumber = $row['gujcet_applicationnumber'];
                                            $stu_jee_seatnumber = $row['jee_seatnumber'];
                                            $stu_jee_applicationnumber = $row['jee_applicationnumber'];
                                            $stu_neet_seatnumber = $row['neet_seatnumber'];
                                            $stu_neet_applicationnumber = $row['neet_applicationnumber'];
                                            $stu_graduation_course = $row['graduation_course'];
                                            $stu_graduation_university = $row['graduation_university'];
                                            $stu_graduation_college_name = $row['graduation_college_name'];
                                            $stu_graduation_cpi = $row['graduation_cpi'];
                                            $stu_graduation_passing_status = $row['graduation_passing_status'];
                                            $stu_graduation_passing_month = $row['graduation_passing_month'];
                                            $stu_graduation_passing_year = $row['graduation_passing_year'];
                                            $stu_gmcet_score = $row['gmcet_score'];
                                            $stu_cmat_score = $row['cmat_score'];

                                            ?>
                                            <tr align="center">
                                                <td scope="row"><?php echo $stu_ssc_boardname; ?></td>
                                                <td scope="row"><?php echo $stu_ssc_schoolname; ?></td>
                                                <td scope="row"><?php echo $stu_ssc_percentage; ?></td>
                                                <td scope="row"><?php echo $stu_ssc_passingmonth; ?>
                                                    <?php echo "/" . "<br>"; ?>
                                                    <?php echo $stu_ssc_passingyear; ?>
                                                </td>

                                                <td scope="row"><?php echo $stu_hsc_stream; ?></td>
                                                <td scope="row"><?php echo $stu_hsc_passingboard; ?></td>
                                                <td scope="row"><?php echo $stu_hsc_boardseatnumber; ?></td>
                                                <td scope="row"><?php echo $stu_hsc_passingstatus; ?></td>
                                                <td scope="row"><?php echo $stu_hsc_schoolname; ?></td>
                                                <td scope="row"><?php echo $stu_hsc_percentage; ?></td>
                                                <td scope="row"><?php echo $stu_hsc_passingmonth; ?>
                                                    <?php echo "/" . "<br>"; ?>
                                                    <?php echo $stu_hsc_passingyear; ?>
                                                </td>
                                                <td scope="row"><?php echo $stu_gujcet_seatnumber; ?></td>
                                                <td scope="row"><?php echo $stu_gujcet_applicationnumber; ?></td>
                                                <td scope="row"><?php echo $stu_jee_seatnumber; ?></td>
                                                <td scope="row"><?php echo $stu_jee_applicationnumber; ?></td>
                                                <td scope="row"><?php echo $stu_neet_seatnumber; ?></td>
                                                <td scope="row"><?php echo $stu_neet_applicationnumber; ?></td>
                                                <td scope="row"><?php echo $stu_graduation_course; ?></td>
                                                <td scope="row"><?php echo $stu_graduation_university; ?></td>
                                                <td scope="row"><?php echo $stu_graduation_college_name; ?></td>
                                                <td scope="row"><?php echo $stu_graduation_cpi; ?></td>
                                                <td scope="row"><?php echo $stu_graduation_passing_status; ?></td>
                                                <td scope="row"><?php echo $stu_graduation_passing_month; ?>
                                                    <?php echo "/" . "<br>"; ?>
                                                    <?php echo $stu_graduation_passing_year; ?>
                                                </td>
                                                <td scope="row"><?php echo $stu_cmat_score; ?></td>
                                                <td scope="row"><?php echo $stu_gmcet_score; ?></td>
                                            </tr>
                                        </tbody>
                                        <?php
                                        }
                                        ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- view and -->


                    <!-- Upload Documents view -->
                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>Upload Documents</b></h5>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="techevent" class="dataTableLoad table table-bordered table-hover">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Photo</b></th>
                                            <th scope="row" style="color:black;"><b>Aadhar Card</b></th>
                                            <th scope="row" style="color:black;"><b>Parent Aadhar Card</b></th>
                                            <th scope="row" style="color:black;"><b>School leaving Certificate</b></th>
                                            <th scope="row" style="color:black;"><b>SSC Marksheet</b></th>
                                            <th scope="row" style="color:black;"><b>HSC Marksheet</b></th>
                                            <th scope="row" style="color:black;"><b>GUJCET Result</b></th>
                                            <th scope="row" style="color:black;"><b>JEE Result</b></th>
                                            <th scope="row" style="color:black;"><b>NEET Result</b></th>
                                            <th scope="row" style="color:black;"><b>Migration Certificate</b></th>
                                            <th scope="row" style="color:black;"><b>Caste Certificate</b></th>
                                            <th scope="row" style="color:black;"><b>Other Certificate</b></th>
                                            <th scope="row" style="color:black;"><b>Transfer Certificate</b></th>
                                            <th scope="row" style="color:black;"><b>Graduation Marksheet</b></th>
                                            <th scope="row" style="color:black;"><b>Degree Certificate</b></th>
                                            <th scope="row" style="color:black;"><b>PEC Certificate</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cmd = "SELECT `photo`, `aadharcard`,`parent_aadharcard`, `school_leaving`, `ssc_marksheet`, `hsc_marksheet`, `caste_certificate`, `gujcet_result`, `jee_result`, `neet_result`, `transfer_certificate`, `graduation_marksheet`, `degree_certificate`, `migration_certificate`, `other_documents`, `pec_certificate` FROM `tbl_student_document` WHERE  student_id = ?";
                                        $stmt = $con->prepare($cmd);
                                        $stmt->bind_param("i", $stu_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        if ($result->num_rows != 0) {
                                            $row = $result->fetch_assoc();
                                            $stu_photo = !empty($row['photo']) ? $row['photo'] : 'N/A';
                                            $stu_aadharcard = !empty($row['aadharcard']) ? $row['aadharcard'] : 'N/A';
                                            $stu_parent_aadharcard = !empty($row['parent_aadharcard']) ? $row['parent_aadharcard'] : 'N/A';
                                            $stu_school_leaving = !empty($row['school_leaving']) ? $row['school_leaving'] : 'N/A';
                                            $stu_ssc_marksheet = !empty($row['ssc_marksheet']) ? $row['ssc_marksheet'] : 'N/A';
                                            $stu_hsc_marksheet = !empty($row['hsc_marksheet']) ? $row['hsc_marksheet'] : 'N/A';
                                            $stu_gujcet_result = !empty($row['gujcet_result']) ? $row['gujcet_result'] : 'N/A';
                                            $stu_jee_result = !empty($row['jee_result']) ? $row['jee_result'] : 'N/A';
                                            $stu_neet_result = !empty($row['neet_result']) ? $row['neet_result'] : 'N/A';
                                            $stu_migration_certificate = !empty($row['migration_certificate']) ? $row['migration_certificate'] : 'N/A';
                                            $stu_caste_certificate = !empty($row['caste_certificate']) ? $row['caste_certificate'] : 'N/A';
                                            $stu_other_documents = !empty($row['other_documents']) ? $row['other_documents'] : 'N/A';
                                            $stu_transfer_certificate = !empty($row['transfer_certificate']) ? $row['transfer_certificate'] : 'N/A';
                                            $stu_graduation_marksheet = !empty($row['graduation_marksheet']) ? $row['graduation_marksheet'] : 'N/A';
                                            $stu_degree_certificate = !empty($row['degree_certificate']) ? $row['degree_certificate'] : 'N/A';
                                            $stu_pec_certificate = !empty($row['pec_certificate']) ? $row['pec_certificate'] : 'N/A';
                                            ?>
                                            <tr align="center">
                                                <td><?php
                                                if ($stu_photo != "N/A") {
                                                    ?>
                                                        <a href="<?php echo "../admission/uploads/" . $stu_id . "/" . $stu_photo; ?>"
                                                            width="100px" alt="Image" download><i class="fa fa-download"
                                                                aria-hidden="true"></i></a>
                                                        <?php
                                                } else {
                                                    ?>
                                                        N/A
                                                        <?php
                                                }
                                                ?>
                                                </td>
                                                <td><?php
                                                if ($stu_aadharcard != "N/A") {
                                                    ?>
                                                        <a href="<?php echo "../admission/uploads/" . $stu_id . "/" . $stu_aadharcard; ?>"
                                                            width="100px" alt="Image" download><i class="fa fa-download"
                                                                aria-hidden="true"></i></a>

                                                        <?php
                                                } else {
                                                    ?>
                                                        N/A
                                                        <?php
                                                }
                                                ?>
                                                </td>
                                                <td><?php
                                                if ($stu_parent_aadharcard != "N/A") {
                                                    ?>
                                                        <a href="<?php echo "../admission/uploads/" . $stu_id . "/" . $stu_parent_aadharcard; ?>"
                                                            width="100px" alt="Image" download><i class="fa fa-download"
                                                                aria-hidden="true"></i></a>

                                                        <?php
                                                } else {
                                                    ?>
                                                        N/A
                                                        <?php
                                                }
                                                ?>
                                                </td>
                                                <td><?php
                                                if ($stu_school_leaving != "N/A") {
                                                    ?>
                                                        <a href="<?php echo "../admission/uploads/" . $stu_id . "/" . $stu_school_leaving; ?>"
                                                            width="100px" alt="Image" download><i class="fa fa-download"
                                                                aria-hidden="true"></i></a>

                                                        <?php
                                                } else {
                                                    ?>
                                                        N/A
                                                        <?php
                                                }
                                                ?>
                                                </td>
                                                <td><?php
                                                if ($stu_ssc_marksheet != "N/A") {
                                                    ?>
                                                        <a href="<?php echo "../admission/uploads/" . $stu_id . "/" . $stu_ssc_marksheet; ?>"
                                                            width="100px" alt="Image" download><i class="fa fa-download"
                                                                aria-hidden="true"></i></a>

                                                        <?php
                                                } else {
                                                    ?>
                                                        N/A
                                                        <?php
                                                }
                                                ?>
                                                </td>
                                                <td><?php
                                                if ($stu_hsc_marksheet != "N/A") {
                                                    ?>
                                                        <a href="<?php echo "../admission/uploads/" . $stu_id . "/" . $stu_hsc_marksheet; ?>"
                                                            width="100px" alt="Image" download><i class="fa fa-download"
                                                                aria-hidden="true"></i></a>

                                                        <?php
                                                } else {
                                                    ?>
                                                        N/A
                                                        <?php
                                                }
                                                ?>
                                                </td>
                                                <?php
                                                if ($stu_gujcet_result == "N/A") {
                                                    ?>
                                                    <td>N/A</td>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <td><a href="<?php echo "../admission/uploads/" . $stu_id . "/" . $stu_gujcet_result; ?>"
                                                            width="100px" alt="Image" download><i class="fa fa-download"
                                                                aria-hidden="true"></i></a></td>
                                                    <?php
                                                }
                                                ?>
                                                <td><?php
                                                if ($stu_jee_result != "N/A") {
                                                    ?>
                                                        <a href="<?php echo "../admission/uploads/" . $stu_id . "/" . $stu_jee_result; ?>"
                                                            width="100px" alt="Image" download><i class="fa fa-download"
                                                                aria-hidden="true"></i></a>
                                                        <?php
                                                } else {
                                                    ?>
                                                        N/A
                                                        <?php
                                                }
                                                ?>
                                                </td>
                                                <td><?php
                                                if ($stu_neet_result != "N/A") {
                                                    ?>
                                                        <a href="<?php echo "../admission/uploads/" . $stu_id . "/" . $stu_neet_result; ?>"
                                                            width="100px" alt="Image" download><i class="fa fa-download"
                                                                aria-hidden="true"></i></a>

                                                        <?php
                                                } else {
                                                    ?>
                                                        N/A
                                                        <?php
                                                }
                                                ?>
                                                </td>
                                                <td><?php
                                                if ($stu_migration_certificate != "N/A") {
                                                    ?>
                                                        <a href="<?php echo "../admission/uploads/" . $stu_id . "/" . $stu_migration_certificate; ?>"
                                                            width="100px" alt="Image" download><i class="fa fa-download"
                                                                aria-hidden="true"></i></a>

                                                        <?php
                                                } else {
                                                    ?>
                                                        N/A
                                                        <?php
                                                }
                                                ?>
                                                </td>
                                                <td><?php
                                                if ($stu_caste_certificate != "N/A") {
                                                    ?>
                                                        <a href="<?php echo "../admission/uploads/" . $stu_id . "/" . $stu_caste_certificate; ?>"
                                                            width="100px" alt="Image" download><i class="fa fa-download"
                                                                aria-hidden="true"></i></a>

                                                        <?php
                                                } else {
                                                    ?>
                                                        N/A
                                                        <?php
                                                }
                                                ?>
                                                </td>
                                                <td><?php
                                                if ($stu_other_documents != "N/A") {
                                                    ?>
                                                        <a href="<?php echo "../admission/uploads/" . $stu_id . "/" . $stu_other_documents; ?>"
                                                            width="100px" alt="Image" download><i class="fa fa-download"
                                                                aria-hidden="true"></i></a>

                                                        <?php
                                                } else {
                                                    ?>
                                                        N/A
                                                        <?php
                                                }
                                                ?>
                                                </td>
                                                <td><?php
                                                if ($stu_transfer_certificate != "N/A") {
                                                    ?>
                                                        <a href="<?php echo "../admission/uploads/" . $stu_id . "/" . $stu_transfer_certificate; ?>"
                                                            width="100px" alt="Image" download><i class="fa fa-download"
                                                                aria-hidden="true"></i></a>

                                                        <?php
                                                } else {
                                                    ?>
                                                        N/A
                                                        <?php
                                                }
                                                ?>
                                                </td>

                                                <td><?php
                                                if ($stu_graduation_marksheet != "N/A") {
                                                    ?>
                                                        <a href="<?php echo "../admission/uploads/" . $stu_id . "/" . $stu_graduation_marksheet; ?>"
                                                            width="100px" alt="Image" download><i class="fa fa-download"
                                                                aria-hidden="true"></i></a>

                                                        <?php
                                                } else {
                                                    ?>
                                                        N/A
                                                        <?php
                                                }
                                                ?>
                                                </td>

                                                <td><?php
                                                if ($stu_degree_certificate != "N/A") {
                                                    ?>
                                                        <a href="<?php echo "../admission/uploads/" . $stu_id . "/" . $stu_degree_certificate; ?>"
                                                            width="100px" alt="Image" download><i class="fa fa-download"
                                                                aria-hidden="true"></i></a>

                                                        <?php
                                                } else {
                                                    ?>
                                                        N/A
                                                        <?php
                                                }
                                                ?>
                                                </td>
                                                <td><?php
                                                if ($stu_pec_certificate != "N/A") {
                                                    ?>
                                                        <a href="<?php echo "../admission/uploads/" . $stu_id . "/" . $stu_pec_certificate; ?>"
                                                            width="100px" alt="Image" download><i class="fa fa-download"
                                                                aria-hidden="true"></i></a>

                                                        <?php
                                                } else {
                                                    ?>
                                                        N/A
                                                        <?php
                                                }
                                                ?>
                                                </td>


                                            </tr>
                                            <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- view and -->
                </div>
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