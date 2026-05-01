<?php include 'include/checklogin.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // take directly pac_id into the student id 
    // $student_id         = isset($_POST['pac_id']) ? $_POST['pac_id'] : null;

    $pac_id             = isset($_POST['pac_id']) ? $_POST['pac_id'] : null;
    $student_id = $pac_id; // Assuming pac_id is student_id
    $new_mode           = isset($_POST['new_mode']) ? $_POST['new_mode'] : null;
    $new_program        = isset($_POST['new_program']) ? $_POST['new_program'] : null;
    $faculty_id         = isset($_POST['new_faculty']) ? $_POST['new_faculty'] : null;
    $level_id           = isset($_POST['new_level_id']) ? $_POST['new_level_id'] : null;
    $program_id         = isset($_POST['new_program_id']) ? $_POST['new_program_id'] : null;
    $confirmed_duplicate = isset($_POST['confirmed_duplicate']) ? $_POST['confirmed_duplicate'] : 0;
    $account_holder     = isset($_POST['account_holder']) ? $_POST['account_holder'] : null;
    $account_number     = isset($_POST['account_number']) ? $_POST['account_number'] : null;
    $ifsc               = isset($_POST['ifsc']) ? $_POST['ifsc'] : null;
    $remaining_fee      = isset($_POST['remaining_fee']) ? $_POST['remaining_fee'] : null;
    $remark             = isset($_POST['remark']) ? $_POST['remark'] : null;

    $receipt_file = '';
    $handwritten_file = '';
    $passbook_cheque_file = '';

    // Handwritten file
    if (isset($_FILES['handwritten_file']) && $_FILES['handwritten_file']['error'] === 0) {
        $handwritten_name = uniqid() . "_" . basename($_FILES["handwritten_file"]["name"]);
        $handwritten_path = "uploads/handwritten/" . $handwritten_name;
        if (move_uploaded_file($_FILES["handwritten_file"]["tmp_name"], $handwritten_path)) {
            $handwritten_file = $handwritten_name;
        }
    }

    // Receipt file (only if faculty is selected)
    if (!empty($faculty_id) && isset($_FILES['receipt']) && $_FILES['receipt']['error'] === 0) {
        $receipt_name = uniqid() . "_" . basename($_FILES["receipt"]["name"]);
        $receipt_path = "uploads/receipts/" . $receipt_name;
        if (move_uploaded_file($_FILES["receipt"]["tmp_name"], $receipt_path)) {
            $receipt_file = $receipt_name;
        }
    }

    // Passbook/Cheque file
    if (isset($_FILES['passbook_cheque']) && $_FILES['passbook_cheque']['error'] === 0) {
        $passbook_name = uniqid() . "_" . basename($_FILES["passbook_cheque"]["name"]);
        $passbook_path = "uploads/passbook_cheques/" . $passbook_name;
        if (move_uploaded_file($_FILES["passbook_cheque"]["tmp_name"], $passbook_path)) {
            $passbook_cheque_file = $passbook_name;
        }
    }

    // Determine final faculty/program values using ternary
    $final_faculty_id = (!empty($faculty_id) && !empty($level_id) && !empty($program_id)) ? $faculty_id : null;
    $final_level_id   = (!empty($faculty_id) && !empty($level_id) && !empty($program_id)) ? $level_id : null;
    $final_program_id = (!empty($faculty_id) && !empty($level_id) && !empty($program_id)) ? $program_id : (!empty($new_program) ? $new_program : null);

    // Old data JSON
    $old_data = '';
    $oldQuery = $con->prepare("SELECT faculty_id, level_id, program_id, mode FROM tbl_pac_form WHERE student_id = ? AND is_delete = 0 LIMIT 1");
    $oldQuery->bind_param("i", $student_id);
    $oldQuery->execute();
    $result = $oldQuery->get_result();
    // $old_data = ($result->num_rows > 0) ? json_encode($result->fetch_assoc()) : '';

    // Final insert
    $stmt = $con->prepare("
        INSERT INTO tbl_branch_transfer_requests 
        (student_id, faculty_id, level_id, program_id, new_mode, old_data, receipt, passbook_cheque, account_holder_name, account_number, ifsc_code, remaining_fee, handwritten_file, is_active, is_delete, f_remark) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 0, ?)
    ");
    $stmt->bind_param(
        "iiisssssssssss",
        $student_id,
        $final_faculty_id,
        $final_level_id,
        $final_program_id,
        $new_mode,
        $old_data,
        $receipt_file,
        $passbook_cheque_file,
        $account_holder,
        $account_number,
        $ifsc,
        $remaining_fee,
        $handwritten_file,
        $remark
    );

    if ($stmt->execute()) {
        $_SESSION['status'] = "Transfer request submitted successfully!";
        $_SESSION['status_code'] = "success";
        echo "<script>setTimeout(function(){window.location='view_branch_request.php'},1500)</script>";
    } else {
        $_SESSION['status'] = "Error submitting transfer request: " . $stmt->error;
        $_SESSION['status_code'] = "error";
    }
    $stmt->close();
}
?>
<!doctype html>
<html lang="en">

