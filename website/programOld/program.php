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

    //fetch program details
    $cmd = $con->prepare("SELECT level.name as level_name, program.name as program_name ,program.id as program_id,program.description as program_description from tbl_program as program LEFT JOIN tbl_level as level ON program.level_id = level.id
    WHERE program.id=? AND program.is_active=1 AND program.is_delete=0");
    $cmd->bind_param("i", $program_id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $program_name = $row['program_name'];
        $program_description = $row['program_description'];
        $level_name = $row['level_name'];
    } else {
        $program_name = "";
        $program_description = "";
    }
} else {
    $program_id = "";
    $program_name = "";
    $program_description = "";
}

if (isset($_GET['faculty_id']) && !empty($_GET['faculty_id'])) {
    $faculty_id = mysqli_real_escape_string($con, $_GET['faculty_id']);
    $faculty_id = only_digits($faculty_id);
    if ($faculty_id == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location=https://gmiu.edu.in/'},1000)</script>";
    }

    //  fetch faculty details
    $cmd = $con->prepare("SELECT faculty.name as faculty_name from tbl_faculty as faculty WHERE faculty.id=? AND faculty.is_active=1 AND faculty.is_delete=0");
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

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <style>
        .des p {
            margin: 0px 0px !important;
        }
    </style>
</head>

<body class="courses">
    <!--   Preloader -->
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
                    <h1><?php echo $program_name.' ('.$level_name .')'; ?></h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="faculty.php?id=<?php echo $faculty_id ?>"><?php echo $faculty_name; ?></a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#"><?php echo $program_name.' ('.$level_name .')'; ?></a></span>
                </p>
                <hr>
            </div>

        </div>

    </section>

    <div class="single-courses-area">
        <div class="container">
            <div class="row two-colum-section">
                <!-- left bar start  -->
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">
                        <!-- Faculty about  -->
                        <section class="des">
                            <h3 class="title gradText">About <?php echo $program_name.' ('.$level_name .')'; ?></h3>
                            <hr>
                            <p style="margin: 0px 0px;"><?php echo htmlspecialchars_decode($program_description) ?></p>

                        </section>

                        <!--  <section class="video-content">
                            <h3 class="title gradText">Video About Department</h3>
                            <hr>
                            <div class="video">
                                <iframe width="100%" height="315" src="https://www.youtube.com/embed/ZGO5Q8H3pwQ"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>
                        </section>


                        <section class="links-card">
                            <h3 class="title gradText">IMPORTANT LINKS</h3>
                            <hr>
                            <div class="cards-container">
                                <div class="card">
                                    <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px" class="center">
                                    <p>Admission Process</p>
                                </div>
                                <div class="card">
                                    <i class="fa fa-book"></i>
                                    <p>Brochure</p>
                                </div>
                                <div class="card">
                                    <i class="fa fa-question"></i>
                                    <p>FAQ</p>
                                </div>
                                <div class="card">
                                    <i class="fa fa-building"></i>
                                    <p>Hostel Facility</p>
                                </div>
                                <div class="card">
                                    <i class="fa fa-street-view"></i>
                                    <p>360 tour link</p>
                                </div>
                                <div class="card">
                                    <i class="fa fa-link"></i>
                                    <p>Apply Online</p>
                                </div>
                            </div>
                        </section>

                        <section class="links-card" style="margin-bottom : 35px"> 
                        <h3 class="title gradText">UNIQUE FEATURES OF OUR DEPARTMENT</h3>
                        <hr>
                        <div class="cards-container">
                            <div class="card">
                                <i class="fa fa-flask"></i>
                                <p>Advance Laboratories</p>
                            </div>
                            <div class="card">
                                <img src="https://www.gmiu.edu.in/assets/img/home/welcome-03.png" alt="" width="55px"
                                    class="center">
                                <p>Excellent Academic System</p>
                            </div>
                            <div class="card">
                                <i class="fa fa-flask"></i>
                                <p>SDP</p>
                            </div>
                            <div class="card">
                                <i class="fa fa-flask"></i>
                                <p>National/lnternational Association</p>
                            </div>
                        </div>
                        </section>-->

                        <!-- why study at gmiu -->
                        <section>
                            <h3 class="title gradText">WHY STUDY AT GMIU?</h3>
                            <hr>
                            <div class="courses-cards">

                                <div class="wel-text-box">
                                    <div class="wel-icon">
                                        <i class="fa-solid fa-user-graduate fa-gmiu"></i>
                                    </div>
                                    <div class="wel-text">
                                        <h3>HIGHEST PLACEMENT</h3>
                                        <p>Placement process GMIU is robust and transparent process which ensures that
                                            all student got equal chance in any placement drive according to their
                                            eligibility and skills expertise which match est with recruiters.</p>
                                    </div>
                                </div>
                                <div class="wel-text-box">
                                    <div class="wel-icon">
                                        <i class="fa-sharp fa-solid fa-arrow-up-right-dots fa-gmiu"></i>
                                    </div>
                                    <div class="wel-text">
                                        <h3>SUPPORT TO START UP</h3>
                                        <p>A startup or start-up is a company or project undertaken by an entrepreneur
                                            to seek, develop, and validate a scalable business model. While
                                            entrepreneurship refers to all new businesses, including self-employment...
                                        </p>
                                    </div>
                                </div>
                                <div class="wel-text-box">
                                    <div class="wel-icon">
                                        <i class="fa-solid fa-graduation-cap fa-gmiu"></i>
                                    </div>
                                    <div class="wel-text">
                                        <h3>EXCELLENT ACADEMIC SYSTEM</h3>
                                        <p>providing excellent teaching learning process by highly qualified faculties.
                                            GMIU is known for the outstanding calibre of its students, well qualified
                                            faculty dedicated to teaching and research and excellent infrastructure.</p>
                                    </div>
                                </div>
                                <div class="wel-text-box">
                                    <div class="wel-icon">
                                        <i class="fa-solid fa-lightbulb fa-gmiu"></i>
                                    </div>
                                    <div class="wel-text">
                                        <h3>RESEARCH & INNOVATION (R&I)</h3>
                                        <p>Research and innovation (R&I) plays an essential role in triggering smart and
                                            sustainable growth and job creation. Research is an intrinsic aspect of the
                                            idea development process. Research helps guide numerous decisions that turn
                                            an idea into an innovation.</p>
                                    </div>
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