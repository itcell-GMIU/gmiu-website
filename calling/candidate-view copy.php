<?php
include './include/config.php';
$url_for = isset($_GET['url_for']) ? $_GET['url_for'] : '';
if (($role_id == 15 || $role_id == 16) && ($url_for == '' || $url_for == 'inq')) {
    echo "<a href='candidate-view.php?url_for=myinq'>my inquiry</a><br>";
    echo "<a href='candidate-view.php?url_for=approvedinq'>approved inquiry</a><br>";
    echo "<a href='candidate-view.php?url_for=rejectedinq'>rejected inquiry</a><br>";
    echo "<a href='candidate-view.php?url_for=closedinq'>closed inquiry</a><br>";
    echo "<a href='candidate-view.php?url_for=approvedbyother'>approved by other inquiry</a><br>";
    exit;
} elseif (($role_id == 57 || $role_id == 12 || $role_id == 14 || $role_id == 11 || $role_id == 60) && ($url_for == 'myinq' || $url_for == 'approvedbyother')) {
    echo "<a href='candidate-view.php?url_for=inq'>all inquiry</a><br>";
    echo "<a href='candidate-view.php?url_for=approvedinq'>approved inquiry</a><br>";
    echo "<a href='candidate-view.php?url_for=rejectedinq'>rejected inquiry</a><br>";
    echo "<a href='candidate-view.php?url_for=closedinq'>closed inquiry</a><br>";
    exit;
}
?>

