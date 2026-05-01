<?php
include './include/checklogin.php';
?>

<?php
$query = "SELECT COUNT(*) AS total FROM tbl_pac_form";
$data = $con->query($query);
if ($data) {
    $count = $data->fetch_assoc();
    $currentFormNo = $count['total'] + 1;
}
?>

<?php
$id = $_GET['stu_id'];
$stmt = $con->prepare("SELECT 
     CONCAT(COALESCE(first_name, ''), ' ', COALESCE(middle_name, ''), ' ', COALESCE(last_name, '')) AS full_name ,
    email,
    mobile_number,
    dob,
    faculty_id,
    level_id,
    program_id,
    token_amount,
    payment_date_time
FROM tbl_admission_student
WHERE id = ?");

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fullName = $row['full_name'];
        $email = $row['email'];
        $mobileNumber = $row['mobile_number'];
        $dob = $row['dob'];
        $facultyID = $row['faculty_id'];
        $levelID = $row['level_id'];
        $programID = $row['program_id'];
        $tokenAmount = $row['token_amount'];
        $paymentDateTime = $row['payment_date_time'];
    }
} else {
    echo "No records found.";
}
?>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from POST with isset() to avoid notices
    $stu_id = isset($_POST['stu_id']) ? $_POST['stu_id'] : '';
    $formno = trim($_POST['formno']) ? $_POST['formno'] : '';
    $studentName = strtoupper(trim(isset($_POST['studentName']) ? $_POST['studentName'] : ''));
    $studentMobile = trim(isset($_POST['studentMobile']) ? $_POST['studentMobile'] : '');
    $studentEmail = trim(isset($_POST['studentEmail']) ? $_POST['studentEmail'] : '');
    $whatsappNumber = trim(isset($_POST['whatsappNumber']) ? $_POST['whatsappNumber'] : '');
    $parentMobile = trim(isset($_POST['parentMobile']) ? $_POST['parentMobile'] : '');
    $birthDate = trim(isset($_POST['birthDate']) ? $_POST['birthDate'] : '');
    $mode = trim(isset($_POST['mode']) ? $_POST['mode'] : '');
    $tshirt = trim(isset($_POST['tshirt']) ? $_POST['tshirt'] : ''); // NEW
    $mode_of_payment = trim(isset($_POST['mode_of_payment']) ? $_POST['mode_of_payment'] : ''); // NEW
    $one_time_scholarship = trim(isset($_POST['one_time_scholarship']) ? $_POST['one_time_scholarship'] : ''); // NEW
    $faculty_id = trim(isset($_POST['faculty_id']) ? $_POST['faculty_id'] : '');
    $level_id = trim(isset($_POST['level_id']) ? $_POST['level_id'] : '');
    $program_id = trim(isset($_POST['program_id']) ? $_POST['program_id'] : '');
    $admissionType = isset($_POST['admissionType']) ? trim(is_array($_POST['admissionType']) ? implode(",", $_POST['admissionType']) : $_POST['admissionType']) : '';
    $branchSpecialization = trim(isset($_POST['branchSpecialization']) ? $_POST['branchSpecialization'] : '');
    $quota = trim(isset($_POST['quota']) ? $_POST['quota'] : '');
    $category = trim(isset($_POST['category']) ? $_POST['category'] : '');
    $dateProvisional = trim(isset($_POST['dateProvisional']) ? $_POST['dateProvisional'] : '');
    $dateAdmission = trim(isset($_POST['dateAdmission']) ? $_POST['dateAdmission'] : '');
    $cbpaStatus = trim(isset($_POST['cbpaStatus']) ? $_POST['cbpaStatus'] : '');
    $tokenFeesAmount = trim(isset($_POST['tokenFeesAmount']) ? $_POST['tokenFeesAmount'] : '');
    $tokenFeesPaidDate = trim(isset($_POST['tokenFeesPaidDate']) ? $_POST['tokenFeesPaidDate'] : '');
    $remainingFees = trim(isset($_POST['remainingFees']) ? $_POST['remainingFees'] : '');
    $remainingPayDate = trim(isset($_POST['remainingPayDate']) ? $_POST['remainingPayDate'] : '');
    $photoStatus = trim(isset($_POST['photoStatus']) ? $_POST['photoStatus'] : '');
    $remarks = trim(isset($_POST['remarks']) ? $_POST['remarks'] : '');
    $level2 = isset($_POST['level1']) ? trim(implode(",", $_POST['level1'])) : '';
    $minor = trim(isset($_POST['minor']) ? $_POST['minor'] : '');
    $honour = trim(isset($_POST['honour']) ? $_POST['honour'] : '');

    $is_edited = [
        "mode" => $mode,
        "faculty_id" => $faculty_id,
        "level2" => $level2,
        "admissionType" => $admissionType,
        "branchSpecialization" => $branchSpecialization
    ];
    $is_edited_json = json_encode($is_edited);

    // Array of required fields
    $requiredFields = [
        'stu_id',
        'studentName',
        'studentMobile',
        'studentEmail',
        'whatsappNumber',
        'mode',
        'faculty_id',
        'level_id',
        'program_id',
        'admissionType',
        'dateProvisional',
        'dateAdmission',
        'cbpaStatus',
        'tokenFeesAmount',
        'tokenFeesPaidDate',
        'remainingFees',
        'remainingPayDate',
        'formno',
        'remarks'
    ];


    // Check if any required field is empty
    foreach ($requiredFields as $field) {
        if (empty($$field)) {
            $_SESSION['status'] = ucfirst($field) . " cannot be empty!";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.history.back()},1000)</script>";
            exit; // Stop further execution
        }
    }
    // Check if formno is unique
    $checkSql = "SELECT formno FROM tbl_pac_form WHERE formno = ?";
    if ($stmt = $con->prepare($checkSql)) {
        $stmt->bind_param("s", $formno);
        $stmt->execute();
        $stmt->store_result();

        // If formno exists, show an error and stop execution
        if ($stmt->num_rows > 0) {
            $_SESSION['status'] = "Form number already exists!";
            $_SESSION['status_code'] = "error";
            echo "<script>setTimeout(function(){window.history.back()},1000)</script>";
            $stmt->close();
            exit; // Stop further execution
        }
        $stmt->close();
    }

    // SQL query to insert data
    $sql = "INSERT INTO tbl_pac_form (
               student_id, studentName, studentMobile, studentEmail, whatsappNumber, 
               parentMobile, mode, faculty_id, level_id, program_id, 
               admissionType, branchSpecialization, quota, category, dateProvisional, 
               dateAdmission, cbpaStatus, tokenFeesAmount, tokenFeesPaidDate,remainingFees,
               remainingPayDate, photoStatus, one_time_scholarship, mode_of_payment, tshirt_size,
               formno, remarks, level2, minor, honour, is_edited
           ) VALUES (
               ?, ?, ?, ?, ?, 
               ?, ?, ?, ?, ?, 
               ?, ?, ?, ?, ?, 
               ?, ?, ?, ?, ?,
               ?, ?, ?, ?, ?,
               ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = $con->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param(
            "sssssssssssssssssssssssssssssss",
            $stu_id,
            $studentName,
            $studentMobile,
            $studentEmail,
            $whatsappNumber,
            $parentMobile,
            $mode,
            $faculty_id,
            $level_id,
            $program_id,
            $admissionType,
            $branchSpecialization,
            $quota,
            $category,
            $dateProvisional,
            $dateAdmission,
            $cbpaStatus,
            $tokenFeesAmount,
            $tokenFeesPaidDate,
            $remainingFees,
            $remainingPayDate,
            $photoStatus,
            $one_time_scholarship,
            $mode_of_payment,
            $tshirt,
            $formno,
            $remarks,
            $level2,
            $minor,
            $honour,
            $is_edited_json
        );

        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['status'] = "PAC Form Submitted Successfully !!!";
            $_SESSION['status_code'] = "success";
            echo "<script>setTimeout(function(){window.location='view_pac.php'},1000)</script>";
        } else {
            $_SESSION['status'] = "PAC form is Not Submitted Successfully !!!";
            $_SESSION['status_code'] = "error";
        }

        // Close the statement
        $stmt->close();
    } else {
        $_SESSION['status'] = "Something Went Wrong !!!";
        $_SESSION['status_code'] = "error";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>

        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Fill PAC Form</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">PAC Form</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-gmiu">
                                <div class="card-header">
                                    <h3 class="card-title">PAC Form</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog"
                                    aria-labelledby="confirmModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to fill this form?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">No</button>
                                                <button type="button" class="btn btn-primary"
                                                    id="confirmYes">Yes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form id="quickForm" method="POST" action="#" class="needs-validation" novalidate>
                                    <div class="card-body">
                                        <input type="text" hidden value="<?php echo $id; ?>" name="stu_id">
                                        <!-- Student Details Section -->
                                        <div class="row">
                                            <p class="heading-p">Student Details</p>
                                            <hr>
                                        </div>
                                        <div class="row">
                                            <!-- Student Email -->
                                            <div class="form-group col-md-2">
                                                <label for="formno">PAC Form No.</label><span
                                                    class="form_error_message">*</span>
                                                <input type="text" class="form-control" id="formno" name="formno" value="2025 / <?php echo str_pad(htmlspecialchars($currentFormNo), 4, '0', STR_PAD_LEFT); ?>" required disabled>
                                                <input type="text" class="form-control" id="formno" name="formno" value="<?php echo $currentFormNo; ?>" required hidden>
                                            </div>

                                        </div>
                                        <!-- Student Name, Mobile, and Email -->
                                        <div class="row">
                                            <!-- Student Name -->
                                            <div class="form-group col-md-6">
                                                <label for="studentName">Student Name</label><span style="color: red;">*</span>
                                                <input type="text" class="form-control" id="studentName" value='<?php echo $fullName; ?>'
                                                    name="studentName" required>
                                            </div>
                                            <!-- Student Mobile Number -->
                                            <div class="form-group col-md-6">
                                                <label for="studentMobile">Mobile Number (Student)</label><span style="color: red;">*</span>
                                                <input type="text" class="form-control" id="studentMobile" value='<?php echo $mobileNumber; ?>'
                                                    name="studentMobile" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- Student Email -->
                                            <div class="form-group col-md-6">
                                                <label for="studentEmail">Student Email ID</label><span style="color: red;">*</span>
                                                <input type="email" class="form-control" id="studentEmail" value='<?php echo $email; ?>'
                                                    name="studentEmail" required>
                                            </div>
                                            <!-- WhatsApp Number -->
                                            <div class="form-group col-md-6">
                                                <label for="whatsappNumber">WhatsApp Number</label><span style="color: red;">*</span>
                                                <input type="text" class="form-control" id="whatsappNumber"
                                                    name="whatsappNumber">
                                            </div>
                                        </div>

                                        <!-- Parent Mobile and Birth Date -->
                                        <div class="row">
                                            <!-- Parent Mobile Number -->
                                            <div class="form-group col-md-6">
                                                <label for="parentMobile">Mobile Number (Parents)</label><span
                                                    class="form_error_message">*</span>
                                                <input type="text" class="form-control" id="parentMobile"
                                                    name="parentMobile" required>
                                            </div>
                                            <!-- Remarks -->
                                            <div class="form-group col-md-6">
                                                <label for="remarks">Remarks</label><span style="color: red;">*</span>
                                                <input type="text" class="form-control" id="remarks" name="remarks"
                                                    required>
                                            </div>
                                        </div>

                                        <!-- Mode and Medium -->
                                        <div class="row">
                                            <!-- Mode -->
                                            <div class="form-group col-md-6">
                                                <label>Mode</label><span style="color: red;">*</span><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="mode" id="modeR"
                                                        value="R" required>
                                                    <label class="form-check-label" for="modeR">R</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="mode" id="modeD"
                                                        value="SM">
                                                    <label class="form-check-label" for="modeD">SM</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="mode" id="modecbpa"
                                                        value="CBPA">
                                                    <label class="form-check-label" for="modecbpa">CBPA</label>
                                                </div>
                                            </div>


                                            <!--T-shirt -->
                                            <div class="form-group col-md-6">
                                                <label for="studentName">T-shirt</label><span
                                                    class="form_error_message">*</span>
                                                <input type="text" class="form-control" id="tshirt" name="tshirt"
                                                    required>
                                            </div>
                                        </div>
                                        <!-- Faculty, Level, and Program -->
                                        <div class="row">
                                            <!-- Select Faculty -->
                                            <div class="form-group col-md-4">
                                                <label class="control-label">Select Faculty <span style="color: red;">*</span></label>
                                                <select class="form-control" name="faculty_id" required id="faculty_id">
                                                    <option value="">---Select Faculty---</option>
                                                    <?php
                                                    $query_faculty = "SELECT * FROM tbl_faculty WHERE is_delete = '0' AND is_active = '1'";
                                                    $stmt_faculty = $con->prepare($query_faculty);
                                                    $stmt_faculty->execute();
                                                    $result_faculty = $stmt_faculty->get_result();
                                                    while ($row_faculty = $result_faculty->fetch_assoc()) {
                                                        ?>
                                                        <option value="<?php echo $row_faculty['id']; ?>" <?php if ($row_faculty['id'] == $facultyID) echo "selected"; ?>>
                                                            <?php echo $row_faculty['name']; ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    $stmt_faculty->close();
                                                    ?>
                                                </select>
                                            </div>

                                            <!-- Select Level -->
                                            <div class="form-group col-md-4">
                                                <label class="control-label">Select Level <span style="color: red;">*</span></label>
                                                <select name="level_id" id="level_id" class="form-control" required>
                                                    <option value="">---Select Level---</option>
                                                </select>
                                            </div>

                                            <!-- Select Program -->
                                            <div class="form-group col-md-4">
                                                <label class="control-label">Select Program <span style="color: red;">*</span></label>
                                                <select name="program_id" id="program_id" class="form-control" required>
                                                    <option value="">---Select Program/Branch---</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Admission Type and Branch/Specialization -->
                                        <div class="row">
                                            <!-- Admission Type -->
                                            <div class="form-group col-md-6">
                                                <label>Admission Type</label><span style="color: red;">*</span><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="admissionType[]" id="type1stYear" value="1st Year" required>
                                                    <label class="form-check-label" for="type1stYear">1st Year</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="admissionType[]" id="type2ndYear" value="2nd Year">
                                                    <label class="form-check-label" for="type2ndYear">2nd Year</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="admissionType[]" id="typeGB" value="GB">
                                                    <label class="form-check-label" for="typeGB">GB</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="admissionType[]" id="typevoc" value="VOC">
                                                    <label class="form-check-label" for="typevoc">VOC</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="admissionType[]" id="Minor" value="Minor">
                                                    <label class="form-check-label" for="Minor">Minor</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="admissionType[]" id="Honour" value="Honour">
                                                    <label class="form-check-label" for="Honour">Honour</label>
                                                </div>
                                            </div>

                                            <!-- Select Level -->
                                            <div class="form-group col-md-6">
                                                <label>Level</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="level1[]"
                                                        id="Diploma" value="Diploma" required>
                                                    <label class="form-check-label" for="Diploma">Diploma</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="level1[]"
                                                        id="UG" value="UG">
                                                    <label class="form-check-label" for="UG">UG</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="level1[]"
                                                        id="PG" value="PG">
                                                    <label class="form-check-label" for="PG">PG</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="level1[]"
                                                        id="PHD" value="PHD">
                                                    <label class="form-check-label" for="PHD">PHD</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="level1[]"
                                                        id="VOC" value="VOC">
                                                    <label class="form-check-label" for="VOC">VOC</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- For the Minor And honour   -->
                                        <div class="row">
                                            <div class="form-group col-md-6 d-none" id="minor-select">
                                                <label class="control-label">Select Minor <span style="color: red;">*</span></label>
                                                <select name="minor" id="minor" class="form-control" required>
                                                    <option value="">---Select Minor---</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6 d-none" id="honour-select">
                                                <label class="control-label">Select Honour <span style="color: red;">*</span></label>
                                                <select name="honour" id="honour" class="form-control" required>
                                                    <option value="">---Select Honour---</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Quota and Category -->
                                        <div class="row">
                                            <!-- Quota -->
                                            <div class="form-group col-md-6">
                                                <label>Quota (UQ/MQ/VQ/SQ)</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="quota"
                                                        id="quotaUQ" value="UQ">
                                                    <label class="form-check-label" for="quotaUQ">UQ</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="quota"
                                                        id="quotaMQ" value="MQ">
                                                    <label class="form-check-label" for="quotaMQ">MQ</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="quota"
                                                        id="quotaVQ" value="VQ">
                                                    <label class="form-check-label" for="quotaVQ">VQ</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="quota"
                                                        id="quotaSQ" value="SQ">
                                                    <label class="form-check-label" for="quotaSQ">SQ</label>
                                                </div>
                                            </div>
                                            <!-- Category -->
                                            <div class="form-group col-md-6">
                                                <label>Category</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        id="categoryOpen" value="Open">
                                                    <label class="form-check-label" for="categoryOpen">Open</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        id="categoryEWS" value="EWS">
                                                    <label class="form-check-label" for="categoryEWS">EWS</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        id="categorySEBC" value="SEBC">
                                                    <label class="form-check-label" for="categorySEBC">SEBC</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="category"
                                                        id="categorySCST" value="SC/ST">
                                                    <label class="form-check-label" for="categorySCST">SC/ST</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Admission Dates and Status -->
                                        <div class="row">
                                            <!-- Date of Provisional Admission -->
                                            <div class="form-group col-md-6">
                                                <label for="dateProvisional">Date of Provisional Admitted</label>
                                                <span style="color: red;">*</span>
                                                <input type="date" class="form-control" id="dateProvisional"
                                                    name="dateProvisional">
                                            </div>
                                            <!-- Date of Admission -->
                                            <div class="form-group col-md-6">
                                                <label for="dateAdmission">Date of Admission</label><span style="color: red;">*</span>
                                                <input type="date" class="form-control" id="dateAdmission"
                                                    name="dateAdmission" required>
                                            </div>
                                        </div>

                                        <!-- Admission Order and CBPA Status -->
                                        <div class="row">
                                            <!-- Admission Order Status -->
                                            <div class="form-group col-md-6">
                                                <label>Mode of payment</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="mode_of_payment" id="online" value="online">
                                                    <label class="form-check-label" for="online">online</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="mode_of_payment" id="offline" value="offline">
                                                    <label class="form-check-label" for="offline">offline</label>
                                                </div>
                                            </div>
                                            <!-- CBPA Status -->
                                            <div class="form-group col-md-6">
                                                <label>CBPA Status</label><span style="color: red;">*</span><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="cbpaStatus"
                                                        id="cbpaYes" value="Yes">
                                                    <label class="form-check-label" for="cbpaYes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="cbpaStatus"
                                                        id="cbpaNo" value="No">
                                                    <label class="form-check-label" for="cbpaNo">No</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Fees and Photo Status -->
                                        <div class="row">
                                            <!-- Token Fees Amount -->
                                            <div class="form-group col-md-6">
                                                <label for="tokenFeesAmount">Token Fees Amount</label> <span style="color: red;">*</span>
                                                <input type="number" class="form-control" id="tokenFeesAmount" value='<?php echo $tokenAmount; ?>' readonly
                                                    name="tokenFeesAmount" required>
                                            </div>
                                            <!-- Token Fees Paid Date -->
                                            <div class="form-group col-md-6">
                                                <label for="tokenFeesPaidDate">Token Fees Paid Date</label><span style="color: red;">*</span>
                                                <input type="date" class="form-control" id="tokenFeesPaidDate" value='<?php echo $paymentDateTime; ?>'
                                                    name="tokenFeesPaidDate" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- Remaining Semester Fees -->
                                            <div class="form-group col-md-6">
                                                <label for="remainingFees">Remaining Semester Fees</label><span style="color: red;">*</span>
                                                <input type="text" class="form-control" id="remainingFeesShowOnly" readonly
                                                    name="remainingFeesShowOnly" required>
                                                <input type="number" class="form-control" id="remainingFees" readonly
                                                    name="remainingFees" required>
                                            </div>
                                            <!-- Remaining Semester Fees Pay Date -->
                                            <div class="form-group col-md-6">
                                                <label for="remainingPayDate">Remaining Semester Fees Pay Date</label><span style="color: red;">*</span>
                                                <input type="date" class="form-control" id="remainingPayDate"
                                                    name="remainingPayDate" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- Photo Submitted Status -->
                                            <div class="form-group col-md-6">
                                                <label>Photo Submitted Status</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="photoStatus"
                                                        id="photoYes" value="Yes">
                                                    <label class="form-check-label" for="photoYes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="photoStatus"
                                                        id="photoNo" value="No">
                                                    <label class="form-check-label" for="photoNo">No</label>
                                                </div>
                                            </div>

                                            <!-- One time Scholarship -->
                                            <div class="form-group col-md-6 d-none">
                                                <label for="oneTimeScholarship">One time Scholarship</label>
                                                <input type="text" class="form-control" id="oneTimeScholarship" value="0"
                                                    name="one_time_scholarship" required>
                                            </div>
                                        </div>

                                        <!-- /.card-body -->

                                        <!-- Submit Button -->
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#confirmModal">Submit</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>

    <?php include 'include/importjs.php'; ?>

    <script>
        // Below code is for the fetching the load the level and the program !!!! /////////////////////////////////////////////////////////////////////////////////////
        $(document).ready(function() {
            // Load level and program on page load if PHP variables exist
            load_level(<?php echo $facultyID; ?>, <?php echo $levelID; ?>);
            load_program(<?php echo $facultyID; ?>, <?php echo $levelID; ?>, <?php echo $programID; ?>);

            // On faculty change
            $('#faculty_id').on('change', function () {
                var faculty_id = this.value;
                load_level(faculty_id);  // reset level
                $('#program_id').html('<option value="">---Select Program/Branch---</option>'); // reset program
            });

            // On level change
            $('#level_id').on('change', function () {
                var level_id = this.value;
                var faculty_id = $('#faculty_id').val();
                load_program(faculty_id, level_id); // load programs dynamically
            });
        });

        /**
         * Load level options.
         */
        function load_level(faculty_id, level_id = null) {
            var path = './include/';
            var api_for = "dashboard";
            $.ajax({
                url: path + 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id,
                    api_for: api_for
                },
                success: function (result) {
                    $('#level_id').html(result);
                }
            });
        }

        /**
         * Load program options.
         */
        function load_program(faculty_id, level_id = null, program_id = null) {
            var path = './include/';
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
                success: function (result) {
                    $('#program_id').html(result);

                    let selectedProgram = $('#program_id').val();
                    if (selectedProgram) {
                        // if you have some further function like fetchTokenFees(selectedProgram)
                        fetchTokenFees(selectedProgram);
                    }
                }
            });
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Below function is for the fetching the token fees /////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Function to fetch token fees
        function fetchTokenFees(program_id) {

            fetch('./include/tokenfees.php', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        program_id: program_id
                    })
                })
                .then(response => response.json())
                .then(data => {

                    if (data.error) {
                        document.getElementById('tokenFeesAmount').value = ''; 
                    } else {
                        let tokenFees = parseInt(data.tokenfees) || 0;
                        let semFees = parseInt(data.semfees) || 0;

                        const tokenInput = document.getElementById('tokenFeesAmount');
                        const remainingInput = document.getElementById('remainingFees');
                        const remainingFeesShowOnly = document.getElementById('remainingFeesShowOnly');

                        if (tokenInput && remainingInput) {
                            tokenInput.value = tokenFees;
                            let remainingFees = semFees - tokenFees;
                            remainingFees = (remainingFees < 0 ? 0 : remainingFees);

                            remainingInput.value = remainingFees.toString();
                            remainingFeesShowOnly.value = remainingFees.toString();
                        } else {
                            console.log("Input fields not found");
                        }

                    }
                })
                .catch(error => {
                    document.getElementById('tokenFeesAmount').value = '';
                });
        }

        // Fetch on dropdown change too
        document.getElementById('program_id').addEventListener('change', function() {
            let program_id = this.value;
            if (program_id) {
                fetchTokenFees(program_id);
            }
        });

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        // Following script is for the confirmation modal !!! ////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Get the confirm modal and the form
        var confirmModal = $('#confirmModal');
        var quickForm = $('#quickForm');
        // Get the confirm yes button
        var confirmYesButton = $('#confirmYes');
        // Add an event listener to the confirm yes button
        confirmYesButton.on('click', function() {
            // Submit the form
            quickForm.submit();
        });
        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        

        // Below code is for the fetching the minor or the honour !!!!  //////////////////////////////////////////////////////////////////////////////////////////////
        document.addEventListener("DOMContentLoaded", function() {
            const path = "./include/";
            const facultyInput = document.getElementById('faculty_id');
            const levelInput = document.getElementById('level_id');

            /**
             * Fetch options and populate select
             */
            function sendRequest(endpoint, selectId, faculty_id, level_id) {
                fetch(path + endpoint, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ status: "checked", faculty_id, level_id })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.options) {
                        const optionsHtml = ['<option value="">--Please select--</option>']
                            .concat(data.options.map(o => `<option value="${o.id}">${o.text}</option>`))
                            .join('');
                        document.getElementById(selectId).innerHTML = optionsHtml;
                    } else {
                        console.error("Invalid data format:", data);
                    }
                })
                .catch(err => console.error("Error:", err));
            }

            /**
             * Toggle select container and optionally populate select
             */
            function setupToggle(checkboxId, selectId, endpoint) {
                const checkbox = document.getElementById(checkboxId);
                const selectContainer = document.getElementById(`${selectId}-select`);
                const select = document.getElementById(selectId);

                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        selectContainer.classList.remove('d-none');
                        sendRequest(endpoint, selectId, facultyInput.value, levelInput.value);
                    } else {
                        selectContainer.classList.add('d-none');
                        select.innerHTML = '<option value="">--Please select--</option>';
                    }
                });
            }

            // Setup toggles
            setupToggle('Minor', 'minor', 'minor.php');
            setupToggle('Honour', 'honour', 'honour.php');
        });

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Below code is for the add minor and honour and reduce gb fees !!!!! ///////////////////////////////////////////////////////////////////////////////////////
        // ============================
        // Shared UI References
        // ============================
        const remainingInput = document.getElementById('remainingFees');
        const remainingFeesShowOnly = document.getElementById('remainingFeesShowOnly');

        // ============================
        // Track last applied fees
        // ============================
        let lastMinorFee = 0;
        let lastHonourFee = 0;
        let lastGbFee = 0; // NEW

        // Save original baseline once
        let originalRemainingFees = null;
        let originalRemainingFeesShowOnly = null;

        // ============================
        // Generic fee update helper
        // ============================
        function updateFee(type, programId, apiUrl, lastFeeRef) {
            if (lastFeeRef.amount > 0) {
                // Remove previously applied fee
                remainingInput.value = Number(remainingInput.value) - lastFeeRef.amount;
                const feePattern = new RegExp(`\\s?\\+\\s?${lastFeeRef.amount}`);
                remainingFeesShowOnly.value = remainingFeesShowOnly.value.replace(feePattern, '');
                lastFeeRef.amount = 0;
            }

            if (programId) {
                fetch(apiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ program_id: programId })
                })
                .then(res => res.json())
                .then(data => {
                    const newFee = Number(data.data.sem1) || 0;
                    lastFeeRef.amount = newFee;

                    remainingInput.value = Number(remainingInput.value) + newFee;
                    remainingFeesShowOnly.value += ` + ${newFee}`;
                })
                .catch(err => console.error(`${type} fetch error:`, err));
            }
        }

        // Minor/Honour states
        const minorState = { amount: lastMinorFee };
        const honourState = { amount: lastHonourFee };

        // ============================
        // Minor listeners
        // ============================
        document.getElementById('minor').addEventListener('change', e =>
            updateFee('Minor', e.target.value, './include/minor_honour_fees_add.php', minorState)
        );
        document.getElementById('Minor').addEventListener('change', e => {
            if (!e.target.checked) updateFee('Minor', null, '', minorState);
        });

        // ============================
        // Honour listeners
        // ============================
        document.getElementById('honour').addEventListener('change', e =>
            updateFee('Honour', e.target.value, './include/minor_honour_fees_add.php', honourState)
        );
        document.getElementById('Honour').addEventListener('change', e => {
            if (!e.target.checked) updateFee('Honour', null, '', honourState);
        });

        // ============================
        // GB checkbox listener
        // ============================
        document.getElementById('typeGB').addEventListener('change', function() {
            const levelCheck = parseInt(document.getElementById('level_id').value) || 0;
            const facultyCheck = parseInt(document.getElementById('faculty_id').value) || 0;

            // Save baseline once
            if (originalRemainingFees === null) {
                originalRemainingFees = Number(remainingInput.value) || 0;
                originalRemainingFeesShowOnly = remainingFeesShowOnly.value;
            }

            if (this.checked) {
                // Remove any previously applied GB
                if (lastGbFee > 0) {
                    remainingInput.value = Number(remainingInput.value) + lastGbFee;
                    const gbPattern = new RegExp(`\\s?-\\s?${lastGbFee}`);
                    remainingFeesShowOnly.value = remainingFeesShowOnly.value.replace(gbPattern, '');
                    lastGbFee = 0;
                }

                let gbAmount = 0;
                if (facultyCheck === 1 && (levelCheck === 1 || levelCheck === 2 || levelCheck === 9 )) {
                    gbAmount = 20000;
                } else if (facultyCheck === 1 && levelCheck === 5) {
                    gbAmount = 10000;
                }
                // New Condition: Faculty 5 or 8 + Level 2
                else if ((facultyCheck === 5 || facultyCheck === 8) && levelCheck === 2) {
                    gbAmount = 20000;
                }

                if (gbAmount > 0) {
                    lastGbFee = gbAmount;
                    remainingInput.value = Number(remainingInput.value) - gbAmount;
                    remainingFeesShowOnly.value += ` - ${gbAmount}`;
                }

            } else {
                // Reverse GB fee deduction
                if (lastGbFee > 0) {
                    remainingInput.value = Number(remainingInput.value) + lastGbFee;
                    const gbPattern = new RegExp(`\\s?-\\s?${lastGbFee}`);
                    remainingFeesShowOnly.value = remainingFeesShowOnly.value.replace(gbPattern, '');
                    lastGbFee = 0;
                }
            }
        });

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

</script>

</body>
</html>