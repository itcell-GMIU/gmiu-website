<?php
// Include the checklogin.php file
include '../include/checklogin.php';
include('../smtp/PHPMailerAutoload.php');
// ini_set('display_errors', 0);
// ini_set('display_startup_errors', 0);
// error_reporting(E_ALL);

$_SESSION['show']  = "d-none";

if (isset($_POST['emailsent'])) {

    $_SESSION['otp'] = rand(100000, 999999);
    // echo '<script>alert("the otp is generated : -' . $otp . '")</script>';

    function smtp_mailer($to, $subject, $msg)
    {
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';
            //$mail->SMTPDebug = 2; 
            $mail->Username = "admissions@gmiu.edu.in";
            $mail->Password = "uhna gbjn dtee tsfy";
            $mail->SetFrom("admissions@gmiu.edu.in");
            $mail->Subject = $subject;
            $mail->Body = $msg;
            $mail->AddAddress($to);
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => false
                )
            );
            if (!$mail->Send()) {
                // echo $mail->ErrorInfo;
            } else {
               $_SESSION['show'] = "";
            }
        }
    
        echo smtp_mailer('ckgohel@gmiu.edu.in', 'Sent OTP for the Assigning Faculty to the Inquiry.', 'This is your OTP for the Verifying Inquiry Assigning... OTP : ' .$_SESSION['otp']);
    
}


if (isset($_POST['submit'])) {

    // echo "<script>alert('".$_SESSION['otp']."')</script>";

    $givenOtp = $_POST['sentotp'];

    if ($_SESSION['otp'] == $givenOtp) {

        $userIP = $_SERVER['REMOTE_ADDR'];
        // echo 'User Real IP Address - ' . $userIP . '<br>';

        $startingInquiryId = trim($_POST['starting_inquiry']);
        $endingInquiryId = trim($_POST['ending_id']);
        $staff_id = $_POST['staff_id'];

        $assign_staff_id = $_SESSION['staff_id'];

        // Extract numeric parts from inquiry IDs
        $startingNumeric = intval(substr($startingInquiryId, 3));
        $endingNumeric = intval(substr($endingInquiryId, 3));

        $check = $con->prepare("SELECT * FROM `tbl_inquiry_student` where CAST(SUBSTRING(inq_student_id, 4) AS UNSIGNED) BETWEEN ? AND ?");
        $check->bind_param("ii", $startingNumeric, $endingNumeric);
        $check->execute();
        $Result = $check->get_result(); // Get the result set

        // Initialize $exist_id outside the loop
        $exist_id = null;
        while ($row = $Result->fetch_assoc()) {
            $exist_id = $row['staff_id'];
        }


        // if($assign_staff_id== '73'){
        // $stmt = $con->prepare("UPDATE tbl_inquiry_student SET staff_id = ?, assign_by = ? , ip_address_column= ? WHERE AND LENGTH(inq_student_id) = LENGTH($startingInquiryId) inq_student_id BETWEEN ? AND ?");
        // $stmt->bind_param("sisss", $staff_id, $assign_staff_id, $userIP, $startingInquiryId, $endingInquiryId);
        // $result = $stmt->execute();

        //     if ($result) {
        //         // Sweet Alert of Success Message
        //         $_SESSION['status'] = "Student Inquiry Assign Successfully";
        //         $_SESSION['status_code'] = "success";
        //         echo "<script>setTimeout(function(){window.location='#'},1000);</script>";
        //     } else {
        //         // Sweet Alert of Error Message
        //         $_SESSION['status'] = "Student Inquiry Assign Failed";
        //         $_SESSION['status_code'] = "error";
        //         echo "<script>setTimeout(function(){window.location='#'},1000);</script>";
        //     }

        //else{
        if (is_null($exist_id)) {
            // Perform your query
            $stmt = $con->prepare("UPDATE tbl_inquiry_student SET staff_id = ?, assign_by = ? , ip_address_column= ? WHERE CAST(SUBSTRING(inq_student_id, 4) AS UNSIGNED) BETWEEN ? AND ?");
            $stmt->bind_param("sisii", $staff_id, $assign_staff_id, $userIP, $startingNumeric, $endingNumeric);
            $result = $stmt->execute();

            if ($result) {
                $totalId = $endingNumeric - $startingNumeric + 1;
                $weirdSql = "INSERT INTO tbl_faculty_assign_log (assign_by, staff_id, starting_id, ending_id, total) 
                            VALUES (?, ?, ?, ?, ?)";
                $weirdStmt = $con->prepare($weirdSql);
                $weirdStmt->bind_param("isssi", $assign_staff_id, $staff_id, $startingInquiryId, $endingInquiryId, $totalId);

                // Execute the statement
                if ($weirdStmt->execute()) {
                    // Sweet Alert of Success Message
                    $_SESSION['status'] = "Student Inquiry Assign Successfully";
                    $_SESSION['status_code'] = "success";
                    $_SESSION['otp'] = "jhgsjhgkdsftgkrjhtklarjjshgjdfshgkjhg";
                    $_SESSION['show']  = "d-none";
                    echo "<script>setTimeout(function(){window.location='#'},1000);</script>";
                } else {
                    echo "Error: " . $weirdSql . "<br>" . $con->error;
                }
            } else {
                // Sweet Alert of Error Message
                $_SESSION['status'] = "Student Inquiry Assign Failed";
                $_SESSION['status_code'] = "error";
                $_SESSION['otp'] = "jhgsjhgkdsftgkrjhtklarjjshgjdfshgkjhg";
                $_SESSION['show']  = "d-none";
                echo "<script>setTimeout(function(){window.location='#'},1000);</script>";
            }
        } else {
             // Sweet Alert of Error Message
             $_SESSION['status'] = "Student Inquiry Assign Failed";
             $_SESSION['status_code'] = "error";
             echo "<script>setTimeout(function(){window.location='#'},1000);</script>";
        }
        //}
        // Redirect to the appropriate page
    }else{
        $_SESSION['status'] = "Wrong OTP!!!";
        $_SESSION['status_code'] = "error";
        $_SESSION['otp'] = "jhgsjhgkdsftgkrjhtklarjjshgjdfshgkjhg";
        $_SESSION['show']  = "d-none";
    }

}