<?php
if (isset($_POST['callForm']) && ($role_id == 15 || $role_id == 16)) {

    $tis_id = isset($_POST['tis_id']) ? $_POST['tis_id'] : '';
    $inq_student_id = isset($_POST['inq_student_id']) ? $_POST['inq_student_id'] : '';
    $call_status = isset($_POST['call_status']) ? $_POST['call_status'] : '';
    $remark = isset($_POST['remark']) ? $_POST['remark'] : '';
    $conversation = isset($_POST['conversation']) ? $_POST['conversation'] : '';
    $other_remark = isset($_POST['other_remark']) ? $_POST['other_remark'] : '';
    $staff_id = isset($_SESSION['staff_id']) ? $_SESSION['staff_id'] : '';

    // Validate
    if ($tis_id == '' || $inq_student_id == '' || $call_status == '' || $remark == '') {
        // echo json_encode(["status" => "error", "message" => "All fields are required"]);
        $_SESSION['status'] = "All fields are required !";
        $_SESSION['status_code'] = "error";
        // exit;
    } else {

        // -------------------------
        // CHECK CURRENT CALL COUNT
        // -------------------------
        $checkSql = "SELECT 
                    (SELECT COUNT(*) 
                    FROM tbl_inquiry_call_logs 
                    WHERE inq_student_id = ? 
                    AND is_active = 1 
                    AND is_delete = 0) AS total_calls,

                    (SELECT call_count 
                    FROM tbl_inquiry_student 
                    WHERE inq_student_id = ? 
                    AND is_active = 1 
                    AND is_delete = 0 
                    LIMIT 1) AS max_call_count";

        $stmt = $con->prepare($checkSql);
        $stmt->bind_param("ss", $inq_student_id, $inq_student_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $currentCount = intval($result['total_calls']);
        $max_call_count = $result['max_call_count'];

        if ($currentCount >= $max_call_count) {
            // echo json_encode(["status" => "error", "message" => "Call limit reached (3)."]);
            $_SESSION['status'] = "Call limit reached ($max_call_count).";
            $_SESSION['status_code'] = "error";
            // exit;
        } else {

            // -------------------------
            // INSERT NEW CALL LOG
            // -------------------------
            $call_count = $currentCount + 1;
            $insertSql = "INSERT INTO tbl_inquiry_call_logs 
                        (tis_id, inq_student_id, call_status, remark, conversation, call_by, call_count, other_remark)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt2 = $con->prepare($insertSql);
            $stmt2->bind_param("issssiis", $tis_id, $inq_student_id, $call_status, $remark, $conversation, $staff_id, $call_count, $other_remark);

            if ($stmt2->execute()) {

                if ($call_status === 'CLOSE') {
                    // -------------------------
                    // UPDATE INQUIRY STUDENT STATUS TO CLOSED
                    // -------------------------
                    $updateSql = "UPDATE tbl_inquiry_student
                                  SET closed_by = ?,
                                  is_closed = 1
                                  WHERE id = ? AND inq_student_id = ?";

                    $stmt3 = $con->prepare($updateSql);
                    $stmt3->bind_param("iis", $staff_id, $tis_id, $inq_student_id);
                    // $stmt3->execute();
                    if ($stmt3->execute()) {
                        // -------------------------
                        // INSERT INTO INQUIRY LOGS
                        $totalRemark = $remark . (!empty($other_remark) ? " - " . $other_remark : "");
                        $sql_i9 = "INSERT INTO tbl_inquiry_logs (inq_student_id, action, staff_id, remark) VALUES (?, 'close', ?, ?)";
                        $stmt_q2 = mysqli_prepare($con, $sql_i9);
                        mysqli_stmt_bind_param($stmt_q2, "sis", $inq_student_id, $staff_id, $totalRemark);
                        mysqli_stmt_execute($stmt_q2);
                        mysqli_stmt_close($stmt_q2);

                        $_SESSION['status'] = "Call log added successfully & Inquiry Closed";
                        $_SESSION['status_code'] = "success";
                    }
                } else {
                    $_SESSION['status'] = "Call log added successfully";
                    $_SESSION['status_code'] = "success";
                }
            } else {
                $_SESSION['status'] = "Error While Inserting Call Log";
                $_SESSION['status_code'] = "error";
            }
            // exit;
        }

    }
}

if (isset($_POST['callMaxCountForm']) && $role_id == 57) {

    $tis_id = isset($_POST['tis_id']) ? $_POST['tis_id'] : '';
    $inq_student_id = isset($_POST['inq_student_id']) ? $_POST['inq_student_id'] : '';
    $new_call_count = isset($_POST['new_call_count']) ? intval($_POST['new_call_count']) : '';

    // Validate
    if ($tis_id == '' || $inq_student_id == '' || $new_call_count == '') {
        // echo json_encode(["status" => "error", "message" => "All fields are required"]);
        $_SESSION['status'] = "All fields are required !";
        $_SESSION['status_code'] = "error";
        // exit;
    } else {
        // -------------------------
        // UPDATE CALL COUNT LIMIT
        // -------------------------
        $updateSql = "UPDATE tbl_inquiry_student
                    SET call_count = call_count + ?
                    WHERE id = ?
                    AND inq_student_id = ?
                    AND is_active = 1
                    AND is_delete = 0";

        $stmt = $con->prepare($updateSql);

        if (!$stmt) {
            $_SESSION['status'] = "Prepare failed: " . $con->error;
            $_SESSION['status_code'] = "error";
            return;
        }

        $stmt->bind_param("iis", $new_call_count, $tis_id, $inq_student_id);

        if ($stmt->execute()) {
            $_SESSION['status'] = "Call limit increased successfully!";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Error while updating call limit!";
            $_SESSION['status_code'] = "error";
        }

        $stmt->close();
    }
}

if (isset($_POST['admissionStatusUpdateFormData']) && $role_id == 57) {

    $tis_id = isset($_POST['tis_id']) ? $_POST['tis_id'] : '';
    $inq_student_id = isset($_POST['inq_student_id']) ? $_POST['inq_student_id'] : '';
    $call_remark = isset($_POST['call_remark']) ? $_POST['call_remark'] : '';
    $staff_id = isset($_POST['staff_id']) ? $_POST['staff_id'] : '';
    $admission_confirmation = isset($_POST['admission_confirmation']) ? $_POST['admission_confirmation'] : '';

    // ---------------------------
    // 1️⃣ Basic Validation
    // ---------------------------
    if ($tis_id == '' || $inq_student_id == '' || $call_remark == '' || $admission_confirmation == '') {
        $fields = [
            "TIS ID" => $tis_id,
            "Inquiry Student ID" => $inq_student_id,
            "Call Remark" => $call_remark,
            "Admission Confirmation" => $admission_confirmation,
        ];

        $missing = array_keys(array_filter($fields, function ($v) {
            return $v == '';
        }));

        if (!empty($missing)) {
            $_SESSION['status'] = "Missing fields: " . implode(", ", $missing);
            $_SESSION['status_code'] = "error";
        }

        // $_SESSION['status'] = "All fields are required!";
        // $_SESSION['status_code'] = "error";
    } else {

        if ($admission_confirmation == 1) {
            // ---------------------------
            // 2️⃣ Fetch Inquiry Student
            // ---------------------------
            $fetchSql = "SELECT id, inq_student_id, faculty_id, level_id, program_id,
                    first_name, middle_name, last_name, email, mobile_number
                 FROM tbl_inquiry_student 
                 WHERE id = ? AND inq_student_id = ?
                 AND is_active = 1 AND is_delete = 0";

            $stmt = $con->prepare($fetchSql);
            $stmt->bind_param("is", $tis_id, $inq_student_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $inquiry = $result->fetch_assoc();
            $stmt->close();

            if (!$inquiry) {
                $_SESSION['status'] = "Inquiry student not found!";
                $_SESSION['status_code'] = "error";
                return;
            }

            $mobile = $inquiry['mobile_number'];
            $admissionID = null;

            // ---------------------------
            // 3️⃣ Check if Mobile Exists in tbl_admission_student
            // ---------------------------
            $checkSql = "SELECT id FROM tbl_admission_student 
                 WHERE mobile_number = ? AND is_active = 1 AND is_delete = 0";

            $stmt = $con->prepare($checkSql);
            $stmt->bind_param("s", $mobile);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Already exists
                $stmt->bind_result($admissionID);
                $stmt->fetch();
            }
            $stmt->close();

            // ---------------------------
            // 4️⃣ Insert new admission record IF NOT EXISTS
            // ---------------------------
            if (!$admissionID) {

                $password = $mobile; // password = mobile number

                $insertSql = "INSERT INTO tbl_admission_student 
                        (faculty_id, level_id, program_id,
                         first_name, middle_name, last_name,
                         email, mobile_number, password)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $con->prepare($insertSql);
                $stmt->bind_param(
                    "iiissssss",
                    $inquiry['faculty_id'],
                    $inquiry['level_id'],
                    $inquiry['program_id'],
                    $inquiry['first_name'],
                    $inquiry['middle_name'],
                    $inquiry['last_name'],
                    $inquiry['email'],
                    $inquiry['mobile_number'],
                    $password
                );

                if ($stmt->execute()) {
                    $admissionID = $stmt->insert_id;  // Only update inquiry table now
                } else {
                    $_SESSION['status'] = "Failed to insert new admission record!";
                    $_SESSION['status_code'] = "error";
                    return;
                }

                $stmt->close();
            }

            // ---------------------------
            // 5️⃣ ONLY NOW update tbl_inquiry_student
            // ---------------------------
            $updateSql = "UPDATE tbl_inquiry_student
                  SET admission_student_id = ?,
                      is_admission_confirm = 1,
                      confirm_by = ?,
                      admission_remark = ?,
                      confirm_on = NOW()
                  WHERE id = ? AND inq_student_id = ?";

            $stmt = $con->prepare($updateSql);
            $stmt->bind_param(
                "iisis",
                $admissionID,
                $staff_id,
                $call_remark,
                $tis_id,
                $inq_student_id
            );

            if ($stmt->execute()) {
                // -------------------------
                // INSERT INTO INQUIRY LOGS
                $sql_i9 = "INSERT INTO tbl_inquiry_logs (inq_student_id, action, admin_id, staff_id, remark) VALUES (?,'approve',?,?,?)";
                $stmt_q2 = mysqli_prepare($con, $sql_i9);
                mysqli_stmt_bind_param($stmt_q2, "siis", $inq_student_id, $_SESSION['staff_id'], $staff_id, $call_remark);
                mysqli_stmt_execute($stmt_q2);
                mysqli_stmt_close($stmt_q2);
                $stmt_q2 = mysqli_prepare($con, $sql_i9);
                $_SESSION['status'] = "Admission status updated successfully!";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "Error while updating inquiry student!";
                $_SESSION['status_code'] = "error";
            }
        } elseif ($admission_confirmation == 0) {
            echo '<script>console.log("hey ' . $admission_confirmation . '")</script>';
            // ---------------------------
            // 5️⃣ ONLY NOW update tbl_inquiry_student
            // ---------------------------
            $updateSql = "UPDATE tbl_inquiry_student
                  SET is_admission_confirm = -1,
                      admission_remark = ?, confirm_on = NOW()
                  WHERE id = ? AND inq_student_id = ?";

            $stmt = $con->prepare($updateSql);
            $stmt->bind_param(
                "sis",
                $call_remark,
                $tis_id,
                $inq_student_id
            );

            if ($stmt->execute()) {
                $data = $con->prepare("SELECT staff_id FROM tbl_inquiry_student WHERE inq_student_id = ? LIMIT 1");
                $data->bind_param("i", $inq_student_id);
                $data->execute();
                $result = $data->get_result();
                $row = $result->fetch_assoc();
                $ass_staff_id = $row['staff_id'];

                // -------------------------
                // INSERT INTO INQUIRY LOGS
                $sql_i9 = "INSERT INTO tbl_inquiry_logs (inq_student_id, action, admin_id, staff_id, remark) VALUES (?, 'reject', ?, ?, ?)";
                $stmt_q2 = mysqli_prepare($con, $sql_i9);
                mysqli_stmt_bind_param($stmt_q2, "siis", $inq_student_id, $_SESSION['staff_id'], $ass_staff_id, $call_remark);
                mysqli_stmt_execute($stmt_q2);
                mysqli_stmt_close($stmt_q2);
                $stmt_q2 = mysqli_prepare($con, $sql_i9);
                $_SESSION['status'] = "Admission status updated successfully!";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "Error while updating inquiry student!";
                $_SESSION['status_code'] = "error";
            }
        }
    }

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'unclose_inquiry') {

        $tis_id = $_POST['tis_id'];
        $inq_student_id = $_POST['inq_student_id'];

        // 🔒 Validate
        if (empty($tis_id) || empty($inq_student_id)) {
            echo 'Invalid data';
            exit;
        }

        // ✅ Update query (example)
        $stmt = $con->prepare("
            UPDATE tbl_inquiry_student
            SET is_closed = 0
            WHERE id = ? AND inq_student_id = ?
        ");
        $stmt->bind_param("is", $tis_id, $inq_student_id);
        // $stmt->execute();
        if ($stmt->execute()) {

            $data = $con->prepare("SELECT staff_id FROM tbl_inquiry_student WHERE inq_student_id = ? LIMIT 1");
            $data->bind_param("i", $inq_student_id);
            $data->execute();
            $result = $data->get_result();
            $row = $result->fetch_assoc();
            $ass_staff_id = $row['staff_id'];

            // -------------------------
            // INSERT INTO INQUIRY LOGS
            $sql_i9 = "INSERT INTO tbl_inquiry_logs (inq_student_id, action, admin_id, staff_id) VALUES (?, 'unclose', ?, ? )";
            $stmt_q2 = mysqli_prepare($con, $sql_i9);
            mysqli_stmt_bind_param($stmt_q2, "sii", $inq_student_id, $staff_id, $ass_staff_id);
            mysqli_stmt_execute($stmt_q2);
            mysqli_stmt_close($stmt_q2);
            $stmt_q2 = mysqli_prepare($con, $sql_i9);

            if (!$stmt_q2) {
                echo "<script>alert('Prepare failed: " . addslashes(mysqli_error($con)) . "');</script>";
                exit;
            }

            mysqli_stmt_bind_param($stmt_q2, "si", $inq_student_id, $staff_id);

            if (!mysqli_stmt_execute($stmt_q2)) {
                echo "<script>alert('Execute failed: " . addslashes(mysqli_stmt_error($stmt_q2)) . "');</script>";
                exit;
            }

            mysqli_stmt_close($stmt_q2);
        }

        echo 'success';
        exit;
    }


    if ($_POST['action'] === 'open_inquiry') {

        $tis_id = $_POST['tis_id'];
        $inq_student_id = $_POST['inq_student_id'];

        // 🔒 Validate
        if (empty($tis_id) || empty($inq_student_id)) {
            echo 'Invalid data';
            exit;
        }

        // ✅ Update query (example)
        $stmt = $con->prepare("
            UPDATE tbl_inquiry_student
            SET is_admission_confirm = 0
            WHERE id = ? AND inq_student_id = ?
        ");
        $stmt->bind_param("is", $tis_id, $inq_student_id);
        // $stmt->execute();
        if ($stmt->execute()) {

            $data = $con->prepare("SELECT staff_id FROM tbl_inquiry_student WHERE inq_student_id = ? LIMIT 1");
            $data->bind_param("i", $inq_student_id);
            $data->execute();
            $result = $data->get_result();
            $row = $result->fetch_assoc();
            $ass_staff_id = $row['staff_id'];

            // -------------------------
            // INSERT INTO INQUIRY LOGS
            $sql_i9 = "INSERT INTO tbl_inquiry_logs (inq_student_id, action, admin_id, staff_id) VALUES (?, 'open', ?, ? )";
            $stmt_q2 = mysqli_prepare($con, $sql_i9);
            mysqli_stmt_bind_param($stmt_q2, "sii", $inq_student_id, $staff_id, $ass_staff_id);
            mysqli_stmt_execute($stmt_q2);
            mysqli_stmt_close($stmt_q2);
            $stmt_q2 = mysqli_prepare($con, $sql_i9);

            if (!$stmt_q2) {
                echo "<script>alert('Prepare failed: " . addslashes(mysqli_error($con)) . "');</script>";
                exit;
            }

            mysqli_stmt_bind_param($stmt_q2, "si", $inq_student_id, $staff_id);

            if (!mysqli_stmt_execute($stmt_q2)) {
                echo "<script>alert('Execute failed: " . addslashes(mysqli_stmt_error($stmt_q2)) . "');</script>";
                exit;
            }

            mysqli_stmt_close($stmt_q2);
        }

        echo 'success';
        exit;
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <?php include('include/head.php'); ?>
</head>

<body>
    <?php include('include/header.php'); ?>
    <?php include('include/sidebar.php'); ?>
    <div class="main-container">
        <div class="pd-ltr-20 height-100-p xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Candidate Data</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Candidate Data</li>
                                </ol>
                            </nav>
                        </div>
                        <?php if ($role_id == 13) { ?>
                            <div class="col-md-6 col-sm-12 text-right">
                                <div class="dropdown">
                                    <a class="btn btn-primary" href="candidate-add.php">
                                        <i class="fa fa-plus"></i> Add Candidate
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- Server-Side Datatable -->
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <div class="table-responsive table-sm">
                        <table id="candidateTable" class="dataTableLoad table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Inquiry ID</th>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th><i class="fa-solid fa-phone"></i> 1</th>
                                    <th><i class="fa-solid fa-phone"></i> 2</th>
                                    <th><i class="fa-solid fa-envelope"></i></th>
                                    <th>Faculty</th>
                                    <th>Level</th>
                                    <th>Program</th>
                                    <th>Last Exam</th>
                                    <th>Last Exam Status</th>
                                    <th>Status</th>
                                    <th>Inquiry Mode</th>
                                    <th>Assign Staff</th>
                                    <th>Confirm By</th>
                                    <th>Assign By</th>
                                    <th>Call Count</th>
                                    <?php $URL_ARRAY = ['approvedinq', 'rejectedinq', 'closedinq', 'approvedbyother'];
                                    if (in_array($url_for, $URL_ARRAY)) { ?>
                                        <th>Remarks</th> <?php } ?>
                                    <?php if ($role_id != 13) { ?>
                                        <th class="">Action</th><?php } ?>
                                    <?php if ($role_id == 57 && $url_for === 'inq') { ?>
                                        <th class="">Admission</th><?php } ?>
                                    <?php if ($role_id != 13) { ?>
                                        <th>Remarks</th><?php } ?>
                                    <?php if ($role_id == 57 && $url_for === 'closedinq') { ?>
                                        <th>Unclose</th><?php } ?>
                                    <?php if ($role_id == 57 && $url_for === 'rejectedinq') { ?>
                                        <th>Open</th><?php } ?>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Inquiry ID</th>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th><i class="fa-solid fa-phone"></i> 1</th>
                                    <th><i class="fa-solid fa-phone"></i> 2</th>
                                    <th><i class="fa-solid fa-envelope"></i></th>
                                    <th>Faculty</th>
                                    <th>Level</th>
                                    <th>Program</th>
                                    <th>Last Exam</th>
                                    <th>Last Exam Status</th>
                                    <th>Status</th>
                                    <th>Inquiry Mode</th>
                                    <th>Assign Staff</th>
                                    <th>Confirm By</th>
                                    <th>Assign By</th>
                                    <th>Call Count</th>
                                    <?php $URL_ARRAY = ['approvedinq', 'rejectedinq', 'closedinq', 'approvedbyother'];
                                    if (in_array($url_for, $URL_ARRAY)) { ?>
                                        <th>Remarks</th>
                                    <?php } ?>
                                    <?php if ($role_id != 13) { ?>
                                        <th class="">Action</th><?php } ?>
                                    <?php if ($role_id == 57 && $url_for === 'inq') { ?>
                                        <th class="">Admission</th><?php } ?>
                                    <?php if ($role_id != 13) { ?>
                                        <th>Remarks</th><?php } ?>
                                    <?php if ($role_id == 57 && $url_for === 'closedinq') { ?>
                                        <th>Unclose</th><?php } ?>
                                    <?php if ($role_id == 57 && $url_for === 'rejectedinq') { ?>
                                        <th>Open</th><?php } ?>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <?php include('include/footer.php'); ?>
        </div>
    </div>


    <!-- CALL STATUS MODAL -->
    <?php
    if ($role_id == 15 || $role_id == 16) {
        ?>
        <!-- CALL STATUS MODAL -->
        <div class="modal fade" id="callStatusModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <form id="callStatusForm" method="POST">

                        <div class="modal-header">
                            <h5 class="modal-title">Add Call Log</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">

                            <!-- Hidden fields (important) -->
                            <input type="hidden" name="tis_id" id="tis_id_modal_openCallStatusModal">
                            <input type="hidden" name="inq_student_id" id="inq_student_id_hidden_openCallStatusModal">

                            <h5>Inquiry ID :</h5>
                            <h5 id="inq_student_id_modal" class="text-primary"></h5>

                            <!-- REMARK -->
                            <?php
                            $remarks = $con->query("SELECT remark 
                                                            FROM tbl_inquiry_calling_short_remarks
                                                            WHERE is_delete = 0 AND is_active = 1
                                                            ORDER BY remark ASC");
                            ?>
                            <div class="form-group mt-3">
                                <label>Remark</label>
                                <select name="remark" id="call_remark_input" class="form-control" required>
                                    <option value="">Choose...</option>

                                    <?php if ($remarks && $remarks->num_rows > 0) { ?>
                                        <?php while ($r = $remarks->fetch_assoc()) { ?>
                                            <option value="<?= htmlspecialchars($r['remark']); ?>">
                                                <?= htmlspecialchars($r['remark']); ?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>

                                </select>
                            </div>


                            <!-- CALL STATUS -->
                            <div class="form-group mt-3">
                                <label>Select Call Status</label>
                                <input name="call_status" id="call_status_input" class="form-control" required readonly>
                                <!-- <select name="call_status" id="call_status_input" class="form-control" required readonly>
                                    <option value="">Choose...</option>
                                    <option value="HOT">HOT</option>
                                    <option value="COLD">COLD</option>
                                    <option value="CLOSE">CLOSE</option>
                                </select> -->
                            </div>

                            <!-- CONVERSATION -->
                            <div class="form-group mt-3">
                                <label>Conversation</label>
                                <select name="conversation" id="conversation_input" class="form-control" required>
                                    <option value="">Choose...</option>
                                </select>
                            </div>


                            <!-- OTHER REMARK    -->
                            <div class="form-group mt-3">
                                <label>Other Remark</label>
                                <input name="other_remark" id="other_remark" class="form-control"
                                    placeholder="Enter other remark (if any)">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="callForm">Save</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <?php
    }

    if ($role_id == 57) {
        ?>
        <!-- INCREASE CALL STATUS MODAL -->
        <div class="modal fade" id="callIncreaseModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <form id="callIncreaseForm" method="POST">

                        <div class="modal-header">
                            <h5 class="modal-title">Increase Call Max Call Count</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">

                            <!-- Hidden fields (important) -->
                            <input type="hidden" name="tis_id" id="tis_id_modal_openCallIncreaseModal">
                            <input type="hidden" name="inq_student_id" id="inq_student_id_hidden_openCallIncreaseModal">

                            <h5>Inquiry ID :</h5>
                            <h5 id="inq_student_id_modal" class="text-primary"></h5>

                            <!-- REMARK -->
                            <div class="form-group mt-3">
                                <label>Call Count</label>
                                <input type="number" name="new_call_count" id="new_call_count" class="form-control"
                                    required>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="callMaxCountForm">Save</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <!-- ADMISSION STATUS UPDATE MODAL -->
        <div class="modal fade" id="admissionStatusUpdateModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="admissionStatusUpdateForm" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">Admission Confirmation</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h5>Are You Sure you want to <span id="admConf"></span> Admission ?</h5>
                            <!-- Hidden fields (important) -->
                            <input type="hidden" name="tis_id" id="tis_id_modal_admissionStatusUpdate">
                            <input type="hidden" name="inq_student_id" id="inq_student_id_hidden_admissionStatusUpdate">
                            <input type="hidden" name="admission_confirmation" id="admission_confirmation">

                            <h5>Inquiry ID :</h5>
                            <h5 id="adm_inq_student_id_modal" class="text-primary"></h5>

                            <!-- REMARK -->
                            <div class="form-group mt-3">
                                <label>Remark</label>
                                <input type="text" name="call_remark" id="call_remark" class="form-control"
                                    placeholder="Enter remark" required>
                            </div>

                            <div class="form-group mt-3" id="staffList">
                                <label>Staff</label>
                                <select class="custom-select" name="staff_id" id="staff_id" required>
                                    <option value="">Choose...</option>
                                    <?php
                                    $result = $con->query("SELECT id, name FROM tbl_staff WHERE is_delete = '0' and is_active='1' and role_id IN(15,16,20)");
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="admissionStatusUpdateFormData">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    <!-- FOLLOWUP REMARK MODAL -->
    <div class="modal fade" id="followupRemarkModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form id="admissionStatusUpdateForm" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Call Followup Remark</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <!-- Basic Call Info -->
                        <div class="mb-3">
                            <div class="col-md-12">
                                <strong>Inquiry Student ID:</strong>
                                <span id="view_inq_student_id">—</span>
                            </div>
                            <!-- <div class="col-md-12">
                                <strong>Total Call Count:</strong>
                                <span id="view_call_count">—</span>
                            </div> -->
                        </div>

                        <hr>

                        <!-- Follow-up History Table -->
                        <h6 class="mb-2">Call Follow-up History</h6>

                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Call By</th>
                                        <th>Call Count</th>
                                        <th>Status</th>
                                        <th>Remark</th>
                                        <th>Other Remark</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody id="followupHistoryTable">
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include('include/script.php'); ?>

    <script>
        $(document).ready(function () {

            $('#candidateTable').DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,

                // scrollX: true,
                scrollCollapse: true,
                autoWidth: false,
                responsive: false,

                order: [], // IMPORTANT for server-side tables

                ajax: {
                    url: './extra/fetch-candidate-data.php',
                    type: 'POST',
                    data: function (d) {
                        d.faculty_id = $('#facultyFilter').val() || '';
                        d.program_id = $('#programFilter').val() || '';
                        d.level_id = $('#levelFilter').val() || '';
                        d.role_id = <?php echo (int) $_SESSION['role_id']; ?>;
                        d.url_for = '<?php echo $url_for; ?>';
                    },
                    dataSrc: function (json) {
                        return json.data || [];
                    }
                },

                columns: [
                    { data: 'sr_no', orderable: false, className: 'text-center' },
                    { data: 'inq_student_id', className: 'text-center' },
                    { data: 'full_name', className: 'text-center' },
                    { data: 'gender', className: 'text-center' },

                    {
                        data: null,
                        className: 'text-center',
                        render: function (data, type, row) {
                            return (row.call_count == row.max_call_count || row.is_closed == 1 || row.is_admission_confirm == -1 || <?php echo (isset($role_id) && $role_id == 14) ? '1' : '0'; ?>)
                                ? '<span class="text-danger"><i class="fa-solid fa-ban"></i></span>'
                                : (row.mobile_number || '-');
                        }
                    },
                    {
                        data: null,
                        className: 'text-center',
                        render: function (data, type, row) {
                            return (row.call_count == row.max_call_count || row.is_closed == 1 || row.is_admission_confirm == -1 || <?php echo (isset($role_id) && $role_id == 14) ? '1' : '0'; ?>)
                                ? '<span class="text-danger"><i class="fa-solid fa-ban"></i></span>'
                                : (row.mobile_number2 || '-');
                        }
                    },
                    {
                        data: null,
                        className: 'text-center',
                        render: function (data, type, row) {
                            return (row.call_count == row.max_call_count || row.is_closed == 1 || row.is_admission_confirm == -1 || <?php echo (isset($role_id) && $role_id == 14) ? '1' : '0'; ?>)
                                ? '<span class="text-danger"><i class="fa-solid fa-ban"></i></span>'
                                : (row.email || '-');
                        }
                    },

                    { data: 'faculty_name', defaultContent: '-', className: 'text-center' },
                    { data: 'level_name', defaultContent: '-', className: 'text-center' },
                    { data: 'program_name', defaultContent: '-', className: 'text-center' },
                    { data: 'last_exam', defaultContent: '-', className: 'text-center' },

                    {
                        data: 'exam_status',
                        className: 'text-center',
                        render: function (data) {
                            return data == 1 ? 'Completed' : 'Pending';
                        }
                    },

                    { data: 'admission_status', defaultContent: 'Pending', className: 'text-center' },
                    { data: 'is_online', defaultContent: '-', className: 'text-center' },
                    { data: 'staff_name', defaultContent: '-', className: 'text-center' },
                    { data: 'confirm_by_name', defaultContent: '-', className: 'text-center' },
                    { data: 'assign_by_name', defaultContent: '-', className: 'text-center' },

                    { data: 'call_count', defaultContent: 0, className: 'text-center' },

                    <?php $URL_ARRAY = ['approvedinq', 'rejectedinq', 'closedinq', 'approvedbyother'];
                    if (in_array($url_for, $URL_ARRAY)) { ?>
                            {
                            data: 'log_remark',
                            className: 'text-center',
                            render: function (data) {
                                return data ? data.replace(/(\r\n|\n|\r)/gm, '') : '';
                            }
                        },
                    <?php } ?>

                    <?php if ($role_id != 13) { ?>{
                            data: 'action',
                            orderable: false,
                            className: 'text-center',
                            render: function (data) {
                                return data ? data.replace(/(\r\n|\n|\r)/gm, '') : '';
                            }
                        }, <?php } ?>

                    <?php if ($role_id == 57 && $url_for === 'inq') { ?>
                            {
                            data: 'admissionBtn',
                            orderable: false,
                            className: 'text-center',
                            render: function (data) {
                                return data ? data.replace(/(\r\n|\n|\r)/gm, '') : '';
                            }
                        },
                    <?php } ?>

                    <?php if ($role_id != 13) { ?>{
                            data: 'followupRemarkBtn',
                            orderable: false,
                            className: 'text-center',
                            render: function (data) {
                                return data ? data.replace(/(\r\n|\n|\r)/gm, '') : '';
                            }
                        },
                    <?php } ?>

                     <?php if ($role_id == 57 && $url_for === 'closedinq') { ?>
                            {
                            data: 'unCloseInq',
                            orderable: false,
                            className: 'text-center',
                            render: function (data) {
                                return data ? data.replace(/(\r\n|\n|\r)/gm, '') : '';
                            }
                        },
                    <?php } ?>

                     <?php if ($role_id == 57 && $url_for === 'rejectedinq') { ?>
                            {
                            data: 'openInq',
                            orderable: false,
                            className: 'text-center',
                            render: function (data) {
                                return data ? data.replace(/(\r\n|\n|\r)/gm, '') : '';
                            }
                        },
                    <?php } ?>
                ],

                <?php if ($role_id == 57) { ?>
                        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                <?php } else { ?>
                        lengthMenu: [[10], [10]],
                <?php } ?>

                language: {
                    info: "_START_ - _END_ of _TOTAL_ entries",
                    searchPlaceholder: "Search"
                },

                // dom: '<"d-flex justify-content-between"Blf>rtip',
                <?php if ($role_id == 57) { ?>
                        dom: '<"d-flex justify-content-between"Blf>rtip',
                    buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
                    <?php } elseif ($role_id == 15 || $role_id == 16) { ?>
                        dom: '<"d-flex justify-content-between"Blf>rtip',
                    buttons: ["pdf", "print", "colvis"]
                    <?php } else { ?>
                        dom: '<"d-flex justify-content-between"lf>rtip'
                <?php } ?>
            });

        });
    </script>


    <?php
    if ($role_id == 15 || $role_id == 16) {
        ?>
        <script>
            function openCallStatusModal(tis_id, inq_student_id) {
                window.call_tis_id = tis_id;
                window.call_inq_student_id = inq_student_id;

                // Clear old values
                document.getElementById("call_status_input").value = "";
                document.getElementById("call_remark_input").value = "";
                document.getElementById("tis_id_modal_openCallStatusModal").value = tis_id;
                document.getElementById("inq_student_id_hidden_openCallStatusModal").value = inq_student_id;
                document.getElementById("inq_student_id_modal").innerText = inq_student_id;

                // Open modal
                $('#callStatusModal').modal('show');
            }
        </script>
        <script>
            document.getElementById('call_remark_input').addEventListener('change', function () {

                const remark = this.value;
                const statusSelect = document.getElementById('call_status_input');
                const conversationSelect = document.getElementById('conversation_input');

                // Reset
                statusSelect.value = '';
                conversationSelect.innerHTML = '<option value="">Choose...</option>';

                if (!remark) return;

                fetch('./extra/get-remark-details.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'remark=' + encodeURIComponent(remark)
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status) {

                            // 1️⃣ Auto select HOT / COLD / CLOSED
                            statusSelect.value = data.category;

                            // 2️⃣ Fill conversations
                            data.conversations.forEach(row => {
                                const opt = document.createElement('option');
                                opt.value = row.conversation;
                                opt.textContent = row.conversation;
                                conversationSelect.appendChild(opt);
                            });
                        }
                    });
            });
        </script>

        <?php
    }
    if ($role_id == 57) {
        ?>
        <script>
            function openCallIncreaseModal(tis_id, inq_student_id) {
                window.call_tis_id = tis_id;
                window.call_inq_student_id = inq_student_id;

                document.getElementById("new_call_count").value = "";
                document.getElementById("tis_id_modal_openCallIncreaseModal").value = tis_id;
                document.getElementById("inq_student_id_hidden_openCallIncreaseModal").value = inq_student_id;
                document.getElementById("inq_student_id_modal").innerText = inq_student_id;

                // Open modal
                $('#callIncreaseModal').modal('show');
            }

            function admissionStatusUpdate(tis_id, inq_student_id, status) {
                window.call_tis_id = tis_id;
                window.call_inq_student_id = inq_student_id;
                // console.log("ID sending:", inq_student_id);

                // always set hidden fields
                document.getElementById("tis_id_modal_admissionStatusUpdate").value = tis_id;
                document.getElementById("inq_student_id_hidden_admissionStatusUpdate").value = inq_student_id;
                document.getElementById("adm_inq_student_id_modal").innerText = inq_student_id;
                document.getElementById("call_remark").value = "";
                document.getElementById("staff_id").value = "";

                if (status === 1) {

                    // 👇 Call API BEFORE confirming
                    $.ajax({
                        url: './extra/check_admission_requirements.php?inq_student_id=' + inq_student_id,
                        type: "GET",
                        success: function (res) {
                            // console.log(res);
                            // let res = JSON.parse(response);

                            if (res.status === "ok") {
                                // All required fields are filled → allow confirmation

                                document.getElementById("admConf").innerText = "CONFIRM";
                                document.getElementById("admConf").classList.add("text-success");
                                document.getElementById("staffList").classList.remove("d-none");
                                document.getElementById("staff_id").required = true;
                                document.getElementById("admission_confirmation").value = 1;

                                // open modal
                                $('#admissionStatusUpdateModal').modal('show');
                            }
                            else {
                                $(function () {
                                    swal({
                                        title: 'Missing Information',
                                        text: res.message + ' kindly fill that fileds firstly !!!',
                                        type: 'error',
                                        showCancelButton: false,
                                        confirmButtonClass: 'btn btn-success',
                                        confirmButtonText: 'OK'
                                    });
                                });
                            }
                        }
                    });

                    return; // stop execution until API responds
                }
                else {
                    // REJECT ADMISSION SIDE
                    document.getElementById("admConf").innerText = "REJECT";
                    document.getElementById("admConf").classList.add("text-danger");
                    document.getElementById("staffList").classList.add("d-none");
                    document.getElementById("staff_id").required = false;
                    document.getElementById("admission_confirmation").value = 0;

                    $('#admissionStatusUpdateModal').modal('show');
                }


            }

        </script>
        <?php
    }
    ?>

    <script>
        function followupRemarkModal(tis_id, inq_student_id) {

            // 1️⃣ Clear previous table rows COMPLETELY
            const $tbody = $('#followupHistoryTable');
            $tbody.empty();

            document.getElementById("view_inq_student_id").innerText = inq_student_id;

            // Optional: show loading row
            $tbody.append(`
            <tr id="loadingRow">
                <td colspan="6" class="text-center">Loading...</td>
            </tr>
        `);

            // 2️⃣ Show modal
            $('#followupRemarkModal').modal('show');

            // 3️⃣ API Call
            $.ajax({
                url: './extra/get-followup-remarks.php', // change to your API
                type: 'POST',
                dataType: 'json',
                data: {
                    tis_id: tis_id,
                    inq_student_id: inq_student_id
                },
                success: function (res) {

                    // Clear loading / old data
                    $tbody.empty();

                    if (!res.success || !res.data || res.data.length === 0) {
                        $tbody.append(`
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No follow-up data found
                            </td>
                        </tr>
                    `);
                        return;
                    }

                    // 4️⃣ Append FULL <tr> blocks
                    res.data.forEach((row, index) => {
                        $tbody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${row.call_by}</td>
                            <td>${row.call_count}</td>
                            <td>${row.call_status}</td>
                            <td>${row.call_remark}</td>
                            <td>${row.other_remark}</td>
                            <td>${row.created_at}</td>
                        </tr>
                    `);
                    });
                },
                error: function () {
                    $tbody.empty();
                    $tbody.append(`
                    <tr>
                        <td colspan="6" class="text-center text-danger">
                            Something went wrong while loading data
                        </td>
                    </tr>
                `);
                }
            });
        }
    </script>

    <?php if ($role_id == 57 && $url_for == 'closedinq') { ?>
        <script>
            function unCloseInqModal(tis_id, inq_student_id) {

                swal({
                    title: 'Are you sure?',
                    text: "This Inquiry will be un-closed!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success margin-5',
                    cancelButtonClass: 'btn btn-danger margin-5',
                    confirmButtonText: 'Yes, re-open inquiry!',
                    cancelButtonText: 'No, cancel!',
                    buttonsStyling: false
                }).then(function (result) {

                    if (result.value) {

                        // ✅ POST to SAME PAGE
                        $.ajax({
                            url: '', // same page
                            type: 'POST',
                            data: {
                                action: 'unclose_inquiry',
                                tis_id: tis_id,
                                inq_student_id: inq_student_id
                            },
                            success: function (response) {
                                swal(
                                    'Re-opened!',
                                    'The inquiry has been un-closed successfully.',
                                    'success'
                                ).then(() => {
                                    location.reload(); // optional
                                });
                            },
                            error: function () {
                                swal(
                                    'Error!',
                                    'Something went wrong. Please try again.',
                                    'error'
                                );
                            }
                        });

                    } else if (result.dismiss === 'cancel') {

                        swal(
                            'Cancelled',
                            'The inquiry is still closed :)',
                            'error'
                        );
                    }
                });
            }
        </script>

    <?php } ?>

    <?php if ($role_id == 57 && $url_for == 'rejectedinq') { ?>
        <script>
            function openInqModal(tis_id, inq_student_id) {

                swal({
                    title: 'Are you sure?',
                    text: "This Inquiry will be re-opened!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success margin-5',
                    cancelButtonClass: 'btn btn-danger margin-5',
                    confirmButtonText: 'Yes, re-open inquiry!',
                    cancelButtonText: 'No, cancel!',
                    buttonsStyling: false
                }).then(function (result) {

                    if (result.value) {

                        // ✅ POST to SAME PAGE
                        $.ajax({
                            url: '', // same page
                            type: 'POST',
                            data: {
                                action: 'open_inquiry',
                                tis_id: tis_id,
                                inq_student_id: inq_student_id
                            },
                            success: function (response) {
                                swal(
                                    'Re-opened!',
                                    'The inquiry has been re-opened successfully.',
                                    'success'
                                ).then(() => {
                                    location.reload(); // optional
                                });
                            },
                            error: function () {
                                swal(
                                    'Error!',
                                    'Something went wrong. Please try again.',
                                    'error'
                                );
                            }
                        });

                    } else if (result.dismiss === 'cancel') {

                        swal(
                            'Cancelled',
                            'The inquiry is still closed :)',
                            'error'
                        );
                    }
                });
            }
        </script>

    <?php } ?>



</body>

</html>