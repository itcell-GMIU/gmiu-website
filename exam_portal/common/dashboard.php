<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include '../include/checklogin.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>

    <?php
    $stmtcmd = $con->prepare("SELECT id from tbl_level where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_levels_count = $result->num_rows;
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
                    if ($role_id == 51) {
                    ?>
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT id FROM tbl_exam_form WHERE is_active = 1");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Total Forms</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../exam_form/exam_form_view.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <?php 
                                         $id_count2 = $con->query("SELECT id FROM tbl_exam_student WHERE status = 3");
                                            $std_success_count = mysqli_num_rows($id_count2);
                                        ?>
                                        <h3><?= $std_success_count ?></h3>
                                        <p>Exam Form Report</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../exam_form/exam_form_reports.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-secondary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT Mtheory FROM tbl_exam_results WHERE Mtheory IS NOT NULL");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Theory Marks Entered</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/marksRecords.php?rc=theory" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-dark">
                                    <div class="inner">
                                        <h3>&nbsp;</h3>
                                        <p>GRADE REPORT</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/result_reports.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-secondary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT id FROM tbl_exam_reassement WHERE status = 1");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Re-check/Re-assessment</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/view_assesment.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3>&nbsp;</h3>
                                        <p>Mid Marks Entry Report</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/report_mid_marks.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3>&nbsp;</h3>
                                        <p>Re-Mid Marks Entry Report</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/report_rmid_marks.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-dark">
                                    <div class="inner">
                                        <h3>&nbsp;</h3>
                                        <p>Final Result Reports</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/final_result_reports.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-dark">
                                    <div class="inner">
                                        <h3>&nbsp;</h3>
                                        <p>ABC Final Result Reports</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/abc_final_result_reports.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3></h3>
                                        <p>Viva Marks Report</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/report_viva_marks.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3></h3>
                                        <p>ALA Marks Report</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/report_ala_marks.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3></h3>
                                        <p>Practical Marks Report</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/report_pr_marks.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php
                    } elseif ($role_id == 52) {
                    ?>
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT Mtheory FROM tbl_exam_results WHERE Mtheory IS NOT NULL AND examinerID = $staff_id ");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Theory Marks Entered</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/marksRecords.php?rc=theory" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <!-- <div class="col-lg-3 col-6">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <?php
                                        $sql = mysqli_query($con, "SELECT Mpractical FROM tbl_exam_results WHERE Mpractical IS NOT NULL AND examinerID = $staff_id ");
                                        $total_students = mysqli_num_rows($sql);
                                        ?>
                                        <h3><?= $total_students ?></h3>
                                        <p>Theory Marks Entered</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/marksRecords.php?rc=practical" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div> -->
                            
                        </div>
                        <?php
                    } elseif ($role_id == 53) {
                    ?>
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3></h3>
                                        <p>Mid Marks Report</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/report_mid_marks.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3></h3>
                                        <p>Re-Mid Marks Report</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/report_rmid_marks.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3></h3>
                                        <p>Viva Marks Report</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/report_viva_marks.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3></h3>
                                        <p>ALA Marks Report</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/report_ala_marks.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3></h3>
                                        <p>Practical Marks Report</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-document"></i>
                                    </div>
                                    <a href="../resultsMng/report_pr_marks.php" class="small-box-footer">More
                                        info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

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