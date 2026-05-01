<?php
// Include the checklogin.php file
include '../include/checklogin.php';

if (isset($_POST['submit'])) {

    $cmd = $con->prepare("SELECT COUNT(*) FROM tbl_inquiry_student ");
    $cmd->execute();
    $result = $cmd->get_result();
    $row = $result->fetch_row();
    $inq_student_id = $row[0] + 1;
    $inq_student_id_padded = str_pad($inq_student_id, 3, '0', STR_PAD_LEFT);

    $inq_student_id_final = "INQ" . "$inq_student_id_padded";

    //Fetch data from HTML Form
    $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $first_name =  mysqli_real_escape_string($con, $_POST["first_name"]);
    $middle_name = mysqli_real_escape_string($con, $_POST["middle_name"]);
    $last_name = mysqli_real_escape_string($con, $_POST["last_name"]);
    // $dob = mysqli_real_escape_string($con, $_POST["dob"]);
    $mobile_number = mysqli_real_escape_string($con, $_POST["mobile_number"]);
    $second_mobile_number = mysqli_real_escape_string($con, $_POST["second_mobile_number"]);
    $last_exam = mysqli_real_escape_string($con, $_POST["last_exam"]);
    $email = $_POST['email'];
    $gender = mysqli_real_escape_string($con, $_POST["gender"]);
    $last_school_name = mysqli_real_escape_string($con, $_POST["last_school_name"]);
    $last_exam_status = mysqli_real_escape_string($con, $_POST["last_exam_status"]);
    $is_online = mysqli_real_escape_string($con, $_POST["is_online"]);


    // validate Data$program_id = validate_data($program_id);
    $level_id = validate_data($level_id);
    $faculty_id = validate_data($faculty_id);
    $first_name = validate_data($first_name);
    $middle_name = validate_data($middle_name);
    $last_name = validate_data($last_name);
    // $dob = validate_data($dob);
    $mobile_number = validate_data($mobile_number);
    $second_mobile_number = validate_data($second_mobile_number);
    $email = validate_data($email);
    $gender = validate_data($gender);
    $last_school_name = validate_data($last_school_name);
    $last_exam_status = validate_data($last_exam_status);
    $is_online = validate_data($is_online);

    $mobileQuery = $con->prepare("SELECT mobile_number FROM tbl_inquiry_student WHERE mobile_number = ?");
    $mobileQuery->bind_param("s", $mobile_number);
    $mobileQuery->execute();
    $mobileResult =  $mobileQuery->get_result();

    if (mysqli_num_rows($mobileResult) > 0) {
        // Email already exists, display an error message
        $_SESSION['status'] = "Mobile Number Already Exist";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='student_view.php'},1000)</script>";
    } else {
        // Prepare and execute the SQL statement to insert a record in the tbl_program_outcome
        $stmt = $con->prepare("INSERT INTO `tbl_inquiry_student`(`inq_student_id`, `last_exam_status`,`first_name`, `middle_name`, `last_name`, `gender`,  `mobile_number`, `mobile_number2`, `email`, `faculty_id`, `level_id`, `program_id`,`last_school_name`, `last_exam`, `last_exam_marks`, `is_online`,`created_by`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sissssssssiissisi", $inq_student_id_final,$last_exam_status, $first_name, $middle_name, $last_name, $gender,  $mobile_number, $second_mobile_number, $email, $faculty_id, $level_id, $program_id, $last_school_name, $last_exam, $last_exam_marks, $is_online,$staff_id);
        $result = $stmt->execute();
        if ($result) {
            if ($result) {
                //Sweet Alert of Success Message
                $_SESSION['status'] = "Student Inquiry Inserted Successfully";
                $_SESSION['status_code'] = "success";

                echo "<script>setTimeout(function(){window.location='student_insert.php'},1000);</script>";
            } else {
                //Sweet Alert of Error Message
                $_SESSION['status'] = "Student Inquiry Insertion Failed";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='student_insert.php'},1000)</script>";
            }
        }
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
                            <h1 class="m-0">Add Inquiry Student</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Inquiry Student</li>
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
                                    <h3 class="card-title">Add Inquiry Student</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" method="POST">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="form-group col-sm-3">
                                                <label for="name">First Name(name)<span style="color: red;">*</span></label>
                                                <input type="text" name="first_name" class="form-control" id="title_id" placeholder="Enter First Name" style="text-transform:uppercase" required>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="name">Middle Name(Father's name)<span style="color: red;">*</span></label>
                                                <input type="text" name="middle_name" class="form-control" id="title_id" placeholder="Enter Middle Name(Father Name)" style="text-transform:uppercase" required>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="name">Last Name(Surname)<span style="color: red;">*</span></label>
                                                <input type="text" name="last_name" class="form-control" id="title_id" placeholder="Enter Last Name(Surname)" style="text-transform:uppercase" required>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="gender">Gender<span style="color: red;">*</span></label>
                                                <select name="gender" id="gender" class="form-control" required>
                                                    <option value="">---Select Gender---</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>
                                            <!-- <div class="form-group col-sm-3">
                                                <label for="name">Date Of Birth</label>
                                                <input type="date" name="dob" class="form-control" id="title_id" placeholder="Enter Date Of Birth" >
                                            </div> -->
                                            <div class="form-group col-sm-3">
                                                <label for="name">Mobile Number<span style="color: red;">*</span></label>
                                                <input type="number" name="mobile_number" class="form-control" id="title_id" placeholder="Enter Mobile Number" required>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="name">Mobile Number 2</label>
                                                <input type="number" name="second_mobile_number" class="form-control" id="title_id" placeholder="Enter Mobile Number 2">
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="name">Email<span style="color: red;"></span></label>
                                                <input type="email" name="email" class="form-control" id="title_id" placeholder="Enter Email" >
                                            </div>
                                             <div class="form-group col-sm-3">
                                                <label for="name">Last School(name)<span style="color: red;"></span></label>
                                                <input type="text" name="last_school_name" class="form-control" id="title_id" placeholder="Enter Last School Name" style="text-transform:uppercase" >
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="last_exam">Last Exam<span style="color: red;">*</span></label>
                                                <select name="last_exam" id="last_exam" class="form-control" required>
                                                    <option value="">---Select Exam---</option>
                                                    <option value="1">SSC</option>
                                                    <option value="8">ITI</option>
                                                    <option value="9">DIPLOMA</option>
                                                    <option value="2">HSC(A)</option>
                                                    <option value="3">HSC(B)</option>
                                                    <option value="5">HSC(COMMERCE)</option>
                                                    <option value="6">HSC(ARTS)</option>
                                                    <option value="4">UNDER GRADUATION (UG)</option>
                                                    <option value="7">POST GRADUATION (PG)</option>
                                                </select>
                                            </div>
                                             <div class="form-group col-sm-3">
                                                <label for="last_exam">Last Exam<span style="color: red;">*</span></label>
                                                <select name="last_exam_status" id="last_exam_status" class="form-control" required>
                                                    <option value="">---Select Exam Status---</option>
                                                    <option value="1">PASS</option>
                                                    <option value="2">Appeared</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="is_online">Inquiry Type<span style="color: red;">*</span></label>
                                                <select name="is_online" id="is_online" class="form-control" required>
                                                    <option value="">---Select Type Of Inquiry---</option>
                                                    <option value="1">website</option>
                                                    <option value="2">Whatsapp</option>
                                                    <option value="3">Other</option>
                                                    <option value="4">Walk In</option>
                                                    <option value="5">E-Mail</option>

                                                    
                                                </select>
                                            </div>
                                            <hr class="w-100">
                                            <!-- Choose Intersted Fields  -->
                                            <div class="form-group col-sm-4">
                                                <label>Select Faculty<span style="color: red;">*</span></label>
                                                <select class="form-control" name="faculty_id" id="faculty_id" required>
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
                                            <div class="form-group col-sm-4">
                                                <label>Select Level<span style="color: red;">*</span></label>
                                                <select name="level_id" id="level_id" class="form-control" required>
                                                    <option value="">---Select Level---</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label>Select Program<span style="color: red;">*</span></label>
                                                <select name="program_id" id="program_id" class="form-control" required>
                                                    <option value="">---Select Program---</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer text-right">
                                        <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
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

    <!--<script>-->
    <!--    $(document).ready(function() {-->

            <!--//call for listing the dropdown and select by default-->
    <!--         load_level();-->

    <!--    });-->

    <!--    function load_level() {-->
    <!--        var path = '<?php //echo $base_url_website_admin; ?>';-->
    <!--        var faculty_id = <?php //echo $faculty_id; ?>;-->
    <!--        var level_id = <?php //echo $level_id; ?>;-->

    <!--        $.ajax({-->
    <!--            url: path + 'level.php',-->
    <!--            type: "POST",-->
    <!--            data: {-->
    <!--                faculty_data: faculty_id,-->
    <!--                level_id: level_id-->
    <!--            },-->
    <!--            success: function(result) {-->
    <!--                $('#level_id').html(result);-->

                    <!--// console.log(result);-->
    <!--            }-->
    <!--        });-->
    <!--    }-->
    <!--</script>-->
    <!--<script type="text/javascript">-->
    <!--    $('#faculty_id').on('change', function() {-->
    <!--        var path = '<?php //echo "$base_url_website_admin"; ?>';-->
    <!--        var faculty_id = this.value;-->
            <!--// alert("hii");-->
    <!--        $.ajax({-->
    <!--            url: path + 'level.php',-->
    <!--            type: "POST",-->
    <!--            data: {-->
    <!--                faculty_data: faculty_id-->
    <!--            },-->
    <!--            success: function(result) {-->
    <!--                $('#level_id').html(result);-->

                    <!--// console.log(result);-->
    <!--            }-->
    <!--        })-->
    <!--    });-->
    <!--</script>-->
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

                     console.log(result);
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
        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>
</body>

</html>