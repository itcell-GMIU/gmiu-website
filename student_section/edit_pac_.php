
<?php include './include/checklogin.php';

$id = $_GET['id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pacid = isset($_POST['pacid']) ? $_POST['pacid'] : '';
    $tshirt = trim(isset($_POST['tshirt']) ? $_POST['tshirt'] : '');
    $category = trim(isset($_POST['category']) ? $_POST['category'] : '');
    $photoStatus = trim(isset($_POST['photoStatus']) ? $_POST['photoStatus'] : '');
    $quota = trim(isset($_POST['quota']) ? $_POST['quota'] : '');
    $one_time_scholarship = trim(isset($_POST['one_time_scholarship']) ? $_POST['one_time_scholarship'] : '');

    // Check if the updated formno already exists
    $checkSql = "SELECT COUNT(*) FROM tbl_pac_form WHERE pacid != ?";
    $checkStmt = $con->prepare($checkSql);
    $checkStmt->bind_param("s", $pacid);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        $_SESSION['status'] = "The updated PAC No. already exists!";
        $_SESSION['status_code'] = "error";
    } else {
        $sql = "UPDATE tbl_pac_form SET
            category = ?,photoStatus = ?, tshirt_size = ? ,quota = ? , one_time_scholarship = ? 
        WHERE pacid = ?";

        if ($stmt = $con->prepare($sql)) {
            // Fix: Use correct number of placeholders
            $stmt->bind_param(
                "ssssss",
                $category,
                $photoStatus,
                $tshirt,
                $quota,
                $one_time_scholarship,
                $pacid
            );

            // Execute and check for errors
            if (!$stmt->execute()) {
                die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            } else {
                $_SESSION['status'] = "PAC Form Updated Successfully !!!";
                $_SESSION['status_code'] = "success";
                echo "<script>setTimeout(function(){window.location='view_pac_student.php'},1000)</script>";
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
                                    <a href="show_pac.php?id=<?php echo $id; ?>" class="btn btn-sm btn-primary ml-auto">Details</a>
                                </div>
                                <!-- /.card-header -->
                                <?php  // Fetch data
                                $sql = "SELECT * FROM tbl_pac_form WHERE pacid = $id";
                                $result = $con->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) { 
                                        $faculty_id = $row['faculty_id'];
                                        $level_id = $row['level_id'];
                                        $program_id = $row['program_id'];
                                        $branch_code = $row['branchSpecialization'];
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
                                                        <input type="text" class="form-control" value="<?php echo $row['formno']; ?>" id="formno" name="formno" required hidden>                                                
                                                        <input type="text" class="form-control" value="2025 / <?php echo str_pad(htmlspecialchars($row['formno']), 4, '0', STR_PAD_LEFT); ?>" id="formno" name="formno" required disabled>                                                
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
                                                        <input type="text" class="form-control" id="remarks" name="remarks" value="<?php echo $row['remarks']?>"
                                                            required>
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
                                                            echo 'checked'; ?> required>
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
                                                <!-- Faculty, Level, and Program -->
                                                 <div class="row">
                                            <!-- Select Faculty -->
                                            <!-- <div class="form-group col-md-6">
                                                <label class="control-label">Select Faculty<span style="color: red;">
                                                        *</span></label>
                                                <select class="form-control" name="faculty_id" required id="faculty_id">
                                                    <option value="">---Select Faculty---</option>
                                                    <?php
                                                                                                        $query_faculty = "SELECT * FROM tbl_faculty WHERE is_delete = '0' AND is_active = '1'";
                                                                                                        $stmt_faculty = $con->prepare($query_faculty);
                                                                                                        $stmt_faculty->execute();
                                                                                                        $result_faculty = $stmt_faculty->get_result();

                                                                                                        while ($row_faculty = $result_faculty->fetch_assoc()) {
                                                                                                            ?>
                                                                                                                <option value="<?php echo $row_faculty['id']; ?>" <?php if ($row_faculty['id'] == $facultyID) {
                                                                                                                       echo "selected";
                                                                                                                   } ?>>
                                                                                                                
                                                                                                                    <?php echo $row_faculty['name']; ?>
                                                                                                                </option>
                                                                                                                <?php
                                                                                                        }
                                                                                                        $stmt_faculty->close();
                                                                                                        ?>
                                                                                                </select>
                                                                                            </div> -->
                                                    <!-- Select Faculty -->
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label" for="faculty_id">Select Faculty<span style="color: red;"> *</span></label>
                                                        <input type="text" class="form-control" name="faculty_id" id="faculty_id" required hidden>
                                                        <input type="text" class="form-control" id="faculty_id_show" required disabled>
                                                    </div>
                                                
                                                    <!-- Select Level -->
                                                    <!-- <div class="form-group col-md-6">
                                                                                                            <label class="control-label">Select Level<span style="color: red;">
                                                                                                                    *</span></label>
                                                                                                            <select name="level_id" id="level_id" class="form-control" required>
                                                                                                                <option value="">---Select Level---</option>
                                                                                                            </select>
                                                                                                        </div> -->
                                                    <!-- Select Level -->
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label" for="level_id">Select Level<span style="color: red;"> *</span></label>
                                                        <input type="text" class="form-control" name="level_id" id="level_id" required hidden>
                                                        <input type="text" class="form-control" id="level_id_show" required disabled>
                                                    </div>
                                                </div>
                                                 <div class="row">
                                            <!-- Select Program -->
                                            <!-- <div class="form-group col-md-6">
                                                <label class="control-label">Select Program<span style="color: red;">
                                                        *</span></label>
                                                <select name="program_id" id="program_id" class="form-control" required>
                                                    <option value="">---Select Program/Branch---</option>
                                                </select>
                                            </div> -->
                                            <!-- Select Program -->
                                            <div class="form-group col-md-6">
                                                <label class="control-label" for="program_id">Select Program<span style="color: red;"> *</span></label>
                                                <input type="text" class="form-control" name="program_id" id="program_id" required hidden>
                                                <input type="text" class="form-control" id="program_id_show" required disabled>
                                            </div>

                                           <!-- Branch/Specialization -->
                                            <div class="form-group col-md-6">
                                                <label for="branchSpecialization">Branch / Specialization</label><span class="form_error_message">*</span>
                                                <select class="form-control" id="branchSpecialization" name="branchSpecialization" required readonly onchange="fetchBranchDetails(this.value)">
                                                    <option value="">Select Branch/Specialization</option>
                                                    <?php
                                                                $queryBranch = "SELECT branch_code, name FROM tbl_program WHERE is_active = 1 AND is_delete = 0";
                                                                $resultBranch = $con->query($queryBranch);
                                                                if ($resultBranch->num_rows > 0) {
                                                                    while ($rowBranch = $resultBranch->fetch_assoc()) {
                                                                        $selected = ($rowBranch['branch_code'] == $branch_code) ? 'selected' : '';
                                                                        echo '<option value="' . htmlspecialchars($rowBranch['branch_code']) . '" ' . $selected . '>' . htmlspecialchars($rowBranch['branch_code'] . ' - ' . $rowBranch['name']) . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                        </select>
                                                    </div>
                                                
                                                </div>


                                                <!-- Admission Type and Branch/Specialization -->
                                                <div class="row">
                                                    <!-- Admission Type -->
                                                    <div class="form-group col-md-6">
                                                        <label>Admission Type</label><br>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="admissionType[]"
                                                                id="type1stYear" value="1st Year" <?php echo (strpos($row['admissionType'], '1st Year') !== false) ? 'checked' : ''; ?> required>
                                                            <label class="form-check-label" for="type1stYear">1st Year</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="admissionType[]"
                                                                id="type2ndYear" value="2nd Year" <?php echo (strpos($row['admissionType'], '2nd Year') !== false) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="type2ndYear">2nd Year</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="admissionType[]"
                                                                id="typeDualDegree" value="Dual Degree" <?php echo (strpos($row['admissionType'], 'Dual Degree') !== false) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="typeDualDegree">Dual
                                                                Degree</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="admissionType[]"
                                                                id="typevoc" value="VOC" <?php echo (strpos($row['admissionType'], 'VOC') !== false) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="typevoc">VOC</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="admissionType[]"
                                                                id="Minor" value="Minor" <?php echo (strpos($row['admissionType'], 'Minor') !== false) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="Minor">Minor</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="admissionType[]"
                                                                id="Honour" value="Honour" <?php echo (strpos($row['admissionType'], 'Honour') !== false) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="Honour">Honour</label>
                                                        </div>
                                                    </div>

                                                      <!-- Select Level -->
                                                    <div class="form-group col-md-6">
                                                        <label>Level</label><br>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="level2[]" <?php echo (strpos($row['level2'], 'Diploma') !== false) ? 'checked' : ''; ?>
                                                                id="Diploma" value="Diploma" required>
                                                            <label class="form-check-label" for="Diploma">Diploma</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="level2[]" <?php echo (strpos($row['level2'], 'UG') !== false) ? 'checked' : ''; ?>
                                                                id="UG" value="UG">
                                                            <label class="form-check-label" for="UG">UG</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="level2[]" <?php echo (strpos($row['level2'], 'PG') !== false) ? 'checked' : ''; ?>
                                                                id="PG" value="PG">
                                                            <label class="form-check-label" for="PG">PG</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="level2[]" <?php echo (strpos($row['level2'], 'PHD') !== false) ? 'checked' : ''; ?>
                                                                id="PHD" value="PHD">
                                                            <label class="form-check-label" for="PHD">PHD</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="level2[]" <?php echo (strpos($row['level2'], 'VOC') !== false) ? 'checked' : ''; ?>
                                                                id="VOC" value="VOC">
                                                            <label class="form-check-label" for="VOC">VOC</label>
                                                        </div>
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
                                                    <input class="form-check-input" type="radio"
                                                        name="mode_of_payment" id="online" value="online" <?php echo ($row['mode_of_payment'] == 'online') ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="online">online</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="mode_of_payment" id="offline" value="offline" <?php echo ($row['mode_of_payment'] == 'offline') ? 'checked' : '' ?>>
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
                                                        <input type="number" class="form-control" id="tokenFeesAmount"
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
                                                    <div class="form-group col-md-6">
                                                        <label for="remainingFees">Remaining Semester Fees</label>
                                                        <input type="number" class="form-control" id="remainingFees"
                                                            name="remainingFees"
                                                            value="<?php echo htmlspecialchars($row['remainingFees']); ?>"
                                                            required>
                                                    </div>
                                                    <!-- Remaining Semester Fees Pay Date -->
                                                    <div class="form-group col-md-6">
                                                        <label for="remainingPayDate">Remaining Semester Fees Pay Date</label>
                                                        <input type="date" class="form-control" id="remainingPayDate"
                                                            name="remainingPayDate"
                                                            value="<?php echo htmlspecialchars($row['remainingPayDate']); ?>"
                                                            required>
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
                                                        id="photoNo" value="No" <?php echo ($row['photoStatus'] == 'No') ? 'checked' : ''?>>
                                                    <label class="form-check-label" for="photoNo">No</label>
                                                </div>
                                            </div>
                                            
                                            <!-- One time Scholarship -->
                                            <div class="form-group col-md-6">
                                                <label for="oneTimeScholarship">One time Scholarship</label>
                                                <input type="text" class="form-control" id="oneTimeScholarship"
                                                name="one_time_scholarship"  value="<?php echo $row['one_time_scholarship']; ?>" required>
                                            </div>
                                        </div>
                                                <!-- /.card-body -->

                                                <!-- Submit Button -->
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                                <!-- /.card-footer -->
                                        </form>
                                        <!-- /.form -->
                                    <?php }
                                } else {
                                    echo "<tr><td colspan='2'>No records found</td></tr>";
                                } ?>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col-md-12 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>

        </div>
        <!-- ./wrapper -->

        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>

    <?php include 'include/importjs.php'; ?>
    
<script>
    $(document).ready(function() {
        //call for listing the dropdown and select by default
        load_level();
        load_program();
    });

    function load_level() {
        // var path = '<?php echo $base_url_api; ?>';
        var path = './include/';
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
        // var path = '<?php echo $base_url_api; ?>';
        var path = './include/';
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
                 // Check if a default value exists & auto-select
                let selectedProgram = $('#program_id').val();
                // console.log("Auto-Selected Program ID:", selectedProgram); // Debugging

                if (selectedProgram) {
                    fetchTokenFees(selectedProgram);
                }
            }
             
        });

    }
      // Function to fetch token fees
    function fetchTokenFees(program_id) {
        // console.log("Fetching Token Fees for:", program_id); // Debugging

        fetch('./include/tokenfees.php', {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ program_id: program_id })
        })
            .then(response => response.json())
            .then(data => {
                // console.log("Response Data:", data); // Debugging output

                if (data.error) {
                    // console.error("SQL Error:", data.error);
                    document.getElementById('tokenFeesAmount').value = ''; // Clear input on error
                } else {
                    let tokenFees = parseInt(data.tokenfees) || 0;
                    let semFees = parseInt(data.semfees) || 0;

                    const tokenInput = document.getElementById('tokenFeesAmount');
                    const remainingInput = document.getElementById('remainingFees');

                    if (tokenInput && remainingInput) {
                      tokenInput.value = tokenFees;
                      let remainingFees = semFees - tokenFees;
                      remainingFees = (remainingFees < 0 ? 0 : remainingFees);
                      console.log(remainingFees + "h");
                      remainingInput.value = remainingFees.toString();
                    } else {
                      console.log("Input fields not found");
                    }

                }
            })
            .catch(error => {
                // console.error("Fetch Error:", error);
                document.getElementById('tokenFeesAmount').value = ''; // Clear input on fetch error
            });
    }
    // Fetch on dropdown change too
    document.getElementById('program_id').addEventListener('change', function () {
        let program_id = this.value;
        if (program_id) {
            fetchTokenFees(program_id);
        }
    });
     load_program();


