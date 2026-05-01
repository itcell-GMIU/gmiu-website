<?php include './include/checklogin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_ss_status') {
    $pacid = intval($_POST['student_id']);
    $status = $_POST['status'];
    $remark = $_POST['remark'];

    // Fetch transfer request details
    $stmt = $con->prepare("SELECT * FROM tbl_branch_transfer_requests WHERE id = ?");
    $stmt->bind_param("i", $pacid);
    $stmt->execute();
    $transfer = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$transfer) {
        $_SESSION['status'] = "Error: Transfer request not found!";
        $_SESSION['status_code'] = "error";
        echo "error";
        exit;
    }

    $student_id = $transfer['student_id'];
    $new_faculty_id = $transfer['faculty_id'];
    $new_program_id = $transfer['program_id'];
    $new_level_id = $transfer['level_id'];
    $new_mode = $transfer['new_mode'];
    $new_quota = $transfer['new_quota'];

    // Fetch old data
    $stmt = $con->prepare("SELECT faculty_id, program_id, level_id FROM tbl_admission_student WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $old_admission_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $stmt = $con->prepare("SELECT mode, quota FROM tbl_pac_form WHERE student_id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $old_pac_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // Check if old data exists (fail-safe)
    if (!is_array($old_admission_data) || !is_array($old_pac_data)) {
        $_SESSION['status'] = "Error: Student's old data not found!";
        $_SESSION['status_code'] = "error";
        echo "error";
        exit;
    }

    if (strtolower($status) === 'approved') {
        // Save old_data JSON in the request row
        $old_data_json = json_encode([
            'admission_student' => $old_admission_data,
            'pac_form' => $old_pac_data
        ]);

        $stmt = $con->prepare("UPDATE tbl_branch_transfer_requests SET student_section_approval = ?, s_remark = ?, old_data = ? WHERE id = ?");
        $stmt->bind_param("sssi", $status, $remark, $old_data_json, $pacid);
        $success = $stmt->execute();
        $stmt->close();

        if (!$success) {
            $_SESSION['status'] = "Error: Failed to approve transfer request.";
            $_SESSION['status_code'] = "error";
            echo "error";
            exit;
        }

        // Update tbl_admission_student with new data
        if (!empty($new_faculty_id) || !empty($new_program_id) || !empty($new_level_id)) {
            $update_fields = [];
            $params = [];
            $types = "";

            if (!empty($new_faculty_id)) {
                $update_fields[] = "faculty_id = ?";
                $params[] = $new_faculty_id;
                $types .= "i";
            }
            if (!empty($new_program_id)) {
                $update_fields[] = "program_id = ?";
                $params[] = $new_program_id;
                $types .= "i";
            }
            if (!empty($new_level_id)) {
                $update_fields[] = "level_id = ?";
                $params[] = $new_level_id;
                $types .= "i";
            }

            $params[] = $student_id;
            $types .= "i";

            $sql = "UPDATE tbl_admission_student SET " . implode(", ", $update_fields) . " WHERE id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $stmt->close();
        }

        // Update tbl_pac_form with new data
        if (!empty($new_mode) || !empty($new_quota)) {
            $update_fields = [];
            $params = [];
            $types = "";

            if (!empty($new_mode)) {
                $update_fields[] = "mode = ?";
                $params[] = $new_mode;
                $types .= "s";
            }
            if (!empty($new_quota)) {
                $update_fields[] = "quota = ?";
                $params[] = $new_quota;
                $types .= "s";
            }

            $params[] = $student_id;
            $types .= "i";

            $sql = "UPDATE tbl_pac_form SET " . implode(", ", $update_fields) . ", updated_at = NOW() WHERE student_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $stmt->close();
        }
    } elseif (strtolower($status) === 'rejected') {
        // Update status only
        $stmt = $con->prepare("UPDATE tbl_branch_transfer_requests SET student_section_approval = ?, s_remark = ? WHERE id = ?");
        $stmt->bind_param("ssi", $status, $remark, $pacid);
        $stmt->execute();
        $stmt->close();

        // Restore old data back to tbl_admission_student
        if (is_array($old_admission_data)) {
            $stmt = $con->prepare("UPDATE tbl_admission_student SET faculty_id = ?, program_id = ?, level_id = ? WHERE id = ?");
            $stmt->bind_param(
                "iiii",
                $old_admission_data['faculty_id'],
                $old_admission_data['program_id'],
                $old_admission_data['level_id'],
                $student_id
            );
            $stmt->execute();
            $stmt->close();
        }

        // Restore old data back to tbl_pac_form
        if (is_array($old_pac_data)) {
            $stmt = $con->prepare("UPDATE tbl_pac_form SET mode = ?, quota = ?, updated_at = NOW() WHERE student_id = ?");
            $stmt->bind_param(
                "ssi",
                $old_pac_data['mode'],
                $old_pac_data['quota'],
                $student_id
            );
            $stmt->execute();
            $stmt->close();
        }
    }

    $_SESSION['status'] = "Transfer request updated successfully!";
    $_SESSION['status_code'] = "success";
    echo "success";
    exit;
}



