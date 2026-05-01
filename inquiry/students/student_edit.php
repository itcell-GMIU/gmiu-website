<?php
// Include the checklogin.php file
include '../include/checklogin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Header -->
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
<?php
// Fetch program id and level id from display table
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='student_edit.php'},1000)</script>";
    }
}
if (isset($_GET["id"])) {


    $inq_id = $_GET["id"];


    $status = 0;
    $cmd = $con->prepare("SELECT pro.id as id, pro.inq_student_id as inq_student_id, pro.first_name as first_name, pro.middle_name as middle_name, pro.last_name as last_name, pro.gender as gender, pro.dob as dob, pro.mobile_number as mobile_number, pro.mobile_number2 as mobile_number2, pro.email as email, pro.faculty_id as faculty_id, pro.level_id as level_id, pro.program_id as program_id, pro.last_exam as last_exam, pro.last_exam_marks as last_exam_mark, pro.last_exam_status as last_exam_status, pro.is_online as is_online, faculty.name as faculty_name, level.name as level_name, program.name as program_name FROM tbl_inquiry_student as pro LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id LEFT JOIN tbl_level level ON pro.level_id = level.id LEFT JOIN tbl_program program ON pro.program_id = program.id WHERE pro.is_delete = ? AND pro.id = ?");
    $cmd->bind_param("ii", $status, $inq_id);
    $cmd->execute();
    $result = $cmd->get_result();
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $inq_student_id = $row['inq_student_id'];
        $first_name  = $row['first_name'];
        $middle_name = $row['middle_name'];
        $last_name = $row['last_name'];
        $gender = $row['gender'];
        // $dob = $row['dob'];
        $mobile_number = $row['mobile_number'];
        $mobile_number2 = $row['mobile_number2'];
        $email = $row['email'];
        $faculty_id = $row['faculty_id'];
        $level_id = $row['level_id'];
        $program_id = $row['program_id'];
        $last_exam = $row['last_exam'];
        $last_exam_mark = $row['last_exam_mark'];
        $is_online = $row['is_online'];
        $last_exam_status = $row['last_exam_status'];
    }
}

?>


