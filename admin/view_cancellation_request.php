<?php include './include/checklogin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_cluster_status') {
    $tcrId = intval($_POST['tcrId']);
    $status = $_POST['status'];
    $remark = trim($_POST['remark']);

    $stmt = $con->prepare("UPDATE tbl_cancellation_requests SET cluster_status = ?, cluster_remark = ?, cluster_at = NOW(), updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("ssi", $status, $remark, $tcrId);
    if ($stmt->execute()) {
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

// code for the accept or reject the refund 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update_refund_status') {
    $tcr_id = $_POST['tcr_id'];
    $status = $_POST['refund_status'];

    $is_refund_required = $status === 'Approved' ? 1 : 0;

    if ($is_refund_required === 1) {
        // Validate and upload file
        $targetDir = "uploads/fee_receipt_file/";

        // Get original file name and extension
        $originalName = basename($_FILES["fee_receipt_file"]["name"]);
        $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);

        // Generate a unique file name
        $uniqueName = uniqid('receipt_', true) . '.' . $fileExtension;

        // Set the full path for file move
        $targetFilePath = $targetDir . $uniqueName;

        // Move the uploaded file
        if (move_uploaded_file($_FILES["fee_receipt_file"]["tmp_name"], $targetFilePath)) {
            // Get other form fields
            $refund_amount = $_POST['refund_amount'];
            $bank_name = $_POST['bank_name'];
            $account_number = $_POST['account_number'];
            $ifsc_code = $_POST['ifsc_code'];
            $tcr_id = $_POST['tcr_id']; // make sure this is being posted

            // Prepare and execute a single update query
            $stmt = $con->prepare("UPDATE tbl_cancellation_requests SET is_refund_required = 1,refund_amount = ?,bank_name = ?,account_number = ?,ifsc_code = ?,fee_receipt_file = ?,cluster_admin_at = NOW() WHERE id = ?");
            $stmt->bind_param("sssssi", $refund_amount, $bank_name, $account_number, $ifsc_code, $uniqueName, $tcr_id);

            if ($stmt->execute()) {
                echo "Refund details saved successfully.";
            } else {
                echo "Database update failed.";
            }
        } else {
            echo "File upload failed.";
        }


        $_SESSION['status'] = "Refund request Approved !";
        $_SESSION['status_code'] = "success";
    } else {
        // Only mark refund not required
        $stmt = $con->prepare("UPDATE tbl_cancellation_requests SET is_refund_required = 0, cluster_admin_at = NOW() WHERE id = ?");
        $stmt->bind_param("i", $tcr_id);
        $stmt->execute();

        $_SESSION['status'] = "Refund request Rejected !";
        $_SESSION['status_code'] = "success";
    }

    echo json_encode(["status" => "success"]);
    exit;
}


$stmt = $con->prepare("SELECT
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
                                    tcr.is_active = 1 AND tcr.is_delete = 0 AND tcr.hod_status = ?
                                ");
$hod_status = "approved";
$stmt->bind_param("s", $hod_status);
$stmt->execute();
$result = $stmt->get_result();

$clusterStatus = '';
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
                                                    <th>Refund Status</th>
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
                                                        echo "<td>";
                                                        $status = $row['cluster_status'];
                                                        $clusterStatus = $row['cluster_status'];
                                                        $refund_status = $row['is_refund_required'];
                                                        if ($status === 'pending') {
                                                            echo "<button class='btn btn-success btn-sm change-cluster-status' data-id='" . $row['tcr_id'] . "' data-status='Approved' title='Approve'>
                                                              <i class='fa fa-check'></i></button>";
                                                            echo "<button class='btn btn-danger btn-sm change-cluster-status' data-id='" . $row['tcr_id'] . "' data-status='Rejected' title='Reject'>
                                                              <i class='fa fa-times'></i></button>";
                                                        } elseif ($row['account_status'] == 'pending') {
                                                            if ($status === 'rejected') {
                                                                echo "<button class='btn btn-success btn-sm change-cluster-status' data-id='" . $row['tcr_id'] . "' data-status='Approved' title='Approve'>
                                                               <i class='fa fa-check'></i> </button>";
                                                            } else { // status is 'approved'
                                                                if ($clusterStatus === 'approved') {
                                                                    echo "
                                                                <div class='d-flex justify-content-between align-items-start gap-3'>
                                                                    <!-- Right Section: Request Button -->
                                                                    <div class='d-flex flex-column align-items-center'>
                                                                        <button class='btn btn-danger btn-sm change-cluster-status' 
                                                                            data-id='" . $row['tcr_id'] . "' 
                                                                            data-status='Rejected' 
                                                                            title='Reject'>
                                                                            <i class='fa fa-times'></i>
                                                                        </button>
                                                                    </div>
                                                                </div>";
                                                                }
                                                            }
                                                        } elseif ($row['account_status'] != 'pending') {
                                                            echo $row['account_status'];
                                                        } else {
                                                            echo 'N/A';
                                                        }

                                                        echo "</td>";
                                                        if ($refund_status === NULL && $clusterStatus === 'approved') {
                                                            echo "<td>
                                                                    <div class='d-flex flex-column align-items-start gap-1'>
                                                                        <div class='d-flex align-items-center gap-2'>
                                                                
                                                                            <!-- Approve Button -->
                                                                            <button class='btn btn-success btn-sm change-refund-status' 
                                                                                data-id='" . $row['tcr_id'] . "' 
                                                                                data-status='Approved' 
                                                                                title='Approve'>
                                                                                <i class='fa fa-check'></i>
                                                                            </button>
                                                                
                                                                            <!-- Reject Button -->
                                                                            <button class='btn btn-danger btn-sm change-refund-status'
                                                                                data-id='" . $row['tcr_id'] . "' 
                                                                                data-status='Rejected' 
                                                                                title='Reject'>
                                                                                <i class='fa fa-times'></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>    
                                                            </td>";
                                                        }
                                                        //  elseif ($refund_status === 1 && $clusterStatus === 'approved') {
                                                        //     echo "<td>
                                                        //         <div class='d-flex flex-column align-items-start gap-1'>
                                                        //             <div class='d-flex align-items-center gap-2'>
                                                        //                 <!-- Reject Button -->
                                                        //                 <button class='btn btn-danger btn-sm change-refund-status'
                                                        //                     data-id='" . $row['tcr_id'] . "' 
                                                        //                     data-status='Rejected' 
                                                        //                     title='Reject'>
                                                        //                     <i class='fa fa-times'></i>
                                                        //                 </button>
                                                        //             </div>
                                                        //         </div>    
                                                        // </td>";
                                                        // } elseif ($refund_status === 0 && $clusterStatus === 'approved') {
                                                        //     echo "<td>Refund Rejected</td>";
                                                        // }
                                                        elseif ($row['is_refund_required'] != null || $row['is_refund_required'] == 1 || $row['is_refund_required'] == 0) {
                                                            echo '<td>';
                                                            echo ($row['is_refund_required'] == 1) ? 'Approved' : 'Rejected';
                                                            echo '</td>';
                                                        } else {
                                                            echo "<td>N/A</td>";
                                                        }
                                                        echo "<td>" . htmlspecialchars($row['account_status']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['eligibility_status']) . "</td>";
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
                                                    <th>Refund Status</th>
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

        <?php include './include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- Cluster Approval Modal -->
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="confirmHodAction" type="button" class="btn btn-primary">Yes, Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal for the refund   -->
    <!-- Modal -->
    <div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="refundForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="refundModalLabel">Refund Action</h5>
                        <button type="button" class="close text-primary" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="tcr_id" id="modal_tcr_id">
                        <input type="hidden" name="refund_status" id="modal_refund_status">

                        <!-- Shown only for Approve -->
                        <div id="refundFields" style="display: none;">
                            <div class="mb-2">
                                <label class="form-label">Refund Amount</label>
                                <input type="number" name="refund_amount" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Account Number</label>
                                <input type="text" name="account_number" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">IFSC Code</label>
                                <input type="text" name="ifsc_code" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Fee Receipt File</label>
                                <input type="file" name="fee_receipt_file" class="form-control" required>
                            </div>
                        </div>

                        <!-- Reject confirmation -->
                        <div id="rejectConfirm" style="display: none;">
                            <p>Are you sure you want to reject the refund request?</p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <?php include './include/importjs.php'; ?>
    <script>
        $(document).on('click', '.change-cluster-status', function () {
            var tcrId = $(this).data('id');
            var newStatus = $(this).data('status');

            // Set modal hidden inputs and message
            $('#modal-cancellation-id').val(tcrId);
            $('#modal-new-status').val(newStatus);
            $('#modal-action-text').text(newStatus);

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

            $.ajax({
                url: '', // same page
                type: 'POST',
                data: {
                    action: 'update_cluster_status',
                    tcrId: tcrId,
                    status: newStatus,
                    remark: remark
                },
                success: function (response) {
                    if (response.trim() === 'success') {
                        location.reload();
                    } else {
                        Swal.fire("Error", "Request failed. Try again.", "error");
                    }
                },
                error: function () {
                    Swal.fire("Error", "Something went wrong.", "error");
                }
            });

            // Close the modal
            $('#hodStatusModal').modal('hide');
        });
    </script>

    <!-- script for the refund   -->
    <script>
        $(document).ready(function () {
            // Open modal
            $('.change-refund-status').on('click', function () {
                const tcrId = $(this).data('id');
                const status = $(this).data('status');

                $('#modal_tcr_id').val(tcrId);
                $('#modal_refund_status').val(status);

                if (status === 'Approved') {
                    // Show refund fields and add required
                    $('#refundFields').show();
                    $('#rejectConfirm').hide();

                    $('#refundFields input').attr('required', true);
                } else {
                    // Hide refund fields and remove required
                    $('#refundFields').hide();
                    $('#rejectConfirm').show();

                    $('#refundFields input').removeAttr('required');
                }

                $('#refundModal').modal('show');
            });

            // Form submission
            $('#refundForm').on('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                formData.append('action', 'update_refund_status');

                $.ajax({
                    url: '', // same page
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $('#refundModal').modal('hide');
                        // alert('Updated successfully!');
                        location.reload();
                    },
                    error: function () {
                        alert('Something went wrong.');
                    }
                });
            });
        });
    </script>


</body>

</html>