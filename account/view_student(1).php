<?php
include './include/checklogin.php';
if (isset($_GET['url_level_id']) && $_GET['url_level_id'] !="") {
    $url_level_id = mysqli_real_escape_string($con, $_GET['url_level_id']);
    $url_level_id = validate_data($url_level_id);
    $query = "SELECT name as level_name FROM tbl_level WHERE id= $url_level_id";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $level_name = $row['level_name'];
    } else {
        $level_name = "";
    }
} else {
    $url_level_id = "";
    $level_name = "";
}
if (isset($_GET['from_date']) && $_GET['from_date'] !="" && isset($_GET['to_date']) && $_GET['to_date'] !="") {
    /* $url_level_id = mysqli_real_escape_string($con, $_GET['url_level_id']);
    $url_level_id = validate_data($url_level_id); */
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
} else {
    $from_date = "";
    $to_date = "";
}


if (isset($_GET['url_for'])) {
    $url_for = mysqli_real_escape_string($con, $_GET['url_for']);
    $url_for = validate_data($url_for);
} else {
    $url_for = "";
}

if (isset($_GET['url_faculty_id']) && $_GET['url_faculty_id'] !="") {

    $url_faculty_id = mysqli_real_escape_string($con, $_GET['url_faculty_id']);
    $url_faculty_id = validate_data($url_faculty_id);


    // if (isset($_GET['url_faculty_id'])) {
    $url_faculty_id = $_GET['url_faculty_id'];
    $query = "SELECT name as faculty_name FROM tbl_faculty WHERE id= $url_faculty_id";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $faculty_name = $row['faculty_name'];
    } else {
        $faculty_name = "";
    }
} else {
    $faculty_name = "";
    $url_faculty_id = "";
}

