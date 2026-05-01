    <?php
include '../include/checklogin.php';

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

    <?php
    
    $cmd = "SELECT `faculty_id` FROM `tbl_staff` WHERE `id` = $staff_id";
    $stmt = $con->prepare($cmd);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    $row = $result->fetch_assoc();
    $list_faculty_id = $row['faculty_id'];
    
    $stmtcmd = $con->prepare("SELECT id from tbl_level where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_levels_count = $result->num_rows;
    
    // $stmtcmd = $con->prepare("SELECT btr.id 
    //                           FROM tbl_branch_transfer_requests btr
    //                           JOIN tbl_pac_form pac ON btr.student_id = pac.student_id
    //                           WHERE pac.faculty_id IN ($list_faculty_id)
    //                             AND btr.is_active = 1 
    //                             AND btr.is_delete = 0
    //                           ");
    // $stmtcmd->execute();
    // $result = $stmtcmd->get_result();
    // $transfer = $result->num_rows;
    if ($role_id == '14' && $user_email != 'dggohil@gmiu.edu.in' )
    {
    $stmtcmd = $con->prepare("SELECT btr.id 
                          FROM tbl_branch_transfer_requests btr
                          JOIN tbl_pac_form pac ON btr.student_id = pac.student_id
                          WHERE pac.faculty_id = ?
                            AND pac.program_id IN ($program_id)
                            AND btr.is_active = 1 
                            AND btr.is_delete = 0");
    $stmtcmd->bind_param("i", $list_faculty_id); // assuming it's an integer
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $transfer = $result->num_rows;
    
    $ccr = $con->prepare("SELECT
                                *
                            FROM
                                tbl_cancellation_requests AS tcr
                            JOIN tbl_pac_form AS tpf
                            ON
                                tcr.student_id = tpf.student_id
                            JOIN tbl_admission_student AS tas
                            ON
                                tpf.student_id = tas.id
                            WHERE
                             tas.faculty_id = ?
                             AND tas.program_id IN ($program_id)");
    $ccr->bind_param("i", $list_faculty_id);
    $ccr->execute();
    $ccrResult = $ccr->get_result();
    $total_ccr = $ccrResult->num_rows;
    }
    
    if ($role_id == '14' && $user_email == 'dggohil@gmiu.edu.in') {

    // Branch Transfer Requests - Filter by pac.mode = 'SM'
    $stmtcmd = $con->prepare("
        SELECT btr.id 
        FROM tbl_branch_transfer_requests btr
        JOIN tbl_pac_form pac ON btr.student_id = pac.student_id
        WHERE pac.mode = 'SM'
            AND btr.is_active = 1 
            AND btr.is_delete = 0
    ");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $transfer = $result->num_rows;

    // Cancellation Requests - Filter by pac.mode = 'SM'
    $ccr = $con->prepare("
        SELECT *
        FROM tbl_cancellation_requests AS tcr
        JOIN tbl_pac_form AS tpf ON tcr.student_id = tpf.student_id
        JOIN tbl_admission_student AS tas ON tpf.student_id = tas.id
        WHERE tpf.mode = 'SM'
    ");
    $ccr->execute();
    $ccrResult = $ccr->get_result();
    $total_ccr = $ccrResult->num_rows;
}

    
    ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- /.login-logo -->
    <div id="preloader">
        <div id="status">&nbsp;

        </div>
    </div>
    <div class="wrapper">
        <!-- Navbar -->
        <?php include '../include/importnav.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include '../include/importsidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <?php
                    if ($role_id == 12 || $role_id == 11) {
                    ?>
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT first_name FROM tbl_inquiry_student where is_delete =  0 and is_active = 1");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Total Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>

                                    <a href="../students/student_view.php?url_for=all" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT first_name 
                                                                   FROM tbl_inquiry_student 
                                                                   WHERE is_admission_confirm = 0 
                                                                    AND is_delete = 0 
                                                                    AND is_active = 1
                                                                    AND inq_student_id NOT IN (
                                                                        SELECT inq_student_id 
                                                                        FROM tbl_inquiry_remarks 
                                                                        WHERE is_followup_need = 0
                                                                        GROUP BY inq_student_id
                                                                    );  ");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Students in Inquiry</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../students/student_view.php?url_for=inq" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT first_name FROM tbl_inquiry_student WHERE is_admission_confirm = 1 and is_delete =  0 ");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Students in admission confirm</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../students/student_view.php?url_for=admission_confirm" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT email FROM tbl_subscribers");
                                        $total_subscriber = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_subscriber ?></h3>
                                        <p>Website subscribers</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../students/subscriber.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT email FROM tbl_website_contact_us");
                                        $total_feedback = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_feedback ?></h3>
                                        <p>Website Feedback</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../students/feedback.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                             <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT DISTINCT id FROM tbl_inquiry_photos WHERE is_delete = '0' and type= 'call_doc' ");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Calling Script</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../admin/doc_view.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                        </div>
                    <?php
                    } elseif ($role_id == 15) {
                    ?>
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT DISTINCT id FROM tbl_inquiry_photos WHERE is_delete = '0' and type= 'call_doc' ");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Calling Script</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../admin/doc_view.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                              <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        // $sql = mysqli_query($con, "SELECT first_name FROM tbl_inquiry_student WHERE is_admission_confirm = 1 and is_delete =  0 ");
                                        $sql = mysqli_query($con, "SELECT first_name FROM tbl_inquiry_student WHERE is_admission_confirm = 1 and staff_id = $staff_id and is_delete =  0 ");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Students in admission confirm</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../counselor/conform_admission_list.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        // $sql = mysqli_query($con, "SELECT id FROM tbl_call_history WHERE staff_id = '$staff_id'");
                                         $sql = mysqli_query($con, "SELECT DISTINCT inq_student_id FROM tbl_call_history WHERE staff_id = '$staff_id'");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Completed call Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../staff/completed_calls.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT id FROM tbl_call_history WHERE staff_id = '$staff_id' AND DATE(call_datetime) = DATE(NOW()) ");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Today's Completed call Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../staff/completed_calls_today.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <?php
                                       // $sql = mysqli_query($con, "SELECT pro.first_name FROM tbl_inquiry_student as pro  LEFT JOIN tbl_inquiry_remarks R ON pro.inq_student_id = R.inq_student_id WHERE pro.staff_id = '$staff_id' AND R.is_followup_need = '0' AND pro.is_admission_confirm = '0'");
                                       // $sql = mysqli_query($con, "SELECT first_name FROM tbl_inquiry_student WHERE staff_id = '$staff_id' AND is_admission_confirm = '0' and is_delete =  0 ");
                                       $sql = mysqli_query($con, "SELECT s.id AS student_count
                                        FROM tbl_inquiry_student s
                                        LEFT JOIN tbl_inquiry_remarks r ON s.inq_student_id = r.inq_student_id
                                        WHERE ((r.inq_student_id IS NULL OR r.staff_id = $staff_id and r.is_followup_need = '0')) and s.staff_id = $staff_id  and s.is_delete =  0 
                                         " ); 
                                       $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Pending Call Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-rotate-right"></i>
                                    </div>
                                    <a href="../staff/view_assign_student.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <?php
                                         $sql = mysqli_query($con, "SELECT pro.first_name FROM tbl_inquiry_student as pro  LEFT JOIN tbl_inquiry_remarks R ON pro.inq_student_id = R.inq_student_id WHERE pro.staff_id = '$staff_id' AND R.is_followup_need = '1' AND pro.is_admission_confirm = '0' and pro.is_delete =  0 GROUP BY pro.id ");
                                        //$sql = mysqli_query($con, "SELECT pro.first_name FROM tbl_inquiry_student as pro  LEFT JOIN tbl_inquiry_remarks R ON pro.inq_student_id = R.inq_student_id WHERE pro.staff_id = '$staff_id' AND R.is_followup_need = '1' AND pro.is_admission_confirm = '0' and pro.is_delete =  0");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Follow Up Call Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-rotate-right"></i>
                                    </div>
                                    <a href="../staff/view_followup.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                  <div class="small-box bg-danger">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT R.inq_student_id, pro.first_name FROM tbl_inquiry_student as pro  LEFT JOIN tbl_inquiry_remarks R ON pro.inq_student_id = R.inq_student_id WHERE DATE(R.follow_up_date) = DATE(NOW()) AND R.staff_id = $staff_id AND R.is_followup_need = '1' AND pro.is_admission_confirm = '0' and pro.is_delete =  0 ");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Today's Follow Up Call Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-rotate-right"></i>
                                    </div>
                                    <a href="../staff/view_followup_today.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php
                    } elseif ($role_id == 13) { ?>
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT first_name FROM tbl_inquiry_student ");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Total Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../students/student_view.php?url_for=all" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT first_name FROM tbl_inquiry_student WHERE is_admission_confirm = 0  and is_delete =  0");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Students in Inquiry</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../students/student_view.php?url_for=inq" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>

                    <?php  } elseif ($role_id == 14 || $role_id == 22 || $role_id == 23) {
                    ?>
                       <div class="row">
                            <!-- <div class="col-lg-3 col-6">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        // $sql = mysqli_query($con, "SELECT first_name FROM tbl_inquiry_student WHERE is_admission_confirm = 0 and faculty_id = $faculty_id and level_id = $level_id and program_id = $program_id ");

                                        // $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?php //echo //$total_students; 
                                            ?></h3>
                                        <p>Inquiry of Students in Your Faculty</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../inquiry_head/assign_student.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div> -->
                            <?php
                            if($role_id == '14' || $user_email == 'dggohil@gmiu.edu.in' ){
                                
                               $sql = mysqli_query($con, "
                                                        SELECT stu.first_name 
                                                        FROM tbl_admission_student AS stu
                                                        INNER JOIN tbl_pac_form AS pac ON stu.id = pac.student_id
                                                        WHERE stu.is_active = 1 
                                                            AND stu.is_delete = 0 
                                                            AND stu.payment_status = 'success' 
                                                            AND stu.admission_status != 'rejected' 
                                                            AND pac.mode = 'SM'
                                                    ");
                              $total_students = mysqli_num_rows($sql);
                            ?>
                             <div class="col-lg-3 col-6">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                      
                                        <h3><?= $total_students ?></h3>
                                        <p>Students in admission confirm</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../inquiry_head/conform_admission_head.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <?php 

                            }
                             if($role_id == '14' ||  $user_email == 'dggohil@gmiu.edu.in' )
                                        {
                                              $sql = mysqli_query($con, "
                                                        SELECT stu.first_name 
                                                        FROM tbl_admission_student AS stu
                                                        INNER JOIN tbl_pac_form AS pac ON stu.id = pac.student_id
                                                        WHERE stu.is_active = 1 
                                                            AND stu.is_delete = 0 
                                                            AND stu.payment_status = 'success' 
                                                            AND stu.admission_status = 'approved' 
                                                            AND pac.mode = 'SM'
                                                    ");
                                                     $total_students = mysqli_num_rows($sql);
                           ?>
                             <div class="col-lg-3 col-6">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                       
                                        <h3><?= $total_students ?></h3>
                                        <p>Admission Approved Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../inquiry_head/conform_admission_head.php?url_for=admission_approved_student" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <?} ?>
                             <?php if ($role_id == 14  && $user_email != 'dggohil@gmiu.edu.in') {   ?>
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3><?php echo "$transfer"; ?></h3>

                                            <p>Branch Transfer Request</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-person-add"></i>
                                        </div>
                                        <a href="../inquiry_head/view_branch_request.php" class="small-box-footer">More
                                            info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                  <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3><?php echo "$total_ccr"; ?></h3>

                                            <p>Admission Cancellation Request</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-person-add"></i>
                                        </div>
                                        <a href="../inquiry_head/view_cancellation_request.php" class="small-box-footer">More
                                            info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            <?php } ?>
                            
                             <?php if ($role_id == 22) {   ?> 
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <?php
                                            // Query to get the total number of marketing visits
                                            $sql = mysqli_query($con, "SELECT COUNT(*) AS total_visits FROM tbl_marketing_visit where is_delete = 0");
                                            $row = mysqli_fetch_assoc($sql);
                                            $total_visits = $row['total_visits'];
                                            ?>
                                            <h3><?= $total_visits ?></h3>
                                            <p>Total Marketing Visits</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-bullhorn"></i>
                                        </div>
                                        <a href="../counselor/marketing_visit_view.php" class="small-box-footer">
                                            More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>

                                </div>
                            <?php   } elseif ($role_id == 23) { ?>
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <?php
                                            // Query to get the total number of marketing visits
                                            $sql = mysqli_query($con, "SELECT COUNT(*) AS total_visits FROM tbl_marketing_visit where is_delete = 0");
                                            $row = mysqli_fetch_assoc($sql);
                                            $total_visits = $row['total_visits'];
                                            ?>
                                            <h3><?= $total_visits ?></h3>
                                            <p>Total Marketing Visits</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-bullhorn"></i>
                                        </div>
                                        <a href="../counselor/marketing_visit_view.php" class="small-box-footer">
                                            More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>

                                </div>
                                 <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <?php
                                            // Query to get the total number of marketing visits
                                            $sql = mysqli_query($con, "SELECT COUNT(*) AS total_task FROM tbl_daily_task where is_delete = 0");
                                            $row = mysqli_fetch_assoc($sql);
                                            $total_task = $row['total_task'];
                                            ?>
                                            <h3><?= $total_task ?></h3>
                                            <p>Total Daily Task</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-tasks"></i>
                                        </div>
                                        <a href="../counselor/dailytask_view.php" class="small-box-footer">
                                            More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>

                                </div>
                                
                            <?php } ?>
                        </div>
                    <?php } elseif ($role_id == 16 || $role_id == 20 || $role_id == 21 || $role_id == 25 || $role_id == 26 || $role_id == 30 ) {
                    ?>
                        <div class="row">

                            <!--<div class="col-lg-3 col-6">-->
                            <!--    <div class="small-box bg-primary">-->
                            <!--        <div class="inner">-->
                                        <?php
                                    //  $sql = mysqli_query($con, "SELECT first_name FROM tbl_inquiry_student WHERE is_admission_confirm = 0 and is_delete =  0 ");
                                     //  $total_students = mysqli_num_rows($sql);
                                       ?>
                            <!--            <h3><?//= $total_students ?></h3>-->
                            <!--            <p>Students in Inquiry</p>-->
                            <!--        </div>-->
                            <!--        <div class="icon">-->
                            <!--            <i class="ion ion-person"></i>-->
                            <!--        </div>-->
                            <!--        <a href="../counselor/student_list.php" class="small-box-footer">More-->
                            <!--            info <i class="fas fa-arrow-circle-right"></i></a>-->
                            <!--    </div>-->
                            <!--</div>-->
                             <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT DISTINCT id FROM tbl_inquiry_photos WHERE is_delete = '0' and type= 'call_doc' ");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Calling Script</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../admin/doc_view.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT first_name FROM tbl_inquiry_student WHERE is_admission_confirm = 1 and staff_id = $staff_id and is_delete =  0 ");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Students in admission confirm</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../counselor/conform_admission_list.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT id FROM tbl_inquiry_student WHERE staff_id = '$staff_id' and is_delete = '0'  AND is_admission_confirm = '0'  ");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Total Assign Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <ahref="#" class="small-box-footer">
                                        &nbsp;</a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        // $sql = mysqli_query($con, "SELECT id FROM tbl_call_history WHERE staff_id = '$staff_id'  ");
                                        $sql = mysqli_query($con, "SELECT DISTINCT inq_student_id FROM tbl_call_history WHERE staff_id = '$staff_id'  ");
                                       
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Completed call Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../staff/completed_calls.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT id FROM tbl_call_history WHERE staff_id = '$staff_id' AND DATE(call_datetime)  = DATE(NOW())");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Today's Completed call Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person"></i>
                                    </div>
                                    <a href="../staff/completed_calls_today.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <?php
                                        //$sql = mysqli_query($con, "SELECT pro.first_name FROM tbl_inquiry_student as pro  LEFT JOIN tbl_inquiry_remarks R ON pro.inq_student_id = R.inq_student_id  and R.staff_id = $staff_id  WHERE pro.staff_id = '$staff_id' AND R.is_followup_need = '0' ");  
                                        $sql = mysqli_query($con, "SELECT s.id AS student_count
                                        FROM tbl_inquiry_student s
                                        LEFT JOIN tbl_inquiry_remarks r ON s.inq_student_id = r.inq_student_id
                                        WHERE ((r.inq_student_id IS NULL OR r.staff_id = $staff_id and r.is_followup_need = '0')) and s.staff_id = $staff_id  and s.is_delete =  0 and s.is_admission_confirm = '0' "
                                        );                                    
                                  
                                      //  $sql = mysqli_query($con, "SELECT first_name FROM tbl_inquiry_student WHERE staff_id = '$staff_id' AND is_admission_confirm = '0'"); 
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Pending Call Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-rotate-right"></i>
                                    </div>
                                    <a href="../staff/view_assign_student.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <?php
                                        //  $sql = mysqli_query($con, "SELECT s.id AS student_count
                                        //  FROM tbl_inquiry_student s
                                        //  LEFT JOIN tbl_inquiry_remarks r ON s.inq_student_id = r.inq_student_id
                                        // WHERE ((r.inq_student_id IS NULL OR r.staff_id = $staff_id )) and r.is_followup_need = '1' and s.staff_id = $staff_id  and s.is_delete =  0");
                                      $sql = mysqli_query($con, "SELECT pro.first_name FROM tbl_inquiry_student as pro  LEFT JOIN tbl_inquiry_remarks R ON pro.inq_student_id = R.inq_student_id WHERE pro.staff_id = '$staff_id' AND R.is_followup_need = '1' AND pro.is_admission_confirm = '0' and pro.is_delete =  0 GROUP BY pro.id");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Follow Up Call Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-rotate-right"></i>
                                    </div>
                                    <a href="../staff/view_followup.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <?php
                                        // $sql = mysqli_query($con, "SELECT R.inq_student_id, pro.first_name FROM tbl_inquiry_student as pro  LEFT JOIN tbl_inquiry_remarks R ON pro.inq_student_id = R.inq_student_id WHERE DATE(R.follow_up_date) = DATE(NOW()) AND R.staff_id = $staff_id AND R.is_followup_need = '1' AND pro.is_admission_confirm = '0' and pro.is_delete =  0 ");
                                         $sql = mysqli_query($con, "SELECT 
                                                COUNT(DISTINCT pro.inq_student_id) AS followup_count
                                            FROM 
                                                tbl_inquiry_student AS pro
                                            LEFT JOIN 
                                                tbl_inquiry_remarks R ON pro.inq_student_id = R.inq_student_id
                                            WHERE 
                                                R.id = (
                                                    SELECT MAX(sub_R.id)
                                                    FROM tbl_inquiry_remarks AS sub_R
                                                    WHERE sub_R.inq_student_id = pro.inq_student_id
                                                ) 
                                                AND DATE(R.follow_up_date) = DATE(NOW()) 
                                                AND R.staff_id = $staff_id
                                                AND R.is_followup_need = '1' 
                                                AND pro.is_admission_confirm = '0' 
                                                AND pro.is_delete = 0 ");
                                        $row = mysqli_fetch_assoc($sql);
                                        $total_students = $row['followup_count'];
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Today's Follow Up Call Students</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-rotate-right"></i>
                                    </div>
                                    <a href="../staff/view_followup_today.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            
                              <?php if ($role_id == 21 || $role_id == 20 || $role_id == 16 || $role_id == 30 ) {   ?>

                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <?php
                                            // Query to get the total number of marketing visits
                                            $sql = mysqli_query($con, "SELECT COUNT(*) AS total_visits FROM tbl_marketing_visit where staff_id = $staff_id and is_delete = 0 ");
                                            $row = mysqli_fetch_assoc($sql);
                                            $total_visits = $row['total_visits'];
                                            ?>
                                            <h3><?= $total_visits ?></h3>
                                            <p>Total Marketing Visits</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-bullhorn"></i>
                                        </div>
                                        <a href="../counselor/marketing_visit_view.php" class="small-box-footer">
                                            More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>

                                </div>
                            <?php   } if ($role_id == 20 || $role_id == 16 || $role_id == 30) { ?>
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <?php
                                            // Query to get the total number of marketing visits
                                            $sql = mysqli_query($con, "SELECT COUNT(*) AS total_task FROM tbl_daily_task where staff_id = $staff_id and is_delete = 0");
                                            $row = mysqli_fetch_assoc($sql);
                                            $total_task = $row['total_task'];
                                            ?>
                                            <h3><?= $total_task ?></h3>
                                            
                                            <p>Total Daily Task</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-tasks"></i>
                                        </div>
                                        <a href="../counselor/dailytask_view.php" class="small-box-footer">
                                            More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                             <?php } elseif ( $role_id == 31 ) { ?>
                   
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <?php
                                            // Query to get the total number of marketing visits
                                            $sql = mysqli_query($con, "SELECT COUNT(*) AS total_visits FROM tbl_marketing_visit where staff_id = $staff_id and is_delete = 0 ");
                                            $row = mysqli_fetch_assoc($sql);
                                            $total_visits = $row['total_visits'];
                                            ?>
                                            <h3><?= $total_visits ?></h3>
                                            <p>Total Marketing Visits</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-bullhorn"></i>
                                        </div>
                                        <a href="../counselor/marketing_visit_view.php" class="small-box-footer">
                                            More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>

                                </div>
                                 <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <?php
                                            // Query to get the total number of marketing visits
                                            $sql = mysqli_query($con, "SELECT COUNT(*) AS total_task FROM tbl_daily_task where staff_id = $staff_id and is_delete = 0");
                                            $row = mysqli_fetch_assoc($sql);
                                            $total_task = $row['total_task'];
                                            ?>
                                            <h3><?= $total_task ?></h3>
                                            
                                            <p>Total Daily Task</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-tasks"></i>
                                        </div>
                                        <a href="../counselor/dailytask_view.php" class="small-box-footer">
                                            More info <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                
                            </div>
                           

                        </div>
                    <?php } ?>
                    
                    <!-- /.row -->

                </div><!-- /.container-fluid -->
            </section>

        </div>
        <!-- /.content-wrapper -->

        <?php include '../include/importfooter.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php include '../include/importjs.php'; ?>
</body>

</html>