// Form to Assign a Single Inquiry
if (isset($_POST['insert'])) {
    // Get form data
    $inquiry_id = $_POST['inquiry_id'];
    $staff_id = $_POST['staff_id'];
    $assign_by = $_SESSION['staff_id']; // Logged-in user performing the action
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Extract numeric part of inquiry ID
    $inquiry_numeric = intval(substr($inquiry_id, 3));

    // Check if the inquiry exists
    $check = $con->prepare("SELECT * FROM `tbl_inquiry_student` WHERE CAST(SUBSTRING(inq_student_id, 4) AS UNSIGNED) = ?");
    $check->bind_param("i", $inquiry_numeric);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (is_null($row['staff_id'])) {

            // Assign the inquiry to the staff
            $stmt = $con->prepare("UPDATE tbl_inquiry_student SET staff_id = ?, assign_by = ?, ip_address_column = ? WHERE CAST(SUBSTRING(inq_student_id, 4) AS UNSIGNED) = ?");
            $stmt->bind_param("issi", $staff_id, $assign_by, $user_ip, $inquiry_numeric);
            $update_result = $stmt->execute();

            if ($update_result) {
                // Log the assignment
                $log_sql = "INSERT INTO tbl_faculty_assign_log (assign_by, staff_id, starting_id, ending_id, total) 
                          VALUES (?, ?, ?, ?, 1)";
                $log_stmt = $con->prepare($log_sql);
                $log_stmt->bind_param("issi", $assign_by, $staff_id, $inquiry_id, $inquiry_id);
                if ($log_stmt->execute()) {
                    $_SESSION['status'] = "Inquiry Assigned Successfully";
                    $_SESSION['status_code'] = "success";
                    echo "<script>setTimeout(function(){window.location='#'},1000);</script>";
                }
            } else {
                // Update failed
                $_SESSION['status'] = "Failed to Assign Inquiry";
                $_SESSION['status_code'] = "error";
                echo "<script>setTimeout(function(){window.location='#'},1000);</script>";
            }
        } else {
            // Inquiry already assigned
            $_SESSION['status'] = "Inquiry is already assigned to another staff.";
            $_SESSION['status_code'] = "warning";
            echo "<script>setTimeout(function(){window.location='#'},1000);</script>";
        }
    } else {
        $_SESSION['status'] = "Inquiry ID does not exist.";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='#'},1000);</script>";
    }
}


