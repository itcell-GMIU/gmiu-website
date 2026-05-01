<?php include './include/checklogin.php';

$id = $_GET['id'];
$sql = "SELECT * FROM tbl_pac_form WHERE pacid = $id";
$result = $con->query($sql);

$selectedMinorId = '';
$selectedHonourId = '';

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $selectedMinorId = $row['minor'];   // make sure column names are correct
    $selectedHonourId = $row['honour'];
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $stu_id = isset($_POST['stu_id']) ? $_POST['stu_id'] : '';
    $pacid = isset($_POST['pacid']) ? $_POST['pacid'] : ''; // Fix: Define pacid
    $formno = trim($_POST['formno']) ? $_POST['formno'] : '';
    $studentName = strtoupper(trim(isset($_POST['studentName']) ? $_POST['studentName'] : ''));
    $studentMobile = trim(isset($_POST['studentMobile']) ? $_POST['studentMobile'] : '');
    $studentEmail = trim(isset($_POST['studentEmail']) ? $_POST['studentEmail'] : '');
    $whatsappNumber = trim(isset($_POST['whatsappNumber']) ? $_POST['whatsappNumber'] : '');
    $parentMobile = trim(isset($_POST['parentMobile']) ? $_POST['parentMobile'] : '');
    $birthDate = trim(isset($_POST['birthDate']) ? $_POST['birthDate'] : '');
    $mode = trim(isset($_POST['mode']) ? $_POST['mode'] : '');
    $tshirt = trim(isset($_POST['tshirt']) ? $_POST['tshirt'] : '');
    $mode_of_payment = trim(isset($_POST['mode_of_payment']) ? $_POST['mode_of_payment'] : '');
    $one_time_scholarship = trim(isset($_POST['one_time_scholarship']) ? $_POST['one_time_scholarship'] : '');
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
    $level2 = isset($_POST['level2']) ? trim(implode(",", $_POST['level2'])) : '';
    $minor1 = trim(isset($_POST['minor']) ? $_POST['minor'] : '');
    $honour1 = trim(isset($_POST['honour']) ? $_POST['honour'] : '');

    // Check if the updated formno already exists
    $checkSql = "SELECT COUNT(*) FROM tbl_pac_form WHERE formno = ? AND pacid != ?";
    $checkStmt = $con->prepare($checkSql);
    $checkStmt->bind_param("ss", $formno, $pacid);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        $_SESSION['status'] = "The updated PAC No. already exists!";
        $_SESSION['status_code'] = "error";
    } else {
        $sql = "UPDATE tbl_pac_form SET
            studentName = ?, studentMobile = ?, studentEmail = ?, whatsappNumber = ?, parentMobile = ?, 
            mode = ?, faculty_id = ?, level_id = ?, program_id = ?, admissionType = ?, branchSpecialization = ?, 
            quota = ?, category = ?, dateProvisional = ?, dateAdmission = ?, cbpaStatus = ?, tokenFeesAmount = ?, 
            tokenFeesPaidDate = ?, remainingFees = ?, remainingPayDate = ?, photoStatus = ?, 
            one_time_scholarship = ?, mode_of_payment = ?, tshirt_size = ?, formno = ?, remarks = ?, level2 = ? , minor = ? , honour = ? 
        WHERE pacid = ?";

        if ($stmt = $con->prepare($sql)) {
            // Fix: Use correct number of placeholders
            $stmt->bind_param(
                "ssssssssssssssssssssssssssssss",
                // $stu_id,
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
                $minor1,
                $honour1,
                $pacid
            );

            // Execute and check for errors
            if (!$stmt->execute()) {
                die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            } else {
                $_SESSION['status'] = "PAC Form Updated Successfully !!!";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='view_pac.php'},1000)</script>";
            }

            $stmt->close();
        } else {
            $_SESSION['status'] = "Something Went Wrong !!!";
            $_SESSION['status_code'] = "error";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include 'include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include 'include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit All Details</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit All Details</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-gmiu">
                                <div class="card-header d-flex">
                                    <h3 class="card-title">PAC Form</h3>
                                    <a href="show_pac.php?id=<?php echo $id; ?>"
                                        class="btn btn-sm btn-primary ml-auto">Details</a>
                                </div>
                                <!-- /.card-header -->
                                <?php  // Fetch data
                                $sql = "SELECT p.*, f.admission_year 
                                        FROM tbl_pac_form p
                                        LEFT JOIN tbl_admission_feedback f 
                                            ON p.student_id = f.student_id and f.is_delete= 0 and f.is_active = 1
                                        WHERE p.pacid = $id
                                    ";
                                $result = $con->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $faculty_id = $row['faculty_id'];
                                        $level_id = $row['level_id'];
                                        $program_id = $row['program_id'];
                                        $branch_code = $row['branchSpecialization'];

                                        $formno = $row['formno'];
                                        $pacid = $row['pacid'];
                                        $admission_year = $row['admission_year'];

                                        // Default → keep original formno
                                        $display_formno = $formno;

                                        // Case 1: Admission year not available OR 2025-26_july
                                        if (empty($admission_year) || $admission_year === '2025-26_july') {

                                            if ($formno == $pacid) {
                                                $display_formno = "2025 / " . str_pad($pacid, 4, '0', STR_PAD_LEFT);
                                            } elseif (strpos($formno, '2025 /') !== 0) {
                                                $display_formno = "2025 / " . ltrim($formno, "0");
                                            } else {
                                                $display_formno = $formno;
                                            }

                                        // Case 2: Admission year is 2026-27_jan OR 2026-27_july
                                        } elseif ($admission_year === '2026-27_jan' || $admission_year === '2026-27_july') {
                                            $display_formno = $formno;
                                        }
                                        ?>
        
                                    <form id="quickForm" method="POST" action="#" class="needs-validation" novalidate>
                                        <input type="text" name="pacid" value="<?php echo $row['pacid']; ?>" hidden>
                                        <div class="card-body">
                                            <!-- Student Details Section -->
                                            <div class="row">
                                                <p class="heading-p">Student Details</p>
                                                <hr>
                                            </div>
                                                <div class="row">
                                                    <!-- Student Email -->
                                                    <div class="form-group col-md-2">
                                                        <label for="formno">PAC Form No.</label>
                                                        <span class="form_error_message">*</span>
                                                        
                                                        <!-- Hidden real value -->
                                                        <input type="text" class="form-control"
                                                            value="<?php echo htmlspecialchars($formno); ?>" 
                                                            id="formno" name="formno" required hidden>

                                                        <!-- Display formatted -->
                                                        <input type="text" class="form-control"
                                                            value="<?php echo htmlspecialchars($display_formno); ?>" 
                                                            id="formno_display" name="formno_display" readonly>
                                                    </div>
                                                </div>
                                                <!-- Student Name, Mobile, and Email -->
                                                <div class="row">
                                                    <!-- Student Name -->
                                                    <div class="form-group col-md-6">
                                                        <label for="studentName">Student Name</label><span
                                                            class="form_error_message">*</span>
                                                        <input type="text" class="form-control" id="studentName"
                                                            name="studentName"
                                                            value="<?php echo htmlspecialchars($row['studentName']); ?>"
                                                            required>
                                                    </div>
                                                    <!-- Student Mobile Number -->
                                                    <div class="form-group col-md-6">
                                                        <label for="studentMobile">Mobile Number (Student)</label><span
                                                            class="form_error_message">*</span>
                                                        <input type="text" class="form-control" id="studentMobile"
                                                            name="studentMobile"
                                                            value="<?php echo htmlspecialchars($row['studentMobile']); ?>"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- Student Email -->
                                                    <div class="form-group col-md-6">
                                                        <label for="studentEmail">Student Email ID</label><span
                                                            class="form_error_message">*</span>
                                                        <input type="email" class="form-control" id="studentEmail"
                                                            name="studentEmail"
                                                            value="<?php echo htmlspecialchars($row['studentEmail']); ?>"
                                                            required>
                                                    </div>
                                                    <!-- WhatsApp Number -->
                                                    <div class="form-group col-md-6">
                                                        <label for="whatsappNumber">WhatsApp Number</label>
                                                        <input type="text" class="form-control" id="whatsappNumber"
                                                            name="whatsappNumber"
                                                            value="<?php echo htmlspecialchars($row['whatsappNumber']); ?>">
                                                    </div>
                                                </div>

                                                <!-- Parent Mobile and Birth Date -->
                                                <div class="row">
                                                    <!-- Parent Mobile Number -->
                                                    <div class="form-group col-md-6">
                                                        <label for="parentMobile">Mobile Number (Parents)</label><span
                                                            class="form_error_message">*</span>
                                                        <input type="text" class="form-control" id="parentMobile"
                                                            name="parentMobile"
                                                            value="<?php echo htmlspecialchars($row['parentMobile']); ?>"
                                                            required>
                                                    </div>
                                                    <!-- Remarks -->
                                                    <div class="form-group col-md-6">
                                                        <label for="remarks">Remarks</label><span
                                                            class="form_error_message">*</span>
                                                        <input type="text" class="form-control" id="remarks" name="remarks"
                                                            value="<?php echo $row['remarks'] ?>" required>
                                                    </div>
                                                </div>

                                                <!-- Mode and Medium -->
                                                <div class="row">
                                                    <!-- Mode -->
                                                    <div class="form-group col-md-6">
                                                        <label>Mode</label><br>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="mode" id="modeR"
                                                                value="R" <?php if ($row['mode'] == 'R')
                                                                    echo 'checked'; ?>
                                                                required>
                                                            <label class="form-check-label" for="modeR">R</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="mode" id="modeD"
                                                                value="SM" <?php if ($row['mode'] == 'SM')
                                                                    echo 'checked'; ?>>
                                                            <label class="form-check-label" for="modeD">SM</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="mode" id="modeD"
                                                                value="CBPA" <?php if ($row['mode'] == 'CBPA')
                                                                    echo 'checked'; ?>>
                                                            <label class="form-check-label" for="modeD">CBPA</label>
                                                        </div>
                                                    </div>


                                                    <!--T-shirt -->
                                                    <div class="form-group col-md-6">
                                                        <label for="studentName">T-shirt</label><span
                                                            class="form_error_message">*</span>
                                                        <input type="text" class="form-control" id="tshirt" name="tshirt"
                                                            required value="<?php echo $row['tshirt_size']; ?>">
                                                    </div>
                                                </div>

                                                <!-- Faculty, Level, and Program in one row -->
                                                <div class="row">
                                                    <!-- Select Faculty -->
                                                    <div class="form-group col-md-4">
                                                        <label class="control-label">Select Faculty <span
                                                                style="color: red;">*</span></label>
                                                        <select class="form-control" name="faculty_id" required id="faculty_id">
                                                            <option value="">---Select Faculty---</option>
                                                            <?php
                                                            $query_faculty = "SELECT * FROM tbl_faculty WHERE is_delete = '0' AND is_active = '1'";
                                                            $stmt_faculty = $con->prepare($query_faculty);
                                                            $stmt_faculty->execute();
                                                            $result_faculty = $stmt_faculty->get_result();
                                                            $facultyID = $row['faculty_id'];
                                                            while ($row_faculty = $result_faculty->fetch_assoc()) { ?>
                                                                <option value="<?php echo $row_faculty['id']; ?>" <?php if ($row_faculty['id'] == $facultyID)
                                                                       echo "selected"; ?>>
                                                                    <?php echo $row_faculty['name']; ?>
                                                                </option>
                                                            <?php }
                                                            $stmt_faculty->close(); ?>
                                                        </select>
                                                    </div>

                                                    <!-- Select Level -->
                                                    <div class="form-group col-md-4">
                                                        <label class="control-label">Select Level <span
                                                                style="color: red;">*</span></label>
                                                        <select name="level_id" id="level_id" class="form-control" required>
                                                            <option value="">---Select Level---</option>
                                                        </select>
                                                    </div>

                                                    <!-- Select Program -->
                                                    <div class="form-group col-md-4">
                                                        <label class="control-label">Select Program <span
                                                                style="color: red;">*</span></label>
                                                        <select name="program_id" id="program_id" class="form-control" required>
                                                            <option value="">---Select Program/Branch---</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Admission Type and Branch/Specialization -->
                                                <div class="row">
                                                    <!-- Admission Type -->
                                                    <div class="form-group col-md-6">
                                                        <label>Admission Type</label><br>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="admissionType[]" id="type1stYear" value="1st Year" <?php echo (strpos($row['admissionType'], '1st Year') !== false) ? 'checked' : ''; ?> required>
                                                            <label class="form-check-label" for="type1stYear">1st Year</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="admissionType[]" id="type2ndYear" value="2nd Year" <?php echo (strpos($row['admissionType'], '2nd Year') !== false) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="type2ndYear">2nd Year</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="admissionType[]" id="typeGB" value="GB" <?php echo (strpos($row['admissionType'], 'GB') !== false) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="typeGB">GB</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="admissionType[]" id="typevoc" value="VOC" <?php echo (strpos($row['admissionType'], 'VOC') !== false) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="typevoc">VOC</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="admissionType[]" id="Minor" value="Minor" <?php echo (strpos($row['admissionType'], 'Minor') !== false) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="Minor">Minor</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="admissionType[]" id="Honour" value="Honour" <?php echo (strpos($row['admissionType'], 'Honour') !== false) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="Honour">Honour</label>
                                                        </div>
                                                    </div>

                                                    <!-- Select Level -->
                                                    <div class="form-group col-md-6">
                                                        <label>Level</label><br>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="level2[]"
                                                                <?php echo (strpos($row['level2'], 'Diploma') !== false) ? 'checked' : ''; ?> id="Diploma" value="Diploma" required>
                                                            <label class="form-check-label" for="Diploma">Diploma</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="level2[]"
                                                                <?php echo (strpos($row['level2'], 'UG') !== false) ? 'checked' : ''; ?> id="UG" value="UG">
                                                            <label class="form-check-label" for="UG">UG</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="level2[]"
                                                                <?php echo (strpos($row['level2'], 'PG') !== false) ? 'checked' : ''; ?> id="PG" value="PG">
                                                            <label class="form-check-label" for="PG">PG</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="level2[]"
                                                                <?php echo (strpos($row['level2'], 'PHD') !== false) ? 'checked' : ''; ?> id="PHD" value="PHD">
                                                            <label class="form-check-label" for="PHD">PHD</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="level2[]"
                                                                <?php echo (strpos($row['level2'], 'VOC') !== false) ? 'checked' : ''; ?> id="VOC" value="VOC">
                                                            <label class="form-check-label" for="VOC">VOC</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- For the Minor And honour   -->
                                                <div class="row">
                                                    <div class="form-group col-md-6 d-none" id="minor-select">
                                                        <label class="control-label">Select Minor <span
                                                                style="color: red;">*</span></label>
                                                        <select name="minor" id="minor" class="form-control" required>
                                                            <option value="">---Select Minor---</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6 d-none" id="honour-select">
                                                        <label class="control-label">Select Honour <span
                                                                style="color: red;">*</span></label>
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
                                                                id="quotaUQ" value="UQ" <?php if ($row['quota'] == 'UQ')
                                                                    echo 'checked'; ?> required>
                                                            <label class="form-check-label" for="quotaUQ">UQ</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="quota"
                                                                id="quotaMQ" value="MQ" <?php if ($row['quota'] == 'MQ')
                                                                    echo 'checked'; ?>>
                                                            <label class="form-check-label" for="quotaMQ">MQ</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="quota"
                                                                id="quotaVQ" value="VQ" <?php if ($row['quota'] == 'VQ')
                                                                    echo 'checked'; ?>>
                                                            <label class="form-check-label" for="quotaVQ">VQ</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="quota"
                                                                id="quotaSQ" value="SQ" <?php if ($row['quota'] == 'SQ')
                                                                    echo 'checked'; ?>>
                                                            <label class="form-check-label" for="quotaSQ">SQ</label>
                                                        </div>
                                                    </div>
                                                    <!-- Category -->
                                                    <div class="form-group col-md-6">
                                                        <label>Category</label><br>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="category"
                                                                id="categoryOpen" value="Open" <?php if ($row['category'] == 'Open')
                                                                    echo 'checked'; ?> required>
                                                            <label class="form-check-label" for="categoryOpen">Open</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="category"
                                                                id="categoryEWS" value="EWS" <?php if ($row['category'] == 'EWS')
                                                                    echo 'checked'; ?>>
                                                            <label class="form-check-label" for="categoryEWS">EWS</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="category"
                                                                id="categorySEBC" value="SEBC" <?php if ($row['category'] == 'SEBC')
                                                                    echo 'checked'; ?>>
                                                            <label class="form-check-label" for="categorySEBC">SEBC</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="category"
                                                                id="categorySCST" value="SC/ST" <?php if ($row['category'] == 'SC/ST')
                                                                    echo 'checked'; ?>>
                                                            <label class="form-check-label" for="categorySCST">SC/ST</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Admission Dates and Status -->
                                                <div class="row">
                                                    <!-- Date of Provisional Admission -->
                                                    <div class="form-group col-md-6">
                                                        <label for="dateProvisional">Date of Provisional Admitted</label><span
                                                            class="form_error_message">*</span>
                                                        <input type="date" class="form-control" id="dateProvisional"
                                                            name="dateProvisional"
                                                            value="<?php echo htmlspecialchars($row['dateProvisional']); ?>"
                                                            required>
                                                    </div>
                                                    <!-- Date of Admission -->
                                                    <div class="form-group col-md-6">
                                                        <label for="dateAdmission">Date of Admission</label>
                                                        <input type="date" class="form-control" id="dateAdmission"
                                                            name="dateAdmission"
                                                            value="<?php echo htmlspecialchars($row['dateAdmission']); ?>"
                                                            required>
                                                    </div>
                                                </div>

                                                <!-- Admission Order and CBPA Status -->
                                                <div class="row">
                                                    <!-- Admission Order Status -->
                                                    <div class="form-group col-md-6">
                                                        <label>Mode of payment</label><br>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="mode_of_payment"
                                                                id="online" value="online" <?php echo ($row['mode_of_payment'] == 'online') ? 'checked' : '' ?>>
                                                            <label class="form-check-label" for="online">online</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="mode_of_payment"
                                                                id="offline" value="offline" <?php echo ($row['mode_of_payment'] == 'offline') ? 'checked' : '' ?>>
                                                            <label class="form-check-label" for="offline">offline</label>
                                                        </div>
                                                    </div>
                                                    <!-- CBPA Status -->
                                                    <div class="form-group col-md-6">
                                                        <label>CBPA Status</label><br>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="cbpaStatus"
                                                                id="cbpaYes" value="Yes" <?php if ($row['cbpaStatus'] == 'Yes')
                                                                    echo 'checked'; ?>>
                                                            <label class="form-check-label" for="cbpaYes">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="cbpaStatus"
                                                                id="cbpaNo" value="No" <?php if ($row['cbpaStatus'] == 'No')
                                                                    echo 'checked'; ?>>
                                                            <label class="form-check-label" for="cbpaNo">No</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Fees and Photo Status -->
                                                <div class="row">
                                                    <!-- Token Fees Amount -->
                                                    <div class="form-group col-md-6">
                                                        <label for="tokenFeesAmount">Token Fees Amount</label>
                                                        <input type="number" class="form-control" id="tokenFeesAmount" readonly
                                                            name="tokenFeesAmount"
                                                            value="<?php echo htmlspecialchars($row['tokenFeesAmount']); ?>"
                                                            required>
                                                    </div>
                                                    <!-- Token Fees Paid Date -->
                                                    <div class="form-group col-md-6">
                                                        <label for="tokenFeesPaidDate">Token Fees Paid Date</label>
                                                        <input type="date" class="form-control" id="tokenFeesPaidDate"
                                                            name="tokenFeesPaidDate"
                                                            value="<?php echo htmlspecialchars($row['tokenFeesPaidDate']); ?>"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Remaining Semester Fees -->
                                                    <!-- <div class="form-group col-md-6">
                                                        <label for="remainingFees">Remaining Semester Fees</label><span
                                                            style="color: red;">*</span>
                                                        <input type="number" class="form-control" id="remainingFees" readonly
                                                            name="remainingFees" required>
                                                    </div> -->
                                                     <!-- Remaining Semester Fees -->
                                                    <div class="form-group col-md-6">
                                                        <label for="remainingFees">Remaining Semester Fees</label><span style="color: red;">*</span>
                                                        <input type="text" class="form-control" id="remainingFeesShowOnly" readonly
                                                            name="remainingFeesShowOnly" required>
                                                        <input type="number" class="form-control" id="remainingFees" readonly
                                                            name="remainingFees"
                                                            required>
                                                    </div>
                                                    <!-- Remaining Semester Fees Pay Date -->
                                                    <div class="form-group col-md-6">
                                                        <label for="remainingPayDate">Remaining Semester Fees Pay
                                                            Date</label><span style="color: red;">*</span>
                                                        <input type="date" class="form-control" id="remainingPayDate"
                                                            name="remainingPayDate" value="<?php echo $row['remainingPayDate']; ?>" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Photo Submitted Status -->
                                                    <div class="form-group col-md-6">
                                                        <label>Photo Submitted Status</label><br>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="photoStatus"
                                                                id="photoYes" value="Yes" <?php echo ($row['photoStatus'] == 'Yes') ? 'checked' : '' ?>>
                                                            <label class="form-check-label" for="photoYes">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="photoStatus"
                                                                id="photoNo" value="No" <?php echo ($row['photoStatus'] == 'No') ? 'checked' : '' ?>>
                                                            <label class="form-check-label" for="photoNo">No</label>
                                                        </div>
                                                    </div>

                                                    <!-- One time Scholarship -->
                                                    <div class="form-group col-md-6 d-none">
                                                        <label for="oneTimeScholarship">One time Scholarship</label>
                                                        <input type="text" class="form-control" id="oneTimeScholarship"
                                                            name="one_time_scholarship"
                                                            value="<?php echo $row['one_time_scholarship']; ?>" required>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->

                                                <!-- Submit Button -->
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                        </form>
                                    <?php }
                                } else {
                                    echo "<tr><td colspan='2'>No records found</td></tr>";
                                } ?>
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
    $(document).ready(function () {
        const path = './include/';
        const faculty_id = <?php echo $faculty_id; ?>;
        const level_id = <?php echo $level_id; ?>;
        const program_id = <?php echo $program_id; ?>;

        // Initial loads
        loadLevel(faculty_id, level_id);
        loadProgram(faculty_id, level_id, program_id);

        // On faculty change, reload level and program
        $('#faculty_id').on('change', function () {
            const selectedFaculty = $(this).val();
            loadLevel(selectedFaculty, null);     // reset level
            loadProgram(selectedFaculty, null);   // reset program
        });

        // On level change, reload program
        $('#level_id').on('change', function () {
            const selectedLevel = $(this).val();
            const selectedFaculty = $('#faculty_id').val();
            loadProgram(selectedFaculty, selectedLevel, null);
        });

        // On program change, fetch token fees
        $('#program_id').on('change', function () {
            fetchTokenFees($(this).val());
        });

        // Fetch level list
        function loadLevel(faculty_id, level_id) {
            $.ajax({
                url: path + 'level.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_id: level_id,
                    api_for: "dashboard"
                },
                success: function (result) {
                    $('#level_id').html(result);
                }
            });
        }

        // Fetch program list
        function loadProgram(faculty_id, level_id, program_id) {
            $.ajax({
                url: path + 'program.php',
                type: "POST",
                data: {
                    faculty_data: faculty_id,
                    level_data: level_id,
                    program_id: program_id,
                    api_for: "dashboard"
                },
                success: function (result) {
                    $('#program_id').html(result);
                    $('#branchSpecialization').html(result); // if you need this too
                    // Fetch token fees if a program is auto-selected
                    if ($('#program_id').val()) {
                        fetchTokenFees($('#program_id').val());
                    }
                }
            });
        }

        // Fetch token fees and set fields
        function fetchTokenFees(program_id) {
            fetch(path + 'tokenfees.php', {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ program_id: program_id })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        $('#tokenFeesAmount').val(''); // clear on error
                    } else {
                        const tokenFees = parseInt(data.tokenfees) || 0;
                        const semFees = parseInt(data.semfees) || 0;
                        const remainingFees = Math.max(semFees - tokenFees, 0); // never less than 0

                        $('#tokenFeesAmount').val(tokenFees);
                        $('#remainingFees').val(remainingFees);
                        $('#remainingFeesShowOnly').val(remainingFees);
                    }
                })
                .catch(() => $('#tokenFeesAmount').val(''));
        }
    });

    const selectedMinorId = "<?= isset($selectedMinorId) ? $selectedMinorId : '' ?>";
    const selectedHonourId = "<?= isset($selectedHonourId) ? $selectedHonourId : '' ?>";

    console.log("Selected Minor:", selectedMinorId);
    console.log("Selected Honour:", selectedHonourId);

    document.addEventListener("DOMContentLoaded", function () {
        const path = "./include/";

        const MinorCheckbox = document.getElementById("Minor");
        const HonourCheckbox = document.getElementById("Honour");

        const faculty_id = document.getElementById('faculty_id').value;
        const level_id = document.getElementById('level_id').value;

        if (MinorCheckbox.checked) {
            document.getElementById('minor-select').classList.remove("d-none");
            sendRequest("minor.php", "minor", faculty_id, level_id, selectedMinorId);
        }

        if (HonourCheckbox.checked) {
            document.getElementById('honour-select').classList.remove("d-none");
            sendRequest("honour.php", "honour", faculty_id, level_id, selectedHonourId);
        }

        // On Minor checkbox change
        MinorCheckbox.addEventListener("change", function () {
            if (this.checked) {
                document.getElementById('minor-select').classList.remove("d-none");
                sendRequest("minor.php", "minor", faculty_id, level_id, selectedMinorId);
            } else {
                document.getElementById('minor-select').classList.add("d-none");
                $('#minor').html('<option value="">--Please select--</option>');
            }
        });

        // On Honour checkbox change
        HonourCheckbox.addEventListener("change", function () {
            if (this.checked) {
                document.getElementById('honour-select').classList.remove("d-none");
                sendRequest("honour.php", "honour", faculty_id, level_id, selectedHonourId);
            } else {
                document.getElementById('honour-select').classList.add("d-none");
                $('#honour').html('<option value="">--Please select--</option>');
            }
        });

        function sendRequest(endpoint, selectId, faculty_id, level_id, selectedId = null) {
            fetch(path + endpoint, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ status: "checked", faculty_id: faculty_id, level_id: level_id })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.options) {
                        let optionsHtml = '<option value="">--Please select--</option>';
                        data.options.forEach(option => {
                            const selected = (selectedId && option.id == selectedId) ? 'selected' : '';
                            optionsHtml += `<option value="${option.id}" ${selected}>${option.text}</option>`;
                        });
                        $('#' + selectId).html(optionsHtml);
                    } else {
                        console.error("Invalid data format:", data);
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    });


    document.addEventListener('DOMContentLoaded', function () {
        // ============================
        // Shared references
        // ============================
        const remainingInput = document.getElementById('remainingFees');
        const remainingFeesShowOnly = document.getElementById('remainingFeesShowOnly');

        // ============================
        // Track last applied fees
        // ============================
        const minorState = { amount: 0 };
        const honourState = { amount: 0 };
        let lastGbFee = 0;

        // Save baseline fees
        let originalRemainingFees = Number(remainingInput.value) || 0;
        let originalRemainingFeesShowOnly = remainingFeesShowOnly.value;

        // ============================
        // Generic helper to add/remove Minor/Honour fees
        // ============================
        function updateFee(type, programId, apiUrl, lastFeeRef) {
            // Remove old fee if present
            if (lastFeeRef.amount > 0) {
                remainingInput.value = Number(remainingInput.value) - lastFeeRef.amount;
                remainingFeesShowOnly.value = remainingFeesShowOnly.value.replace(new RegExp(`\\s?\\+\\s?${lastFeeRef.amount}`), '');
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

        // ============================
        // Minor listener
        // ============================
        const minorCheckbox = document.getElementById('Minor');
        const minorSelect = document.getElementById('minor');

        minorCheckbox.addEventListener('change', () => {
            if (!minorCheckbox.checked) {
                minorSelect.value = '';
                updateFee('Minor', null, '', minorState);
            } else if (minorSelect.value) {
                updateFee('Minor', minorSelect.value, './include/minor_honour_fees_add.php', minorState);
            }
        });

        minorSelect.addEventListener('change', e => {
            if (minorCheckbox.checked) {
                updateFee('Minor', e.target.value, './include/minor_honour_fees_add.php', minorState);
            }
        });

        // ============================
        // Honour listener
        // ============================
        const honourCheckbox = document.getElementById('Honour');
        const honourSelect = document.getElementById('honour');

        honourCheckbox.addEventListener('change', () => {
            if (!honourCheckbox.checked) {
                honourSelect.value = '';
                updateFee('Honour', null, '', honourState);
            } else if (honourSelect.value) {
                updateFee('Honour', honourSelect.value, './include/minor_honour_fees_add.php', honourState);
            }
        });

        honourSelect.addEventListener('change', e => {
            if (honourCheckbox.checked) {
                updateFee('Honour', e.target.value, './include/minor_honour_fees_add.php', honourState);
            }
        });

        // ============================
        // GB listener and logic
        // ============================
        const gbCheckbox = document.getElementById('typeGB');

        function applyGbFee() {
            const facultyCheck = parseInt(document.getElementById('faculty_id').value) || 0;
            const levelCheck = parseInt(document.getElementById('level_id').value) || 0;

            // Remove old GB fee
            if (lastGbFee > 0) {
                remainingInput.value = Number(remainingInput.value) + lastGbFee;
                remainingFeesShowOnly.value = remainingFeesShowOnly.value.replace(new RegExp(`\\s?-\\s?${lastGbFee}`), '');
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
                else if(facultyCheck === 2 && (levelCheck === 1 || levelCheck === 9)){
                    gbAmount = 20000;
                }

            if (gbAmount > 0) {
                lastGbFee = gbAmount;
                remainingInput.value = Number(remainingInput.value) - gbAmount;
                remainingFeesShowOnly.value += ` - ${gbAmount}`;
            }
        }

        gbCheckbox.addEventListener('change', function () {
            if (this.checked) {
                applyGbFee();
            } else if (lastGbFee > 0) {
                remainingInput.value = Number(remainingInput.value) + lastGbFee;
                remainingFeesShowOnly.value = remainingFeesShowOnly.value.replace(new RegExp(`\\s?-\\s?${lastGbFee}`), '');
                lastGbFee = 0;
            }
        });

        // ============================
        // INITIALIZE on page load
        // ============================
        // if (gbCheckbox.checked) {
        //     applyGbFee();
        // }
        // if (minorCheckbox.checked && minorSelect.value) {
        //     updateFee('Minor', minorSelect.value, './include/minor_honour_fees_add.php', minorState);
        // }
        // if (honourCheckbox.checked && honourSelect.value) {
        //     updateFee('Honour', honourSelect.value, './include/minor_honour_fees_add.php', honourState);
        // }
        setTimeout(() => {
            if (gbCheckbox.checked) {
                applyGbFee();
            }
            if (minorCheckbox.checked && minorSelect.value) {
                updateFee('Minor', minorSelect.value, './include/minor_honour_fees_add.php', minorState);
            }
            if (honourCheckbox.checked && honourSelect.value) {
                updateFee('Honour', honourSelect.value, './include/minor_honour_fees_add.php', honourState);
            }
        }, 1000);
    });

</script>

</body>
</html>