$stmt = $con->prepare("
    SELECT 
        pac.pacid as id,
        btr.student_id,
        btr.id as b_id,
        pac.studentName AS student_name,
        f.name as faculty_name,
        l.name as level_name,
        p.name as program_name,
        btr.new_mode,
        btr.new_quota,
        btr.hod_approval,
        btr.clusteradmin_approval,
        btr.account_approval,
        btr.student_section_approval,
        btr.is_active,
        btr.is_delete,
        btr.created_at,
        btr.updated_at
    FROM tbl_branch_transfer_requests AS btr
    INNER JOIN tbl_pac_form AS pac ON pac.student_id = btr.student_id
    LEFT JOIN tbl_faculty AS f ON f.id = btr.faculty_id
    LEFT JOIN tbl_level AS l ON l.id = btr.level_id
    LEFT JOIN tbl_program AS p ON p.id = btr.program_id
    WHERE btr.is_delete = 0
    AND btr.clusteradmin_approval = 'approved' 
    AND btr.hod_approval = 'approved' 
    AND (
        btr.program_id IS NULL -- skip account_approval
        OR btr.account_approval = 'approved' -- required only if program_id is null
    )
    ORDER BY btr.created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();


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
                            <h1 class="m-0">View All Details</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View All Details</li>
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
                                <div class="card-header">
                                    <h3 class="card-title">PAC Form Details</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">

                                            <thead>
                                                <tr>
                                                    <th>PAC Form No</th>
                                                    <th>Student ID</th>
                                                    <th>Student Name</th>
                                                    <th>Requested Faculty</th>
                                                    <th>Requested Level</th>
                                                    <th>Requested Program</th>
                                                    <!--<th>Requested Quota</th>-->
                                                    <th>Requested Mode</th>
                                                    <th>Hod Approval</th>
                                                    <th>Cluster Admin Approval</th>
                                                    <th>Accounts Approval</th>
                                                    <th>Student Section Approval</th>
                                                    <th>View</th>
                                                    <!-- <th>View</th>
                                                    <th>Edit</th> -->
                                                    <!-- <th>Delete</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($result->num_rows > 0): ?>
                                                    <?php while ($row = $result->fetch_assoc()): ?>
                                                        <tr align="center">
                                                            <?php
                                                            $formatted_id = '2025 / ' . str_pad($row['id'], 4, '0', STR_PAD_LEFT);
                                                            ?>
                                                            <td><?= htmlspecialchars($formatted_id) ?></td>
                                                            <td><?= htmlspecialchars($row['student_id']) ?></td>
                                                            <td><?= htmlspecialchars($row['student_name']) ?></td>
                                                            <td><?= htmlspecialchars($row['faculty_name']) ?></td>
                                                            <td><?= htmlspecialchars($row['level_name']) ?></td>
                                                            <td><?= htmlspecialchars($row['program_name']) ?></td>
                                                            <!--<td><?//= htmlspecialchars($row['new_quota']) ?></td>-->
                                                            <td><?= htmlspecialchars($row['new_mode']) ?></td>
                                                            <td><?= htmlspecialchars($row['hod_approval']) ?></td>
                                                            <td><?= htmlspecialchars($row['clusteradmin_approval']) ?></td>
                                                            <td><?= htmlspecialchars($row['account_approval']) ?></td>

                                                            <td>
                                                                <?php if ($row['student_section_approval'] === 'pending'): ?>
                                                                    <button class="btn btn-success btn-sm change-ss-status" data-id="<?= $row['b_id'] ?>" data-status="Approved" title="Approve">
                                                                        <i class="fa fa-check"></i>
                                                                    </button>
                                                                    <button class="btn btn-danger btn-sm change-ss-status" data-id="<?= $row['b_id'] ?>" data-status="Rejected" title="Reject">
                                                                        <i class="fa fa-times"></i>
                                                                    </button>
                                                                <?php elseif ($row['student_section_approval'] === 'rejected'): ?>
                                                                    <button class="btn btn-success btn-sm change-ss-status" data-id="<?= $row['b_id'] ?>" data-status="Approved" title="Approve">
                                                                        <i class="fa fa-check"></i>
                                                                    </button>
                                                                <?php else: // Approved 
                                                                ?>
                                                                    <?= htmlspecialchars($row['student_section_approval']) ?>
                                                                <?php endif; // Approved 
                                                                ?>
                                                            </td>
                                                            <td><a href="detail_branch_request.php?id=<?= $row['b_id'] ?>" class='btn btn-primary'>View</a></td>";

                                                        </tr>
                                                    <?php endwhile; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="12" class="text-center">No records found.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>


                                            <tfoot>
                                                <tr>
                                                    <th>PAC Form No</th>
                                                    <th>Student ID</th>
                                                    <th>Student Name</th>
                                                    <th>Requested Faculty</th>
                                                    <th>Requested Level</th>
                                                    <th>Requested Program</th>
                                                    <!--<th>Requested Quota</th>-->
                                                    <th>Requested Mode</th>
                                                    <th>Hod Approval</th>
                                                    <th>Cluster Admin Approval</th>
                                                    <th>Accounts Approval</th>
                                                    <th>Student Section Approval</th>
                                                    <th>View</th>
                                                    <!-- <th>View</th>
                                                    <th>Edit</th> -->
                                                    <!-- <th>Delete</th> -->
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <div class="modal fade" id="hodStatusModal" tabindex="-1" role="dialog" aria-labelledby="hodStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="hodStatusModalLabel">Confirm Action</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to <strong id="modal-action-text"></strong> this transfer request?
                    <div class="form-group">
                        <label for="account-remark">Add Remark (optional):</label>
                        <textarea id="account-remark" class="form-control" rows="3" placeholder="Enter remark here..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="modal-student-id">
                    <input type="hidden" id="modal-new-status">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="confirmHodAction" type="button" class="btn btn-primary">Yes, Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'include/importjs.php'; ?>
    <script>
        $(document).on('click', '.change-ss-status', function() {
            var pacId = $(this).data('id');
            var newStatus = $(this).data('status');

            // Set modal hidden inputs and message
            $('#modal-student-id').val(pacId);
            $('#modal-new-status').val(newStatus);
            $('#modal-action-text').text(newStatus);

            // Clear any previous remark
            $('#account-remark').val('');

            // Show the modal
            $('#hodStatusModal').modal('show');
        });

        // Confirm button click inside modal
        $('#confirmHodAction').click(function() {
            var pacId = $('#modal-student-id').val();
            var newStatus = $('#modal-new-status').val();
            var remark = $('#account-remark').val();

            $.ajax({
                url: '', // same page
                type: 'POST',
                data: {
                    action: 'update_ss_status',
                    student_id: pacId,
                    status: newStatus,
                    remark: remark
                },
                success: function(response) {
                    // console.log("Raw AJAX Response:", response); // Add this

                    if (response.trim() === 'success') {
                        location.reload(); // reload to show SweetAlert from session
                    } else {
                        Swal.fire("Error", "Request failed. Try again.", "error");
                    }
                },
                error: function() {
                    Swal.fire("Error", "Something went wrong.", "error");
                }
            });
            // Close the modal
            $('#hodStatusModal').modal('hide');
        });
    </script>


</body>

</html>