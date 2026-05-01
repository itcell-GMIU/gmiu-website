<?php include 'include/checklogin.php'; ?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pac_id = isset($_POST['pac_id']) ? $_POST['pac_id'] : null;
    // echo "<script>alert('" . $pac_id . "')</script>";
    // exit;
    // $student_id = $pac_id;
    $combinedValue = isset($_POST['pac_id']) ? $_POST['pac_id'] : null;
    list($formno, $student_id, $pac_id) = explode('|', $combinedValue);
    $remark = isset($_POST['remark']) ? $_POST['remark'] : null;

    $handwritten_file = '';

    // Handle handwritten file upload
    if (isset($_FILES['handwritten_file']) && $_FILES['handwritten_file']['error'] === 0) {
        $uploadDir = "uploads/handwritten/";

        // ✅ Check if folder exists, if not — create it (with permissions)
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // true enables recursive directory creation
        }

        $handwritten_name = uniqid() . "_" . basename($_FILES["handwritten_file"]["name"]);
        $handwritten_path = $uploadDir . $handwritten_name;

        if (move_uploaded_file($_FILES["handwritten_file"]["tmp_name"], $handwritten_path)) {
            $handwritten_file = $handwritten_name;
        }
    }

    // Insert into cancellation_requests
    $stmt = $con->prepare("
        INSERT INTO tbl_cancellation_requests 
        (student_id, pac_id, handwritten_file, followup_remark, followup_at, is_active, is_delete, created_at, updated_at)
        VALUES (?, ?, ?, ?, NOW(), 1, 0, NOW(), NOW())
    ");

    $stmt->bind_param(
        "isss",
        $student_id,
        $pac_id,
        $handwritten_file,
        $remark
    );

    if ($stmt->execute()) {
        $_SESSION['status'] = "Cancellation request submitted successfully!";
        $_SESSION['status_code'] = "success";
        // echo "<script>setTimeout(function(){window.location='view_cancellation_requests.php'}, 1500);</script>";
    } else {
        $_SESSION['status'] = "Error: " . $stmt->error;
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
                            <h1 class="m-0">Cancellation Request</h1>
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
                                        $sql = "SELECT DISTINCT pac.pacid, pac.formno, pac.student_id, pac.studentName
                                                FROM tbl_pac_form AS pac
                                                WHERE pac.is_delete = 0
                                                AND pac.pacid NOT IN (
                                                    SELECT pac_id FROM tbl_cancellation_requests
                                                )";
                                        $result = $con->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            $padded_formno = str_pad($row['formno'], 4, '0', STR_PAD_LEFT);
                                            ?>
                                            <option
                                                value="<?= $row['formno'] . '|' . $row['student_id'] . '|' . $row['pacid'] ?>">
                                                2025/<?= str_pad($row['formno'], 4, '0', STR_PAD_LEFT) ?>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <?= $row['studentName']; ?>
                                            </option>
                                            <?php
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
                                                <td><b>Upload Handwritten Request</b></td>
                                                <td>
                                                    <input type="file" name="handwritten_file" accept="image/*"
                                                        class="form-control" required>
                                                    <small class="text-muted">Accepted formats: JPG, PNG. Max size:
                                                        2MB</small>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> <label for="remark">Remark</label> </td>
                                                <td>
                                                    <textarea name="remark" id="remark" rows="3" class="form-control"
                                                        required></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="submit" name="submitBtn" class="btn btn-primary"
                                                        value="Submit Transfer Request">
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

    <script>
        $(document).ready(function () {
            $('#pac_id').select2({
                placeholder: "-- Select PAC ID --",
                allowClear: true
            });

            // Fetch student details when PAC ID is selected
            $('#pac_id').on('change', function () {
                const value = $(this).val();
                let studentId = '';
                if (value) {
                    const [formno, student_id, pac_id] = value.split('|');
                    studentId = student_id;
                    // console.log("Form No:", formno);
                    // console.log("Student ID:", student_id);
                    // console.log("PAC ID:", pac_id);
                } else {
                    // console.log("Nothing selected");
                }

                if (studentId) {
                    $.ajax({
                        url: 'fetch_student_details.php',
                        type: 'GET',
                        data: { student_id: studentId },
                        dataType: 'json',
                        success: function (data) {
                            if (data) {
                                $('#gr_number').text(data.gr_number || 'N/A');
                                $('#faculty').text(data.faculty_name || 'N/A');
                                $('#level').text(data.level_name || 'N/A');
                                $('#program').text(data.program_name || 'N/A');
                                $('#student-data-section').slideDown(); // show the section
                            } else {
                                Swal.fire('Error', 'Student data not found.', 'error');
                                $('#student-data-section').hide();
                            }
                        },
                        error: function () {
                            Swal.fire('Error', 'Failed to fetch student data.', 'error');
                            $('#student-data-section').hide();
                        }
                    });
                } else {
                    $('#student-data-section').hide();
                }
            });
        });
    </script>

</body>

</html>