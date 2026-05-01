<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];

    // Fetch existing data for the staff
    $query = $con->prepare("SELECT * FROM tbl_staff WHERE id = ?");
    $query->bind_param("i", $staff_id);
    $query->execute();
    $result = $query->get_result();
    $staff = $result->fetch_assoc();

    // Extract staff data
    $staff_name = $staff['name'];
    $mobile_number = $staff['mobile_number'];
    $email = $staff['email'];
    $role = $staff['role_id'];
    $faculty_id = $staff['faculty_id'];
    $level_id = $staff['level_id'];
    $program_id = $staff['program_id'];
    $u_staff_id = explode(',', $staff['under_staff_id']); // Convert to array
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
    $u_staff_id = implode(',', array_map('intval', $u_staff_ids));

    // Update query
    $stmt = $con->prepare("UPDATE tbl_staff SET faculty_id = ?, level_id = ?, program_id = ?, role_id = ?, name = ?, email = ?, mobile_number = ?, under_staff_id = ? WHERE id = ?");
    $stmt->bind_param("iiisssssi", $faculty_id, $level_id, $program_id, $role, $staff_name, $email, $mobile_number, $u_staff_id, $staff_id);
    $result = $stmt->execute();

    // Check if update was successful
    if ($result) {
        $_SESSION['status'] = "Staff Details Updated Successfully";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Staff Details Update Failed";
        $_SESSION['status_code'] = "error";
    }

    echo "<script>setTimeout(function(){window.location='staff_edit.php?id=$staff_id'},1000)</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>
    <!-- /.header -->
    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> <!-- /.Preloader -->

    <div class="wrapper">
        <?php include '../include/importnav.php'; ?>
        <?php include '../include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Edit Staff Details</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Staff Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- card -->
                            <div class="card card-gmiu">

                                <!-- card-header -->
                                <div class="card-header">
                                    <h3 class="card-title">Add Staff Details</h3>
                                </div> <!-- /.card-header -->

                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label>Select Role<span style="color: red;"> *</span></label>
                                            <select name="role" class="browser-default custom-select" required>
                                                <option value="">--Please select--</option>
                                                <?php
                                                $query = "SELECT id,name FROM tbl_role WHERE is_active = 1 and is_delete=0 and id IN (13,14,15,16,20,21,22,23,25,26,27,28,29,30,31,59) ";
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
                                                <?php
                                                $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                ?>
                                                    <option value="<?php echo $row['id'] ?>" 
                                                    <?php if ($faculty_id == $row['id']) {
                                                        echo "selected";     } ?>>
                                                        <?php echo $row['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Level</label>
                                            <select name="level_id" id="level_id" class="form-control" required>
                                                <option value="">---Select Level---</option>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label>Select Program<span style="color: red;"> *</span></label>
                                            <select name="program_id" id="program_id" class="form-control" required>
                                                <option value="">---Select Program---</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Staff (only for head)</label>
                                            <select class="form-control" name="u_staff_id[]" id="staff_id" multiple>
                                                <option value="">---Select Staff Name---</option>
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
                                            <input type="text" name="name" class="form-control" value="<?php echo $staff_name; ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Contact<span style="color: red;"> *</span></label>
                                            <input type="text" name="mobile_number" class="form-control" value="<?php echo $mobile_number; ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Email<span style="color: red;"> *</span></label>
                                            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                                        </div>

                                    </div>
                                </form>
                            </div> <!-- /.card -->
                        </div> <!--/.col (left) -->
                    </div> <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
        </div>
    </div>
    <?php include '../include/importfooter.php'; ?>
    <?php include '../include/importjs.php'; ?>
</body>

</html>
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
        var api_for = "dashboard";
        $.ajax({
            url: path + 'level.php',
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_id: level_id,
                api_for: api_for
            },
            success: function(result) {
                $('#level_id').html(result);
            }
        });

    }

    function load_program() {
        var path = '<?php echo $base_url_api; ?>';
        var faculty_id = <?php echo $faculty_id; ?>;
        var level_id = <?php echo $level_id; ?>;
        var program_id = <?php echo $program_id; ?>;
        var api_for = "dashboard";
        $.ajax({
            url: path + 'program.php',
            type: "POST",
            data: {
                faculty_data: faculty_id,
                level_data: level_id,
                program_id: program_id,
                api_for: api_for
            },
            success: function(result) {
                $('#program_id').html(result);
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
            }
        })
    });
</script>