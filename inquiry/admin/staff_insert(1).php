<?php
// Include the checklogin.php file
include '../include/checklogin.php';

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

    // Validate data
    $name = validate_data($name);
    $mobile_number = validate_data($mobile_number);
    $email = validate_data($email);
    $role = validate_data($role);
    
    // Prepare and execute SQL query
    if (!empty($faculty_id) && !empty($level_id) && !empty($program_id)) {
        $stmt = $con->prepare("INSERT INTO `tbl_staff`(faculty_id, level_id, program_id, role_id, name, email, mobile_number, password, under_staff_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiissssss", $faculty_id, $level_id, $program_id, $role, $name, $email, $mobile_number, $password, $u_staff_id);
        $result = $stmt->execute();
    } else {
        $stmt = $con->prepare("INSERT INTO `tbl_staff`(role_id, name, email, mobile_number, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $role, $name, $email, $mobile_number, $password);
        $result = $stmt->execute();
    }

    // Check if insertion was successful
    if ($result) {
        //Sweet Alert of Success Message
        $_SESSION['status'] = "Staff Details Inserted Successfully";
        $_SESSION['status_code'] = "success";
    } else {
        //Sweet Alert of Error Message
        $_SESSION['status'] = "Staff Details Insertion Failed";
        $_SESSION['status_code'] = "error";
    }
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

    <!-- CKeditor custom script -->
    <script type="text/javascript" src="../../admin_assets/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            CKEDITOR.replace('text_editor');
        });
    </script>

    <!-- /.CKeditor custom script -->

    <!--  <style>
        #row-form {
            column-gap: 16px;
            margin-top: 20px;
        }

        .multi-select {
            position: relative;
            display: inline-block;
        }

        .selected-items {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            min-height: 30px;
            cursor: text;
        }

        .selected-items>span {
            display: inline-block;
            background-color: #e0e0e0;
            color: #333;
            padding: 3px 8px;
            margin: 2px;
            border-radius: 20px;
        }

        .selection-input {
            font-size: 14px;
            padding: 5px;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .selection-input[multiple] {
            height: auto;
        }

        .selection-input[multiple] option:checked {
            background-color: #f5f5f5;
        }
    </style> -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> <!-- /.Preloader -->

    <!-- wrapper -->
    <div class="wrapper">

        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <!-- container-fluid -->
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row mb-2">

                        <!-- col -->
                        <div class="col-sm-6">
                            <h1 class="m-0">Add Staff Details</h1>
                        </div><!-- /.col -->

                        <!-- col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Staff Details</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
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

                                <!-- card-header -->
                                <div class="card-header">
                                    <h3 class="card-title">Add Staff Details</h3>
                                </div> <!-- /.card-header -->

                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">

                                    <!-- card-body -->
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Select Role<span style="color: red;"> *</span></label>
                                            <select name="role" class="browser-default custom-select" required>
                                                <option value="">--Please select--</option>
                                                <?php
                                                $query = "SELECT id,name FROM tbl_role WHERE is_active = 1 and is_delete=0 and id IN (13,14,15,16) ";
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
                                            <label>Select Faculty(only for head)<span style="color: red;"></span></label>
                                            <select class="form-control" name="faculty_id" id="faculty_id">
                                                <option value="">---Select Faculty---</option>
                                                <?php
                                                $cmd = "SELECT id,name FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
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

                                        <div class="form-group">
                                            <label>Select Level(only for head)<span style="color: red;"> </span></label>
                                            <select name="level_id" id="level_id" class="form-control">
                                                <option value="">---Select Level---</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Program(only for head)<span style="color: red;"> </span></label>
                                            <select name="program_id" id="program_id" class="form-control">
                                                <option value="">---Select Program---</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-sm-4">
                                            <label>Select staff (only for head)</label>
                                            <select class="form-control" name="u_staff_id[]" id="staff_id" multiple>
                                                <option value="">---Select Staff Name---</option>
                                                <?php
                                                $stmt = $con->prepare("SELECT id, name FROM tbl_staff WHERE is_delete = '0' AND is_active = '1' AND role_id = '15'");
                                                $stmt->execute();
                                                $result = $stmt->get_result();

                                                while ($row = $result->fetch_assoc()) {
                                                    $selected = ($url_staff_id == $row['id']) ? "selected" : "";
                                                ?>
                                                    <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
                                                        <?php echo $row['name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>



                                        <div class="form-group">
                                            <label>Name<span style="color: red;"> *</span></label>
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Contact<span style="color: red;"> *</span></label>
                                            <input type="text" name="mobile_number" class="form-control" id="mobile_number" placeholder="Enter Mobile Number" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Email <span style="color: red;"> *</span></label>
                                            <input type="text" name="email" class="form-control" id="email" placeholder="Enter Email" required>
                                        </div>


                                        <div class="form-group">
                                            <label for="name">Password<span style="color: red;">*</span></label>
                                            <input type="text" name="password" class="form-control" id="password" placeholder="Enter password" required>
                                        </div>

                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>

                                    </div> <!-- /.card-body -->
                                </form>
                            </div> <!-- /.card -->
                        </div> <!--/.col (left) -->
                    </div> <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section> <!-- /.content -->
        </div> <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- footer -->
    <?php include '../include/importfooter.php'; ?>
    <!-- /.footer -->

    <!-- Import JavaScript -->
    <?php include '../include/importjs.php'; ?>

</body>

</html>











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






<!-- Library for image preview -->
<script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>


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