<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div><!-- /.Preloader -->
    </div>
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
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit Student Inquiry</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Student Inquiry</li>

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
                                    <h3 class="card-title">Edit Student Inquiry</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="quickForm" name="std_details" action="student_update.php" method="POST">
                                    <div class="card-body">

                                        <div class="row">
                                            <input type="hidden" value="<?php echo $id ?>" name="id">
                                            <div class="form-group col-sm-3">
                                                <label for="name">First Name(Name)<span style="color: red;">*</span></label>
                                                <input type="text" name="first_name" value="<?php echo $first_name ?>" class="form-control" id="title_id" style="text-transform:uppercase" placeholder="Enter First Name" required>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="name">Middle Name(Father's name)<span style="color: red;">*</span></label>
                                                <input type="text" name="middle_name" value="<?php echo $middle_name ?>" class="form-control" id="title_id" style="text-transform:uppercase" placeholder="Enter Middle Name(Father Name)" required>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="name">Last Name(Surname)<span style="color: red;">*</span></label>
                                                <input type="text" name="last_name" value="<?php echo $last_name ?>" class="form-control" id="title_id" style="text-transform:uppercase" placeholder="Enter Last Name(Surname)" required>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="gender">Gender<span style="color: red;">*</span></label>
                                                <select name="gender" id="gender" value="<?php echo $gender ?>" class="form-control" required>
                                                    <option value="">---Select Gender---</option>
                                                    <option value="male" <?php if ($gender == "male") {
                                                                                echo "selected";
                                                                            } ?>>Male</option>
                                                    <option value="female" <?php if ($gender == "female") {
                                                                                echo "selected";
                                                                            } ?>>Female</option>
                                                </select>
                                            </div>
                                            <!-- <div class="form-group col-sm-3">
                                                <label for="name">Date Of Birth</label>
                                                <input type="date" name="dob" value="<?php //echo $dob 
                                                                                        ?>" class="form-control" id="title_id" placeholder="Enter Date Of Birth">
                                            </div> -->
                                            <div class="form-group col-sm-3">
                                                <label for="name">Mobile Number<span style="color: red;">*</span></label>
                                                <input type="number" name="mobile_number" value="<?php echo $mobile_number ?>" class="form-control" id="title_id" placeholder="Enter Mobile Number" required>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="name">Mobile Number 2</label>
                                                <input type="number" name="second_mobile_number" value="<?php echo $mobile_number2 ?>" class="form-control" id="title_id" placeholder="Enter Mobile Number 2">
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="name">Email<span style="color: red;"></span></label>
                                                <input type="email" name="email" value="<?php echo $email ?>" class="form-control" id="title_id" placeholder="Enter Email">
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="last_exam">Last Exam<span style="color: red;">*</span></label>
                                                <select name="exam" id="exam" class="form-control" required>
                                                    <option value="">---Select Exam---</option>
                                                    <option value="1" <?php if ($last_exam == "1") echo "selected"; ?>>10th</option>
                                                    <option value="2" <?php if ($last_exam == "2") echo "selected"; ?>>12th Commerce</option>
                                                    <option value="3" <?php if ($last_exam == "3") echo "selected"; ?>>12th Science (A Group)</option>
                                                    <option value="4" <?php if ($last_exam == "4") echo "selected"; ?>>12th Science (B Group)</option>
                                                    <option value="5" <?php if ($last_exam == "5") echo "selected"; ?>>12th Arts</option>
                                                    <option value="6" <?php if ($last_exam == "6") echo "selected"; ?>>Under Graduate</option>
                                                    <option value="7" <?php if ($last_exam == "7") echo "selected"; ?>>Post Graduate</option>
                                                    <option value="8" <?php if ($last_exam == "8") echo "selected"; ?>>Diploma</option>
                                                    <option value="9" <?php if ($last_exam == "9") echo "selected"; ?>>ITI</option>
                                                    <option value="10" <?php if ($last_exam == "10") echo "selected"; ?>>Diploma Pharmacy</option>
                                               </select>
                                            </div>

                                            <div class="form-group col-sm-3">
                                                <label for="last_exam">Last Exam Status<span style="color: red;">*</span></label>
                                                <select name="last_exam_status" id="last_exam_status" value="<?php echo $last_exam_status ?>" class="form-control" required>
                                                    <option value="">---Last Exam Status---</option>
                                                    <option value="1" <?php if ($last_exam_status == 1) {
                                                                            echo "selected";
                                                                        } ?>>PASS</option>
                                                    <option value="2" <?php if ($last_exam_status == 2) {
                                                                            echo "selected";
                                                                        } ?>>Appeared</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="is_online">Inquiry Mode<span style="color: red;">*</span></label>
                                                <select name="is_online" id="in_online" value="<?php echo $is_online ?>" class="form-control" required>
                                                    <option value="">---Inquiry Mode---</option>
                                                    <option value="1" <?php if ($is_online == "1") {
                                                                            echo "selected";
                                                                        } ?>>website</option>
                                                    <option value="2" <?php if ($is_online == "2") {
                                                                            echo "selected";
                                                                        } ?>>Whatsapp</option>
                                                    <option value="3" <?php if ($is_online == "3") {
                                                                            echo "selected";
                                                                        } ?>>Other</option>
                                                    <option value="4" <?php if ($is_online == "4") {
                                                                            echo "selected";
                                                                        } ?>>Walk In</option>
                                                    <option value="5" <?php if ($is_online == "5") {
                                                                            echo "selected";
                                                                        } ?>>E-Mail</option>
                                                </select>
                                            </div>
                                            <hr class="w-100">
                                            <!-- Choose Intersted Fields  -->
                                            <div class="form-group col-sm-4">
                                                <label>Select Faculty</label>
                                                <select class="form-control" name="faculty_id" id="faculty_id" required>
                                                    <option value="">---Select Faculty---</option>
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
                                                            <?php echo $row['name'] ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label>Select Level</label>
                                                <select name="level_id" id="level_id" class="form-control" required>
                                                    <option value="">---Select Level---</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label>Select Program</label>
                                                <select name="program_id" id="program_id" class="form-control" required>
                                                    <option value="">---Select Program---</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer text-right">
                                        <button type="submit" name="submit_std" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                    <!-- right column -->
                    <div class="col-md-6">

                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
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