if (isset($_POST['reassignsubmit'])) {

    $old_staff_id = $_POST['old_staff_id'];
    $new_staff_id = $_POST['new_staff_id'];
    $assign_staff_id = $_SESSION['staff_id'];

    // First, fetch affected inquiry IDs
    $stmt = $con->prepare("SELECT id FROM tbl_inquiry_student WHERE staff_id = ?");
    $stmt->bind_param("i", $old_staff_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $inquiry_ids = [];
    while ($row = $result->fetch_assoc()) {
        $inquiry_ids[] = $row['id'];
    }

    if (!empty($inquiry_ids)) {
        // Update the inquiries with new staff
        $stmt = $con->prepare("UPDATE tbl_inquiry_student SET staff_id = ?, assign_by = ? WHERE staff_id = ?");
        $stmt->bind_param("iii", $new_staff_id, $assign_staff_id, $old_staff_id);
        $update_result = $stmt->execute();

        if ($update_result) {
            // Log the reassignment
            $inquiry_ids_str = implode(",", $inquiry_ids);
            $total_reassigned = count($inquiry_ids);
            $stmt = $con->prepare("INSERT INTO tbl_inquiry_reassignment_log (old_staff_id, new_staff_id, inquiry_ids, total_reassigned, assign_by) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iisii", $old_staff_id, $new_staff_id, $inquiry_ids_str, $total_reassigned, $assign_staff_id);
            $stmt->execute();

            // Sweet Alert of Success Message
            $_SESSION['status'] = "Student Inquiries Reassigned Successfully";
            $_SESSION['status_code'] = "success";
        }
    } else {
        $_SESSION['status'] = "No inquiries found to reassign";
        $_SESSION['status_code'] = "info";
    }
}




if (isset($_GET['url_level_id']) && $_GET['url_level_id'] != "") {
    $url_level_id = mysqli_real_escape_string($con, $_GET['url_level_id']);
    $url_level_id = validate_data($url_level_id);
    $query = "SELECT name as level_name FROM tbl_level WHERE id= $url_level_id";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $level_name = $row['level_name'];
    } else {
        $level_name = "";
    }
} else {
    $url_level_id = "";
    $level_name = "";
}
if (isset($_GET['url_program_id']) && $_GET['url_program_id'] != "") {
    $url_program_id = mysqli_real_escape_string($con, $_GET['url_program_id']);
    $url_program_id = validate_data($url_program_id);
    $query = "SELECT name as program_name FROM tbl_program WHERE id= $url_program_id";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $program_name = $row['program_name'];
    } else {
        $program_name = "";
    }
} else {
    $url_program_id = "";
    $program_name = "";
}
if (isset($_GET['url_for'])) {
    $url_for = mysqli_real_escape_string($con, $_GET['url_for']);
    $url_for = validate_data($url_for);
} else {
    $url_for = "";
}
if (isset($_GET['url_faculty_id']) && $_GET['url_faculty_id'] != "") {

    $url_faculty_id = mysqli_real_escape_string($con, $_GET['url_faculty_id']);
    $url_faculty_id = validate_data($url_faculty_id);
    // if (isset($_GET['url_faculty_id'])) {
    $url_faculty_id = $_GET['url_faculty_id'];
    $query = "SELECT name as faculty_name FROM tbl_faculty WHERE id= $url_faculty_id";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $faculty_name = $row['faculty_name'];
    } else {
        $faculty_name = "";
    }
} else {
    $faculty_name = "";
    $url_faculty_id = "";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- header -->
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">-->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                top: 6px !important;
                right: 5px !important;
            }
            .select2-container .select2-selection--single {
               height: 37px !important;
            }
            .select2-container--default .select2-selection--single {
                 border: 1px solid #ced4da !important;
            }
    </style>
