<?php
include 'include/checklogin.php';

if (isset($_GET['url_faculty_id']) && $_GET['url_faculty_id'] != "") {

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
if (isset($_GET['from_date']) && $_GET['from_date'] != "" && isset($_GET['to_date']) && $_GET['to_date'] != "") {
    /* $url_level_id = mysqli_real_escape_string($con, $_GET['url_level_id']);
    $url_level_id = validate_data($url_level_id); */
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
} else {
    $from_date = "";
    $to_date = "";
}
if (isset($_GET['url_level_id']) && $_GET['url_level_id'] != "") {
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
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <!-- <h1 class="m-0">Payment History</h1> -->
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Payment History</li>
                            </ol>
                        </div><!-- /.col -->
                    </div>

                </div>
            </div>
            <section class="content">
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

                                            <select id="faculty_id" name="url_faculty_id" class="browser-default custom-select" style="color:black; border-color:#325d88; border-width:2px">
                                                <option value="">---Select Faculty---</option>

                                                <?php
                                                $query = "SELECT * FROM tbl_faculty WHERE is_active = 1 and is_delete=0";
                                                $result = $con->query($query);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        $selected = ($url_faculty_id == $row['id']) ? "selected" : "";
                                                        //echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
                                                ?>
                                                        <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
                                                            <?php echo $row['name']; ?>
                                                        </option>
                                                <?php
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
                                    <div class="col-md-4">
                                        <div class="form-label-group">
                                            <label for="">From Date:</label>
                                            <input type="date" id="from_date" name="from_date" class="form-control" style="color:black; border-color:#325d88; border-width:1px" value="<?php echo isset($_GET['from_date']) ? htmlspecialchars($_GET['from_date']) : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-label-group">
                                            <label for="">To Date:</label>
                                            <input type="date" id="to_date" name="to_date" class="form-control" style="color:black; border-color:#325d88; border-width:1px" value="<?php echo isset($_GET['to_date']) ? htmlspecialchars($_GET['to_date']) : ''; ?>">
                                        </div>
                                    </div>
                                    <!-- <?php

                                            //echo '<div class="col-md-4">
                                            //     <div class="form-label-group">

                                            //         <label for="">From Date :</label>
                                            //         <input type="date" id="from_date" name="from_date" class="form-control"
                                            //             style="color:black; border-color:#325d88; border-width:1px">


                                            //     </div>
                                            // </div>
                                            // <div class="col-md-4">
                                            //     <div class="form-label-group">

                                            //         <label for="">To Date :</label>
                                            //         <input type="date" id="to_date" name="to_date" class="form-control"
                                            //             style="color:black; border-color:#325d88; border-width:1px">


                                            //     </div>
                                            // </div>';


                                            ?> -->
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="card">
                    <div class="card-header">
                        <p class="font-weight-bold m-0 p-0">Transactions</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="acedemic" class="dataTableLoad table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ApplicationName</th>
                                        <th>Name </th>
                                        <th>Enrollment</th>
                                        <th>Amount</th>
                                        <th>MerchantOrderNo</th>
                                        <th>TransactionID</th>
                                        <th>Status</th>
                                        <th>TransactionDate</th>
                                        <th>Session</th>
                                        <th>College</th>
                                        <th>Course</th>
                                        <th>Exam Type</th>
                                        <th>Sem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cmd = "SELECT es.*,p.name as pname,  
                                    f.name,ts.first_name,ts.middle_name,ts.last_name,ef.session,ef.year,ef.program_id,ef.level_id,ef.faculty_id,ef.semester, ef.type as type FROM `tbl_exam_student` AS es LEFT JOIN `tbl_students_2023` AS ts ON es.enrollnment_no = ts.enrollnment_no LEFT JOIN `tbl_exam_form` AS ef ON es.exam_id = ef.id LEFT JOIN `tbl_program` AS p
                                    ON ef.program_id = p.id  -- Add this join
                                    LEFT JOIN `tbl_faculty` AS f
                                    ON ef.faculty_id = f.id  -- Add this join
                                    WHERE es.`is_active` = 1
                                    AND es.status = 3";

                                    if ($url_faculty_id != "") {
                                        $cmd .= " AND ef.faculty_id = ?";
                                    }

                                    if ($url_level_id != "") {
                                        $cmd .= " AND ef.level_id = ?";
                                    }

                                    if ($from_date != "" && $to_date != "") {
                                        $cmd .= " AND DATE(es.payment_date) BETWEEN DATE(?) AND DATE(?)";
                                    }

                                    $cmd = $con->prepare($cmd);

                                    if ($url_faculty_id != "" && $url_level_id != "" && $from_date != "" && $to_date != "") {
                                        $cmd->bind_param("iiss", $url_faculty_id, $url_level_id, $from_date, $to_date);
                                    }elseif ($url_faculty_id != ""  && $from_date != "" && $to_date != "") {
                                        $cmd->bind_param("iss", $url_faculty_id,  $from_date, $to_date);
                                    } elseif ($url_faculty_id != "" && $url_level_id != "") {
                                        $cmd->bind_param("ii", $url_faculty_id, $url_level_id);
                                    } elseif ($from_date != "" && $to_date != "") {
                                        $cmd->bind_param("ss", $from_date, $to_date);
                                    }elseif ($url_faculty_id != "" ) {
                                        $cmd->bind_param("i", $url_faculty_id);
                                    }
                                    $cmd->execute();
                                    $result1 = $cmd->get_result();

                                    while ($row1 = $result1->fetch_assoc()) {
                                        // Status and payment status handling using switch statements...

                                        // Access exam form information from the left join
                                        // $session = $row1['session'];
                                        // $year = $row1['year'];
                                        // $program_id = $row1['program_id'];
                                        // $level_id = $row1['level_id'];
                                        // $faculty_id = $row1['faculty_id'];
                                        // $semester = $row1['semester'];


                                        $exam_status = $row1['status'];
                                        $er_no = $row1['enrollnment_no'];
                                        $examID = $row1['exam_id'];
                                        $amount = $row1['fee_amount'];
                                        $account_status = $row1['account_status'];
                                        $ApplicationName = "Exam Form";
                                        $payment_status = $row1['payment_status'];
                                        $transaction_id = $row1['transaction_id'];
                                        $payment_date = $row1['payment_date'];
                                        $payment_id = $row1['payment_id'];
                                        $session = $row1['session'];
                                        $exyear = $row1['year'];
                                        $pr_id = $row1['program_id'];
                                        $lvl_id = $row1['level_id'];
                                        $fclt_id = $row1['faculty_id'];
                                        $exsem = $row1['semester'];
                                        $extype = $row1['type'];
                                        $stu_name = $row1["first_name"] . ' ' . $row1["middle_name"] . ' ' . $row1["last_name"];
                                        $payment_date_new = date("d/m/Y h:i A", strtotime($payment_date));
                                        $f_name = $row1['name'];
                                        $p_name = $row1['pname'];

                                        // Additional queries for other information...
                                        // (You can add the additional queries here)
                                        if ($payment_status == "success") {
                                            $pay_status = '<span class="badge badge-success">Successful</span>';
                                        } elseif ($payment_status == "failure") {
                                            $pay_status = '<span class="badge badge-danger">Failed</span>';
                                        } elseif ($payment_status == "userCancelled") {
                                            $pay_status = '<span class="badge badge-danger">User Cancelled</span>';
                                        } else {
                                            $pay_status = '<span class="badge badge-info">Pending</span>';
                                        }




                                        // $cmd2 = "SELECT * FROM `tbl_exam_student` WHERE `is_active` = 1 AND status = 3";

                                        // if ($url_faculty_id != "") {
                                        //     $cmd2 = $cmd2 . " AND stu.faculty_id = '$url_faculty_id' ";
                                        // }
                                        // if ($url_level_id != "") {
                                        //     $cmd2 = $cmd2 . " AND stu.level_id = '$url_level_id' ";
                                        // }
                                        // if ($from_date != "" && $to_date != "") {
                                        //     /* echo $from_date;
                                        //     echo $to_date; */
                                        //     $cmd = $cmd . "  AND stu.account_office_approve_reject_date BETWEEN '$from_date' AND '$to_date' ";
                                        // }
                                        // $cmd2 = $con->prepare("$cmd2");
                                        // $cmd2->execute();
                                        // $result1 = $cmd2->get_result();
                                        // while ($row1 = $result1->fetch_assoc()) {
                                        //     $exam_status = $row1['status'];
                                        //     $er_no = $row1['enrollnment_no'];
                                        //     $examID = $row1['exam_id'];
                                        //     $amount = $row1['fee_amount'];
                                        //     $account_status = $row1['account_status'];
                                        //     $ApplicationName = "Exam Form";
                                        //     $payment_status = $row1['payment_status'];
                                        //     $transaction_id = $row1['transaction_id'];
                                        //     $payment_date = $row1['payment_date'];
                                        //     $payment_id = $row1['payment_id'];
                                        //     $payment_date_new = date("d/m/Y h:i A", strtotime($payment_date));
                                        //     if ($exam_status == 0 || $account_status == 0) {
                                        //         $echo_status = '<span class="badge badge-info">Pending</span>';
                                        //         $form_status = '<p class="text-info">Not Eligible!</p>';
                                        //     } elseif ($exam_status == 1 && $account_status == 1) {
                                        //         $echo_status = '<span class="badge badge-success">Approved</span>';
                                        //     } elseif ($exam_status == 2 || $account_status == 2) {
                                        //         $form_status = '<p class="text-danger">Not Eligible!</p>';
                                        //         $echo_status = '<span class="badge badge-danger">Rejected</span>';
                                        //     } elseif ($exam_status == 3) {
                                        //         $echo_status = '<span class="badge badge-success">Form Filled</span>';
                                        //     }

                                        //     if ($payment_status == "success") {
                                        //         $pay_status = '<span class="badge badge-success">Successful</span>';
                                        //     } elseif ($payment_status == "failure") {
                                        //         $pay_status = '<span class="badge badge-danger">Failed</span>';
                                        //     } elseif ($payment_status == "userCancelled") {
                                        //         $pay_status = '<span class="badge badge-danger">User Cancelled</span>';
                                        //     } else {
                                        //         $pay_status = '<span class="badge badge-info">Pending</span>';
                                        //     }

                                        //     if ($transaction_id == NULL) {
                                        //         $transaction_id = "";
                                        //     }

                                        //     if ($payment_date == NULL) {
                                        //         $payment_date_new = "";
                                        //     }


                                        //     //student info 
                                        //     $subquery = "SELECT * FROM `tbl_students_2023` WHERE `enrollnment_no` = ?";
                                        //     $cmdstd = $con->prepare($subquery);
                                        //     $cmdstd->bind_param("s", $er_no); // Assuming 'enrollment_no' is a string

                                        //     // Execute the subquery
                                        //     $cmdstd->execute();
                                        //     $resultstd = $cmdstd->get_result();
                                        //     while ($rstd = $resultstd->fetch_assoc()) {
                                        //         $stu_name = $rstd["first_name"] . ' ' . $rstd["middle_name"] . ' ' . $rstd["last_name"];
                                        //     }

                                        //     $cmd3 = $con->prepare("SELECT * FROM `tbl_exam_form` WHERE `is_active` = 1 AND `id` = ?");
                                        //     $cmd3->bind_param("i", $examID);
                                        //     $cmd3->execute();
                                        //     $result3 = $cmd3->get_result();
                                        //     while ($row3 = $result3->fetch_assoc()) {
                                        //         $session = $row3['session'];
                                        //         $exyear = $row3['year'];
                                        //         $pr_id = $row3['program_id'];
                                        //         $lvl_id = $row3['level_id'];
                                        //         $fclt_id = $row3['faculty_id'];
                                        //         $exsem = $row3['semester'];

                                        //         $cmd4 = $con->prepare("SELECT * FROM `tbl_program` WHERE `is_active` = 1 AND `id` = ?");
                                        //         $cmd4->bind_param("i", $pr_id);
                                        //         $cmd4->execute();
                                        //         $result4 = $cmd4->get_result();
                                        //         while ($row4 = $result4->fetch_assoc()) {
                                        //             $p_name = $row4['name'];
                                        //         }
                                        //         $cmd5 = $con->prepare("SELECT * FROM `tbl_faculty` WHERE `is_active` = 1 AND `id` = ?");
                                        //         $cmd5->bind_param("i", $fclt_id);
                                        //         $cmd5->execute();
                                        //         $result5 = $cmd5->get_result();
                                        //         while ($row5 = $result5->fetch_assoc()) {
                                        //             $f_name = $row5['name'];
                                        //         }
                                        //     }
                                    ?>
                                        <tr>
                                            <td><?= $ApplicationName ?></td>
                                            <td class="text-nowrap"><?= $stu_name ?></td>
                                            <td><?= $er_no ?></td>
                                            <td><i class="fa fa-inr" style="font-size: 13px;"></i> <?= $amount ?></td>
                                            <td><?= $transaction_id ?></td>
                                            <td><?= $payment_id ?></td>
                                            <td><?= $pay_status ?></td>
                                            <td class="text-nowrap"><?= $payment_date_new ?></td>
                                            <td class="text-nowrap text-uppercase"><?= $session . '-' . $exyear ?></td>
                                            <td class="text-nowrap text-uppercase"><?= $f_name ?></td>
                                            <td class="text-nowrap text-uppercase"><?= $p_name ?></td>
                                            <td class="text-nowrap text-uppercase"><?= $extype ?></td>
                                            <td><?= $exsem ?></td>
                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include 'include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include 'include/importjs.php'; ?>
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

    <script>
        $(document).ready(function() {
            //call for listing the dropdown and select by default
            load_level();
            load_program();
        });

        function load_level() {
            var path = '<?php echo $base_url_api; ?>';
            var faculty_id = <?php echo $url_faculty_id; ?>;
            var level_id = <?php echo $url_level_id; ?>;
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

        
    </script>

</body>

</html>