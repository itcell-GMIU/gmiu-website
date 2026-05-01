<?php include './include/checklogin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_hod_status') {
    $pacid = intval($_POST['student_id']);
    $status = $_POST['status'];

    $stmt = $con->prepare("UPDATE tbl_branch_transfer_requests SET hod_approval = ?, updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("si", $status, $pacid);
    if ($stmt->execute()) {
        $_SESSION['status'] = "Transfer request Approved !";
        $_SESSION['status_code'] = "success";
        echo "success"; // ✅ Required for AJAX
        // echo "<script>setTimeout(function(){window.location='view_branch_request.php'},3000)</script>";
    } else {
        $_SESSION['status'] = "Error submitting transfer request: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        echo "error"; // ✅ Also required for AJAX
    }


    $stmt->close();
    // ✅ This is critical to stop loading the rest of the page!
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
                                                    <th>Requested Quota</th>
                                                    <th>Requested Mode</th>
                                                    <th>Hod Approval</th>
                                                    <th>Cluster Admin Approval</th>
                                                    <th>Accounts Approval</th>
                                                    <th>Student Section Approval</th>
                                                    <!-- <th>View</th>
                                                    <th>Edit</th> -->
                                                    <!-- <th>Delete</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        $formatted_id = '2025/' . str_pad($row['id'], 3, '0', STR_PAD_LEFT);

                                                        echo "<td>" . htmlspecialchars($formatted_id) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['faculty_name']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['level_name']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['program_name']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['new_quota']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['new_mode']) . "</td>";
                                                        echo "<td>";
                                                        $status = $row['hod_approval'];
                                                        $clusterStatus = $row['clusteradmin_approval']; // Get the cluster admin approval status

                                                        if ($status === 'pending') {
                                                            echo "<button class='btn btn-success btn-sm change-hod-status' data-id='" . $row['b_id'] . "' data-status='Approved' title='Approve'>
                                                              <i class='fa fa-check'></i></button>";
                                                            echo "<button class='btn btn-danger btn-sm change-hod-status' data-id='" . $row['b_id'] . "' data-status='Rejected' title='Reject'>
                                                              <i class='fa fa-times'></i></button>";
                                                        } elseif ($status === 'rejected') {
                                                            echo "<button class='btn btn-success btn-sm change-hod-status' data-id='" . $row['b_id'] . "' data-status='Approved' title='Approve'>
                                                               <i class='fa fa-check'></i> </button>";
                                                        } else { // status is 'approved'
                                                            if ($clusterStatus !== 'approved') {
                                                                echo "<button class='btn btn-danger btn-sm change-hod-status' data-id='" . $row['b_id'] . "' data-status='Rejected' title='Reject'>
                                                                <i class='fa fa-times'></i> </button>";
                                                            }
                                                        }

                                                        echo "</td>";

                                                        echo "<td>" . htmlspecialchars($row['clusteradmin_approval']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['account_approval']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['student_section_approval']) . "</td>";
                                                        // echo "<td><a href='view_pac.php?id=" . urlencode($row['student_id']) . "' class='btn btn-info btn-sm'>View</a></td>";
                                                        // echo "<td><a href='edit_pac.php?id=" . urlencode($row['student_id']) . "' class='btn btn-warning btn-sm'>Edit</a></td>";
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
                                                    <th>Requested Faculty</th>
                                                    <th>Requested Level</th>
                                                    <th>Requested Program</th>
                                                    <th>Requested Quota</th>
                                                    <th>Requested Mode</th>
                                                    <th>Hod Approval</th>
                                                    <th>Cluster Admin Approval</th>
                                                    <th>Accounts Approval</th>
                                                    <th>Student Section Approval</th>
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
    <!-- HOD Approval Modal -->
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
        $(document).on('click', '.change-hod-status', function() {
            var pacId = $(this).data('id');
            var newStatus = $(this).data('status');

            Swal.fire({
                title: "Are you sure?",
                text: "You want to " + newStatus + " this request?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, " + newStatus + " it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '', // same page
                        type: 'POST',
                        data: {
                            action: 'update_hod_status',
                            student_id: pacId,
                            status: newStatus
                        },
                        success: function(response) {
                            console.log("Raw AJAX Response:", response); // Add this

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
                }
            });
        });
    </script>


</body>

</html>