</head>

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
            <?php
            if ($url_for == "inq" && $role_id != 13 && $role_id != 11) { ?>
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Assign Inquiry Student</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Assign Inquiry Student</li>
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
                                        <h3 class="card-title">Assign Inquiry Student</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    
                                    <div class="card-body pb-0">
                                        <form id="quickForm" method="POST">
                                            <div class="form-group mb-0">
                                                <button type="submit" name="emailsent" class="btn btn-primary">
                                                    <i class="fas fa-save"></i> Send OTP</button>
                                            </div>
                                            <p class="text-danger <?php echo $_SESSION['show']; ?>">OTP Sent Successfully !!!</p>
                                         </form>
                                        <form id="quickForm" method="POST">

                                            <div class="row">
                                                <div class="form-group col-sm-3">
                                                    <label for="name">starting Inquiry Id<span style="color: red;">*</span></label>
                                                    <input type="text" name="starting_inquiry" class="form-control" id="starting_inquiry" placeholder="Enter starting Inquiry Id" required>
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label for="name">Ending Inquiry Id<span style="color: red;">*</span></label>
                                                    <input type="text" name="ending_id" class="form-control" id="title_id" placeholder="Enter Ending Inquiry Id" required>
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label>Select Faculty</label>
                                                    <select class="form-control" name="staff_id" id="staff_id">
                                                        <option value="">---Select Staff Name---</option>
                                                        <?php
                                                        $cmd = "SELECT * FROM tbl_staff WHERE is_delete = '0' and is_active='1' and role_id IN(15,16,20)";
                                                        $stmt = $con->prepare($cmd);
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();
                                                        while ($row = $result->fetch_assoc()) {
                                                            $staff_id = $row['id'];
                                                        ?>
                                                            <option value="<?php echo $row['id'] ?>" <?php if ($staff_id == $row['id']) {
                                                                                                            echo "selected";
                                                                                                        } ?>>
                                                                <?php echo $row['name'] ?></option>
                                                        <?php } ?>

                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-3">
                                                    <label for="name">OTP :<span style="color: red;">*</span></label>
                                                    <input type="text" name="sentotp" class="form-control" id="otp" placeholder="Enter OTP Which Sent to you." required>
                                                </div>
                                                <!-- <div class="form-group">
                                                    <button type="submit" name="submit" class="btn btn-primary m-4"><i class="fas fa-save"></i> Submit</button>
                                                </div> -->
                                                <div class="form-group">
                                                <button type="button" class="btn btn-primary" onclick="showValue()" data-toggle="modal" data-target="#asign">
                                                    <i class="fas fa-save"></i> Submit</button>
                                                </div>
                                                </div>
                                                <div class="modal fade" id="asign" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Do you want to Assign Faculty : <span id="fac" class="text-dark font-weight-bold"></span> to the Student Who's Inquiry Id starting from <span id="sid" class="text-dark font-weight-bold"></span> to <span id="eid" class="text-dark font-weight-bold"></span></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                            </form>
                                        </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                    
                    
         <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-gmiu">
                        <div class="card-header">
                            <h3 class="card-title">Assign To One Faculty</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" id="assignForm">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Inquiry ID Input -->
                                    <div class="form-group col-sm-4">
                                        <label for="inquiry_id">Inquiry ID:</label>
                                        <input class="form-control" type="text" placeholder="Enter Inquiry ID" name="inquiry_id" id="inquiry_id" required>
                                    </div>

                                    <!-- Select Faculty Dropdown -->
                                    <div class="form-group col-sm-4">
                                        <label>Select Faculty</label>
                                        <select class="form-control" name="staff_id" id="staff_id" required>
                                            <option value="">---Select Staff Name---</option>
                                            <?php
                                            $cmd = "SELECT * FROM tbl_staff WHERE is_delete = '0' AND is_active='1' AND role_id IN(15,16)";
                                            $stmt = $con->prepare($cmd);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" name="insert" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Assign Inquiry
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->

        <!-- Modal -->

                    
                    
                    <?php
                    $assign_staff_id = $_SESSION['staff_id'];

                    if ($assign_staff_id == '73') { ?>


                        <div class="container-fluid">
                            <div class="row">
                                <!-- left column -->
                                <div class="col-md-12">
                                    <!-- jquery validation -->
                                    <div class="card card-gmiu">
                                        <div class="card-header">
                                            <h3 class="card-title">Reassignment of Faculty Inquiries </h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <!-- form start -->
                                        <form id="quickForm" method="POST">
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="form-group col-sm-4">
                                                        <label>Select Faculty</label>
                                                        <select class="form-control" name="old_staff_id" id="old_staff_id">
                                                            <option value="">---Select Staff Name---</option>
                                                            <?php
                                                            $cmd = "SELECT * FROM tbl_staff WHERE is_delete = '0' and is_active='1' and role_id IN(15,16,20)"; 
                                                            $stmt = $con->prepare($cmd);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();
                                                            while ($row = $result->fetch_assoc()) {
                                                                $staff_id = $row['id'];
                                                            ?>
                                                                <option value="<?php echo $row['id'] ?>" <?php if ($staff_id == $row['id']) {
                                                                                                                echo "selected";
                                                                                                            } ?>>
                                                                    <?php echo $row['name'] ?></option>
                                                            <?php } ?>

                                                        </select>
                                                    </div>

                                                    <div class="form-group col-sm-4">
                                                        <label>Select Faculty</label>
                                                        <select class="form-control" name="new_staff_id" id="new_staff_id">
                                                            <option value="">---Select Reassign Staff Name---</option>
                                                            <?php
                                                            $cmd = "SELECT * FROM tbl_staff WHERE is_delete = '0' and is_active='1' and role_id IN(15,16,20)";
                                                            $stmt = $con->prepare($cmd);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();
                                                            while ($row = $result->fetch_assoc()) {
                                                                $staff_id = $row['id'];
                                                            ?>
                                                                <option value="<?php echo $row['id'] ?>" <?php if ($staff_id == $row['id']) {
                                                                                                                echo "selected";
                                                                                                            } ?>>
                                                                    <?php echo $row['name'] ?></option>
                                                            <?php } ?>

                                                        </select>
                                                    </div>

                                                    <!-- <div class="form-group">
                                                        <button type="submit" name="reassignsubmit" class="btn btn-primary m-4"><i class="fas fa-save"></i> Submit</button>
                                                    </div> -->

                                                    <div class="form-group">
                                                <button type="button" class="btn btn-primary m-4" onclick="showValue2()" data-toggle="modal" data-target="#reassign"><i class="fas fa-save"></i> Submit</button>
                                                </div>
                                                <div class="modal fade" id="reassign" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Do you want to Reassign Faculty : <span id="fac1" class="text-dark font-weight-bold"></span> to the  <span id="fac2" class="text-dark font-weight-bold"></span>
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="submit" name="reassignsubmit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!--/.col (right) -->
                            </div>
                            <!-- /.row -->
                        </div><!-- /.container-fluid -->
                            <?php } ?>

                <?php }
                ?>
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">

                            <div class="col-sm-6">
                                <?php if ($url_for == "inq") { ?>
                                    <h1 class="m-0">View Student Inquiry List</h1>
                                <?php } elseif ($url_for == "admission_confirm") { ?>
                                    <h1 class="m-0">View Student Admission confirm List</h1>
                                <?php } else { ?>
                                    <h1 class="m-0">View Student Inquiry List</h1>
                                <?php  } ?>
                            </div><!-- /.col -->

                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../common/dashboard.php">Home</a></li>
                                    <?php if ($url_for == "inq") { ?>
                                        <li class="breadcrumb-item active">View Student Inquiry</li>
                                    <?php } elseif ($url_for == "admission_confirm") { ?>
                                        <li class="breadcrumb-item active">View Student Admission confirm List</li>
                                    <?php } else {
                                    ?>
                                        <li class="breadcrumb-item active">View Student Inquiry</li>
                                    <?php   } ?>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>

                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <!-- jquery validation -->
                                <div class="card mb-3">
                                    <div class="card-header">

                                        <i class="far fa-hand-pointer"></i>

                                        <span> <b>Select Faculty to View Students</b></span>

                                    </div>
                                    <form method="GET" action="">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col-md-3">
                                                        <div class="form-label-group">

                                                            <input type="hidden" name="url_for" value="<?php echo $url_for; ?>">
                                                            <select id="faculty_id" name="url_faculty_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px">
                                                                <option value="">---Select Faculty---</option>

                                                                <?php
                                                                $query = "SELECT * FROM tbl_faculty WHERE is_active = 1 and is_delete=0";
                                                                $result = $con->query($query);
                                                                if ($result->num_rows > 0) {
                                                                    while ($row = $result->fetch_assoc()) {
                                                                        $selected = ($url_faculty_id == $row['id']) ? "selected" : "";
                                                                        //echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
                                                                ?>
                                                                        <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
                                                                            <?php echo $row['name']; ?>
                                                                        </option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-label-group">
                                                            <select name="url_level_id" id="level_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px">
                                                                <option value="">---Select Level---</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-label-group">
                                                            <select name="url_program_id" id="program_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px">
                                                                <option value="">---Select Program---</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="submit" class="btn btn-primary btn-block" id="export" style="float:center" />

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->



                    <!-- Content Header (Page header) -->

                    <!-- /.content-header -->

                    <!-- Main content -->
                    <section class="content">
                        <div class="container-fluid">

                            <!--   Program list code  -->

                            <div class="card">
                                <div class="card-header">
                                    <span>
                                        <center>
                                            <h5><b><i class="fas fa-book-reader"></i>View Student Inquiry</b></h5>
                                        </center>
                                    </span>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- + ADD Button  -->
                                    <a class="btn btn-primary" style="margin-left: 90%;" href="student_insert.php"><i class="fa-solid fa-plus"></i> Add</a>
                                    <!-- + ADD Button End -->
                                    <div class="table-responsive">
                                    <table id="example" class="display ">
                                            <thead>
                                                <tr align="center">
                                                    <th scope="row" style="color:black;"><b>Sr.no</b></th>
                                                    <th scope="row" style="color:black;"><b>inquiry Id</b></th>
                                                    <th scope="row" style="color:black;"><b>First Name</b></th>
                                                    <th scope="row" style="color:black;"><b>middle Name</b></th>
                                                    <th scope="row" style="color:black;"><b>Last Name</b></th>
                                                    <th scope="row" style="color:black;"><b>Gender</b></th>
                                                    <th scope="row" style="color:black;"><b>last school name</b></th>
                                                    <!-- <th scope="row" style="color:black;"><b>Date Of Birth</b></th> -->
                                                    <th scope="row" style="color:black;"><b>Mobile Number 1</b></th>
                                                    <th scope="row" style="color:black;"><b>Mobile Number 2</b></th>
                                                    <th scope="row" style="color:black;"><b>Email</b></th>
                                                    <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                                    <th scope="row" style="color:black;"><b>Level Name</b></th>
                                                    <th scope="row" style="color:black;"><b>Program Name</b></th>
                                                    <th scope="row" style="color:black;"><b>Last Exam</b></th>
                                                    <th scope="row" style="color:black;"><b>Last Exam Status</b></th>
                                                    <th scope="row" style="color:black;"><b>Status</b></th>
                                                    <th scope="row" style="color:black;"><b>Inquiry Mode</b></th>
                                                    <th scope="row" style="color:black;"><b>Assign Staff</b></th>
                                                    <th scope="row" style="color:black;"><b>Counselor</b></th>
                                                     <th scope="row" style="color:black;"><b>Call Count</b></th>
                                                    <!--<th scope="row" style="color:black;"><b>Last Remark</b></th>-->
                                                    <th scope="row" style="color:black;"><b>Remarks</b></th>
                                                    <th scope="row" style="color:black;"><b>Action</b></th>
                                                </tr>
                                            </thead>

                                            
                                            <tfoot>
                                                <tr align="center">
                                                    <th scope="row" style="color:black;"><b>Id</b></th>

                                                    <th scope="row" style="color:black;"><b>inquiry Id</b></th>
                                                    <th scope="row" style="color:black;"><b>First Name</b></th>
                                                    <th scope="row" style="color:black;"><b>middle Name</b></th>
                                                    <th scope="row" style="color:black;"><b>Last Name</b></th>
                                                    <th scope="row" style="color:black;"><b>Gender</b></th>
                                                    <th scope="row" style="color:black;"><b>last school name</b></th>
                                                    <!-- <th scope="row" style="color:black;"><b>Date Of Birth</b></th> -->
                                                    <th scope="row" style="color:black;"><b>Mobile Number 1</b></th>
                                                    <th scope="row" style="color:black;"><b>Mobile Number 2</b></th>
                                                    <th scope="row" style="color:black;"><b>Email</b></th>
                                                    <th scope="row" style="color:black;"><b>Faculty Name</b></th>
                                                    <th scope="row" style="color:black;"><b>Level Name</b></th>
                                                    <th scope="row" style="color:black;"><b>Program Name</b></th>
                                                    <th scope="row" style="color:black;"><b>Last Exam</b></th>
                                                    <th scope="row" style="color:black;"><b>Last Exam Status</b></th>
                                                    <th scope="row" style="color:black;"><b>Status</b></th>
                                                    <th scope="row" style="color:black;"><b>Inquiry Mode</b></th>
                                                    <th scope="row" style="color:black;"><b>Assign Staff</b></th>
                                                    <th scope="row" style="color:black;"><b>Counselor</b></th>
                                                    <th scope="row" style="color:black;"><b>Call Count</b></th>
                                                      <!--<th scope="row" style="color:black;"><b>Last Remark</b></th>-->
                                                    <th scope="row" style="color:black;"><b>Remarks</b></th>
                                                    <th scope="row" style="color:black;"><b>Action</b></th>
                                                </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- /.card-body -->
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
    <!-- footer -->
    <?php include '../include/importjs.php'; ?>
</body>
<script>
    $(document).ready(function() {
        $('#staff_id').select2({
            placeholder: "---Select Staff Name---",
            allowClear: true
        });
          $('#old_staff_id').select2({
            placeholder: "---Select Staff Name---",
            allowClear: true
        });
         $('#new_staff_id').select2({
            placeholder: "---Select Staff Name---",
            allowClear: true
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.view-remarks').on('click', function() {
            // Get the inquiry ID from the data attribute
            var inquiryId = $(this).data('inquiry-id');

            // Make an AJAX request to fetch the remarks for the selected inquiry ID
            $.ajax({
                url: 'fetch_remarks.php', // Create a PHP script to fetch remarks
                method: 'POST',
                data: {
                    inquiryId: inquiryId
                },
                success: function(response) {
                    // Update the modal content with the fetched remarks
                    $('#modal-lg .modal-body').html(response);
                },
                error: function() {
                    alert('An error occurred while fetching remarks.');
                }
            });
        });
    });
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
        //call for listing the dropdown and select by default
        load_level();
        load_program();
    });

    function load_level() {
        var path = '<?php echo $base_url_api; ?>';
        var faculty_id = <?php echo $url_faculty_id; ?>;
        var level_id = <?php echo $url_level_id; ?>;
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
        var faculty_id = <?php echo $url_faculty_id; ?>;
        var level_id = <?php echo $url_level_id; ?>;
        var program_id = <?php echo $url_program_id; ?>;
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
<script>
    jQuery(document).ready(function () {

        var url_for = '<?php echo $url_for; ?>';
    var url_faculty_id = '<?php echo $url_faculty_id; ?>';
    var url_level_id = '<?php echo $url_level_id; ?>';
    var url_program_id = '<?php echo $url_program_id; ?>';

    var table = jQuery('#example').dataTable({
        "bProcessing": true,
        "sAjaxSource": "pagination_data.php?url_for=" + url_for + "&url_faculty_id=" + url_faculty_id + "&url_level_id=" + url_level_id + "&url_program_id=" + url_program_id,
        "sPaginationType": "full_numbers",
        "iDisplayLength": 100,
        "bLengthChange": false,
        "bFilter": true,
            "aoColumns": [
                { mData: 'Sr' },
                { mData: 'inquiry Id' },
                { mData: 'First Name' },
                { mData: 'middle Name' },
                { mData: 'Last Name' },
                { mData: 'Gender' },
                { mData: 'last_school_name' },
                { mData: 'Mobile Number 1' },
                { mData: 'Mobile Number 2' },
                { mData: 'Email' },
                { mData: 'Faculty Name' },
                { mData: 'Level Name' },
                { mData: 'Program Name' },
                { mData: 'Last Exam' },
                { mData: 'Last Exam Status' },
                { mData: 'Status' },
                { mData: 'Inquiry Mode' },
                { mData: 'Assign Staff' },
                { mData: 'Counselor' },
                 { mData: 'call_count' },
                // { mData: 'last Remarks'},
                { mData: 'Remarks'},
                { mData: 'Action'}
            ]<?php if ($role_id == 11 || $role_id == 12){ ?>

            ,dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Excel',
                exportOptions: {
                    columns: ':visible'
                }
            }]
            <?php } ?>
        });
    });
</script>

<script>
    function showValue(){
        const startingIncId = document.querySelector('input[name="starting_inquiry"]').value;
        const endingIncId = document.querySelector('input[name="ending_id"]').value;
        const selectElement = document.querySelector('select[name="staff_id"]');
        const selectedFacultyText = selectElement.selectedOptions[0].innerText;

        const fac = document.getElementById('fac');
        const sid = document.getElementById('sid');
        const eid = document.getElementById('eid');

        fac.innerText = selectedFacultyText;
        sid.innerText = startingIncId;
        eid.innerText = endingIncId
    }

    function showValue2(){
        const selectElement1 = document.querySelector('select[name="old_staff_id"]');
        const selectedFacultyText1 = selectElement1.selectedOptions[0].innerText;

        const selectElement2 = document.querySelector('select[name="new_staff_id"]');
        const selectedFacultyText2 = selectElement2.selectedOptions[0].innerText;

        const fac1 = document.getElementById('fac1');
        const fac2 = document.getElementById('fac2');

        fac1.innerText = selectedFacultyText1;
        fac2.innerText = selectedFacultyText2;
    }
</script>


</html>