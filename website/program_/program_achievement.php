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

?>


<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url;?>css/program.css">
</head>

<body class="courses">
    <!-- Preloader
<div id="preloader">
    <div id="status">&nbsp;</div>
</div> -->
    <?php include '../include/importheader.php'; ?>

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Achievement</h1>
                    <p style="font-size: 14px; text-transform: capitalize;">By Department Of <?= $program_name.' ('.$level_name .')'?></p>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a
                            href="program.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>"><?php echo $program_name.' ('.$level_name .')'; ?></a>
                        <i class='fa fa-angle-right'></i></span>
                    <span class="b-active">Achievement<a href=""></a></span>
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
                        <section class="student-achievement">
                            <h3 class="title gradText">STUDENT ACHIEVEMENT</h3>
                            <hr>

                            <div class="student-achievement-img-grid">
                                <?php
                                // fetch a data for student achievement
                                $cmd = $con->prepare("SELECT ach.id AS ach_id, ach.program_id AS program_id, ach.type AS ach_type, photo.type_id AS type_id, photo.type AS photo_type, photo.file_name AS file_name
                                                FROM tbl_achievement AS ach
                                                LEFT JOIN tbl_site_photos AS photo ON ach.id = photo.type_id AND photo.type = 'achievement'
                                                WHERE ach.program_id = ? AND ach.type = 'student';");
                                $cmd->bind_param("i", $program_id);
                                $cmd->execute();
                                $result = $cmd->get_result();
                                if ($result->num_rows != 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $file_name  = !empty($row['file_name']) ? $row['file_name'] : "<b>N/A</b>";
                                ?>

                                <img src="<?php echo $upload_website_admin_url."achievement/" . "$file_name"; ?>" alt=""
                                    class="image-grid" height="200" width="200">
                                <?php
                                    }
                                } else {
                                    echo "";
                                }
                                ?>


                            </div>

                        </section>

                        <section class="student-achievement">
                            <h3 class="title gradText">FACULTY ACHIEVEMENT</h3>
                            <hr>

                            <div class="student-achievement-img-grid">
                                <?php
                                // fetch a data for feculty achievement
                                $cmd = $con->prepare("SELECT ach.id AS ach_id, ach.program_id AS program_id, ach.type AS ach_type, photo.type_id AS type_id, photo.type AS photo_type, photo.file_name AS file_name
                                                FROM tbl_achievement AS ach
                                                LEFT JOIN tbl_site_photos AS photo ON ach.id = photo.type_id AND photo.type = 'achievement'
                                                WHERE FIND_IN_SET(?,ach.program_id) AND ach.type = 'faculty';");
                                $cmd->bind_param("i", $program_id);
                                $cmd->execute();
                                $result = $cmd->get_result();
                                if ($result->num_rows != 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $file_name  = !empty($row['file_name']) ? $row['file_name'] : "<b>N/A</b>";
                                ?>
                                <img src="<?php echo $upload_website_admin_url."achievement/" . "$file_name"; ?>" alt=""
                                    class="image-grid" height="200" width="200">
                                <?php
                                }
                            } else{
                                echo "";
                            }
                                ?>

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