if (isset($_POST['comment_btn'])) {
    $account_office_comment = $_POST['account_office_comment'];

    $stu_id = $_POST['stu_id'];


    $update = $con->prepare("UPDATE tbl_admission_student SET account_office_comment = ? WHERE id = ?");
    $update->bind_param("si", $account_office_comment, $stu_id);
    if ($update->execute()) {
        $_SESSION['status'] = "Comment Added Successfully";
        $_SESSION['status_code'] = "success";
        /*  var locations = ;

        window.location = locations */
        echo "<script>window.location='$(location).attr('href');</script>";
    } else {
        $_SESSION['status'] = "Something Went Wrong";
        $_SESSION['status_code'] = "error";
        echo "<script>window.location='$(location).attr('href');</script>";
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

                            <h1 class="m-0">View <?php
                                                    if ($url_for == 'account_office_status_pending') {
                                                        echo "Account Status Pending";
                                                    } elseif ($url_for == 'payment_online') {
                                                        echo "Payment Online ";
                                                    } elseif ($url_for == 'account_office_status_approved') {
                                                        echo "Account Status Approved";
                                                    } elseif ($url_for == 'account_office_status_rejected') {
                                                        echo "Account Status Rejected";
                                                    } elseif ($url_for == 'payment_offline') {
                                                        echo "Payment offline";
                                                    } elseif ($url_for == 'all') {
                                                        echo "Total";
                                                    }
                                                    ?>
                                Student

                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">View <?php
                                                                        if ($url_for == 'account_office_status_pending') {
                                                                            echo "Account Status Pending";
                                                                        } elseif ($url_for == 'payment_online') {
                                                                            echo "Payment Online ";
                                                                        } elseif ($url_for == 'account_office_status_approved') {
                                                                            echo "Account Status Approved";
                                                                        } elseif ($url_for == 'account_office_status_rejected') {
                                                                            echo "Account Status Rejected";
                                                                        } elseif ($url_for == 'payment_offline') {
                                                                            echo "Payment offline";
                                                                        } elseif ($url_for == 'all') {
                                                                            echo "Total";
                                                                        }
                                                                        ?>
                                    Student</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Default box -->
                    <div class="card mb-3">
                        <div class="card-header">

                            <i class="far fa-hand-pointer"></i>

                            <span> <b>Select Faculty to View Students</b></span>

                        </div>
                        <form method="GET" action="">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-label-group">

                                                <input type="hidden" name="url_for" value="<?php echo $url_for; ?>">
                                                <select id="faculty_id" name="url_faculty_id"
                                                    class="browser-default custom-select"
                                                    style="color:black; border-color:#325d88; border-width:2px">
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
                                                <select name="url_level_id" id="level_id"
                                                    class="browser-default custom-select"
                                                    style="color:black; border-color:#325d88; border-width:2px">
                                                    <option value="">---Select Level---</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="submit" class="btn btn-primary btn-block" id="export"
                                                style="float:center" />

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


                    <!--   student list code  -->


                    <div class="card">
                        <div class="card-header">
                            <span>
                                <center>
                                    <h5><b><i class="fas fa-book-reader"></i>
                                            <?php echo $faculty_name . "-" . $level_name; ?>
                                            Students </b></h5>
                                </center>
                            </span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="acedemic" class="dataTableLoad table table-bordered table-striped ">
                                    <thead>
                                        <tr align="center">
                                            <th scope="row" style="color:black;"><b>Student Id</b></th>
                                            <th scope="row" style="color:black;"><b>Student Gr Number</b></th>
                                            <th scope="row" style="color: black;"><b>Program Name</b></th>
                                            <th scope="row" style="color: black;"><b>Name</b></th>
                                            <th scope="row" style="color: black;"><b>Contact</b></th>
                                            <!-- <th scope="row" style="color:black;"><b>Payment Date and Time</b></th> -->
                                            <?php
                                            if($url_for=="all")
                                            { 
                                                echo '<th scope="row" style="color:black;"><b>Payment Date </b></th>';
                                                echo '<th scope="row" style="color:black;"><b>Approve/Reject Date</b></th>';
                                            }
                                            else if($url_for=="account_office_status_pending")
                                            {
                                                echo '<th scope="row" style="color:black;"><b>Payment Date</b></th>';
                                            }
                                            else if($url_for=="account_office_status_approved")
                                            {
                                                echo '<th scope="row" style="color:black;"><b>Approved Date</b></th>';
                                            }
                                            else if($url_for=="account_office_status_rejected")
                                            {
                                                echo '<th scope="row" style="color:black;"><b>Rejected Date </b></th>';
                                            }
                                            else if($url_for=="payment_online")
                                            {
                                                 echo '<th scope="row" style="color:black;"><b>Payment ID </b></th>';
                                                echo '<th scope="row" style="color:black;"><b>Payment Date </b></th>';
                                                echo '<th scope="row" style="color:black;"><b>Approve/Reject Date</b></th>';
                                            }
                                            else if($url_for=="payment_offline")
                                            {
                                                echo '<th scope="row" style="color:black;"><b>Payment Date </b></th>';
                                                echo '<th scope="row" style="color:black;"><b>Approve/Reject Date</b></th>';
                                            }
                                            ?>

                                            <th scope="row" style="color: black;"><b>Payment Detail</b></th>
                                            <th scope="row" style="color:black;"><b>Payment Receipt</b></th>
                                            <th scope="row" style="color:black;"><b>Token</th>
                                            <th scope="row" style="color:black;"><b>Accept/Reject</b></th>
                                            <th scope="row" style="color:black;"><b>Payment Mode</b></th>
                                            <th scope="row" style="color:black;"><b>Payment Status</b></th>
                                            <th scope="row" style="color:black;"><b>Account Status</b></th>
                                            <th scope="row" style="color:black;"><b>Comment</b></th>
                                            <th scope="row" style="color:black;"><b>Add Comment</b></th>
                                        </tr>
                                    </thead>
                                    <script src="../admin_assets/plugins/jquery/jquery.min.js"></script>
                                    <script>
                                    function load_student_data(sts, id) {
                                        $(document).ready(function() {

                                            if (sts == 'approved') {

                                                $("#approved" + id).hide();
                                                $("#rejected" + id).show();
                                                $("#status_lable_" + id).removeClass(
                                                    'badge-danger badge-info badge-warning');
                                                $("#status_lable_" + id).addClass('badge-success');
                                                $("#status_lable_" + id).html('Approved');
                                            } else if (sts == 'rejected') {
                                                $("#approved" + id).show();
                                                $("#rejected" + id).hide();
                                                $("#status_lable_" + id).removeClass(
                                                    'badge-success badge-info badge-warning');
                                                $("#status_lable_" + id).addClass('badge-danger');
                                                $("#status_lable_" + id).html('Rejected');
                                            } else if (sts == 'submitted') {
                                                $("#approved" + id).show();
                                                $("#rejected" + id).show();
                                                $("#status_lable_" + id).removeClass(
                                                    'badge-danger badge-info badge-success');
                                                $("#status_lable_" + id).addClass('badge-warning');
                                                $("#status_lable_" + id).html('Pending');
                                            } else if (sts == 'pending') {
                                                $("#approved" + id).show();
                                                $("#rejected" + id).show();
                                                $("#status_lable_" + id).removeClass(
                                                    'badge-danger badge-info badge-success');
                                                $("#status_lable_" + id).addClass('badge-warning');
                                                $("#status_lable_" + id).html('Pending');
                                            }

                                        });
                                    }
                                    </script>
                                    <tbody>
                                        <?php

                                        $cmd = "Select stu.token_amount,stu.id, stu.payment_date_time,stu.account_office_comment,stu.account_office_approve_reject_date,stu.gr_number,stu.first_name,stu.program_id,stu.middle_name,stu.last_name,stu.email,stu.mobile_number,stu.payment_id,stu.payment_status,stu.payment_mode,stu.account_office_status,stu.created_at,pro.name as program_name,level.name as level_name,faculty.name as faculty_name from tbl_admission_student as stu LEFT JOIN tbl_program pro
                                                ON stu.program_id = pro.id LEFT JOIN tbl_faculty as faculty
                                                ON stu.faculty_id = faculty.id LEFT JOIN tbl_level as level
                                                ON stu.level_id = level.id Where stu.is_active=1 AND stu.is_delete=0";
                                        if ($url_for != "") {
                                            if ($url_for == "account_office_status_pending") {
                                                $cmd = $cmd . " AND stu.account_office_status!='approved' AND stu.account_office_status!='rejected'";
                                                if ($from_date != "" && $to_date != "") {
                                                    /* echo $from_date;
                                                    echo $to_date; */
                                                    $cmd = $cmd . "  AND stu.payment_date_time BETWEEN '$from_date' AND '$to_date' "; 
                                                }
                                            } elseif ($url_for == "account_office_status_approved") {
                                                $cmd = $cmd . " AND stu.account_office_status ='approved' ";
                                                if ($from_date != "" && $to_date != "") {
                                                    /* echo $from_date;
                                                    echo $to_date; */
                                                    $cmd = $cmd . "  AND stu.account_office_approve_reject_date BETWEEN '$from_date' AND '$to_date' "; 
                                                }
                                            } elseif ($url_for == "account_office_status_rejected") {

                                                $cmd = $cmd . " AND stu.account_office_status ='rejected' ";
                                                if ($from_date != "" && $to_date != "") {
                                                    /* echo $from_date;
                                                    echo $to_date; */
                                                    $cmd = $cmd . "  AND stu.account_office_approve_reject_date BETWEEN '$from_date' AND '$to_date' "; 
                                                }
                                            } elseif ($url_for == "payment_online") {
                                                $status = "online";
                                                $cmd = $cmd . " AND stu.payment_mode = '$status' ";
                                                if ($from_date != "" && $to_date != "") {
                                                    /* echo $from_date;
                                                    echo $to_date; */
                                                    $cmd = $cmd . "  AND stu.payment_date_time BETWEEN '$from_date' AND '$to_date' "; 
                                                }
                                            } elseif ($url_for == "payment_offline") {
                                                $status = "offline";
                                                $cmd = $cmd . " AND stu.payment_mode = '$status' ";
                                                if ($from_date != "" && $to_date != "") {
                                                    /* echo $from_date;
                                                    echo $to_date; */
                                                    $cmd = $cmd . "  AND stu.account_office_approve_reject_date BETWEEN '$from_date' AND '$to_date' "; 
                                                }
                                            }
                                        }
                                        if ($url_faculty_id != "") {
                                            $cmd = $cmd . " AND stu.faculty_id = '$url_faculty_id' ";
                                        }
                                        if ($url_level_id != "") {
                                            $cmd = $cmd . " AND stu.level_id = '$url_level_id' ";
                                        }
                                      /*   print_r($cmd);
                                        exit(); */
                                        $stmt = $con->prepare($cmd);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $rows = $result->num_rows;
                                        if ($rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $stu_id = $row['id'];
                                                $stu_gr_number = $row['gr_number'];
                                                $stu_program_id = $row['program_id'];
                                                $stu_first_name = $row['first_name'];
                                                $stu_middle_name = $row['middle_name'];
                                                $stu_last_name = $row['last_name'];
                                                $stu_email = $row['email'];
                                                $stu_mobile_number = $row['mobile_number'];
                                                $stu_payment_id= $row['payment_id'];
                                                $stu_payment_mode = $row['payment_mode'];
                                                $register_date = $row['created_at'];
                                                $stu_payment_status = $row['payment_status'];
                                                $stu_token_amount = $row['token_amount'];
                                                $stu_account_office_status = $row['account_office_status'];
                                                $sts =  $row['account_office_status'];
                                                $stu_program_name = $row['program_name'];
                                                $stu_level_name = $row['level_name'];
                                                $stu_payment_date_time = $row['payment_date_time'];
                                                $account_office_comment = $row['account_office_comment'];
                                                $account_office_approve_reject_date = $row['account_office_approve_reject_date'];

                                        ?>
                                        <tr align="center">

                                            <td scope="row"><?php echo $stu_id; ?></td>
                                            <td scope="row"><?php echo $stu_gr_number; ?></td>
                                            <td scope="row"><?php echo $stu_program_name; ?></td>

                                            <td scope="row"><?php echo $stu_first_name; ?>
                                                <?php echo $stu_middle_name; ?>
                                                <?php echo $stu_last_name; ?></td>
                                            <td scope="row"><?php echo $stu_email; ?>
                                                <?php echo "<br>"; ?>
                                                <?php echo $stu_mobile_number; ?>
                                            </td>
                                            <?php
                                            if($url_for=="all")
                                            { 
                                                  echo ' <td scope="row">'.$stu_payment_date_time.'</td>';
                                                  echo ' <td scope="row">'.$stu_payment_date_time.'</td>';
                                            }
                                            else if($url_for=="account_office_status_pending")
                                            {
                                                  echo ' <td scope="row">'.$stu_payment_date_time.'</td>';
                                            }
                                            else if($url_for=="account_office_status_approved")
                                            {
                                                 echo ' <td scope="row">'.$account_office_approve_reject_date.'</td>';

                                            }
                                            else if($url_for=="account_office_status_rejected")
                                            {
                                                echo ' <td scope="row">'.$account_office_approve_reject_date.'</td>';

                                            }
                                            else if($url_for=="payment_online")
                                            {
                                                 echo ' <td scope="row">'.$stu_payment_id.'</td>';
                                                  echo ' <td scope="row">'.$stu_payment_date_time.'</td>';
                                                  echo ' <td scope="row">'.$account_office_approve_reject_date.'</td>';

                                            }
                                            else if($url_for=="payment_offline")
                                            {
                                                  echo ' <td scope="row">'.$stu_payment_date_time.'</td>';
                                                  echo ' <td scope="row">'.$account_office_approve_reject_date.'</td>';
                                            }
                                            ?>

                                            <td scope="row"><a
                                                    href="view_student_detail.php?stu_id=<?php echo $stu_id; ?>"
                                                    style="color:blue;" target="_blank"><button type="button"
                                                        class="btn btn-success">View</button></a></td>
                                            <td scope="row"><?php if ($stu_payment_status == "success") {
                                                                    ?>
                                                <a href="view_receipt.php?stu_id=<?php echo $stu_id; ?>"
                                                    style="color:blue;" target="_blank"><button type="button"
                                                        class="btn btn-success">View</button></a>
                                                <?php }

                                                        ?>

                                            </td>
                                            <td scope="row"><?php echo $stu_token_amount;?></td>


                                            <script>
                                            load_student_data('<?php echo $stu_account_office_status; ?>',
                                                '<?php echo $stu_id; ?>');
                                            </script>
                                            <td scope="row"><button id="approved<?php echo $stu_id ?>" <?php $stu_payment_status == "success"
                                                                                                                ?>
                                                    data-name="approved" data-student_id="<?php echo $stu_id ?>"
                                                    class="btn btn-success approve_reject"><i
                                                        class="fas fa-check"></i></button>
                                                <button id="rejected<?php echo $stu_id ?>"
                                                    data-student_id="<?php echo $stu_id ?>" data-name="rejected"
                                                    class="btn btn-danger approve_reject"><i class="fas fa-times"></i>
                                                </button>
                                            </td>


                                            <td scope="row"><?php if ($stu_payment_mode == "online") {
                                                                    ?>
                                                <span class="badge badge-info"><?php echo $stu_payment_mode ?></span>
                                                <?php } else { ?>
                                                <span class="badge badge-success"><?php echo $stu_payment_mode ?></span>

                                                <?php   }
                                                        ?>
                                            </td>

                                            <td scope="row"><?php if ($stu_payment_status == "success") {
                                                                    ?>
                                                <span
                                                    class="badge badge-success"><?php echo $stu_payment_status ?></span>
                                                <?php } else { ?>
                                                <span
                                                    class="badge badge-danger"><?php echo $stu_payment_status ?></span>

                                                <?php   }
                                                        ?>
                                            </td>
                                            <td scope="row"><span id="status_lable_<?php echo $stu_id ?>"
                                                    class="badge"></span></td>
                                            <td scope="row"><?php echo $account_office_comment; ?></td>
                                            <td scope="row">
                                                <form action="" method="POST">
                                                    <div class="form-group">
                                                        <input type="hidden" name="stu_id"
                                                            value="<?php echo $stu_id; ?>">

                                                        <textarea font-size: 18px; class="form-control" rows="2"
                                                            id="account_office_comment" name="account_office_comment"
                                                            required></textarea>
                                                    </div>
                                                    <button type="submit" name="comment_btn"
                                                        value="account_office_comment"
                                                        class="btn btn-block btn-primary btn-xs">Submit</button>
                                                </form>
                                            </td>

                                        </tr>

                                        <?php
                                            }
                                        }

                                        ?>

                                    </tbody>
                                    <tfoot>
                                        <tr align="center">

                                            <th scope="row" style="color:black;"><b>Student Id</b></th>
                                            <th scope="row" style="color:black;"><b>Student Gr Number</b></th>
                                            <th scope="row" style="color: black;"><b>Program Name</b></th>
                                            <th scope="row" style="color: black;"><b>Name</b></th>
                                            <th scope="row" style="color: black;"><b>Contact</b></th>
                                            <?php
                                            if($url_for=="all")
                                            { 
                                                echo '<th scope="row" style="color:black;"><b>Payment Date </b></th>';
                                                echo '<th scope="row" style="color:black;"><b>Approve/Reject Date</b></th>';
                                            }
                                            else if($url_for=="account_office_status_pending")
                                            {
                                                echo '<th scope="row" style="color:black;"><b>Payment Date</b></th>';
                                            }
                                            else if($url_for=="account_office_status_approved")
                                            {
                                                echo '<th scope="row" style="color:black;"><b>Approved Date</b></th>';
                                            }
                                            else if($url_for=="account_office_status_rejected")
                                            {
                                                echo '<th scope="row" style="color:black;"><b>Rejected Date </b></th>';
                                            }
                                            else if($url_for=="payment_online")
                                            {
                                                echo '<th scope="row" style="color:black;"><b>Payment Date </b></th>';
                                                echo '<th scope="row" style="color:black;"><b>Approve/Reject Date</b></th>';
                                            }
                                            else if($url_for=="payment_offline")
                                            {
                                                echo '<th scope="row" style="color:black;"><b>Payment Date </b></th>';
                                                echo '<th scope="row" style="color:black;"><b>Approve/Reject Date</b></th>';
                                            }
                                            ?>
                                            <th scope="row" style="color: black;"><b>Payment Detail</b></th>
                                            <th scope="row" style="color:black;"><b>Payment Receipt</b></th>
                                            <th scope="row" style="color:black;"><b>Token</th>
                                            <th scope="row" style="color:black;"><b>Accept/Reject</b></th>
                                            <th scope="row" style="color:black;"><b>Payment Mode</b></th>
                                            <th scope="row" style="color:black;"><b>Payment Status</b></th>
                                            <th scope="row" style="color:black;"><b>Account Status</b></th>
                                            <th scope="row" style="color:black;"><b>Comment</b></th>
                                            <th scope="row" style="color:black;"><b>Add Comment</b></th>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <?php

                    ?>
                </div>
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'include/importfooter.php'; ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include 'include/importjs.php'; ?>

    <script>
    $(".approve_reject").click(function(e) {
        var name = $(this).attr('data-name');
        var student_id = $(this).attr('data-student_id');
        // e.preventDefault();
        //var path = '<?php echo "$base_url_admin_api"; ?>';
        var formData = new FormData();
        formData.append('name', name);
        formData.append('student_id', student_id);

        swal({
            title: 'Are you sure?',
            text: "Do you want to continue?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Continue'
        }).then(function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: 'approve_reject_api.php',
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Student is ' + data.message,
                            });
                            var locations = $(location).attr('href');

                            window.location = locations
                            // load_student_data(data.message, student_id);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            });
                        }

                        window.location = locations
                        // load_student_data(data.message, student_id);
                    }
                });
            }

        });
    });
    </script>



</body>

</html>
<script type="text/javascript">
$('#faculty_id').on('change', function() {
    var path = '<?php echo "$base_url_api"; ?>';
    var faculty_id = this.value;
    // alert("hii");
    $.ajax({
        url: path + 'level.php',
        type: "POST",
        data: {
            faculty_data: faculty_id
        },
        success: function(result) {
            $('#level_id').html(result);

            // console.log(result);
        }
    })
});
</script>