</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let excludeFields = ["photoStatus", "category", "tshirt","quota", "one_time_scholarship"]; // Fields that should remain editable

        document.querySelectorAll("input, textarea, select").forEach(function (element) {
            if (!excludeFields.includes(element.name)) {
                if (element.tagName === "SELECT") {
                    element.style.pointerEvents = "none"; // Prevent selection change
                    element.style.backgroundColor = "#e9ecef"; // Light grey background like readonly fields
                } else if (element.type === "radio" || element.type === "checkbox") {
                    element.disabled = true; // Disable checkboxes & radio buttons
                } else {
                    element.readOnly = true; // Make text inputs, textareas readonly
                }
            }
        });
    });
</script>

<script>
        function fetchBranchDetails(branchID) {
            if (branchID) {
                fetch('include/api_of_fetch_branchspecialization.php?branch_id=' + branchID)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('faculty_id').value = data.faculty_id;
                            document.getElementById('faculty_id_show').value = data.faculty_name;
                            document.getElementById('level_id').value = data.level_id;
                            document.getElementById('level_id_show').value = data.level_name;
                            document.getElementById('program_id').value = data.program_id;
                            document.getElementById('program_id_show').value = data.program_name;
                        } else {
                            console.error('Error fetching data');
                        }
                    })
                    .catch(error => console.error('Fetch error:', error));
            }
        }

        window.onload = function () {
            fetchBranchDetails(<?php echo $branch_code; ?>)
    };

</script>
   
</body>

</html>