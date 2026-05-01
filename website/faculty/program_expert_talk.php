<?php
include '../../common/importwebsitefile.php';
if (isset($_GET['program_slug']) && !empty($_GET['program_slug'])) {
    $program_slug = mysqli_real_escape_string($con, $_GET['program_slug']);
    // $program_slug = only_digits($program_slug);
    if ($program_slug == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location='https://gmiu.edu.in/'},1000)</script>";
    }

    //fetch program details
    $cmd = $con->prepare("SELECT level.name as level_name, 
     REPLACE(
        REPLACE(
            REPLACE(
                program.name,
                'premium', 'PLM'
            ),
            'Premium', 'PLM'
        ),
        'PREMIUM', 'PLM'
    ) AS program_name,
    program.id as program_id, program.description as program_description from tbl_program as program LEFT JOIN tbl_level as level ON program.level_id = level.id
    WHERE program.program_slug=? AND program.is_active=1 AND program.is_delete=0");
    $cmd->bind_param("s", $program_slug);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $program_name = $row['program_name'];
        $program_id = $row['program_id'];
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

if (isset($_GET['faculty_slug']) && !empty($_GET['faculty_slug'])) {
    $faculty_slug = mysqli_real_escape_string($con, $_GET['faculty_slug']);
    // $faculty_slug = only_digits($faculty_slug);
    if ($faculty_slug == false) {
        $_SESSION['status'] = "Invalid data in url";
        $_SESSION['status_code'] = "error";
        echo "<script>setTimeout(function(){window.location=https://gmiu.edu.in/'},1000)</script>";
    }

    //  fetch faculty details
    $cmd = $con->prepare("SELECT faculty.id as faculty_id, faculty.name as faculty_name from tbl_faculty as faculty WHERE faculty.faculty_slug=? AND faculty.is_active=1 AND faculty.is_delete=0");
    $cmd->bind_param("s", $faculty_slug);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $faculty_name = $row['faculty_name'];
        $faculty_id = $row['faculty_id'];
    } elseif ($faculty_slug == 'faculty-of-engineering-amp-technology-diploma') {
        // Fetch faculty_description from the database where id = 1
        $query = $con->prepare("SELECT description FROM tbl_faculty WHERE id = 1");
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();

        $faculty_id = '1';
        $faculty_name = 'INSTITUTE OF ENGINEERING & TECHNOLOGY(DIPLOMA)';
        $faculty_description = $row['description'];
    }else {
        $faculty_name = "";
    }
} else {
    $faculty_id = "";
    $faculty_name = "";
}
if (!isset($program_slug) || empty($program_slug) || empty($program_name)) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: " . $base_url_website_faculty . $faculty_slug);
    exit;
}



