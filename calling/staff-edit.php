<?php
include './include/config.php';

// --- START: LOGIC FROM OLD FILE ---

if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];

    // Fetch existing data for the staff
    $query = $con->prepare("SELECT * FROM tbl_staff WHERE id = ?");
    $query->bind_param("i", $staff_id);
    $query->execute();
    $result = $query->get_result();
    $staff = $result->fetch_assoc();

    if ($staff) {
        // Extract staff data
        $staff_name = $staff['name'];
        $mobile_number = $staff['mobile_number'];
        $email = $staff['email'];
        $role = $staff['role_id'];
        $faculty_id = $staff['faculty_id'];
        $level_id = $staff['level_id'];
        $program_id = $staff['program_id'];
        $u_staff_id = explode(',', $staff['under_staff_id']); // Convert to array
    } else {
        // Handle case where staff ID is not found
        die("Staff member not found.");
    }
} else {
    // Handle case where no ID is provided
    die("No Staff ID provided.");
}

if (isset($_POST['update'])) {
    // Fetch data from HTML Form
    $staff_name = mysqli_real_escape_string($con, $_POST['name']);
    $mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $role = mysqli_real_escape_string($con, $_POST['role']);
    $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);

    // Sanitize and format u_staff_id values
    $u_staff_ids = isset($_POST['u_staff_id']) ? $_POST['u_staff_id'] : array();
    $u_staff_id_str = implode(',', array_map('intval', $u_staff_ids));

    // Update query
    $stmt = $con->prepare("UPDATE tbl_staff SET faculty_id = ?, level_id = ?, program_id = ?, role_id = ?, name = ?, email = ?, mobile_number = ?, under_staff_id = ? WHERE id = ?");
    $stmt->bind_param("iiisssssi", $faculty_id, $level_id, $program_id, $role, $staff_name, $email, $mobile_number, $u_staff_id_str, $staff_id);
    $result = $stmt->execute();

    // Check if update was successful and set session status
    if ($result) {
        $_SESSION['status'] = "Staff Details Updated Successfully";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Staff Details Update Failed";
        $_SESSION['status_code'] = "error";
    }

}
// --- END: LOGIC FROM OLD FILE ---
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
        <div class="pd-ltr-20  height-100-p xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Edit Staff Details</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item"><a href="staff_manage.php">Manage Staff</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Staff</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <form method="POST" enctype="multipart/form-data">
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
                                while ($row = $result->fetch_assoc()) {
                                    $selected = ($role == $row['id']) ? 'selected' : '';
                                    echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select Faculty</label>
                            <select class="form-control" name="faculty_id" id="faculty_id">
                                <option value="">--Please select--</option>
                                <?php
                                $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                $stmt = $con->prepare($cmd);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['id'] ?>" <?php if ($faculty_id == $row['id']) {
                                           echo "selected";
                                       } ?>>
                                        <?php echo $row['name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Select Level</label>
                            <select name="level_id" id="level_id" class="form-control">
                                <option value="">---Select Level---</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Select Program<span style="color: red;"> *</span></label>
                            <select name="program_id" id="program_id" class="form-control">
                                <option value="">---Select Program---</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Select staff (only for head)</label>
                            <select class="select2" name="u_staff_id[]" id="staff_id" multiple="multiple"
                                data-placeholder="---Select Staff Name---" style="width: 100%;">
                                <?php
                                $stmt = $con->prepare("SELECT id, name FROM tbl_staff WHERE is_delete = 0 AND is_active = 1 AND role_id IN ('15','20','21')");
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    $selected = in_array($row['id'], $u_staff_id) ? 'selected' : '';
                                    echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Name<span style="color: red;"> *</span></label>
                            <input type="text" name="name" class="form-control"
                                value="<?php echo htmlspecialchars($staff_name); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Contact<span style="color: red;"> *</span></label>
                            <input type="text" name="mobile_number" class="form-control"
                                value="<?php echo htmlspecialchars($mobile_number); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Email<span style="color: red;"> *</span></label>
                            <input type="email" name="email" class="form-control"
                                value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="update" class="btn btn-primary">Update Staff</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>
    <?php include('include/script.php'); ?>

    <script>
        $(document).ready(function () {
            // On page load, call functions to populate dropdowns with existing values
            load_level();
            load_program();

            // ** INITIALIZE SELECT2 **
            $('#staff_id').select2();
        });

        function load_level() {
            var faculty_id = <?php echo json_encode($faculty_id); ?>;
            var level_id = <?php echo json_encode($level_id); ?>;

            if (faculty_id) {
                $.ajax({
                    url: 'level.php', // Endpoint to get levels based on faculty
                    type: "POST",
                    data: {
                        faculty_data: faculty_id,
                        level_id: level_id // Pass existing level_id to pre-select it
                    },
                    success: function (result) {
                        $('#level_id').html(result);
                    }
                });
            }
        }

        function load_program() {
            var faculty_id = <?php echo json_encode($faculty_id); ?>;
            var level_id = <?php echo json_encode($level_id); ?>;
            var program_id = <?php echo json_encode($program_id); ?>;

            if (level_id) {
                $.ajax({
                    url: 'program.php', // Endpoint to get programs based on level
                    type: "POST",
                    data: {
                        faculty_data: faculty_id,
                        level_data: level_id,
                        program_id: program_id // Pass existing program_id to pre-select it
                    },
                    success: function (result) {
                        $('#program_id').html(result);
                    }
                });
            }
        }

        // When faculty dropdown changes
        $('#faculty_id').on('change', function () {
            var faculty_id = this.value;

            $('#level_id').html('<option value="">---Select Level---</option>'); // Reset level
            $('#program_id').html('<option value="">---Select Program---</option>'); // Reset program

            $.ajax({
                url: 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id
                },
                success: function (result) {
                    $('#level_id').html(result);
                }
            })
        });

        // When level dropdown changes
        $('#level_id').on('change', function () {
            var level_id = this.value;
            var faculty_id = $("#faculty_id").val();

            $('#program_id').html('<option value="">---Select Program---</option>'); // Reset program

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