<?php
include '../include/checklogin.php';

if (isset($_POST['submit'])) {
    // Fetch data from HTML Form
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $short_name = $_POST['short_name'];

    $faculty_id = validate_data($faculty_id);
    $level_id = validate_data($level_id);

    // Insert the JSON data into the database
    $stmt = $con->prepare("INSERT INTO tbl_short_name (`short_name`, `faculty_id`, `level_id`) VALUES (?,?,?)");
    $stmt->bind_param("sii", $short_name,$faculty_id,$level_id);
    $result1 = $stmt->execute();

    // Error handling if insertion fails
    if ($result1) {
        $_SESSION['status'] = "Exam Form Inserted Successfully!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='short_name_insert.php'},1000)</script>";
    } else {
        $_SESSION['status'] = "Program Outcome Insertion Failed";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='short_name_insert.php'},1000)</script>";
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
                            <h1 class="m-0">Add Short Name</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Short Name</li>
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
                                    <h3 class="card-title">Add Short Name</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST" enctype="multipart/form-data">
                                    <div class="card-body">

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
                                                    $faculty_id = $row['id'];

                                                    $cmd33 = "SELECT * FROM tbl_clg_name WHERE is_delete = '0' and is_active='1' and FIND_IN_SET('$faculty_id', faculty_id) > 0";
                                                    $stmt33 = $con->prepare($cmd33);
                                                    $stmt33->execute();
                                                    $result33 = $stmt33->get_result();

                                                    echo '<option value="' . $faculty_id . '">';
                                                    if ($result33->num_rows > 0) {
                                                        $counter = 0;
                                                        while ($row33 = $result33->fetch_assoc()) {
                                                            $counter++;
                                                            echo $row33['clg_name'];

                                                            // Add a comma if it's not the last college name
                                                            if ($counter < $result33->num_rows) {
                                                                echo ', ';
                                                            }
                                                        }
                                                    }
                                                    echo '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Select Level<span style="color: red;"> *</span></label>
                                            <select name="level_id" id="level_id" class="form-control" required>
                                                <option value="">---Select Level---</option>
                                            </select>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label>Select Program<span style="color: red;"> *</span></label>
                                            <select name="program_id" id="program_id" class="form-control" required>
                                                <option value="">---Select Program---</option>
                                            </select>
                                        </div> -->

                                        <div class="form-group">
                                            <label class="short_name">Short Name<span style="color: red;"> *</span></label>
                                            <input type="text" name="short_name" id="short_name" class="form-control" required>
                                        </div>

                                    </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    <!-- /.card -->
                    
                    <div class="card card-gmiu mt-3">
                        <div class="card-header">
                            <div class="card-title">
                                View Short Name
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>Short Name</th>
                                        <th>Faculty Name</th>
                                        <th>Level Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $status = 0;
                                    $cmd2 = $con->prepare("SELECT std.short_name, std.faculty_id, std.level_id, std.program_id,faculty.name as faculty_name,
                            level.name as level_name FROM tbl_short_name as std
                            LEFT JOIN tbl_faculty faculty ON std.faculty_id = faculty.id
                            LEFT JOIN tbl_level level ON std.level_id = level.id WHERE std.is_delete = ?");
                                    $cmd2->bind_param("i", $status);
                                    $cmd2->execute();
                                    $result2 = $cmd2->get_result();
                                    $in = 1;
                                    while ($row2 = $result2->fetch_assoc()) {
                                        $short_name = $row2['short_name'];
                                        $faculty_name = $row2['faculty_name'];
                                        $level_name = $row2['level_name'];
                                    ?>

                                        <tr>
                                            <td><?= $in ?></td>
                                            <td><?= $short_name ?></td>
                                            <td><?= $faculty_name ?></td>
                                            <td><?= $level_name ?></td>
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