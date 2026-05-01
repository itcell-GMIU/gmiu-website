<?php
include './include/config.php';

// Initialize a variable to hold student data
$student = null;
$student_id = 0;
$isReadOnly = ($role_id == 12 || $role_id == 57) ? '' : 'readonly'; // Disable certain fields for role_id 12 and 13
$isDisabled = ($role_id == 12 || $role_id == 57) ? '' : 'disabled'; // Disable certain fields for role_id 12 and 13

/**
 * ---------------------------------------------------------
 * STEP 1: Fetch the student ID from the URL
 * ---------------------------------------------------------
 * - We need an ID to know which student to edit.
 * - If no ID is provided, redirect to a list page (assumed to be 'view_inquiries.php').
 */
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $student_id = (int) $_GET['id'];
} else {
    // Redirect if no ID is provided in the URL
    $_SESSION['status'] = "Invalid request. No student ID provided.";
    $_SESSION['status_code'] = "warning";
}

/**
 * ---------------------------------------------------------
 * STEP 2: Handle form submission for UPDATE
 * ---------------------------------------------------------
 * - This block runs only when the form is submitted (POST request).
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // It's crucial to get the ID from a hidden field in the form, not the URL, on POST.
    $student_id_to_update = !empty($_POST['student_id']) ? (int) $_POST['student_id'] : 0;

    // Sanitize the submitted form data
    $first_name = !empty($_POST['first_name']) ? strtoupper(trim($_POST['first_name'])) : '';
    $middle_name = !empty($_POST['middle_name']) ? strtoupper(trim($_POST['middle_name'])) : '';
    $last_name = !empty($_POST['last_name']) ? strtoupper(trim($_POST['last_name'])) : '';
    $mobile = !empty($_POST['mobile']) ? preg_replace('/\D/', '', $_POST['mobile']) : '';
    $gender = !empty($_POST['gender']) ? trim($_POST['gender']) : '';
    $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    /**
     * NOTE: The unique `inq_student_id` is NOT updated. It was generated on creation
     * and should remain constant. We only update the student's personal details.
     */

    $sql = "UPDATE tbl_inquiry_student SET 
                first_name = ?, 
                middle_name = ?, 
                last_name = ?, 
                mobile_number = ?, 
                gender = ?, 
                faculty_id = ?, 
                level_id = ?,   
                program_id = ?,              
                updated_by = ?,
                email = ?
            WHERE id = ?"; // Assuming 'id' is your primary key

    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param(
            "sssssiiiisi",
            $first_name,
            $middle_name,
            $last_name,
            $mobile,
            $gender,
            $faculty_id,
            $level_id,
            $program_id,
            $staff_id,
            $email,
            $student_id_to_update
        );

        if ($stmt->execute()) {
            $_SESSION['status'] = "Student Inquiry updated successfully.";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Update Failed: " . $stmt->error;
            $_SESSION['status_code'] = "error";
        }
        $stmt->close();
    } else {
        $_SESSION['status'] = "Update Failed, Something Went Wrong: " . $con->error;
        $_SESSION['status_code'] = "error";
    }

}

/**
 * ---------------------------------------------------------
 * STEP 3: Fetch existing student data for the form
 * ---------------------------------------------------------
 * - This runs when the page is first loaded (GET request).
 */
