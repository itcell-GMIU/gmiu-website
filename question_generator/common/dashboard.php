<?php
include '../include/checklogin.php';
?>
<?php
$stmtcmd = $con->prepare("SELECT COUNT(DISTINCT subject_code) AS total_unique_subjects
FROM tbl_questions
WHERE is_active = 1 AND is_delete = 0");
$stmtcmd->execute();
$result = $stmtcmd->get_result();

if ($row = $result->fetch_assoc()) {
    $question = $row['total_unique_subjects'];
} else {
    $question = 0; // fallback in case something goes wrong
}



$stmtcmd = $con->prepare("SELECT id from tbl_std_corner_exam where is_active = 1 and is_delete = 0");
$stmtcmd->execute();
$result = $stmtcmd->get_result();
$subject = $result->num_rows;

$stmtcmd = $con->prepare("SELECT id from tbl_bl_level where is_active = 1 and is_delete = 0");
$stmtcmd->execute();
$result = $stmtcmd->get_result();
$weightage = $result->num_rows;


$stmtcmd = $con->prepare("SELECT id from tbl_paper where is_active = 1 and is_delete = 0");
$stmtcmd->execute();
$result = $stmtcmd->get_result();
$paper = $result->num_rows;


$stmtcmd = $con->prepare("SELECT paper_id from tbl_paper_mcq where is_active = 1 and is_delete = 0");
$stmtcmd->execute();
$result = $stmtcmd->get_result();
$paper_mcq = $result->num_rows;


$stmtcmd = $con->prepare("SELECT id from tbl_staff where role_id IN ('8','51','54') and is_active = 1 and is_delete = 0");
$stmtcmd->execute();
$result = $stmtcmd->get_result();
$staff = $result->num_rows;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../include/importhead.php'; ?>

    <!-- Google Font: Source Sans Pro -->
    <?php include '../include/importcss.php'; ?>


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
                    </div>

                    <!-- Small boxes (Stat box) -->
                    <div class="row">

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3><?php echo "$subject"; ?></h3>
                                    <p>Total subject</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-book"></i>

                                </div>
                                <a href="../subject_weightage/subject_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3><?php echo "$weightage"; ?></h3>
                                    <p>Total subject Weightage</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios-analytics"></i>

                                </div>
                                <a href="../subject_weightage/view_weightage.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3><?php echo "$question"; ?></h3>
                                    <p>Total Questions</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-question-circle"></i>

                                </div>
                                <a href="../question_bank/view_question_bank.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <?php if ($role_id == "51") {
                        ?>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$paper"; ?></h3>
                                        <p>Total subject Paper</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-file-alt"></i>

                                    </div>
                                    <a href="../question_paper/view_generate_paper.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$paper_mcq"; ?></h3>
                                        <p>Total subject Paper MCQ</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-file-alt"></i>

                                    </div>
                                    <a href="../question_paper/view_generate_mcqpaper.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$staff"; ?></h3>
                                        <p>Total staff</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-users"></i>

                                    </div>
                                    <a href="../staff/staff_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        <?php } ?>
                        <!--<div class="col-lg-3 col-sm-6">-->
                        <!--    <ol class="breadcrumb float-sm-right">-->
                        <!--        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>-->
                        <!--        <li class="breadcrumb-item active">Dashboard</li>-->
                        <!--    </ol>-->
                        <!--</div>-->
                        <!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- /.content -->

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