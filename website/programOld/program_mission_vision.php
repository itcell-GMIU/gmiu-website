<?php

include '../../common/importwebsitefile.php';

if (isset($_GET['program_id']) && !empty($_GET['program_id'])) {
    $program_id = mysqli_real_escape_string($con, $_GET['program_id']);
    $program_id = only_digits($program_id);
    if ($program_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='https://gmiu.edu.in/'},1000)</script>"; 
        }
    // fetch program details
    $cmd = $con->prepare("SELECT program.name as program_name from tbl_program as program WHERE id=? AND is_active=1 AND is_delete=0");
    $cmd->bind_param("i", $program_id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $program_name = $row['program_name'];
    } else {
        $program_name = "";
    }
} else {
    $program_id = "";
    $program_name = "";
}

if (isset($_GET['faculty_id']) && !empty($_GET['faculty_id'])) {
    $faculty_id = mysqli_real_escape_string($con, $_GET['faculty_id']);
    $faculty_id = only_digits($faculty_id);
    if ($faculty_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='https://gmiu.edu.in/'},1000)</script>"; 
        }
    //  fetch faculty details
    $cmd = $con->prepare("SELECT faculty.name as faculty_name from tbl_faculty as faculty WHERE id=? AND is_active=1 AND is_delete=0");
    $cmd->bind_param("i", $faculty_id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $faculty_name = $row['faculty_name'];
    } else {
        $faculty_name = "";
    }
} else {
    $faculty_id = "";
    $faculty_name = "";
}


// fetch mission vision details


?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url;?>css/program.css">
</head>

<body class="courses">
    <!-- Preloader-->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <?php include '../include/importheader.php'; ?>

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Mission Vision</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a
                            href="program.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>"><?php echo $program_name; ?></a>
                        <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#">Mission Vision</a></span>
                </p>
                <hr>
            </div>

        </div>

    </section>

    <div class="single-courses-area">
        <div class="container">
            <div style="padding: 20px 0;" class="row two-colum-section">
                <!-- left bar start  -->
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">
                        <!-- Faculty about  -->
                        <section class="events-area">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-7 events-full-box">
                                        <div class="events-single-box">
                                            <div class="row">
                                                <div class="col-sm-12 event-info">
                                                    <?php 
                                                    $cmd = $con->prepare("SELECT mission_vision.mission as mission_vision_mission, mission_vision.id as mission_vision_id,mission_vision.vision as  mission_vision_vision from tbl_mission_vision as mission_vision WHERE FIND_IN_SET(?,program_id) AND is_active=1 AND is_delete=0");
                                                    $cmd->bind_param("i", $program_id);
                                                    $cmd->execute();
                                                    $result = $cmd->get_result();
                                                    if ($result->num_rows != 0) {
                                                        $row = $result->fetch_assoc();
                                                        $mission_vision_mission = $row['mission_vision_mission'];
                                                        $mission_vision_vision = $row['mission_vision_vision'];
                                                   
                                                    ?>
                                                    <h3>MISSION</h3>
                                                    <hr>

                                                    <p><?php echo htmlspecialchars_decode($mission_vision_mission) ?>
                                                    </p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-7 events-full-box">
                                        <div class="events-single-box">
                                            <div class="row">
                                                <div class="col-sm-12 event-info">
                                                    <h3>VISION</h3>
                                                    <hr>
                                                    <p>
                                                        <?php echo htmlspecialchars_decode($mission_vision_vision) ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }  else {
                                        echo "No Mission & Vision Details Are Available";
                                    }
                                    ?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- left bar end  -->

                <!-- right bar start  -->

                <?php include '../include/importrightsidebar.php' ?>
                <!-- right bar end  -->
            </div>
        </div>
    </div>





    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->
    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>