<?php
include './include/checklogin.php';

// ----------------------------------------
// 1. GET URL PARAMETERS
// ----------------------------------------
$url_level_id = isset($_GET['url_level_id']) ? validate_data($_GET['url_level_id']) : "";
$url_faculty_id = isset($_GET['url_faculty_id']) ? validate_data($_GET['url_faculty_id']) : "";
$url_for = isset($_GET['url_for']) ? validate_data($_GET['url_for']) : "";
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : "";
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : "";


// ----------------------------------------
// 2. FETCH LEVEL NAME (once only)
// ----------------------------------------
$level_name = "";
if ($url_level_id != "") {
    $q = $con->query("SELECT name FROM tbl_level WHERE id='$url_level_id'");
    if ($q->num_rows > 0) $level_name = $q->fetch_assoc()['name'];
}


// ----------------------------------------
// 3. FETCH FACULTY NAME (once only)
// ----------------------------------------
$faculty_name = "";
if ($url_faculty_id != "") {
    $q = $con->query("SELECT name FROM tbl_faculty WHERE id='$url_faculty_id'");
    if ($q->num_rows > 0) $faculty_name = $q->fetch_assoc()['name'];
}


// ----------------------------------------
// 4. PRELOAD PROGRAM FEES (Huge Optimization)
// ----------------------------------------
$programFees = [];
$query_pf = $con->query("SELECT * FROM tbl_program");
while ($pf = $query_pf->fetch_assoc()) {
    $programFees[$pf['id']] = $pf;
}


// ----------------------------------------
// 5. COMMENT INSERT
// ----------------------------------------
if (isset($_POST['comment_btn'])) {
    $account_office_comment = $_POST['account_office_comment'];
    $stu_id = $_POST['stu_id'];

    $update = $con->prepare("UPDATE tbl_admission_student SET account_office_comment = ? WHERE id = ?");
    $update->bind_param("si", $account_office_comment, $stu_id);
    if ($update->execute()) {
        $_SESSION['status'] = "Comment Added Successfully";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Something Went Wrong";
        $_SESSION['status_code'] = "error";
    }
    echo "<script>location.reload();</script>";
    exit;
}



// ========================================
// HTML START
// ========================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<?php include 'include/importnav.php'; ?>
<?php include 'include/importsidebar.php'; ?>

<div class="content-wrapper">
    
    <!-- Page Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">View 
                    <?php
                        if ($url_for == 'account_office_status_pending') echo "Account Status Pending";
                        elseif ($url_for == 'payment_online') echo "Payment Online";
                        elseif ($url_for == 'account_office_status_approved') echo "Account Status Approved";
                        elseif ($url_for == 'account_office_status_rejected') echo "Account Status Rejected";
                        elseif ($url_for == 'payment_offline') echo "Payment Offline";
                        elseif ($url_for == 'all') echo "Total";
                    ?>
                    Students
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">View Students</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<!-- FILTER CARD -->
<section class="content">
<div class="container-fluid">

