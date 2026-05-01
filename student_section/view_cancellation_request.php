<?php include './include/checklogin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_account_status') {
    $tcrId = intval($_POST['tcrId']);
    $status = $_POST['status'];
    $remark = trim($_POST['remark']);
    $studentId = intval($_POST['studentId']);

    $stmt = $con->prepare("UPDATE tbl_cancellation_requests SET eligibility_status = ?, eligibility_remark = ?, eligibility_at = NOW(), updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("ssi", $status, $remark, $tcrId);

    $stmt1 = $con->prepare("UPDATE tbl_admission_student SET is_active = 0, is_delete = 1 WHERE id = ?");
    $stmt1->bind_param("i", $studentId);

    if ($stmt->execute() && $stmt1->execute()) {
        $_SESSION['status'] = "Cancellation request Approved !";
        $_SESSION['status_code'] = "success";
        echo "success"; // ✅ Required for AJAX
        // echo "<script>setTimeout(function(){window.location='view_branch_request.php'},3000)</script>";
    } else {
        $_SESSION['status'] = "Error submitting Cancellation request: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        echo "error"; // ✅ Also required for AJAX
    }


    $stmt->close();
    // ✅ This is critical to stop loading the rest of the page!
    exit;
}

$stmt = $con->prepare("
SELECT
    tcr.id AS tcr_id,
    tpf.formno,
    tcr.student_id,
    tpf.studentName,
    f.name AS faculty_name,
    l.name AS level_name,
    p.name AS program_name,
    tcr.hod_status,
    tcr.cluster_status,
    tcr.account_status,
    tcr.eligibility_status,
    tcr.is_refund_required
FROM
    tbl_cancellation_requests AS tcr
JOIN tbl_pac_form AS tpf
ON
    tcr.student_id = tpf.student_id
JOIN tbl_admission_student AS tas
ON
    tpf.student_id = tas.id
JOIN tbl_faculty AS f
ON
    f.id = tas.faculty_id
JOIN tbl_level AS l
ON
    l.id = tas.level_id
JOIN tbl_program AS p
ON
    p.id = tas.program_id
WHERE
    tcr.is_active = 1 AND tcr.is_delete = 0 AND tcr.hod_status = ? AND tcr.cluster_status = ? AND account_status = ?
");
$hod_status = "approved";
$cluster_status = "approved";
$account_status = "approved";
$stmt->bind_param("sss", $hod_status, $cluster_status, $account_status);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include './include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include './include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include './include/importsidebar.php'; ?>
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
                                    <h3 class="card-title">Cancellation Details</h3>
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
                                                    <th>Faculty</th>
                                                    <th>Level</th>
                                                    <th>Program</th>
                                                    <th>Hod Status</th>
                                                    <th>Cluster Admin Status</th>
                                                    <th>Accounts Status</th>
                                                    <th>Eligibility Section Status</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        $formatted_id = '2025/' . str_pad($row['formno'], 4, '0', STR_PAD_LEFT);

                                                        echo "<td>" . htmlspecialchars($formatted_id) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['studentName']) . "</td>";
                                                        echo "<td>" . html_entity_decode($row['faculty_name']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['level_name']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['program_name']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['hod_status']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['cluster_status']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['account_status']) . "</td>";
                                                        echo "<td>";
                                                        $status = $row['eligibility_status'];

                                                        if ($status === 'pending') {
                                                            echo "<button class='btn btn-success btn-sm change-eligibility-status' data-id='" . $row['tcr_id'] . "' data-studentid='" . $row['student_id'] . "' data-status='Approved' title='Approve'>
                                                              <i class='fa fa-check'></i></button>";
                                                            echo "<button class='btn btn-danger btn-sm change-eligibility-status' data-id='" . $row['tcr_id'] . "' data-studentid='" . $row['student_id'] . "' data-status='Rejected' title='Reject'>
                                                              <i class='fa fa-times'></i></button>";
                                                        } elseif ($status === 'rejected') {
                                                            // echo "<button class='btn btn-success btn-sm change-eligibility-status' data-id='" . $row['tcr_id'] . "' data-studentid='" . $row['student_id'] . "' data-status='Approved' title='Approve'>
                                                            //    <i class='fa fa-check'></i> </button>";
                                                            echo "Rejected";
                                                        } elseif ($status === 'approved') { // status is 'approved'
                                                            // if ($eligibility_status !== 'approved') {
                                                            //     echo "<button class='btn btn-danger btn-sm change-eligibility-status' data-id='" . $row['tcr_id'] . "' data-status='Rejected' title='Reject'>
                                                            //     <i class='fa fa-times'></i> </button>";
                                                            // }
                                                            // echo "<button class='btn btn-danger btn-sm change-eligibility-status' data-id='" . $row['tcr_id'] . "' data-studentid='" . $row['student_id'] . "' data-status='Rejected' title='Reject'>
                                                            //     <i class='fa fa-times'></i> </button>";
                                                            echo "Approved";
                                                        }

                                                        echo "</td>";
                                                        echo "<td><a href='view_cancellation_detail.php?id=" . $row['tcr_id'] . "' class='btn btn-primary'>View</a></td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='10' class='text-center'>No records found.</td></tr>";
                                                }
                                                ?>
                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <th>PAC Form No</th>
                                                    <th>Student ID</th>
                                                    <th>Student Name</th>
                                                    <th>Faculty</th>
                                                    <th>Level</th>
                                                    <th>Program</th>
                                                    <th>Hod Status</th>
                                                    <th>Cluster Admin Status</th>
                                                    <th>Accounts Status</th>
                                                    <th>Eligibility Section Status</th>
                                                    <th>View</th>
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

        <?php include '../include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- HOD Approval Modal -->
    <div class="modal fade" id="hodStatusModal" tabindex="-1" role="dialog" aria-labelledby="hodStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="hodStatusModalLabel">Confirm Action</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to <strong id="modal-action-text"></strong> this cancellation request?
                    <div class="form-group">
                        <label for="hod-remark">Add Remark (optional):</label>
                        <textarea id="hod-remark" class="form-control" rows="3"
                            placeholder="Enter remark here..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="modal-cancellation-id">
                    <input type="hidden" id="modal-new-status">
                    <input type="hidden" id="modal-student-id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="confirmHodAction" type="button" class="btn btn-primary">Yes, Confirm</button>
                </div>
            </div>
        </div>
    </div>


    <?php include './include/importjs.php'; ?>
    <script>
        $(document).on('click', '.change-eligibility-status', function () {
            var tcrId = $(this).data('id');
            var newStatus = $(this).data('status');
            var studentId = $(this).data('studentid');

            // Set modal hidden inputs and message
            $('#modal-cancellation-id').val(tcrId);
            $('#modal-new-status').val(newStatus);
            $('#modal-action-text').text(newStatus);
            $('#modal-student-id').val(studentId);

            // Clear any previous remark
            $('#hod-remark').val('');

            // Show the modal
            $('#hodStatusModal').modal('show');
        });

        // Confirm button click inside modal
        $('#confirmHodAction').click(function () {
            var tcrId = $('#modal-cancellation-id').val();
            var newStatus = $('#modal-new-status').val();
            var remark = $('#hod-remark').val();
            var studentId = $('#modal-student-id').val();

            $.ajax({
                url: '', // same page
                type: 'POST',
                data: {
                    action: 'update_account_status',
                    tcrId: tcrId,
                    status: newStatus,
                    remark: remark,
                    studentId: studentId,
                },
                success: function (response) {
                    if (response.trim() === 'success') {
                        location.reload();
                    } else {
                        Swal.fire("Error", "Request failed. Try again.", "error");
                        console.log(response);
                    }
                },
                error: function () {
                    Swal.fire("Error", "Something went wrong.", "error");
                    console.log(response);
                }
            });

            // Close the modal
            $('#hodStatusModal').modal('hide');
        });
    </script>


</body>

</html>