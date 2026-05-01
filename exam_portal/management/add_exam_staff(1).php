<?php
include '../include/checklogin.php';

if (isset($_POST['submit'])) {
    // Fetch data from HTML Form
    $role_id = $_POST['role_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $shortname = $_POST['short_name'];
    $EXsubject = $_POST['subject'];
    $password = $_POST['password'];
    $ex_role = $_POST['ex_role'];

    // Insert the JSON data into the database
    $stmt = $con->prepare("INSERT INTO tbl_exam_staff (`role_id`, `name`, `email`, `shortname`, `EXsubject`, `password`,`ex_role`) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("isssssi", $role_id, $name, $email, $shortname, $EXsubject, $password,$ex_role);
    $result1 = $stmt->execute();

    // Error handling if insertion fails
    if ($result1) {
        $_SESSION['status'] = "Staff Inserted Successfully!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='add_exam_staff.php'},1000)</script>";
    } else {
        $_SESSION['status'] = "Staff Insertion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='add_exam_staff.php'},1000)</script>";
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
                            <h1 class="m-0">Add Exam Staff</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Exam Staff</li>
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
                                    <h3 class="card-title">Add Exam Staff</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label>Select Role<span style="color: red;"> *</span></label>
                                                <select name="role_id" id="role_id" class="form-control" required>
                                                    <option value="52">Examiner</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label>Select Marks Entry Type<span style="color: red;"> *</span></label>
                                                <select name="ex_role" id="ex_role" class="form-control" required>
                                                    <option value="1">Theory</option>
                                                    <option value="2">Practical</option>
                                                    <option value="3">Theory + Practical</option>
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

                                            <div class="form-group col-sm-6">
                                                <label for="password">Password<span style="color: red;"> *</span></label>
                                                <input type="text" name="password" id="password" class="form-control" required>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label for="short_name">Faculty's Short Name<span style="color: red;"> *</span></label>
                                                <input type="text" name="short_name" id="short_name" class="form-control" required>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label for="subject">Subject<span style="color: red;"> *</span></label>
                                                <input type="text" name="subject" id="subject" class="form-control" required>
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
                                View Exam Staff
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped text-center">
                                    <thead>
                                        <tr align="center">
                                            <th>Sr.No.</th>
                                            <th>Name</th>
                                            <th>Subject</th>
                                            <th>Role Type</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Total Entered Marks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = 0;
                                        $cmd2 = $con->prepare("SELECT * FROM tbl_exam_staff WHERE is_delete = ?");
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
                                                <td><?= $row2['EXsubject'] ?></td>
                                                <td><?php if($row2['ex_role'] == 1){
                                                    echo "Theory Examiner";
                                                }elseif($row2['ex_role'] == 2){
                                                    echo "Practical Examiner";
                                                }elseif($row2['ex_role'] == 3){
                                                    echo "Theory + Practical Examiner";
                                                }   ?></td>
                                                <td><?= $row2['email'] ?></td>
                                                <td><?= $row2['password'] ?></td>
                                                <td>
                                                    <?php 
                                                    $sql = mysqli_query($con, "SELECT Mtheory FROM tbl_exam_results WHERE Mtheory IS NOT NULL AND examinerID = $id ");
                                                    $total = mysqli_num_rows($sql);
                                                    echo $total;
                                                    ?>
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
    <script type="text/javascript">
        $('#faculty_id').on('change', function() {
            var path = '<?php echo "$base_url_website_admin"; ?>';
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
    </script>
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
    <script>
        $(document).ready(function() {
            // Call this function whenever the selected values change
            function populateSubjectDropdown() {
                var faculty_id = $('#faculty_id').val();
                var level_id = $('#level_id').val();
                var program_id = $('#program_id').val();
                var sem = $('#sem').val();

                $.ajax({
                    url: 'get_subjects.php',
                    type: 'POST',
                    data: {
                        faculty_id: faculty_id,
                        level_id: level_id,
                        program_id: program_id,
                        sem: sem
                    },
                    dataType: 'json',
                    success: function(subjects) {
                        // Clear existing options and add new options
                        var subjectDropdown = $('#subject_code');
                        subjectDropdown.empty();
                        subjectDropdown.append($('<option>', {
                            value: '',
                            text: '--- Select Subject ---'
                        }));
                        $.each(subjects, function(index, subject) {
                            subjectDropdown.append($('<option>', {
                                value: subject.subject_code, // Set value to subject_code
                                text: subject.subject_name + '(' + subject.subject_code + ')' // Set text to subject_name
                            }));
                        });
                    }
                });
            }

            // Call the function when any of the selection boxes change
            $('#faculty_id, #level_id, #program_id, #sem').on('change', function() {
                populateSubjectDropdown();
            });

            // Call the function initially to populate the subject dropdown
            populateSubjectDropdown();
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