<div class="card mb-3">
    <div class="card-header">
        <b>Select Faculty to View Students</b>
    </div>

   <form method="GET" action="">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-label-group">

                                                <input type="hidden" name="url_for" value="<?php echo $url_for; ?>">
                                                <select id="faculty_id" name="url_faculty_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px">
                                                    <option value="">---Select Faculty---</option>

                                                    <?php
                                                    $query = "SELECT * FROM tbl_faculty WHERE is_active = 1 and is_delete=0";
                                                    $result = $con->query($query);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-label-group">
                                                <select name="url_level_id" id="level_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px">
                                                    <option value="">---Select Level---</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="submit" class="btn btn-primary btn-block" id="export" style="float:center" />

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-row">
                                        <?php
                                        if ($url_for == 'account_office_status_pending' || $url_for == 'account_office_status_approved' || $url_for == 'account_office_status_rejected') {
                                            echo '<div class="col-md-4">
                                                                            <div class="form-label-group">
                                
                                                                                <label for="">From Date :</label>
                                                                                <input type="date" id="from_date" name="from_date" class="form-control"
                                                                                    style="color:black; border-color:#325d88; border-width:1px">
                                
                                
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-label-group">
                                
                                                                                <label for="">To Date :</label>
                                                                                <input type="date" id="to_date" name="to_date" class="form-control"
                                                                                    style="color:black; border-color:#325d88; border-width:1px">
                                
                                
                                                                            </div>
                                                                        </div>';
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>

                        </form>
</div>


<!-- ========================= -->
<!--   OPTIMIZED SQL QUERY     -->
<!-- ========================= -->

<?php
$cmd = "
SELECT 
    stu.id,
    stu.faculty_id,
    stu.program_id,
    stu.level_id,
    stu.token_amount,
    stu.mode,
    stu.bookbank_fees_status,
    stu.Uniform_status,
    stu.gr_number,
    stu.first_name,
    stu.middle_name,
    stu.last_name,
    stu.email,
    stu.mobile_number,
    stu.payment_status,
    stu.payment_mode,
    stu.account_office_status,
    stu.payment_date_time,
    stu.account_office_comment,
    stu.account_office_approve_reject_date,
    pro.name AS program_name,
    level.name AS level_name,
    faculty.name AS faculty_name
FROM tbl_admission_student stu
LEFT JOIN tbl_program pro ON stu.program_id = pro.id
LEFT JOIN tbl_faculty faculty ON stu.faculty_id = faculty.id
LEFT JOIN tbl_level level ON stu.level_id = level.id
WHERE stu.is_active=1 AND stu.is_delete=0
";


// Apply filters
if ($url_for == "account_office_status_pending") {
    $cmd .= " AND stu.account_office_status NOT IN ('approved','rejected') ";
    if ($from_date != "" && $to_date != "")
        $cmd .= " AND DATE(stu.payment_date_time) BETWEEN '$from_date' AND '$to_date' ";
}
elseif ($url_for == "account_office_status_approved") {
    $cmd .= " AND stu.account_office_status='approved' ";
    if ($from_date != "" && $to_date != "")
        $cmd .= " AND DATE(stu.account_office_approve_reject_date) BETWEEN '$from_date' AND '$to_date' ";
}
elseif ($url_for == "account_office_status_rejected") {
    $cmd .= " AND stu.account_office_status='rejected' ";
    if ($from_date != "" && $to_date != "")
        $cmd .= " AND DATE(stu.account_office_approve_reject_date) BETWEEN '$from_date' AND '$to_date' ";
}
elseif ($url_for == "payment_online") {
    $cmd .= " AND stu.payment_mode='online' ";
}
elseif ($url_for == "payment_offline") {
    $cmd .= " AND stu.payment_mode='offline' ";
}

if ($url_faculty_id != "") {
    $cmd .= " AND stu.faculty_id='$url_faculty_id' ";
}
if ($url_level_id != "") {
    $cmd .= " AND stu.level_id='$url_level_id' ";
}

$result = $con->query($cmd);

?>


<!-- STUDENT TABLE -->
<div class="card">
    <div class="card-header text-center">
        <h5><b><i class="fas fa-book-reader"></i> 
            <?php echo $faculty_name . " - " . $level_name; ?> Students
        </b></h5>
    </div>

  <div class="card-body">
    <div class="table-responsive">
        <table id="acedemic" class="dataTableLoad table table-bordered table-striped">
            <thead>
                <tr class="text-center">
                    <th>Student Id</th>
                    <th>GR Number</th>
                    <th>Program</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Payment Date</th>
                    <th>Approve/Reject Date</th>
                    <th>Payment Detail</th>
                    <th>Receipt</th>
                    <th>Token</th>
                    <th>Accept/Reject</th>
                    <th>Payment Mode</th>
                    <th>Payment Status</th>
                    <th>Account Status</th>
                    <th>Book Bank</th>
                    <th>Stationery</th>
                    <th>Pending Fees</th>
                    <th>Comment</th>
                    <th>Add Comment</th>
                </tr>
            </thead>

            <tbody>

<?php
while ($row = $result->fetch_assoc()) {

    $stu_id = $row['id'];
    $stu_program_id = $row['program_id'];
    $stu_faculty_id = $row['faculty_id'];
    $stu_level_id = $row['level_id'];

    $full_name = $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'];

    $payment_date = $row['payment_date_time'];
    $approve_date = $row['account_office_approve_reject_date'];

    $bookbank = ($row['bookbank_fees_status'] == 1) ? "Completed" : "Pending";
    $stationery = ($row['Uniform_status'] == 1) ? "Completed" : "Pending";

    $account_status = $row['account_office_status'];
    $token = $row['token_amount'];
    $mode = $row['mode'];

    // Faster Fee Calculation
    $fees = $programFees[$stu_program_id];

    $pending_fees = 0;

    if ($mode == "regular") {
        $pending_fees = ($fees['regular'] / 2) - $token;
    } elseif ($mode == "genius") {
        $pending_fees = ($fees['genius'] / 2) - $token;
    } elseif ($mode == "honors") {
        $pending_fees = ($fees['honors'] / 2) - $token;
    } elseif ($mode == "international") {
        $pending_fees = ($fees['international'] / 2) - $token;
    } elseif ($mode == "minor") {
        $pending_fees = ($fees['minor'] / 2) - $token;
    }
?>
<tr class="text-center">

    <td><?php echo $stu_id; ?></td>
    <td><?php echo $row['gr_number']; ?></td>
    <td><?php echo $row['program_name']; ?></td>

    <td><?php echo $full_name; ?></td>

    <td>
        <?php echo $row['email']; ?><br>
        <?php echo $row['mobile_number']; ?>
    </td>

    <td><?php echo $payment_date; ?></td>
    <td><?php echo $approve_date; ?></td>

    <td>
        <a href="view_student_detail.php?stu_id=<?php echo $stu_id; ?>" target="_blank">
            <button class="btn btn-success">View</button>
        </a>
    </td>

    <td>
        <?php if ($row['payment_status'] == "success") { ?>
            <a href="view_receipt.php?stu_id=<?php echo $stu_id; ?>" target="_blank">
                <button class="btn btn-success">View</button>
            </a>
        <?php } ?>
    </td>

    <td><?php echo $token; ?></td>

    <!-- APPROVE / REJECT -->
    <td>
        <button class="btn btn-success approve_reject" data-name="approved" data-student_id="<?php echo $stu_id; ?>">
            <i class="fas fa-check"></i>
        </button>
        <button class="btn btn-danger approve_reject" data-name="rejected" data-student_id="<?php echo $stu_id; ?>">
            <i class="fas fa-times"></i>
        </button>
    </td>

    <td>
        <?php if ($row['payment_mode'] == "online") { ?>
            <span class="badge badge-info">Online</span>
        <?php } else { ?>
            <span class="badge badge-success">Offline</span>
        <?php } ?>
    </td>

    <td>
        <?php if ($row['payment_status'] == "success") { ?>
            <span class="badge badge-success">Success</span>
        <?php } else { ?>
            <span class="badge badge-danger">Failed</span>
        <?php } ?>
    </td>

    <td>
        <span class="badge badge-<?php 
            if ($account_status == 'approved') echo 'success';
            else if ($account_status == 'rejected') echo 'danger';
            else echo 'warning';
        ?>">
            <?php echo ucfirst($account_status ?: 'Pending'); ?>
        </span>
    </td>

    <td><?php echo $bookbank; ?></td>
    <td><?php echo $stationery; ?></td>

    <td><?php echo $pending_fees; ?></td>

    <td><?php echo $row['account_office_comment']; ?></td>

    <td>
        <form method="POST">
            <input type="hidden" name="stu_id" value="<?php echo $stu_id; ?>">
            <textarea class="form-control" name="account_office_comment" rows="2" required></textarea>
            <button type="submit" name="comment_btn" class="btn btn-primary btn-sm mt-1">Submit</button>
        </form>
    </td>

</tr>

<?php } ?>
</tbody>
 <tfoot>
                <tr class="text-center">
                    <th>Student Id</th>
                    <th>GR Number</th>
                    <th>Program</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Payment Date</th>
                    <th>Approve/Reject Date</th>
                    <th>Payment Detail</th>
                    <th>Receipt</th>
                    <th>Token</th>
                    <th>Accept/Reject</th>
                    <th>Payment Mode</th>
                    <th>Payment Status</th>
                    <th>Account Status</th>
                    <th>Book Bank</th>
                    <th>Stationery</th>
                    <th>Pending Fees</th>
                    <th>Comment</th>
                    <th>Add Comment</th>
                </tr>
            </tfoot>

</table>
</div>
</div>
</div>

</div><!-- container-fluid -->
</section><!-- content -->

</div><!-- content-wrapper -->


<?php include 'include/importfooter.php'; ?>
</div><!-- wrapper -->


<!-- jQuery -->
<script src="../admin_assets/plugins/jquery/jquery.min.js"></script>
 <?php include 'include/importjs.php'; ?>




<!-- APPROVE / REJECT AJAX -->
<script>
$(document).on("click", ".approve_reject", function(e) {
    var name = $(this).data("name");
    var student_id = $(this).data("student_id");

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to continue?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, continue'
    }).then((result) => {
        if (result.isConfirmed) {

            var formData = new FormData();
            formData.append("name", name);
            formData.append("student_id", student_id);

            $.ajax({
                type: "POST",
                url: "approve_reject_api.php",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Student is ' + response.message,
                    });
                    setTimeout(() => location.reload(), 700);
                }
            });
        }
    });
});
</script>


<!-- LOAD LEVELS BASED ON FACULTY -->
<script>
$('#faculty_id').on('change', function() {
    var path = '<?php echo $base_url_api; ?>';
    var faculty_id = $(this).val();

    $.post(path + "level.php", { faculty_data: faculty_id }, function(result) {
        $('#level_id').html(result);
    });
});
</script>

</body>
</html>
