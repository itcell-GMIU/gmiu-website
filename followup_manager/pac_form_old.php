<?php include './include/checklogin.php'; ?>
<?php $id = $_GET['stu_id']; ?>

<?php
// Assume the $con variable is your database connection
// $con = new mysqli("host", "username", "password", "database_name");

// Check if the form is submitted
// data insertion code 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stu_id = $_POST['stu_id'];
    $studentName = strtoupper($_POST['studentName']);
    $studentMobile = $_POST['studentMobile'];
    $studentEmail = $_POST['studentEmail'];
    $whatsappNumber = $_POST['whatsappNumber'];
    $parentMobile = $_POST['parentMobile'];
    $birthDate = $_POST['birthDate'];
    $mode = $_POST['mode'];
    $medium = $_POST['medium'];
    $faculty_id = $_POST['faculty_id'];
    $level_id = $_POST['level_id'];
    $program_id = $_POST['program_id'];  // Changed from stu_branch
    $admissionType = $_POST['admissionType'];
    $branchSpecialization = $_POST['branchSpecialization'];
    $quota = $_POST['quota'];
    $category = $_POST['category'];
    $dateProvisional = $_POST['dateProvisional'];
    $dateAdmission = $_POST['dateAdmission'];
    $admissionOrderStatus = $_POST['admissionOrderStatus'];
    $cbpaStatus = $_POST['cbpaStatus'];
    $tokenFeesAmount = $_POST['tokenFeesAmount'];
    $tokenFeesPaidDate = $_POST['tokenFeesPaidDate'];
    $remainingFees = $_POST['remainingFees'];
    $remainingPayDate = $_POST['remainingPayDate'];
    $photoStatus = $_POST['photoStatus'];
    $remarks = $_POST['remarks'];

    // SQL query to insert data
    $sql = "INSERT INTO tbl_pac_form (
                student_id, studentName, studentMobile, studentEmail, whatsappNumber, parentMobile,
                birthDate, mode, medium, faculty_id, level_id, program_id,
                admissionType, branchSpecialization, quota, category, dateProvisional,
                dateAdmission, admissionOrderStatus, cbpaStatus, tokenFeesAmount,
                tokenFeesPaidDate, remainingFees, remainingPayDate, photoStatus, remarks
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )";

    // Prepare statement
    if ($stmt = $con->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param(
            "ssssssssssssssssssssssssss",
            $stu_id,
            $studentName,
            $studentMobile,
            $studentEmail,
            $whatsappNumber,
            $parentMobile,
            $birthDate,
            $mode,
            $medium,
            $faculty_id,
            $level_id,
            $program_id,
            $admissionType,
            $branchSpecialization,
            $quota,
            $category,
            $dateProvisional,
            $dateAdmission,
            $admissionOrderStatus,
            $cbpaStatus,
            $tokenFeesAmount,
            $tokenFeesPaidDate,
            $remainingFees,
            $remainingPayDate,
            $photoStatus,
            $remarks
        );

        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['status'] = "PAC Form Submitted Successfully !!!";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='view_pac.php'},1000)</script>";
        } else {
            $_SESSION['status'] = "PAC form is Not Submitted Successfully !!!";
            $_SESSION['status_code'] = "error";
        }

        // Close the statement
        $stmt->close();
    } else {
        // echo "Error preparing statement: " . $con->error;
        $_SESSION['status'] = "Something Went Wrong !!!";
        $_SESSION['status_code'] = "error";
    }
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
                            <h1 class="m-0">Fill PAC Form</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">PAC Form</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <h3 class="card-title">PAC Form</h3>
                                </div>
                                <!-- /.card-header -->

                                <form id="quickForm" method="POST" action="#" class="needs-validation" novalidate>
                                    <div class="card-body">
                                        <input type="text" hidden value="<?php echo $id; ?>" name="stu_id">
                                        <!-- Student Details Section -->
                                        <div class="row">
                                            <p class="heading-p">Student Details</p>
                                            <hr>
                                        </div>

                                        <!-- Student Name, Mobile, and Email -->
                                        <div class="row">
                                            <!-- Student Name -->
                                            <div class="form-group col-md-6">
                                                <label for="studentName">Student Name</label><span
                                                    class="form_error_message">*</span>
                                                <input type="text" class="form-control" id="studentName"
                                                    name="studentName" required>
                                            </div>
                                            <!-- Student Mobile Number -->
                                            <div class="form-group col-md-6">
                                                <label for="studentMobile">Mobile Number (Student)</label><span
                                                    class="form_error_message">*</span>
                                                <input type="text" class="form-control" id="studentMobile"
                                                    name="studentMobile" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- Student Email -->
                                            <div class="form-group col-md-6">
                                                <label for="studentEmail">Student Email ID</label><span
                                                    class="form_error_message">*</span>
                                                <input type="email" class="form-control" id="studentEmail"
                                                    name="studentEmail" required>
                                            </div>
                                            <!-- WhatsApp Number -->
                                            <div class="form-group col-md-6">
                                                <label for="whatsappNumber">WhatsApp Number</label>
                                                <input type="text" class="form-control" id="whatsappNumber"
                                                    name="whatsappNumber">
                                            </div>
                                        </div>

                                        <!-- Parent Mobile and Birth Date -->
                                        <div class="row">
                                            <!-- Parent Mobile Number -->
                                            <div class="form-group col-md-6">
                                                <label for="parentMobile">Mobile Number (Parents)</label><span
                                                    class="form_error_message">*</span>
                                                <input type="text" class="form-control" id="parentMobile"
                                                    name="parentMobile" required>
                                            </div>
                                            <!-- Date of Birth -->
                                            <div class="form-group col-md-6">
                                                <label for="birthDate">Birth Date</label><span
                                                    class="form_error_message">*</span>
                                                <input type="date" class="form-control" id="birthDate" name="birthDate"
                                                    required>
                                            </div>
                                        </div>

                                        <!-- Mode and Medium -->
                                        <div class="row">
                                            <!-- Mode -->
                                            <div class="form-group col-md-6">
                                                <label>Mode</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="mode" id="modeR"
                                                        value="Reg" required>
                                                    <label class="form-check-label" for="modeR">Reg.</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="mode" id="modeD"
                                                        value="DLMC">
                                                    <label class="form-check-label" for="modeD">DLMC</label>
                                                </div>
                                            </div>
                                            <!-- Medium -->
                                            <div class="form-group col-md-6">
                                                <label>Medium</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="medium"
                                                        id="mediumGuj" value="Guj">
                                                    <label class="form-check-label" for="mediumGuj">Guj</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="medium"
                                                        id="mediumEng" value="Eng">
                                                    <label class="form-check-label" for="mediumEng">Eng</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Faculty, Level, and Program -->
                                        <div class="row">
                                            <!-- Select Faculty -->
                                            <div class="form-group col-md-6">
                                                <label class="control-label">Select Faculty<span style="color: red;">
                                                        *</span></label>
                                                <select class="form-control" name="faculty_id" required id="faculty_id">
                                                    <option value="">---Select Faculty---</option>
                                                    <?php
                                                    $query_faculty = "SELECT * FROM tbl_faculty WHERE is_delete = '0' AND is_active = '1'";
                                                    $stmt_faculty = $con->prepare($query_faculty);
                                                    $stmt_faculty->execute();
                                                    $result_faculty = $stmt_faculty->get_result();

                                                    while ($row_faculty = $result_faculty->fetch_assoc()) {
                                                        ?>
                                                        <option value="<?php echo $row_faculty['id']; ?>">
                                                            <?php echo $row_faculty['name']; ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    $stmt_faculty->close();
                                                    ?>
                                                </select>
                                            </div>

                                            <!-- Select Level -->
                                            <div class="form-group col-md-6">
                                                <label class="control-label">Select Level<span style="color: red;">
                                                        *</span></label>
                                                <select name="level_id" id="level_id" class="form-control" required>
                                                    <option value="">---Select Level---</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- Select Program -->
                                            <div class="form-group col-md-12">
                                                <label class="control-label">Select Program<span style="color: red;">
                                                        *</span></label>
                                                <select name="program_id" id="program_id" class="form-control" required>
                                                    <option value="">---Select Program/Branch---</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Admission Type and Branch/Specialization -->
                                        <div class="row">
                                            <!-- Admission Type -->
                                            <div class="form-group col-md-6">
                                                <label>Admission Type</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="admissionType"
                                                        id="type1stYear" value="1st Year" required>
                                                    <label class="form-check-label" for="type1stYear">1st Year</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="admissionType"
                                                        id="type2ndYear" value="2nd Year">
                                                    <label class="form-check-label" for="type2ndYear">2nd Year</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="admissionType"
                                                        id="typeDualDegree" value="Dual Degree">
                                                    <label class="form-check-label" for="typeDualDegree">Dual
                                                        Degree</label>
                                                </div>
                                            </div>
                                            <!-- Branch/Specialization -->
                                            <div class="form-group col-md-6">
                                                <label for="branchSpecialization">Branch / Specialization</label><span
                                                    class="form_error_message">*</span>
                                                <input type="text" class="form-control" id="branchSpecialization"
                                                    name="branchSpecialization" required>
                                            </div>
                                        </div>

                                        <!-- Quota and Category -->
                                        <div class="row">
                                            <!-- Quota -->
                                            <div class="form-group col-md-6">
                                                <label>Quota (UQ/MQ/VQ/SQ)</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="quota"
                                                        id="quotaUQ" value="UQ" required>
                                                    <label class="form-check-label" for="quotaUQ">UQ</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="quota"
                                                        id="quotaMQ" value="MQ">
                                                    <label class="form-check-label" for="quotaMQ">MQ</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="quota"
                                                        id="quotaVQ" value="VQ">
                                                    <label class="form-check-label" for="quotaVQ">VQ</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="quota"
                                                        id="quotaSQ" value="SQ">
                                                    <label class="form-check-label" for="quotaSQ">SQ</label>
                                                </div>
                                            </div>
                                            <!-- Category -->
                                            <div class="form-group col-md-6">
                                                <label>Category</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        id="categoryOpen" value="Open" required>
                                                    <label class="form-check-label" for="categoryOpen">Open</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        id="categoryEWS" value="EWS">
                                                    <label class="form-check-label" for="categoryEWS">EWS</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        id="categorySEBC" value="SEBC">
                                                    <label class="form-check-label" for="categorySEBC">SEBC</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        id="categorySCST" value="SC/ST">
                                                    <label class="form-check-label" for="categorySCST">SC/ST</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Admission Dates and Status -->
                                        <div class="row">
                                            <!-- Date of Provisional Admission -->
                                            <div class="form-group col-md-6">
                                                <label for="dateProvisional">Date of Provisional Admitted</label><span
                                                    class="form_error_message">*</span>
                                                <input type="date" class="form-control" id="dateProvisional"
                                                    name="dateProvisional" required>
                                            </div>
                                            <!-- Date of Admission -->
                                            <div class="form-group col-md-6">
                                                <label for="dateAdmission">Date of Admission</label>
                                                <input type="date" class="form-control" id="dateAdmission"
                                                    name="dateAdmission" required>
                                            </div>
                                        </div>

                                        <!-- Admission Order and CBPA Status -->
                                        <div class="row">
                                            <!-- Admission Order Status -->
                                            <div class="form-group col-md-6">
                                                <label>Admission Order Status</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="admissionOrderStatus" id="orderStatusYes" value="Yes">
                                                    <label class="form-check-label" for="orderStatusYes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="admissionOrderStatus" id="orderStatusNo" value="No">
                                                    <label class="form-check-label" for="orderStatusNo">No</label>
                                                </div>
                                            </div>
                                            <!-- CBPA Status -->
                                            <div class="form-group col-md-6">
                                                <label>CBPA Status</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="cbpaStatus"
                                                        id="cbpaYes" value="Yes">
                                                    <label class="form-check-label" for="cbpaYes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="cbpaStatus"
                                                        id="cbpaNo" value="No">
                                                    <label class="form-check-label" for="cbpaNo">No</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Fees and Photo Status -->
                                        <div class="row">
                                            <!-- Token Fees Amount -->
                                            <div class="form-group col-md-6">
                                                <label for="tokenFeesAmount">Token Fees Amount</label>
                                                <input type="number" class="form-control" id="tokenFeesAmount"
                                                    name="tokenFeesAmount" required>
                                            </div>
                                            <!-- Token Fees Paid Date -->
                                            <div class="form-group col-md-6">
                                                <label for="tokenFeesPaidDate">Token Fees Paid Date</label>
                                                <input type="date" class="form-control" id="tokenFeesPaidDate"
                                                    name="tokenFeesPaidDate" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- Remaining Semester Fees -->
                                            <div class="form-group col-md-6">
                                                <label for="remainingFees">Remaining Semester Fees</label>
                                                <input type="number" class="form-control" id="remainingFees"
                                                    name="remainingFees" required>
                                            </div>
                                            <!-- Remaining Semester Fees Pay Date -->
                                            <div class="form-group col-md-6">
                                                <label for="remainingPayDate">Remaining Semester Fees Pay Date</label>
                                                <input type="date" class="form-control" id="remainingPayDate"
                                                    name="remainingPayDate" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- Photo Submitted Status -->
                                            <div class="form-group col-md-6">
                                                <label>Photo Submitted Status</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="photoStatus"
                                                        id="photoYes" value="Yes">
                                                    <label class="form-check-label" for="photoYes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="photoStatus"
                                                        id="photoNo" value="No">
                                                    <label class="form-check-label" for="photoNo">No</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Remarks -->
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="remarks">Remark</label>
                                                <textarea class="form-control" id="remarks" name="remarks"
                                                    rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <!-- Submit Button -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    <!-- /.card-footer -->
                                </form>
                                <!-- /.form -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col-md-12 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
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
        $(document).ready(function () {
            $('.select2option').select2();
        });
    </script>
    <script>
        $(document).ready(function () {
            load_level();
            load_program();
        });

        function load_level() {
            var path = '<?php echo $base_url_website_admin; ?>';
            var faculty_id = <?php echo $faculty_id; ?>;
            var level_id = <?php echo $level_id; ?>;

            $.ajax({
                url: 'include/level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id
                },
                success: function (result) {
                    $('#level_id').html(result);
                }
            });
        }

        function load_program() {
            var path = '<?php echo $base_url_website_admin; ?>';
            var faculty_id = <?php echo $faculty_id; ?>;
            var level_id = <?php echo $level_id; ?>;

            $.ajax({
                url: 'include/program.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id
                },
                success: function (result) {
                    $('#program_id').html(result);
                }
            });
        }
    </script>

    <script type="text/javascript">
        $('#faculty_id').on('change', function () {
            var path = '<?php echo "$base_url_website_admin"; ?>';
            var faculty_id = this.value;

            $.ajax({
                url: 'include/level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id
                },
                success: function (result) {
                    $('#level_id').html(result);
                }
            })
        });

        $('#level_id').on('change', function () {
            var path = '<?php echo "$base_url_api"; ?>';
            var level_id = this.value;
            var faculty_id = $("select#faculty_id option:checked").val();

            $.ajax({
                url: 'include/program.php',
                type: "POST",
                data: {
                    level_data: level_id,
                    faculty_data: faculty_id
                },
                cache: false,
                success: function (data) {
                    $('#program_id').html(data);
                }
            })
        });
    </script>

    <script>
        $(document).ready(function () {
            load_level();
            load_program();
        });

        function load_level() {
            $.ajax({
                url: 'include/level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id
                },
                success: function (result) {
                    $('#level_id').html(result);
                }
            });
        }

        function load_program() {
            $.ajax({
                url: 'include/program.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id
                },
                success: function (result) {
                    $('#program_id').html(result);
                }
            });
        }
    </script>
    <script type="text/javascript">
        $('#faculty_id').on('change', function () {
            var faculty_id = this.value;
            $.ajax({
                url: 'include/level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id
                },
                success: function (result) {
                    $('#level_id').html(result);
                }
            })
        });

        $('#level_id').on('change', function () {
            var level_id = this.value;
            var faculty_id = $("select#faculty_id option:checked").val();

            $.ajax({
                url: 'include/program.php',
                type: "POST",
                data: {
                    level_data: level_id,
                    faculty_data: faculty_id
                },
                cache: false,
                success: function (data) {
                    $('#program_id').html(data);
                }
            })
        });
    </script>


</body>

</html>