if ($student_id > 0) {
    $stmt = $con->prepare("SELECT * FROM tbl_inquiry_student WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $student = $result->fetch_assoc();
        $faculty_id = $student['faculty_id'];
        $level_id = $student['level_id'];
        $program_id = $student['program_id'];
    } else {
        // No student found with that ID
        $_SESSION['status'] = "Student not found.";
        $_SESSION['status_code'] = "error";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include('include/head.php'); ?>
</head>

<body>
    <?php include('include/header.php'); ?>
    <?php include('include/sidebar.php'); ?>
    <div class="main-container">
        <div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Edit Student Inquiry</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Inquiry</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <?php if ($student): // Only show the form if student data was successfully fetched ?>
                        <form method="POST">
                            <!-- Hidden input to store the student ID for the POST request -->
                            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student['id']); ?>">

                            <div class="form-group">
                                <label>Inquiry ID</label>
                                <input type="text" class="form-control"
                                    value="<?php echo htmlspecialchars($student['inq_student_id']); ?>" readonly>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>First Name (Student Name)</label>
                                        <input type="text" name="first_name" class="form-control"
                                            placeholder="Enter First Name" <?= $isReadOnly; ?>
                                            value="<?php echo htmlspecialchars($student['first_name']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Middle Name (Father's Name)</label>
                                        <input type="text" name="middle_name" class="form-control"
                                            placeholder="Enter Middle Name" <?= $isReadOnly; ?>
                                            value="<?php echo htmlspecialchars($student['middle_name']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Last Name (Surname)</label>
                                        <input type="text" name="last_name" class="form-control"
                                            placeholder="Enter Last Name" <?= $isReadOnly; ?>
                                            value="<?php echo htmlspecialchars($student['last_name']); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Mobile Number</label>
                                <div class="col-sm-12 col-md-4">
                                    <input class="form-control" type="tel" name="mobile" placeholder="98765 43210"
                                        <?= $isReadOnly; ?>
                                        value="<?php echo htmlspecialchars($student['mobile_number']); ?>">
                                </div>

                                <label class="col-sm-12 col-md-2 col-form-label">Gender</label>
                                <div class="col-sm-12 col-md-4">
                                    <select class="form-control" name="gender" <?= $isDisabled; ?>>
                                        <option value="">Select</option>
                                        <option value="male" <?php if ($student['gender'] == 'male')
                                            echo 'selected'; ?>>Male
                                        </option>
                                        <option value="female" <?php if ($student['gender'] == 'female')
                                            echo 'selected'; ?>>
                                            Female</option>
                                        <option value="other" <?php if ($student['gender'] == 'other')
                                            echo 'selected'; ?>>
                                            Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Email</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input type="email" name="email" class="form-control"
                                            placeholder="Enter Email" <?= $isReadOnly; ?>
                                            value="<?php echo htmlspecialchars($student['email']); ?>">
                                    </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Completed Study</label>
                                <div class="col-sm-12 col-md-10">
                                    <select id="completedStudy" name="completed_study" class="custom-select col-12"
                                        disabled>
                                        <option>Choose...</option>
                                        <option value="1" <?php if ($student['last_exam'] == '1')
                                            echo 'selected'; ?>>10th
                                        </option>
                                        <option value="2" <?php if ($student['last_exam'] == '2')
                                            echo 'selected'; ?>>12th
                                            Commerce</option>
                                        <option value="3" <?php if ($student['last_exam'] == '3')
                                            echo 'selected'; ?>>12th
                                            Science (A Group)</option>
                                        <option value="4" <?php if ($student['last_exam'] == '4')
                                            echo 'selected'; ?>>12th
                                            Science (B Group)</option>
                                        <option value="5" <?php if ($student['last_exam'] == '5')
                                            echo 'selected'; ?>>12th
                                            Arts</option>
                                        <option value="6" <?php if ($student['last_exam'] == '6')
                                            echo 'selected'; ?>>Under
                                            Graduate</option>
                                        <option value="7" <?php if ($student['last_exam'] == '7')
                                            echo 'selected'; ?>>Post
                                            Graduate</option>
                                    </select>
                                </div>
                            </div>

                            <?php
                            // Determine if the 'Specify Degree' field should be visible on page load
                            $show_specify_degree = in_array($student['last_exam'], ['6', '7']);
                            ?>
                            <div class="form-group row" id="graduationDetails"
                                style="<?php echo $show_specify_degree ? 'display: flex;' : 'display: none;'; ?>">
                                <label class="col-sm-12 col-md-2 col-form-label">Specify Degree</label>
                                <div class="col-sm-12 col-md-10">
                                    <input class="form-control" type="text" name="specify_degree"
                                        placeholder="e.g., Bachelor of Commerce, Master of Science" <?= $isReadOnly; ?>
                                        value="<?php echo htmlspecialchars($student['specify_degree']); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Inquiry Type</label>
                                <div class="col-sm-12 col-md-4">
                                    <select id="inquiryType" name="is_online" class="custom-select col-12" required
                                        disabled>
                                        <option value="">---Select Type Of Inquiry---</option>
                                        <option value="1" <?php if ($student['is_online'] == '1')
                                            echo 'selected'; ?>>Website
                                        </option>
                                        <option value="2" <?php if ($student['is_online'] == '2')
                                            echo 'selected'; ?>>Whatsapp
                                        </option>
                                        <option value="3" <?php if ($student['is_online'] == '3')
                                            echo 'selected'; ?>>Other
                                        </option>
                                        <option value="4" <?php if ($student['is_online'] == '4')
                                            echo 'selected'; ?>>Walk In
                                        </option>
                                        <option value="5" <?php if ($student['is_online'] == '5')
                                            echo 'selected'; ?>>E-Mail
                                        </option>
                                        <option value="5" <?php if ($student['is_online'] == '6')
                                            echo 'selected'; ?>>Confidential Data
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Select Faculty</label>
                                <div class="col-sm-12 col-md-4">
                                    <select class="custom-select col-12" name="faculty_id" id="faculty_id" required
                                        <?= $isReadOnly; ?>>
                                        <option value="">---Select Faculty---</option>
                                        <?php
                                        $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' AND is_active = '1'";
                                        $stmt = $con->prepare($cmd);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) { ?>
                                            <option value="<?php echo $row['id']; ?>" <?php if ($student['faculty_id'] == $row['id'])
                                                   echo "selected"; ?>>
                                                <?php echo ($row['name']); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <label class="col-sm-12 col-md-2 col-form-label">Select Level</label>
                                <div class="col-sm-12 col-md-4">
                                    <select name="level_id" id="level_id" class="custom-select col-12" required
                                        <?= $isReadOnly; ?>>
                                        <option value="">---Select Level---</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Select Program</label>
                                <div class="col-sm-12 col-md-4">
                                    <select name="program_id" id="program_id" class="custom-select col-12" required
                                        <?= $isReadOnly; ?>>
                                        <option value="">---Select Program---</option>
                                    </select>
                                </div>
                            </div>


                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Update Inquiry</button>
                            </div>

                        </form>
                    <?php else: ?>
                        <div class="alert alert-danger">Student data could not be found.</div>
                    <?php endif; ?>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>

    <script>
        $(document).ready(function () {
            // This script is the same as your create page.
            // It ensures the "Specify Degree" field is shown/hidden correctly when the dropdown changes.
            $('#completedStudy').on('change', function () {
                var selectedValue = $(this).val();
                if (selectedValue === '6' || selectedValue === '7') {
                    $('#graduationDetails').slideDown();
                } else {
                    $('#graduationDetails').slideUp();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            //call for listing the dropdown and select by default
            load_level();
            load_program();
        });

        function load_level() {

            var faculty_id = <?php echo $faculty_id; ?>;
            var level_id = <?php echo $level_id; ?>;
            var api_for = "dashboard";
            $.ajax({
                url: 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id,
                    api_for: api_for
                },
                success: function (result) {
                    $('#level_id').html(result);
                }
            });

        }

        function load_program() {

            var faculty_id = <?php echo $faculty_id; ?>;
            var level_id = <?php echo $level_id; ?>;
            var program_id = <?php echo $program_id; ?>;
            var api_for = "dashboard";
            $.ajax({
                url: 'program.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_data: level_id,
                    program_id: program_id,
                    api_for: api_for
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
            // alert("hii");
            $.ajax({
                url: 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id
                },
                success: function (result) {
                    $('#level_id').html(result);

                    // console.log(result);
                }
            })
        });

        $('#level_id').on('change', function () {

            var level_id = this.value;
            var faculty_id = $("select#faculty_id option:checked").val();

            $.ajax({
                url: 'program.php',
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