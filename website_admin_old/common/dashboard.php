<?php
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

    $stmtcmd = $con->prepare("SELECT id from tbl_faculty where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_faculty_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_program where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_programs_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_staff where is_active = 1 and is_delete = 0 and role_id=4");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_staff_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_daily_post where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_daily_post_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_brochure where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_brochure_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_media_coverage where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_media_coverage_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_mission_vision where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_mission_vision_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_placement where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_placement_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_program_outcome where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_program_outcome_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_sdp where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_sdp_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_testimonial where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_testimonial_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_timetable where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_timetable_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_workshop where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_workshop_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_laboratories where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_laboratories_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_daily_post where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_dailypost_count = $result->num_rows;


    $stmtcmd = $con->prepare("SELECT id from tbl_expert_talk where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_expert_talk_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_industry_visit where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_industry_visit_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_achievement where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_achievement_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_achievement where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_achievement_count = $result->num_rows;

    $stmtcmd = $con->prepare("SELECT id from tbl_circular where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_circular_count = $result->num_rows;
    
    $stmtcmd = $con->prepare("SELECT id from tbl_daily_post where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_daily_post = $result->num_rows;
    
    $stmtcmd = $con->prepare("SELECT id from tbl_bitly_post where is_active = 1 and is_delete = 0");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_bitly_post = $result->num_rows;
    
    $stmtcmd = $con->prepare("SELECT id from tbl_site_photos where is_active = 1 and is_delete = 0 and type='slider_image' ");
    $stmtcmd->execute();
    $result = $stmtcmd->get_result();
    $total_slide = $result->num_rows;

    $stmtCareer = $con->prepare("SELECT id FROM tbl_career WHERE is_active = 1 AND is_delete = 0");
    $stmtCareer->execute();
    $resultCareer = $stmtCareer->get_result();
    $total_career_posts = $resultCareer->num_rows;
    
    $stmtCareerApp = $con->prepare("SELECT id FROM tbl_career_applications WHERE is_active = 1 AND is_delete = 0");
    $stmtCareerApp->execute();
    $resultCareerApp = $stmtCareerApp->get_result();
    $total_career_applications = $resultCareerApp->num_rows;

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

            <!-- Main content -->
            <?php
            if ($role_id == '5') {
            ?>
                <!--======================================================================================================================================================================-->
                <!----------------------------------------------------------------------------- Sub admin cards ---------------------------------------------------------------------------->
                <!--======================================================================================================================================================================-->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_staff_count"; ?></h3>
                                        <p>Total Staff Department</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../staff/staff_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_laboratories_count"; ?></h3>
                                        <p>Total Laboratories</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../laboratories/laboratories_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_mission_vision_count"; ?></h3>
                                        <p>Total Mission & Vision</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../mission_vision/mission_vision_view.php" class="small-box-footer">More info
                                        <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_program_outcome_count"; ?></h3>
                                        <p>Total Programs Outcome</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../program_outcome/program_outcome_view.php" class="small-box-footer">More info
                                        <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_timetable_count"; ?></h3>
                                        <p>Total Time Table</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../time_table/timetable_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_expert_talk_count"; ?></h3>
                                        <p>Total Expert Talk</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../expert_talk/expert_talk_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_industry_visit_count"; ?></h3>
                                        <p>Total Industry Visit</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../industry_visit/industryvisit_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_workshop_count"; ?></h3>
                                        <p>Total Workshop</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../workshop/workshop_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_achievement_count"; ?></h3>
                                        <p>Total Achievement</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../achievement/achievement_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <!-- /.row -->

                    </div><!-- /.container-fluid -->
                </section>

                <!--======================================================================================================================================================================-->
                <!----------------------------------------------------------------------------- Sub admin cards end ------------------------------------------------------------------------>
                <!--======================================================================================================================================================================-->
            <?php } elseif ($role_id == '6') { ?>
                <!--======================================================================================================================================================================-->
                <!----------------------------------------------------------------------------- main admin cards --------------------------------------------------------------------------->
                <!--======================================================================================================================================================================-->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_levels_count"; ?></h3>

                                        <p>Total Levels</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../level/level_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_faculty_count"; ?></h3>

                                        <p>Total Faculty</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../faculty/faculty_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_programs_count"; ?></h3>
                                        <p>Total Programs</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../program/program_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_staff_count"; ?></h3>
                                        <p>Total Staff Department</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../staff/staff_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_laboratories_count"; ?></h3>
                                        <p>Total Laboratories</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../laboratories/laboratories_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_brochure_count"; ?></h3>
                                        <p>Total E-Brochure</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../brochure/brochure_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_dailypost_count"; ?></h3>
                                        <p>Total Daily Post</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../daily_post/daily_post_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_testimonial_count"; ?></h3>
                                        <p>Total Testimonial</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../testimonials/testimonial_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_mission_vision_count"; ?></h3>
                                        <p>Total Mission & Vision</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../mission_vision/mission_vision_view.php" class="small-box-footer">More info
                                        <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_program_outcome_count"; ?></h3>
                                        <p>Total Programs Outcome</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../program_outcome/program_outcome_view.php" class="small-box-footer">More info
                                        <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_timetable_count"; ?></h3>
                                        <p>Total Time Table</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../time_table/timetable_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_placement_count"; ?></h3>
                                        <p>Total Placement Statistics</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../placement_statistics/placement_view.php" class="small-box-footer">More info
                                        <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_expert_talk_count"; ?></h3>
                                        <p>Total Expert Talk</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../expert_talk/expert_talk_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_industry_visit_count"; ?></h3>
                                        <p>Total Industry Visit</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../industry_visit/industryvisit_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_workshop_count"; ?></h3>
                                        <p>Total Workshop</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../workshop/workshop_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_sdp_count"; ?></h3>
                                        <p>Total SDP</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../sdp/sdp_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_achievement_count"; ?></h3>
                                        <p>Total Achievement</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../achievement/achievement_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                           

                            <!-- /.row -->
                        </div>



                    </div><!-- /.container-fluid -->
                </section>
                <!--======================================================================================================================================================================-->
                <!----------------------------------------------------------------------------- main admin cards end ----------------------------------------------------------------------->
                <!--======================================================================================================================================================================-->
            <?php } elseif ($role_id == '8') { ?>
                <!--======================================================================================================================================================================-->
                <!----------------------------------------------------------------------------- hod admin cards ---------------------------------------------------------------------------->
                <!--======================================================================================================================================================================-->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_achievement_count"; ?></h3>
                                        <p>Total Achievement</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../achievement/achievement_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_expert_talk_count"; ?></h3>
                                        <p>Total Expert Talk</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../expert_talk/expert_talk_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_industry_visit_count"; ?></h3>
                                        <p>Total Industry Visit</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../industry_visit/industryvisit_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_workshop_count"; ?></h3>
                                        <p>Total Workshop</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../workshop/workshop_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_sdp_count"; ?></h3>
                                        <p>Total SDP</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../sdp/sdp_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_mission_vision_count"; ?></h3>
                                        <p>Total Mission & Vision</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../mission_vision/mission_vision_view.php" class="small-box-footer">More info
                                        <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_program_outcome_count"; ?></h3>
                                        <p>Total Programs Outcome</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../program_outcome/program_outcome_view.php" class="small-box-footer">More info
                                        <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_timetable_count"; ?></h3>
                                        <p>Total Time Table</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../time_table/timetable_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_laboratories_count"; ?></h3>
                                        <p>Total Laboratories</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../laboratories/laboratories_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>


                        </div>
                        <!-- /.row -->

                    </div><!-- /.container-fluid -->
                </section>

                <!--======================================================================================================================================================================-->
                <!----------------------------------------------------------------------------- hod admin cards end ------------------------------------------------------------------------>
                <!--======================================================================================================================================================================-->
            <?php } elseif ($role_id == '9') { ?>
                <!--======================================================================================================================================================================-->
                <!----------------------------------------------------------------------------- hr admin cards ------------------------------------------------------------------------------>
                <!--======================================================================================================================================================================-->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_circular_count"; ?></h3>
                                        <p>Total Circular</p>
                                    </div>
                                    <div class="icon">
                                      <i class="fa-solid fa-newspaper"></i>
                                    </div>
                                    <a href="../circular/circular_view.php" class="small-box-footer">More info
                                        <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                                <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3><?php echo "$total_staff_count"; ?></h3>
                                        <p>Total Staff Department</p>
                                    </div>
                                    <div class="icon">
                                          <i class="fa-solid fa-users"></i>
                                    </div>
                                    <a href="../staff/staff_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                              <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3><?php echo "$total_career_posts"; ?></h3>
                                        <p>Total Career Notifications</p>
                                    </div>
                                    <div class="icon">
                                     <i class="fa-solid fa-bullhorn"></i>
                                    </div>
                                    <a href="../career_manage/view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                              <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3><?php echo "$total_career_applications"; ?></h3>
                                        <p>Total Career Applications</p>
                                    </div>
                                    <div class="icon">
                                       <i class="ion ion-clipboard"></i>
                                    </div>
                                    <a href="../career_manage/career_cv.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                        </div>
                        <!-- /.row -->

                    </div><!-- /.container-fluid -->
                </section>

                <!--======================================================================================================================================================================-->
                <!----------------------------------------------------------------------------- hr admin cards end ------------------------------------------------------------------------->
                <!--======================================================================================================================================================================-->
            <?php
            }
            elseif ($role_id == '10') { ?>
                <!--======================================================================================================================================================================-->
                <!----------------------------------------------------------------------------- Promotional admin cards ------------------------------------------------------------------------------>
                <!--======================================================================================================================================================================-->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                             <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_media_coverage_count"; ?></h3>
                                        <p>Total Media Coverage</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-camera"></i>
                                    </div>
                                    <a href="../media_coverage/mediacoverage_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                             <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_daily_post"; ?></h3>
                                        <p>Total Daily Post</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-calendar"></i>
                                    </div>
                                    <a href="../daily_post/daily_post_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                             <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_bitly_post"; ?></h3>
                                        <p>Total Bitly Post</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-link"></i>
                                    </div>
                                    <a href="../bitly_post/bitly_post_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                             <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_slide"; ?></h3>
                                        <p>Total Homepage Slider</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-grid"></i>
                                    </div>
                                    <a href="../homepage_slider/slider_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                        </div>
                        <!-- /.row -->

                    </div><!-- /.container-fluid -->
                </section>

             <?php } elseif($role_id == '11') { ?>
                
                <section class="content">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                             <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_media_coverage_count"; ?></h3>
                                        <p>Total Media Coverage</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../media_coverage/mediacoverage_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                             <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_daily_post"; ?></h3>
                                        <p>Total Daily Post</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../daily_post/daily_post_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                             <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_bitly_post"; ?></h3>
                                        <p>Total Bitly Post</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../bitly_post/bitly_post_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                             <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo "$total_slide"; ?></h3>
                                        <p>Total Homepage Slider</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="../homepage_slider/slider_view.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                        </div>
                        <!-- /.row -->

                    </div><!-- /.container-fluid -->
                </section>
                
                
                <?php } ?>
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