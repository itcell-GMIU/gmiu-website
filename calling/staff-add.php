<?php
include './include/config.php';

// Initialize variables to avoid potential JS errors on page load
$faculty_id = 0;
$level_id = 0;
// Make sure $base_url_api is defined, likely in one of your include files (e.g., head.php)

if (isset($_POST['submit'])) {
    // Fetch data from HTML Form
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $role = mysqli_real_escape_string($con, $_POST['role']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);

    // Sanitize and format u_staff_id values
    $u_staff_ids = isset($_POST['u_staff_id']) ? $_POST['u_staff_id'] : array();
    $u_staff_id = implode(',', array_map('intval', $u_staff_ids));

    // Check if the name already exists in the database
    $namecheck = $con->prepare("SELECT name FROM tbl_staff WHERE name = ? AND role_id = ?");
    $namecheck->bind_param("si", $name, $role);
    $namecheck->execute();
    $nameresult = $namecheck->get_result();

    // Check if the email already exists in the database
    $emailcheck = $con->prepare("SELECT email FROM tbl_staff WHERE email = ? AND role_id = ? AND is_active = 1 AND is_delete = 0");
    $emailcheck->bind_param("si", $email, $role);
    $emailcheck->execute();
    $emailresult = $emailcheck->get_result();

    // Check if the mobile number already exists in the database
    $numbercheck = $con->prepare("SELECT mobile_number FROM tbl_staff WHERE mobile_number = ? AND role_id = ? AND is_active = 1 AND is_delete = 0");
    $numbercheck->bind_param("si", $mobile_number, $role);
    $numbercheck->execute();
    $numberresult = $numbercheck->get_result();

    // if (mysqli_num_rows($nameresult) > 0) {
    if (false) {
        $_SESSION['status'] = "Name already exists";
        $_SESSION['status_code'] = "error";
    } elseif (mysqli_num_rows($emailresult) > 0) {
        $_SESSION['status'] = "Email already exists";
        $_SESSION['status_code'] = "error";
    } elseif (mysqli_num_rows($numberresult) > 0) {
        $_SESSION['status'] = "Mobile number already exists";
        $_SESSION['status_code'] = "error";
    } else {
        // Prepare and execute SQL query for insertion
        if (!empty($faculty_id) && !empty($level_id) && !empty($program_id)) {
            $stmt = $con->prepare("INSERT INTO tbl_staff (faculty_id, level_id, program_id, role_id, name, email, mobile_number, password, under_staff_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iiissssss", $faculty_id, $level_id, $program_id, $role, $name, $email, $mobile_number, $password, $u_staff_id);
        } else {
            $stmt = $con->prepare("INSERT INTO tbl_staff (role_id, name, email, mobile_number, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $role, $name, $email, $mobile_number, $password);
        }

        // Check if insertion was successful
        if ($stmt->execute()) {
            $_SESSION['status'] = "Staff Details Inserted Successfully";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Staff Details Insertion Failed";
            $_SESSION['status_code'] = "error";
        }
        if (isset($stmt)) {
            $stmt->close();
        }
    }

    // Close statements
    $namecheck->close();
    $emailcheck->close();
    $numbercheck->close();
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
                                <h4>Add Staff Details</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Staff Details</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                    <form id="quickForm" method="POST" action="">

                        <div class="form-group">
                            <label>Select Role<span style="color: red;"> *</span></label>
                            <select name="role" class="form-control" required>
                                <option value="">--Please select--</option>
                                <?php
                                if ($role_id == 60) {
                                    $query = "SELECT id,name FROM tbl_role WHERE is_active = 1 and is_delete=0 and id IN (12,13,14,15,16,21,25,57,59,11,22)";
                                } else {
                                    $query = "SELECT id,name FROM tbl_role WHERE is_active = 1 and is_delete=0 and id IN (12,13,14,15,16,21,25,57,59)";
                                }
                                $result = $con->query($query);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Select Faculty (only for head)</label>
                            <select class="form-control" name="faculty_id" id="faculty_id">
                                <option value="">---Select Faculty---</option>
                                <?php
                                $cmd = "SELECT id,name FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                $stmt = $con->prepare($cmd);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Select Level (only for head)</label>
                            <select name="level_id" id="level_id" class="form-control">
                                <option value="">---Select Level---</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Select Program (only for head)</label>
                            <select name="program_id" id="program_id" class="form-control">
                                <option value="">---Select Program---</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Select staff (only for head)</label>
                            <select class="select2" name="u_staff_id[]" id="staff_id" multiple="multiple"
                                data-placeholder="---Select Staff Name---" style="width: 100%;">
                                <?php
                                $stmt = $con->prepare("SELECT id, name FROM tbl_staff WHERE is_delete = '0' AND is_active = '1' AND role_id IN ('15','20','21') ");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Name<span style="color: red;"> *</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                        </div>

                        <div class="form-group">
                            <label>Contact<span style="color: red;"> *</span></label>
                            <input type="text" name="mobile_number" class="form-control"
                                placeholder="Enter Mobile Number" required>
                        </div>

                        <div class="form-group">
                            <label>Email <span style="color: red;"> *</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                        </div>

                        <div class="form-group">
                            <label>Password<span style="color: red;">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password"
                                required>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>


    <script type="text/javascript">
        $(document).ready(function () {

            // ** INITIALIZE SELECT2 **
            $('#staff_id').select2();

            // This is for dynamic dropdowns when a user makes a selection
            $('#faculty_id').on('change', function () {
                var faculty_id = this.value;
                $.ajax({
                    url: 'level.php',
                    type: "POST",
                    data: {
                        faculty_data: faculty_id
                    },
                    success: function (result) {
                        $('#level_id').html(result);
                        $('#program_id').html('<option value="">---Select Program---</option>');
                    }
                })
            });

            $('#level_id').on('change', function () {
                var level_id = this.value;
                var faculty_id = $("#faculty_id").val();

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
        });
    </script>
</body>

</html>