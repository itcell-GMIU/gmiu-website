<?php
// Include the checklogin.php file
include '../include/checklogin.php';
$inq_id = $_GET['id'];
$first_name_error = $middle_name_error = $last_name_error = $mobile_number_error = $email_error = "";
$faculty_id_error = $level_id_error = $password_error = $program_id_error = "";
if (isset($_POST['submit'])) {



    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($con, $_POST['middle_name']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number']);
    $password = generate_password();
    //$password = mysqli_real_escape_string($con, $_POST['password']);
    /*   $hash_password = password_hash(
            $password,
            PASSWORD_DEFAULT
        ); */
    $faculty_id = mysqli_real_escape_string($con, $_POST['faculty_id']);
    $level_id = mysqli_real_escape_string($con, $_POST['level_id']);
    $program_id = mysqli_real_escape_string($con, $_POST['program_id']);
    
    // Check if email exists


    // Check if mobile number exists
    $mobileQuery = $con->prepare("SELECT mobile_number FROM tbl_admission_student WHERE mobile_number = ?");
    $mobileQuery->bind_param("s", $mobile_number);
    $mobileQuery->execute();
    $mobileResult =  $mobileQuery->get_result();

    if (mysqli_num_rows($mobileResult) > 0) {
        // Mobile number already exists, display an error message
        $_SESSION['status'] = "Mobile Number Already Exist";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='student_list.php'},1000)</script>";
    } else {
        if (empty($password_error) && empty($first_name_error) && empty($middle_name_error) && empty($last_name_error) && empty($email_error) && empty($mobile_number_error) && empty($faculty_id_error) && empty($level_id_error) && empty($program_id_error)) {
            $admission_year = date("Y");
            $semester = 1;
            $stmt = $con->prepare("INSERT INTO tbl_admission_student (admission_year,first_name,middle_name,last_name,email,mobile_number,faculty_id,level_id,program_id,password,counselor_id)
                VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssssssiiisi", $admission_year, $first_name, $middle_name, $last_name, $email, $mobile_number, $faculty_id, $level_id, $program_id, $password,$staff_id);
            if ($stmt->execute()) {
                $confirm = 1;
                $stmt1 = $con->prepare("UPDATE `tbl_inquiry_student` SET is_admission_confirm = ? , counselor_id = ?  WHERE id = ? ");
                $stmt1->bind_param("iii", $confirm,$staff_id,$inq_id);
                $result = $stmt1->execute();
                $admission_student_id = $con->insert_id;
                $subject = "Student Registration";
                $message = "Dear Applicant, <br>
                            Thank you for showing your interest in Gyanmanjari Innovative University. You are just </br>a step
                            away from enrolling at GMIU.Login in on https://gmiu.edu.in/gmiu/admission/ to </br>complete
                            your registration process.<br>
                            You are advised to change your password Immediately.Keep visiting our website regularly for updates.
                            <br>
                            <b>Username: {$mobile_number}  <br>
                            Password: {$password} </b><br>
                            <br>
                            -GMIU
                            ";
               //$to = $email;


                //code for sending sms
                $smsmessage = "Dear Applicant,Thank you for showing interest in Gyanmanjari Innovative University.You are just a step away from enrolling at GMIU.Login on https://gmiu.edu.in/gmiu/admission/ to complete your Registration process.Username:$mobile_number,Password:$password Note:Do not share your Username and Password with anyone.";
                //send_mail($to, $subject, $message);

                // $send_mail_error = send_mail($to, $subject, $message);
                // if ($send_mail_error == true) {
                //     $mail_status = "success";
                // } else {
                //     $mail_status = $send_mail_error;
                // }
                $stmt5 = $con->prepare("INSERT INTO tbl_email_error_log (admission_student_id,first_name,last_name,email,mail_status,mobile_number,faculty_id,level_id,program_id)
                VALUES (?,?,?,?,?,?,?,?,?)");
                $stmt5->bind_param("isssssiii", $admission_student_id, $first_name, $last_name, $email, $mail_status, $mobile_number, $faculty_id, $level_id, $program_id);
                $stmt5->execute();
                $_SESSION['status'] = "Registered Successfully,Password Will Sended on your registered mobile number & Email Address.";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='conform_admission_list.php'},2000)</script>";
                //send_sms($mobile_number, $smsmessage);
            } else {
                $_SESSION['status'] = "Something Went Wrong.";
                $_SESSION['status_code'] = "error";
                 echo "<script>setTimeout(function(){window.location='conform_admission.php'},2000)</script>";
            }
        } else {
            $_SESSION['status'] = "Invalid Data";
            $_SESSION['status_code'] = "error";
             echo "<script>setTimeout(function(){window.location='student_list.php'},1000)</script>";
        }
    }

}
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
        echo "<script>setTimeout(function(){window.location='#.php'},1000)</script>";
    }
}
if (isset($_GET["id"])) {


    $inq_id = $_GET["id"];


    $status = 0;
    $cmd = $con->prepare("SELECT pro.id as id, pro.inq_student_id as inq_student_id, pro.first_name as first_name, pro.middle_name as middle_name, pro.last_name as last_name, pro.gender as gender, pro.dob as dob, pro.mobile_number as mobile_number, pro.mobile_number2 as mobile_number2, pro.email as email, pro.faculty_id as faculty_id, pro.level_id as level_id, pro.program_id as program_id, pro.last_exam as last_exam, pro.last_exam_marks as last_exam_mark, pro.is_online as is_online, faculty.name as faculty_name, level.name as level_name, program.name as program_name FROM tbl_inquiry_student as pro LEFT JOIN tbl_faculty faculty ON pro.faculty_id = faculty.id LEFT JOIN tbl_level level ON pro.level_id = level.id LEFT JOIN tbl_program program ON pro.program_id = program.id WHERE pro.is_delete = ? AND pro.id = ?");
    $cmd->bind_param("ii", $status, $inq_id);
    $cmd->execute();
    $result = $cmd->get_result();
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $inq_student_id = $row['inq_student_id'];
        $first_name1  = $row['first_name'];
        $middle_name1 = $row['middle_name'];
        $last_name1 = $row['last_name'];
        $gender = $row['gender'];
        $dob = $row['dob'];
        $mobile_number1 = $row['mobile_number'];
        $mobile_number2 = $row['mobile_number2'];
        $email1 = $row['email'];
        $faculty_id1 = $row['faculty_id'];
        $level_id1 = $row['level_id'];
        $program_id1 = $row['program_id'];
        $last_exam = $row['last_exam'];
        $last_exam_mark = $row['last_exam_mark'];
        $is_online = $row['is_online'];
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
                                <form id="quickForm" name="std_details" action="" method="POST">
                                    <div class="card-body">

                                        <div class="row">
                                            <input type="hidden" value="<?php echo $id ?>" name="id">
                                            <div class="form-group col-sm-3">
                                                <label for="name">First Name<span style="color: red;">*</span></label>
                                                <input type="text" name="first_name" value="<?php echo $first_name1 ?>" class="form-control" placeholder="Enter First Name" required readonly>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="name">Middle Name<span style="color: red;">*</span></label>
                                                <input type="text" name="middle_name" value="<?php echo $middle_name1 ?>" class="form-control" placeholder="Enter Middle Name" required readonly>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="name">Last Name<span style="color: red;">*</span></label>
                                                <input type="text" name="last_name" value="<?php echo $last_name1 ?>" class="form-control" placeholder="Enter Last Name" required readonly>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="gender">Gender<span style="color: red;">*</span></label>
                                                <select name="gender" id="gender" value="<?php echo $gender ?>" class="form-control" required readonly>
                                                    <option value="">---Select Gender---</option>
                                                    <option value="male" <?php if ($gender == "male") {
                                                                                echo "selected";
                                                                            } ?>>Male</option>
                                                    <option value="female" <?php if ($gender == "female") {
                                                                                echo "selected";
                                                                            } ?>>Female</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="name">Date Of Birth</label>
                                                <input type="date" name="dob" value="<?php echo $dob ?>" class="form-control" placeholder="Enter Date Of Birth" readonly>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="name">Mobile Number<span style="color: red;">*</span></label>
                                                <input type="number" name="mobile_number" value="<?php echo $mobile_number1 ?>" class="form-control" placeholder="Enter Mobile Number" required readonly>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="name">Mobile Number 2</label>
                                                <input type="number" name="second_mobile_number" value="<?php echo $mobile_number2 ?>" class="form-control" placeholder="Enter Mobile Number 2" readonly>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="name">Email<span style="color: red;">*</span></label>
                                                <input type="email" name="email" value="<?php echo $email1 ?>" class="form-control" placeholder="Enter Email" required readonly>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label for="gender">Last Exam<span style="color: red;">*</span></label>
                                                <select name="exam" id="exam" value="<?php echo $last_exam ?>" class="form-control" required readonly>
                                                    <option value="">---Select Exam---</option>
                                                    <option value="1" <?php if ($last_exam == "1") {
                                                                            echo "selected";
                                                                        } ?>>SSC</option>
                                                    <option value="2" <?php if ($last_exam == "2") {
                                                                            echo "selected";
                                                                        } ?>>HSC(A)</option>
                                                    <option value="3" <?php if ($last_exam == "3") {
                                                                            echo "selected";
                                                                        } ?>>HSC(B)</option>
                                                    <option value="4" <?php if ($last_exam == "4") {
                                                                            echo "selected";
                                                                        } ?>>UG</option>
                                                </select>
                                            </div>
                                            <hr class="w-100">
                                            <!-- Choose Intersted Fields  -->
                                            <div class="form-group col-sm-4">
                                                <label>Select Faculty<span style="color: red;">*</span></label>
                                                <select class="form-control" name="faculty_id" id="faculty_id" required readonly>
                                                    <option value="">---Select Faculty---</option>
                                                    <?php
                                                    $cmd = "SELECT * FROM tbl_faculty WHERE is_delete = '0' and is_active='1'";
                                                    $stmt = $con->prepare($cmd);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();
                                                    while ($row = $result->fetch_assoc()) {

                                                    ?>
                                                        <option value="<?php echo $row['id'] ?>" <?php if ($faculty_id1 == $row['id']) {
                                                                                                        echo "selected";
                                                                                                    } ?>>
                                                            <?php echo $row['name'] ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label>Select Level<span style="color: red;">*</span></label>
                                                <select name="level_id" id="level_id" class="form-control" required readonly>
                                                    <option value="">---Select Level---</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label>Select Program<span style="color: red;">*</span></label>
                                                <select name="program_id" id="program_id" class="form-control" required readonly>
                                                    <option value="">---Select Program---</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label><span style="color: red;">*</span>
                                                    <input type="checkbox" name="confirmation" value="1" required>
                                                    I confirm that the above details are correct.
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer text-right">
                                        <button type="submit" name="submit" class="btn btn-primary"><i class="fa-solid fa-square-check"></i> confirm Admission</button>
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
        var faculty_id = <?php echo $faculty_id1; ?>;
        var level_id = <?php echo $level_id1; ?>;
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
        var faculty_id = <?php echo $faculty_id1; ?>;
        var level_id = <?php echo $level_id1; ?>;
        var program_id = <?php echo $program_id1; ?>;
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