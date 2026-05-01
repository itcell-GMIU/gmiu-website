<?php
include '../include/checklogin.php';

if (isset($_POST['submit'])) {
    // Fetch data from HTML Form
    $role_id = $_POST['role_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $shortname = $_POST['short_name'];
    $program_id = $_POST['program_id'];
    $password = $_POST['password'];
    $ex_role = 3;


    $program_id = implode(',', $program_id);

    // Insert the JSON data into the database
    $stmt = $con->prepare("INSERT INTO tbl_exam_staff (`role_id`, `name`, `email`, `shortname`, `program_id`, `password`,`ex_role`) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("isssssi", $role_id, $name, $email, $shortname, $program_id, $password, $ex_role);
    $result1 = $stmt->execute();

    // Error handling if insertion fails
    if ($result1) {
        $_SESSION['status'] = "Staff Inserted Successfully!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='add_hod_staff.php'},1000)</script>";
    } else {
        $_SESSION['status'] = "Staff Insertion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='add_hod_staff.php'},1000)</script>";
    }
}

if (isset($_GET['dlt'])) {

    $dltid = $_GET["dlt"];

    $stmt = $con->prepare("UPDATE tbl_exam_staff SET is_active = 0 , is_delete = 1 where id = ?");
    $stmt->bind_param("s", $dltid);
    $result1 = $stmt->execute();

    // Error handling if insertion fails
    if ($result1) {
        $_SESSION['status'] = "Staff Delete Successfully!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='add_hod_staff.php'},1000)</script>";
    } else {
        $_SESSION['status'] = "Staff Deletion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='add_hod_staff.php'},1000)</script>";
    }
}

if (isset($_POST['update'])) {

    extract($_POST);

    $program_id = implode(',', $program_id);

    // Insert the JSON data into the database
    $stmt = $con->prepare("UPDATE tbl_exam_staff SET program_id = ? where id = ? ");
    $stmt->bind_param("ss", $program_id, $uid);
    $result1 = $stmt->execute();

    // Error handling if insertion fails
    if ($result1) {
        $_SESSION['status'] = "Staff Updated Successfully!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='add_hod_staff.php'},1000)</script>";
    } else {
        $_SESSION['status'] = "Staff Updation Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='add_hod_staff.php'},1000)</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>

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
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <?php

    if (isset($_GET["fsid"])) {
        $stdID = $_GET["fsid"];

        $cmd22 = "SELECT * from tbl_exam_staff where id = $stdID";
        $stmt22 = $con->prepare($cmd22);
        $stmt22->execute();
        $result33 = $stmt22->get_result();
        while ($row33 = $result33->fetch_assoc()) {
    ?>
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body p-0">
                            <form id="quickForm" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="uid" value="<?= $stdID ?>">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label>Select program<span style="color: red;"> *</span></label>
                                            <!-- <div class="multi-select"> -->
                                            <div class="selected-items"></div>
                                            <select class="select2option" style="width: 100%" name="program_id[]" multiple="multiple" required>
                                                <?php
                                                $cmd = "SELECT pro.id,pro.name,level.name as level_name FROM tbl_program as pro LEFT JOIN tbl_faculty faculty
                                                ON pro.faculty_id = faculty.id LEFT JOIN tbl_level level
                                                ON pro.level_id = level.id WHERE pro.is_delete = 0 and pro.is_active=1 ";
                                                $stmt = $con->prepare($cmd);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                while ($row = $result->fetch_assoc()) {
                                                    $program_id = $row['id'];
                                                    $program_name = $row['name'];
                                                    $level_name = $row['level_name'];

                                                    $numbersArray = explode(",", $row33['program_id']);

                                                    // Check if the number exists in the array
                                                    if (in_array($program_id, $numbersArray)) {
                                                        $select = "selected";
                                                    } else {
                                                        $select = "";
                                                    }
                                                ?>
                                                    <option <?= $select ?> value="<?php echo $program_id; ?>">
                                                        <?php echo $program_name . "(" . $level_name . ")"; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" name="update" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                        </div>
                        </form>
                    </div>
                    <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div> -->
                </div>

            </div>
            </div>
    <?php
        }
    }
    ?>

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
    </div>
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
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Add HOD Staff</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add HOD Staff</li>
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
                                    <h3 class="card-title">Add HOD Staff</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label>Select Role<span style="color: red;"> *</span></label>
                                                <select name="role_id" id="role_id" class="form-control" required readonly>
                                                    <option value="53">HOD Examiner</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label for="name">Name<span style="color: red;"> *</span></label>
                                                <input type="text" name="name" id="name" class="form-control" required>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label for="email">Email<span style="color: red;"> *</span></label>
                                                <input type="email" name="email" id="email" class="form-control" required>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="password">Password<span style="color: red;"> *</span></label>
                                                <input type="text" id="password" class="form-control" name="password" placeholder="Password Here..." readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="password">&nbsp;</label>
                                                <button onclick="generateMixedPassword()" class="btn btn-success waves-effect waves-light w-100">Generate</button>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label for="short_name">Faculty's Short Name<span style="color: red;"> *</span></label>
                                                <input type="text" name="short_name" id="short_name" class="form-control" required>
                                            </div>

                                            <!-- <div class="form-group col-sm-6">
                                                <label for="subject">Subject<span style="color: red;"> *</span></label>
                                                <input type="text" name="subject" id="subject" class="form-control" required>
                                            </div> -->

                                            <div class="form-group col-sm-12">
                                                <label>Select program<span style="color: red;"> *</span></label>
                                                <!-- <div class="multi-select"> -->
                                                <div class="selected-items"></div>
                                                <select class="select2option" style="width: 100%" name="program_id[]" multiple="multiple" required>

                                                    <?php
                                                    $cmd = "SELECT pro.id,pro.name,level.name as level_name FROM tbl_program as pro LEFT JOIN tbl_faculty faculty
                                                ON pro.faculty_id = faculty.id LEFT JOIN tbl_level level
                                                ON pro.level_id = level.id WHERE pro.is_delete = 0 and pro.is_active=1 ";
                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {
                                                        $program_id = $row['id'];
                                                        $program_name = $row['name'];
                                                        $level_name = $row['level_name'];

                                                    ?>
                                                        <option value="<?php echo $program_id; ?>">
                                                            <?php echo $program_name . "(" . $level_name . ")"; ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" name="submit" class="btn btn-primary">+ Add</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- /.card -->

                <div class="card card-gmiu mt-3">
                    <div class="card-header">
                        <div class="card-title">
                            View HOD staff
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table id="acedemic" class="dataTableLoad table table-bordered table-striped text-center">
                                <thead>
                                    <tr align="center">
                                        <th>Sr.No.</th>
                                        <th>Name</th>
                                        <th>Role Type</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $status = 0;
                                    $cmd2 = $con->prepare("SELECT * FROM tbl_exam_staff WHERE is_delete = ? and role_id = 53");
                                    $cmd2->bind_param("i", $status);
                                    $cmd2->execute();
                                    $result2 = $cmd2->get_result();
                                    $in = 1;
                                    while ($row2 = $result2->fetch_assoc()) {
                                        $id = $row2['id'];
                                    ?>

                                        <tr>
                                            <td><?= $in ?></td>
                                            <td><?= $row2['name'] ?></td>
                                            <td><?php if ($row2['ex_role'] == 1) {
                                                    echo "Theory Examiner";
                                                } elseif ($row2['ex_role'] == 2) {
                                                    echo "Practical Examiner";
                                                } elseif ($row2['ex_role'] == 3) {
                                                    echo "Theory + Practical Examiner";
                                                }   ?></td>
                                            <td><?= $row2['email'] ?></td>
                                            <td><?= $row2['password'] ?></td>
                                            <td>
                                                <a href="<?= $_SERVER['PHP_SELF'] ?>?fsid=<?= $row2['id'] ?>" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                <a href="<?= $_SERVER['PHP_SELF'] ?>?dlt=<?= $row2['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php
                                        $in++;
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
    </section>
    </div>
    <!-- /.content-wrapper -->
    <?php include '../include/importfooter.php'; ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include '../include/importjs.php'; ?>
    <script>
        $(document).ready(function() {
            $('.select2option').select2();
        });
    </script>
    <script>
        function generateMixedPassword() {
            const length = 8;
            const charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            let password = "";

            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * charset.length);
                password += charset.charAt(randomIndex);
            }

            document.getElementById("password").value = password;
        }
    </script>
    <script>
        $(document).ready(function() {

            //call for listing the dropdown and select by default
            load_level();

        });

        function load_level() {
            var path = '<?php echo $base_url_website_admin; ?>';
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
    </script>
    <script>
        $(document).ready(function() {
            $('#myModal').modal('show');
        });
    </script>

    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>

    <script src="../../admin_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
        document.getElementById('add_entry').addEventListener('click', function() {
            const lateFeeEntries = document.getElementById('late_fee_entries');
            const newEntry = document.querySelector('.late_fee_entry').cloneNode(true);

            // Reset input values in the new entry
            newEntry.querySelectorAll('input').forEach(input => {
                input.value = '';
            });

            lateFeeEntries.appendChild(newEntry);
        });
    </script>
</body>

</html>