?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
        /* .swiper {
            height: auto !important;
        }
        .swipermain{
            height: 200px !important;
        }

        .swiper-slide img {
            display: block;
            width: 80px ;
            height: 80px;
            object-fit: cover;
            border-radius: 5px !important;

            aspect-ratio: 16 / 9 !important;
        } */
        .swiper {
            width: 100%;
            height: 100%;
            margin: 20px;

        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            /* background: #fff; */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
        }

        .swiper {
            width: 100%;
            height: auto;
            aspect-ratio: 16/10;
            margin-left: auto;
            margin-right: auto;
        }

        .swiper-slide {
            background-size: cover;
            background-position: center;
        }

        .mySwiper2 {
            height: 80%;
            width: 100%;
        }

        .mySwiper {
            height: 20%;
            box-sizing: border-box;
            padding: 10px 0;
        }

        .mySwiper .swiper-slide {
            width: 25%;
            height: 100%;
            opacity: 0.4;
        }

        .mySwiper .swiper-slide-thumb-active {
            opacity: 1;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
        }

        .events-list-03 .events-single-box img {
            border-radius: 5px;
        }

        .events-list-03 .event-info {
            padding-top: 0;
        }

        .events-list-03 .events-single-box {
            background-color: white;
        }

        #dwn-btn {
            padding: 5px 10px;
            background-color: #ba2a21;
            color: white;
            border: 1px transparent;
            border-radius: 4px;
        }

        #dwn-btn:hover {
            transform: translateY(-5px);
            transition: all .3s ease-in-out;
        }
        .swiper-button-next, 
        .swiper-button-prev {
            color: #dce4ed;
        }

        @media screen and (min-width: 992px) {
            .swiper {
                margin-bottom: -55px !important;
            }

            .event-info {
                margin-top: 0 !important;
                padding-top: 0 !important;
            }

            .swiper-pagination {
                margin-bottom: 45px;
            }
        }
    </style>
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
                    <h1>Expert Talk</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i
                            class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a
                            href="<?php echo $base_url_website_faculty; ?><?php echo $faculty_slug; ?>"><?php echo $faculty_name; ?></a>
                        <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a
                            href="<?php echo $base_url_website_faculty ?><?php echo $faculty_slug; ?>/<?php echo $program_slug; ?>"><?php echo $program_name; ?></a>
                        <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#">Expert Talk</a></span>
                </p>
                <hr>
            </div>

        </div>

    </section>

    <div class="single-courses-area">
        <div class="container">
            <section class="placed-students">
                <div class="buttons-container-flex" style="padding: 10px;">

                    <?php
                    //code for getting year buttons by grouping year in placement table
                    $cmd = "SELECT YEAR(date) FROM tbl_expert_talk WHERE is_active = 1 AND is_delete = 0 and FIND_IN_SET('$program_id', program_id) and faculty_id = $faculty_id GROUP BY YEAR(date) ORDER BY YEAR(date)DESC ";
                    $stmt = $con->prepare($cmd);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $sem_btn = $row['YEAR(date)'];
                        ?>
                        <!-- <a href="#s-<?php echo $sem_btn; ?>"> -->
                        <button class="tabBtn" data-semester="<?php echo $sem_btn; ?>"
                            onclick="showSemester(<?php echo $sem_btn; ?>)"><?php echo $sem_btn; ?></button>
                        <!-- </a> -->
                        <?php
                    }
                    ?>
                </div>
            </section>
            <div style="padding: 20px 0;" class="row two-colum-section">
                <!-- left bar start  -->

                <div class="col-sm-8 sidebar-left">

                    <div class="single-curses-contert">
                        <!-- Faculty about  -->
                        <section class="events-list-03">
                            <div class="container">
                                <?php
                                //code for getting year buttons by grouping year in placement table
                                $cmd6 = "SELECT YEAR(date) FROM tbl_expert_talk WHERE is_active = 1 AND is_delete = 0 and FIND_IN_SET('$program_id', program_id) and faculty_id = $faculty_id GROUP BY YEAR(date) ORDER BY YEAR(date) DESC";
                                $stmt6 = $con->prepare($cmd6);
                                $stmt6->execute();
                                $result6 = $stmt6->get_result();

                                while ($row6 = $result6->fetch_assoc()) {
                                    $sem_c = $row6['YEAR(date)'];
                                    ?>
                                    <div class="row event-body-content semester-content" id="sem-<?php echo $sem_c; ?>"
                                        style="display: none;">
                                        <?php
                                        $cmd = $con->prepare("SELECT expert_talk.id as expert_talk_id,expert_talk.title as expert_talk_title, expert_talk.description as expert_talk_description,expert_talk.report_file as expert_talk_report  FROM tbl_expert_talk as expert_talk  WHERE FIND_IN_SET('$program_id', program_id) AND is_active=1 AND is_delete=0 AND YEAR(date) = $sem_c");
                                        //  $cmd->bind_param("i", $program_id);
                                        $cmd->execute();
                                        $result = $cmd->get_result();
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $expert_talk_title = $row['expert_talk_title'];
                                                $expert_talk_description = $row['expert_talk_description'];
                                                $expert_talk_id = $row['expert_talk_id'];
                                                $expert_talk_report = $row['expert_talk_report'];
                                                ?>
                                                <div class="col-sm-8 events-full-box">
                                                    <div class="events-single-box">
                                                        <div class="" style="display: flex; align-items:center;">
                                                            <h3 class="color-gmiu" style="padding-top:0; margin-left:20px;">
                                                                <?php echo $expert_talk_title; ?>
                                                            </h3>
                                                        </div>
                                                        <hr style="margin: 0;">
                                                        <div class="row">
                                                            <!-- SLIDER SECTION FIRST -->
                                                            <div class="col-12">
                                                                <div
                                                                    class="swiper swipermain mySwipers<?php echo $expert_talk_id; ?>">
                                                                    <div class="swiper-wrapper">
                                                                        <?php
                                                                        $type = "expert_talk";
                                                                        $cmd1 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp  WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0 ");
                                                                        $cmd1->bind_param("is", $expert_talk_id, $type);
                                                                        $cmd1->execute();
                                                                        $result1 = $cmd1->get_result();
                                                                        // if ($result1->num_rows > 0) {
                                                                        while ($row1 = $result1->fetch_assoc()) {
                                                                            echo "<div class='swiper-slide'>
                                                                                    <img src='" . $upload_website_admin_url . "expert_talk/image/" . htmlspecialchars($row1['sp_file_name']) . "' 
                                                                                    class='img-fluid' onerror=\"this.style.display='none';\">
                                                                                  </div>";
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <!-- Add Pagination and Navigation -->
                                                                    <div class="swiper-pagination">
                                                                    </div>
                                                                    <div class="swiper-button-next"></div>
                                                                    <div class="swiper-button-prev"></div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 mt-3">
                                                                <div class="event-info">
                                                                    <p class="events-time">
                                                                        <?php echo htmlspecialchars_decode($expert_talk_description); ?>
                                                                    </p>
                                                                   <?php if (!empty($expert_talk_report)) { ?>
                                                                        <a target="_blank"
                                                                           href="<?php echo $upload_website_admin_url; ?>expert_talk/report/<?php echo $expert_talk_report; ?>">
                                                                            <button id="dwn-btn">
                                                                                <i class="fa fa-download"></i>
                                                                                Download Report
                                                                            </button>
                                                                        </a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </div>
                                    <?php
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

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->

    <script>
        <?php
        // Get all expert_talk_id IDs for Swiper initialization
        $cmd = $con->prepare("SELECT id FROM tbl_expert_talk WHERE FIND_IN_SET(?, program_id) AND is_active=1 AND is_delete=0 AND faculty_id=?");
        $cmd->bind_param("ii", $program_id, $faculty_id);
        $cmd->execute();
        $result = $cmd->get_result();
        while ($row = $result->fetch_assoc()) {
            $expert_talk_id = $row['id'];
            echo '
    var swiper' . $expert_talk_id . ' = new Swiper(".mySwipers' . $expert_talk_id . '", {
        loop: true,
        spaceBetween: 10,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
    ';
        }
        ?>
    </script>

    <script>
        function showSemester(semesterId) {
            var semesterDivs = document.querySelectorAll('.semester-content');
            var semesterButtons = document.querySelectorAll('.tabBtn');

            // Hide all semester divs
            for (var i = 0; i < semesterDivs.length; i++) {
                semesterDivs[i].style.display = 'none';
            }

            // Remove "active" class from all buttons
            for (var i = 0; i < semesterButtons.length; i++) {
                semesterButtons[i].classList.remove('tabBtn-active');
            }

            // Show selected semester div if it exists, otherwise show the first available semester div
            var semesterDiv = document.getElementById('sem-' + semesterId);
            if (!semesterDiv) {
                for (var i = 0; i < semesterDivs.length; i++) {
                    if (semesterDivs[i].style.display !== 'none') {
                        semesterDiv = semesterDivs[i];
                        semesterId = semesterDiv.getAttribute('id').split('-')[1];
                        break;
                    }
                }
            }

            semesterDiv.style.display = 'block';

            // Add "active" class to the clicked button
            var clickedButton = document.querySelector('.tabBtn[data-semester="' + semesterId + '"]');
            clickedButton.classList.add('tabBtn-active');
        }

        // Find the first available semester div and show it
        var firstSemesterDiv = document.querySelector('.semester-content');
        if (firstSemesterDiv) {
            var firstSemesterId = firstSemesterDiv.getAttribute('id').split('-')[1];
            showSemester(firstSemesterId);
        }
    </script>


    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>