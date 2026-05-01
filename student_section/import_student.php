<?php
// Include the checklogin.php file
include 'include/checklogin.php';
if (isset($_POST["import"])) {
    $o_faculty_id = $_POST['faculty_id'];
    $year = date("Y");

    // dynamic table name 
    $tbl_new = "tbl_students_" . $year;

    // SQL statement to create the table with dynamic name
    $sql = "CREATE TABLE IF NOT EXISTS $tbl_new (
    `id` BIGINT(20) NOT NULL AUTO_INCREMENT , `faculty_id` INT(20) NULL DEFAULT NULL , `level_id` INT(20) NULL DEFAULT NULL , `program_id` INT(20) NULL DEFAULT NULL ,`student_id` INT(20) NULL DEFAULT NULL , `minor_program` VARCHAR(255) NULL DEFAULT NULL , `semester` INT(11) NULL DEFAULT NULL , `admisssion_quota` VARCHAR(255) NULL DEFAULT NULL , `mode` VARCHAR(255) NULL DEFAULT NULL , `gr_number` VARCHAR(255) NULL DEFAULT NULL , `enrollnment_no` VARCHAR(255) NULL DEFAULT NULL , `profile_image` VARCHAR(255) NULL DEFAULT NULL , `first_name` VARCHAR(255) NULL DEFAULT NULL , `middle_name` VARCHAR(255) NULL DEFAULT NULL , `last_name` VARCHAR(255) NULL DEFAULT NULL , `email` VARCHAR(255) NULL DEFAULT NULL , `adhar_number` VARCHAR(255) NULL DEFAULT NULL , `mobile_number` VARCHAR(255) NULL DEFAULT NULL , `dob` DATE NULL DEFAULT NULL , `gender` VARCHAR(255) NULL DEFAULT NULL , `blood_group` VARCHAR(255) NULL DEFAULT NULL , `religion` VARCHAR(255) NULL DEFAULT NULL , `caste` VARCHAR(255) NULL DEFAULT NULL , `father_name` VARCHAR(255) NULL DEFAULT NULL , `mother_name` VARCHAR(255) NULL DEFAULT NULL , `father_occupation` VARCHAR(255) NULL DEFAULT NULL , `mother_occupation` VARCHAR(255) NULL DEFAULT NULL , `parent_mobile_number` VARCHAR(255) NULL DEFAULT NULL , `parent_email_id` VARCHAR(255) NULL DEFAULT NULL , `city` VARCHAR(255) NULL DEFAULT NULL , `state` VARCHAR(255) NULL DEFAULT NULL , `country` VARCHAR(255) NULL DEFAULT NULL , `pincode` VARCHAR(255) NULL DEFAULT NULL , `address` VARCHAR(255) NULL DEFAULT NULL , `is_same_addr` INT(1) NULL DEFAULT NULL , `permanent_city` VARCHAR(255) NULL DEFAULT NULL , `permanent_state` VARCHAR(255) NULL DEFAULT NULL , `permanent_country` VARCHAR(255) NULL DEFAULT NULL , `permanent_address` VARCHAR(255) NULL DEFAULT NULL , `permanent_pincode` VARCHAR(255) NULL DEFAULT NULL , `admission_year` YEAR(4) NULL DEFAULT NULL , `password` VARCHAR(255) NULL DEFAULT NULL , `payment_id` VARCHAR(255) NULL DEFAULT NULL , `is_active` TINYINT(1) NOT NULL DEFAULT '1' , `is_delete` TINYINT(1) NOT NULL DEFAULT '0' , `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `created_by` VARCHAR(255) NULL DEFAULT NULL , `updated_by` VARCHAR(255) NULL DEFAULT NULL , PRIMARY KEY (`id`)
)";
    $con->query($sql);

    // if ($con->query($sql) === TRUE) {

    // } else {
    //     echo "Error creating table: " . $con->error;
    // }

    $filename = $_FILES["file"]["tmp_name"];
    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($filename, "r");
        // Flag to skip the first row
        $skipFirstRow = true;
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
            // Skip the first row
            if ($skipFirstRow) {
                $skipFirstRow = false;
                continue;
            }
            $new_enrollment = $getData[1];
            $mobile_number = $getData[5];
            $email = $getData[6];
            $dob = $getData[8];

            // Check for duplicate entry
            $cmd = "SELECT * FROM tbl_admission_student WHERE is_delete = '0' AND is_active='1' AND mobile_number = ? AND email = ?";
            $stmt = $con->prepare($cmd);
            $stmt->bind_param("ss", $mobile_number, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Duplicate entry found, retrieve existing data
                while ($row = $result->fetch_assoc()) {
                    $faculty_id = !empty($row['faculty_id']) ? $row['faculty_id'] : null;
                $level_id = !empty($row['level_id']) ? $row['level_id'] : null;
                $program_id = !empty($row['program_id']) ? $row['program_id'] : null;
                $student_id = !empty($row['id']) ? $row['id'] : null;
                $minor_program = !empty($row['minor_program']) ? $row['minor_program'] : null;
                $semester = !empty($row['semester']) ? $row['semester'] : null;
                $admission_quota = !empty($row['admisssion_quota']) ? $row['admisssion_quota'] : null;
                $mode = !empty($row['mode']) ? $row['mode'] : null;
                $gr_number = !empty($row['gr_number']) ? $row['gr_number'] : null;
                $enrollment =  $new_enrollment;
                $profile_image = !empty($row['profile_image']) ? $row['profile_image'] : null;
                $first_name = !empty($row['first_name']) ? $row['first_name'] : null;
                $middle_name = !empty($row['middle_name']) ? $row['middle_name'] : null;
                $last_name = !empty($row['last_name']) ? $row['last_name'] : null;
                $email = !empty($row['email']) ? $row['email'] : null;
                $adhar_number = !empty($row['adhar_number']) ? $row['adhar_number'] : null;
                $mobile_number = !empty($row['mobile_number']) ? $row['mobile_number'] : null;
                $dob = !empty($row['dob']) ? $row['dob'] : null;
                $gender = !empty($row['gender']) ? $row['gender'] : null;
                $blood_group = !empty($row['blood_group']) ? $row['blood_group'] : null;
                $religion = !empty($row['religion']) ? $row['religion'] : null;
                $caste = !empty($row['caste']) ? $row['caste'] : null;
                $father_name = !empty($row['father_name']) ? $row['father_name'] : null;
                $mother_name = !empty($row['mother_name']) ? $row['mother_name'] : null;
                $father_occupation = !empty($row['father_occupation']) ? $row['father_occupation'] : null;
                $mother_occupation = !empty($row['mother_occupation']) ? $row['mother_occupation'] : null;
                $parent_mobile_number = !empty($row['parent_mobile_number']) ? $row['parent_mobile_number'] : null;
                $parent_email_id = !empty($row['parent_email_id']) ? $row['parent_email_id'] : null;
                $city = !empty($row['city']) ? $row['city'] : null;
                $state = !empty($row['state']) ? $row['state'] : null;
                $country = !empty($row['country']) ? $row['country'] : null;
                $pincode = !empty($row['pincode']) ? $row['pincode'] : null;
                $address = !empty($row['address']) ? $row['address'] : null;
                $is_same_addr = !empty($row['is_same_addr']) ? $row['is_same_addr'] : null;
                $permanent_city = !empty($row['permanent_city']) ? $row['permanent_city'] : null;
                $permanent_state = !empty($row['permanent_state']) ? $row['permanent_state'] : null;
                $permanent_country = !empty($row['permanent_country']) ? $row['permanent_country'] : null;
                $permanent_address = !empty($row['permanent_address']) ? $row['permanent_address'] : null;
                $permanent_pincode = !empty($row['permanent_pincode']) ? $row['permanent_pincode'] : null;
                $admission_year = !empty($row['admission_year']) ? $row['admission_year'] : null;
                $password = !empty($row['password']) ? $row['password'] : null;
                $payment_id = !empty($row['payment_id']) ? $row['payment_id'] : null;

                $stmt = $con->prepare("INSERT INTO $tbl_new (`faculty_id`, `level_id`, `program_id`, `student_id`, `minor_program`, `semester`, `admisssion_quota`, `mode`, `gr_number`, `enrollnment_no`, `profile_image`, `first_name`, `middle_name`, `last_name`, `email`, `adhar_number`, `mobile_number`, `dob`, `gender`, `blood_group`, `religion`, `caste`, `father_name`, `mother_name`, `father_occupation`, `mother_occupation`, `parent_mobile_number`, `parent_email_id`, `city`, `state`, `country`, `pincode`, `address`, `is_same_addr`, `permanent_city`, `permanent_state`, `permanent_country`, `permanent_address`, `permanent_pincode`, `admission_year`, `password`, `payment_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                // Bind the parameters with the values
                $stmt->bind_param(
                    "iiiisisssisssssiisssssssssissssisisssssiss",
                    $faculty_id,
                    $level_id,
                    $program_id,
                    $student_id,
                    $minor_program,
                    $semester,
                    $admission_quota,
                    $mode,
                    $gr_number,
                    $enrollment,
                    $profile_image,
                    $first_name,
                    $middle_name,
                    $last_name,
                    $email,
                    $adhar_number,
                    $mobile_number,
                    $dob,
                    $gender,
                    $blood_group,
                    $religion,
                    $caste,
                    $father_name,
                    $mother_name,
                    $father_occupation,
                    $mother_occupation,
                    $parent_mobile_number,
                    $parent_email_id,
                    $city,
                    $state,
                    $country,
                    $pincode,
                    $address,
                    $is_same_addr,
                    $permanent_city,
                    $permanent_state,
                    $permanent_country,
                    $permanent_address,
                    $permanent_pincode,
                    $admission_year,
                    $password,
                    $payment_id
                );

                    if (!($stmt->execute())) {
                        echo "Error inserting data";
                    }
                }
            }
        }
        $_SESSION['status'] = "Imported Successfully";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='import_student.php'},2000)</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">


    <!-- Navbar -->
    <?php include 'include/importnav.php'; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include 'include/importsidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <div class="wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Import Student in Software</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Import Student in Software</li>
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
                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <!-- <h3 class="card-title">Import Student-<a href="admission_sq.csv" download="admission_sq.csv">Click Here to download Sample to upload .csv file</a></h3>
                                    <br>
                                    <span><a href="admission_all_relation.xlsx" download="admission_all_relation.xlsx">Click here to download Relational table excel.</a></span> -->
                                    <h3 class="card-title">Import Student</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <div class="card-body">
                                    <form method="POST" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <label>Select Faculty<span style="color: red;"> *</span></label>
                                            <select class="form-control" name="faculty_id" required id="faculty_id">
                                                <option value="">---Select Faculty---</option>
                                                <?php
                                                $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                    $faculty_id = $row['faculty_id'];
                                                ?>

                                                    <option value="<?php echo $row['id'] ?>" <?php if ($faculty_id == $row['id']) {
                                                                                                    echo "selected";
                                                                                                } ?>>
                                                        <?php echo $row['name'] ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label>Select Level<span style="color: red;"> *</span></label>
                                            <select name="level_id" id="level_id" class="form-control" required>
                                                <option value="">---Select Level---</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select Program<span style="color: red;"> *</span></label>
                                            <select name="program_id" id="program_id" class="form-control" required>
                                                <option value="">---Select Program---</option>
                                            </select>
                                        </div> -->

                                        <div class="form-group">
                                            <label for="name">Select CSV<span style="color: red;">*</span></label>
                                            <input type="file" name="file" class="form-control" id="file" accept=".csv" required>
                                        </div>
                                        <div class="card-footer text-right">
                                            <input type="submit" name="import" value="Import" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->

            </section>
        </div><!-- /.container-fluid -->
    </div>
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

            $.ajax({
                url: path + 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id
                },
                success: function(result) {
                    $('#level_id').html(result);

                    // console.log(result);
                }
            });

        }

        function load_program() {
            var path = '<?php echo $base_url_api; ?>';
            var faculty_id = <?php echo $faculty_id; ?>;
            var level_id = <?php echo $level_id; ?>;

            $.ajax({
                url: path + 'program.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id
                },
                success: function(result) {
                    $('#program_id').html(result);

                    // console.log(result);
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

</body>

</html>