<head>
    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>
    <!-- SweetAlert2 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    
    <!-- Select2 JS -->
  
    <style>
        .badge {
            border-radius: 4px;
        }

        .tab-pane {
            position: relative;
            padding: 20px;
            border-radius: 9px;
            margin: 25px 0;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.13);
        }
        .select2-container .select2-selection--single {
            height: 35px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include 'include/importnav.php'; ?>
        <?php include 'include/importsidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Branch Transfer Request</h1>
                        </div>
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
                    <div class="card card-gmiu">
                        <div class="card-header">
                            <h3 class="card-title">PAC Form</h3>
                        </div>
                        <form id="transferForm" method="POST" enctype="multipart/form-data">

                            <div class="card-body">
                                <!-- PAC ID Dropdown -->
                                <div class="form-group">
                                    <label for="pac_id"><b>Select PAC ID</b></label>
                                    <select name="pac_id" id="pac_id" class="form-control" required>
                                        <option value="">-- Select PAC ID --</option>
                                        <?php
                                        $sql = "SELECT DISTINCT formno, student_id FROM tbl_pac_form WHERE is_delete = 0";
                                        $result = $con->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                           $padded_formno = str_pad($row['formno'], 4, '0', STR_PAD_LEFT);
                                           echo "<option value='{$row['student_id']}'>2025/{$padded_formno}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Student Details -->
                                <div id="student-data-section" style="display:none;">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><b>GR Number:</b></td>
                                                <td><span id="gr_number"></span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Faculty:</b></td>
                                                <td><span id="faculty"></span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Level:</b></td>
                                                <td><span id="level"></span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Program:</b></td>
                                                <td><span id="program"></span></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Editable Sections -->
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox" class="transfer-toggle" data-target="#modeTransfer"> <b>Mode Transfer</b></td>
                                                <td>
                                                    <div id="modeTransfer" style="display: none;">
                                                        <p><b>Current Mode:</b> <span id="current_mode"></span></p>
                                                        <label><input type="checkbox" name="new_mode" value="R" class="group-mode"> Regular</label><br>
                                                        <label><input type="checkbox" name="new_mode" value="SM" class="group-mode"> Special Mode</label><br>
                                                        <label><input type="checkbox" name="new_mode" value="CBPA" class="group-mode"> CBPA</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><input type="checkbox" class="transfer-toggle" data-target="#branchTransfer"> <b>Branch Transfer</b></td>
                                                <td>
                                                    <div id="branchTransfer" style="display: none;">
                                                        <p><b>Current Program:</b>
                                                            <input type="hidden" id="program_id_b" name="program_id_b" />
                                                            <span id="current_program"></span>
                                                        </p>
                                                        <label for="new_program"><b>Select New Branch:</b></label><br>
                                                        <select id="level_id" hidden>
                                                            <option value="">-- Select Branch --</option>
                                                        </select>

                                                        <select id="faculty_id" hidden>
                                                            <option value="">-- Select Branch --</option>
                                                        </select>
                                                        <select name="new_program" id="program_id" class="form-control">
                                                            <option value="">-- Select Branch --</option>
                                                        </select>


                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="checkbox" class="transfer-toggle" data-target="#facultyTransfer"> <b>Faculty Transfer</b></td>
                                                <td>
                                                    <div id="facultyTransfer" style="display: none;">
                                                        <p><b>Current Faculty:</b> <span id="current_faculty"></span></p>
                                                        <label for="new_faculty"><b>Select New Faculty:</b></label><br>
                                                        <select name="new_faculty" id="new_faculty" class="form-control">
                                                            <option value="">-- Select Faculty --</option>
                                                            <?php
                                                            $sql = "SELECT id, name FROM tbl_faculty WHERE is_active = 1 AND is_delete = 0";
                                                            $res = $con->query($sql);
                                                            while ($row = $res->fetch_assoc()) {
                                                                echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        <label class="control-label">Select Level<span style="color: red;">
                                                                *</span></label>
                                                        <select name="new_level_id" id="new_level_id" class="form-control">
                                                            <option value="">---Select Level---</option>
                                                        </select>

                                                        <label class="control-label">Select Program<span style="color: red;">
                                                                *</span></label>
                                                        <select name="new_program_id" id="new_program_id" class="form-control">
                                                            <option value="">---Select Program/Branch---</option>
                                                        </select>

                                                        <label class="control-label" for="receipt">Upload Receipt</label>
                                                        <input type="file" name="receipt" id="receipt" class="form-control" accept="image/*,application/pdf"><br>

                                                        <label class="control-label" for="passbook_cheque">Upload Bank Passbook/Cheque</label>
                                                        <input type="file" name="passbook_cheque" id="passbook_cheque" class="form-control" accept="image/*,application/pdf"><br>

                                                        <label class="control-label" for="account_holder">Account Holder Name</label>
                                                        <input type="text" name="account_holder" class="form-control" id="account_holder"><br>

                                                        <label class="control-label" for="account_number">Account Number</label>
                                                        <input type="text" name="account_number" class="form-control" id="account_number"><br>

                                                        <label class="control-label" for="ifsc">IFSC Code</label>
                                                        <input type="text" name="ifsc" class="form-control" id="ifsc"><br>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Remain Fee</b></td>
                                                <td>
                                                    <input type="text" name="remaining_fee" class="form-control" id="remaining_fee" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Upload Handwritten Request</b></td>
                                                <td>
                                                    <input type="file" name="handwritten_file" accept="image/*" class="form-control" required>
                                                    <small class="text-muted">Accepted formats: JPG, PNG. Max size: 2MB</small>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> <label for="remark">Remark</label> </td>
                                                <td>
                                                    <textarea name="remark" id="remark" rows="3" class="form-control" required></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <input type="hidden" name="confirmed_duplicate" value="0" id="confirmed_duplicate">
                                                    <input type="submit" name="submitBtn" class="btn btn-primary" value="Submit Transfer Request">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </section>
        </div>
        <?php include 'include/importfooter.php'; ?>
    </div>

    <?php include 'include/importjs.php'; ?>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <?php include 'branch_transfer_js.php'; ?>
 


</body>

</html>