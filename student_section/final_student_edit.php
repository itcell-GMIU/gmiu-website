<?php
// Include the checklogin.php file
include 'include/checklogin.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Header  -->
    <?php include 'include/importhead.php'; ?>`

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
    <script src="../website_assets/js/cities.js"></script>
</head>

<?php

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $level_id = mysqli_real_escape_string($con, $_GET['id']);
    $level_id = only_digits($level_id);
    if ($level_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='view_final_student.php'},1000)</script>";
    }

    // Fetch level id from display table
    $cmd = $con->prepare("SELECT * FROM tbl_students_2023 WHERE id = ?");
    $cmd->bind_param("i", $_GET['id']);
    $cmd->execute();
    $result = $cmd->get_result();

    while ($row = $result->fetch_assoc()) {
        // Fetch data from database
        // $level_name = !empty($row['level_name']) ? $row['level_name'] : 'N/A';

        $mode = $row['mode'];
        $level_id = $row['level_id'];
        $faculty_id = $row['faculty_id'];
        $program_id = $row['program_id'];
        $Student_is_active = $row['is_active'];
        $stu_first_name = $row['first_name'];
        $stu_middle_name = $row['middle_name'];
        $stu_last_name = $row['last_name'];
        $stu_gr_no = $row['gr_number'];
        $stu_number = $row['mobile_number'];
        $parent_mobile_no = $row['parent_mobile_number'];
        $stu_email = $row['email'];
        $parent_email = $row['parent_email_id'];
        $mode = $row['mode'];
        $stu_id = $row['id'];
        $adhar_number = $row['adhar_number'];
        $dob = $row['dob'];
        $gender = $row['gender'];
        $blood_group = $row['blood_group'];
        $religion = $row['religion'];
        $caste = $row['caste'];
        $father_name = $row['father_name'];
        $mother_name = $row['mother_name'];
        $father_occupation = $row['father_occupation'];
        $mother_occupation = $row['mother_occupation'];
        $parent_mobile_number = $row['parent_mobile_number'];
        $parent_email_id = $row['parent_email_id'];
        $city = $row['city'];
        $state = $row['state'];
        $country = $row['country'];
        $pincode = $row['pincode'];
        $address = $row['address'];
        $is_same_addr = $row['is_same_addr'];
        $permanent_city = $row['permanent_city'];
        $permanent_state = $row['permanent_state'];
        $permanent_country = $row['permanent_country'];
        $permanent_address = $row['permanent_address'];
        $permanent_pincode = $row['permanent_pincode'];
        $admission_year = $row['admission_year'];
        $password = $row['password'];
        $is_active = $row['is_active'];
        $is_delete = $row['is_delete'];
        $created_at = $row['created_at'];
        $updated_at = $row['updated_at'];
        $created_by = $row['created_by'];
        $updated_by = $row['updated_by'];
        $updated_by = $row['updated_by'];
    }
}
?>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> <!-- /.Preloader -->

    <!-- wrapper -->
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
                <!-- Container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row mb-2">
                        <!-- col -->
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit Student</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Student</li>
                            </ol>
                        </div> <!-- /.col -->
                    </div> <!-- /.row -->
                </div> <!-- /.container-fluid -->
            </div> <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <!-- container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- card -->
                            <div class="card card-gmiu">
                                <!-- card header -->
                                <div class="card-header">
                                    <h3 class="card-title">Edit Student</h3>
                                </div> <!-- /.card-header -->

                                <!-- form start -->
                                <form id="quickForm" method="POST" action="final_student_update.php">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <input type="text" name="stu_id" class="form-control" id="stu_id" value="<?php echo $stu_id; ?>" hidden>
                                        <div class="row">
                                            <p class="heading-p">Student Details</p>
                                            <hr>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="program_id">Select Program</label><span class="form_error_message">*</span>
                                                <select type="text" class="form-control" name="program_id" id="program_id" value="<?php echo $program_id; ?>">
                                                    <option value="">Select</option>
                                                    <?php
                                                    $cmd22 = $con->prepare("SELECT * FROM tbl_program WHERE faculty_id = ? AND level_id = ? ");
                                                    $cmd22->bind_param("ii", $faculty_id, $level_id);
                                                    $cmd22->execute();
                                                    $result22 = $cmd22->get_result();

                                                    while ($row22 = $result22->fetch_assoc()) {

                                                        if($row22['id'] == $program_id){
                                                            $selected = "selected";
                                                        }else{
                                                            $selected = "";
                                                        }
                                                    ?>
                                                        <option <?= $selected ?> value="<?= $row22['id'] ?>"><?= $row22['name'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="first_name">First Name</label><span class="form_error_message">*</span>
                                                <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $stu_first_name; ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="middle_name">Middle Name</label><span class="form_error_message">*</span>
                                                <input type="text" class="form-control" name="middle_name" id="middle_name" value="<?php echo $stu_middle_name; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!--    <hr> -->
                                            <div class="form-group col-md-6">
                                                <label for="last_name">Last Name</label><span class="form_error_message">*</span>
                                                <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $stu_last_name; ?>">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="gender">Gender</label><span class="form_error_message">*</span>
                                                <select class="form-control" name="gender" id="gender">
                                                    <option value="">--Please Select Gender--</option>
                                                    <option value="male" <?php if ($gender == "male") {
                                                                                echo "selected";
                                                                            } ?>>Male</option>
                                                    <option value="female" <?php if ($gender == "female") {
                                                                                echo "selected";
                                                                            } ?>>Female</option>
                                                    <option value="other" <?php if ($gender == "other") {
                                                                                echo "selected";
                                                                            } ?>>Others</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="mobile_number">Mobile Number</label><span class="form_error_message">*</span>
                                                <input type="text" class="form-control" name="mobile_number" id="mobile_number" value="<?php echo $stu_number; ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">Email</label><span class="form_error_message">*</span>
                                                <input type="email" class="form-control" name="email" id="email" value="<?php echo $stu_email; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!--      <hr> -->
                                            <div class="form-group col-md-6">
                                                <label for="dob">Date Of Birth</label><span class="form_error_message">*</span>
                                                <input type="date" class="form-control" name="dob" id="dob" value="<?php echo $dob; ?>" placeholder="">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="blood_group">Blood Group</label><span class="form_error_message">*</span>
                                                <select class="form-control" name="blood_group" id="blood_group">
                                                    <option value="">--Please Select Blood Group--</option>
                                                    <option value="A+" <?php if ($blood_group == "A+") {
                                                                            echo "selected";
                                                                        } ?>>A+</option>
                                                    <option value="A-" <?php if ($blood_group == "A-") {
                                                                            echo "selected";
                                                                        } ?>>A-</option>
                                                    <option value="B+" <?php if ($blood_group == "B+") {
                                                                            echo "selected";
                                                                        } ?>>B+</option>
                                                    <option value="B-" <?php if ($blood_group == "B-") {
                                                                            echo "selected";
                                                                        } ?>>B-</option>
                                                    <option value="O+" <?php if ($blood_group == "O+") {
                                                                            echo "selected";
                                                                        } ?>>O+</option>
                                                    <option value="O-" <?php if ($blood_group == "O-") {
                                                                            echo "selected";
                                                                        } ?>>O-</option>
                                                    <option value="AB+" <?php if ($blood_group == "AB+") {
                                                                            echo "selected";
                                                                        } ?>>AB+</option>
                                                    <option value="AB-" <?php if ($blood_group == "AB-") {
                                                                            echo "selected";
                                                                        } ?>>AB-</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!--  <hr> -->
                                            <div class="form-group col-md-6">
                                                <label for="religion">Religion</label><span class="form_error_message">*</span>
                                                <select class="form-control" name="religion" id="religion">
                                                    <option value="">--Please Select Religion--</option>
                                                    <option value="hindu" <?php if ($religion == "hindu") {
                                                                                echo "selected";
                                                                            } ?>>Hindu</option>
                                                    <option value="muslim" <?php if ($religion == "muslim") {
                                                                                echo "selected";
                                                                            } ?>>Muslim</option>
                                                    <option value="jain" <?php if ($religion == "jain") {
                                                                                echo "selected";
                                                                            } ?>>Jain</option>
                                                    <option value="buddhist" <?php if ($religion == "buddhist") {
                                                                                    echo "selected";
                                                                                } ?>>Buddhist</option>
                                                    <option value="christian" <?php if ($religion == "christian") {
                                                                                    echo "selected";
                                                                                } ?>>Christian</option>
                                                    <option value="sikh" <?php if ($religion == "sikh") {
                                                                                echo "selected";
                                                                            } ?>>Sikh</option>
                                                    <option value="other" <?php if ($religion == "other") {
                                                                                echo "selected";
                                                                            } ?>>Other</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="caste">Category</label><span class="form_error_message">*</span>
                                                <select class="form-control" name="caste" id="caste">
                                                    <option value="">--Please Select Category--</option>
                                                    <option value="general" <?php if ($caste == "general") {
                                                                                echo "selected";
                                                                            } ?>>General</option>
                                                    <option value="obc" <?php if ($caste == "obc") {
                                                                            echo "selected";
                                                                        } ?>>OBC</option>
                                                    <option value="sc" <?php if ($caste == "sc") {
                                                                            echo "selected";
                                                                        } ?>>SC</option>
                                                    <option value="st" <?php if ($caste == "st") {
                                                                            echo "selected";
                                                                        } ?>>ST</option>
                                                    <option value="ews" <?php if ($caste == "ews") {
                                                                            echo "selected";
                                                                        } ?>>EWS</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="adhar">Aadhar Card Number</label><span class="form_error_message">*</span>
                                                <input type="number" class="form-control" name="adhar" id="adhar" value="<?php echo $adhar_number; ?>">
                                            </div>
                                        </div>


                                        <!--  <p class="heading-p">Parent Details</p> -->
                                        <div class="row">
                                            <p class="heading-p">Parent Details</p>
                                            <hr>
                                        </div>

                                        <div class="row">

                                            <!--       <hr> -->
                                            <div class="form-group col-md-6">
                                                <label for="father">Father Name</label><span class="form_error_message">*</span>
                                                <input type="text" class="form-control" name="father" id="father" value="<?php echo $father_name; ?>">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="mother">Mother Name</label><span class="form_error_message">*</span>
                                                <input type="text" class="form-control" name="mother" id="mother" value="<?php echo $mother_name; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="father_occupation">Father Occupation</label><span class="form_error_message">*</span>
                                                <input type="text" class="form-control" id="father_occupation" name="father_occupation" value="<?php echo $father_occupation; ?>">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="mother_occupation">Mother Occupation</label><span class="form_error_message">*</span>
                                                <input type="text" class="form-control" name="mother_occupation" id="mother_occupation" value="<?php echo $mother_occupation; ?>">
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="form-group col-md-6">
                                                <label for="parents_number">Parent Mobile Number</label><span class="form_error_message">*</span>
                                                <input type="text" class="form-control" name="parents_number" id="parents_number" value="<?php echo $parent_mobile_number; ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="parents_email">Parent Email</label><!-- <span class="form_error_message">*</span> -->
                                                <input type="email" class="form-control" name="parents_email" id="parents_email" value="<?php echo $parent_email_id; ?>">
                                            </div>

                                        </div>

                                        <div class="row">
                                            <p class="heading-p">Mode And Quota</p>
                                            <hr>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label for="mode">Mode </label>
                                                <select id="admission_mode" name="mode" class="form-control tp">
                                                    <option value="">--Select--
                                                    </option>
                                                    <option id="regular_option" value="regular" <?php if ($mode == "regular") {
                                                                                                    echo "selected";
                                                                                                } ?>>Regular
                                                    </option>
                                                    <option id="genius_option" value="genius" <?php if ($mode == "genius") {
                                                                                                    echo "selected";
                                                                                                } ?>>Genius
                                                    </option>
                                                    <option id="minor_option" value="minor" <?php if ($mode == "minor") {
                                                                                                echo "selected";
                                                                                            } ?>>Minor
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="quota">Admission Quota </label>
                                                <select type="text" name="adm_quota" class="form-control" id="quota">
                                                    <option value="">--select--</option>
                                                    <option value="mq" <?php if ($adm_quota == "mq") {
                                                                            echo "selected";
                                                                        } ?>>MQ</option>
                                                    <option value="sq" <?php if ($adm_quota == "sq") {
                                                                            echo "selected";
                                                                        } ?>>SQ</option>
                                                    <option value="vq" <?php if ($adm_quota == "vq") {
                                                                            echo "selected";
                                                                        } ?>>VQ</option>
                                                    <option value="d2d" <?php if ($adm_quota == "d2d") {
                                                                            echo "selected";
                                                                        } ?>>D2D</option>
                                                    <option value="d2dacpc" <?php if ($adm_quota == "d2dacpc") {
                                                                                echo "selected";
                                                                            } ?>>D2D ACPC</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <p class="heading-p">Present Address</p>
                                            <hr>
                                        </div>

                                        <div class="row">

                                            <div class="form-group col-md-6">
                                                <label for="address">Address</label><span class="form_error_message">*</span>
                                                <input type="text" id="address" class="form-control" name="address" value="<?php echo $address; ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="pincode">Pincode</label><span class="form_error_message">*</span>
                                                <input type="number" class="form-control" id="pincode" name="pincode" value="<?php echo $pincode; ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="state">State</label><span class="form_error_message">*</span>
                                                <select onchange="print_city('city', this.selectedIndex);" id="state" name="state" class="form-control"></select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="city">City</label><span class="form_error_message">*</span>
                                                <select id="city" name="city" class="form-control"></select>
                                                <script language="javascript">
                                                    print_state("state");
                                                </script>
                                            </div>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="checkbox" name="is_same_addr" value="1" <?php if ($is_same_addr == 1)
                                                                                                            echo "checked"; ?> class="form-check-input" id="is_same_addr"> Is permanent address being same
                                                address for communication? Yes, or No
                                            </div>

                                        </div> -->
                                        <!--  <p class="heading-p">Permanent Address</p> -->

                                        <div class="row">
                                            <p class="heading-p">Permanent Address</p>
                                            <hr>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="permanent_address">Address</label><span class="form_error_message">*</span>

                                                <input type="text" class="form-control" id="permanent_address" name="permanent_address" value="<?php echo $permanent_address; ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="permanent_pincode">Pincode</label><span class="form_error_message">*</span>
                                                <input type="number" class="form-control" id="permanent_pincode" name="permanent_pincode" value="<?php echo $permanent_pincode; ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="permanent_state">State</label><span class="form_error_message">*</span>
                                                <select onchange="print_city_2('permanent_city', this.selectedIndex);" id="permanent_state" name="permanent_state" class="form-control"></select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="city">City</label><span class="form_error_message">*</span>
                                                <select id="permanent_city" name="permanent_city" class="form-control"></select>
                                                <script language="javascript">
                                                    print_state_2("permanent_state");
                                                </script>
                                            </div>
                                        </div>
                                        <!-- card footer -->
                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div> <!-- /.card footer -->
                                    </div> <!-- /.card-body -->
                                </form> <!-- /.form end -->
                            </div> <!-- /.card -->
                        </div> <!--/.left column -->
                    </div> <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section> <!-- /.content -->
        </div> <!-- /.content-wrapper -->

        <!-- footer -->
        <?php include 'include/importfooter.php'; ?>
        <!-- /.footer -->

    </div> <!-- ./wrapper -->

    <!-- Import JavaScript -->
    <?php include 'include/importjs.php'; ?>

    <script>
        $(document).ready(function() {
            // Keep selected city and state options
            var state = '<?php echo "$state"; ?>';
            var city = '<?php echo "$city"; ?>';
            var permanent_state = '<?php echo "$permanent_state"; ?>';
            var permanent_city = '<?php echo "$permanent_city"; ?>';

            // Set selected options for state and city
            $("#state option[value='" + state + "']").attr("selected", "selected");
            $("#permanent_state option[value='" + permanent_state + "']").attr("selected", "selected");

            // Print city options based on selected state
            var selected_state = $("#state")[0].selectedIndex;
            print_city('city', selected_state);

            // Print permanent city options based on selected permanent state
            var selected_permanent_state = $("#permanent_state")[0].selectedIndex;
            print_city_2('permanent_city', selected_permanent_state);

            // Autofill the city and state on window load
            $(window).on('load', function() {
                $("#city option[value='" + city + "']").attr("selected", "selected");
                $("#permanent_city option[value='" + permanent_city + "']").attr("selected", "selected");
            });


        });
    </script>
</body>

</html>