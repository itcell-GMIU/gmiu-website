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
        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            /* height: 100%; */
            max-height: 245px;
            object-fit: cover;
        }


        .swiper {
            width: 100%;
            height: 300px;
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

        /* popup image  */
        .modal-ns {
            z-index: 999999999;
            display: none;
            /* padding-top: 10px; */
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.8)
        }

        .modal-ns-content {
            margin-left: auto;
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .modal-ns-hover-opacity {
            opacity: 1;
            filter: alpha(opacity=100);
            -webkit-backface-visibility: hidden;
        }

        .modal-ns-hover-opacity:hover {
            opacity: 0.60;
            filter: alpha(opacity=60);
            -webkit-backface-visibility: hidden;
        }

        .modal-ns img {
            width: auto;
            height: 80vh;
        }

        @media only screen and (max-width: 767px) {

            /* Styles for mobile devices */
            .modal-ns img {
                width: 90vw;
                height: auto;
            }
        }

        .close {
            text-decoration: none;
            /* float: right; */
            font-size: 40px;
            margin-top: 50px;
            margin-right: 50px;
            font-weight: bold;
            color: white;
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
                    <h1>SDP</h1>
                    <p>By Department Of <?php echo $program_name ?></p>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href=""><?php echo $program_name ?></a></span><i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="">SDP</a></span>
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
                        <section class="expert-talk-card-section">
                            <div class="row event-body-content">
                                <!-- <img src="<?php echo $website_assets_url; ?>images/karma.jpg" alt="" style="width: -webkit-fill-available; margin:10px;"> -->
                                <?php
                                $cmd = $con->prepare("SELECT id, title, date, YEAR, description, report as report, level_id, program_id, faculty_id, img_name as image FROM tbl_sdp as exp_sdp WHERE is_active = 1 AND is_delete = 0 and FIND_IN_SET(?,program_id) and faculty_id = ?");
                                $cmd->bind_param("ii", $program_id, $faculty_id);
                                $cmd->execute();
                                $result = $cmd->get_result();
                                if ($result->num_rows > 0) {
                                    // variable


                                    while ($row = $result->fetch_assoc()) {
                                        // variables
                                        $title = $row['title'];
                                        $date = $row['date'];
                                        $description = $row['description'];
                                        $report_file = $row['report'];
                                        $id = $row['id'];
                                        $image = $row['image'];
                                ?>
                                        <div class="col-sm-12 events-full-box center">
                                            <div class="events-single-box">
                                                <h3 style="margin-top: 10px;">
                                                    <?php echo $title; ?>
                                                    <?php //echo $date; 
                                                    ?>
                                                </h3>
                                                <hr style="border: 1px solid #727272;">

                                                <div class="row space-card-bottom">
                                                    <div class="col-sm-4" style="display:flex; justify-content:center; align-items:center; padding-left:20px;">
                                                        <img src="../../website_admin/uploads/sdp/image/<?php echo $image; ?>" style="height:fit-content; cursor:pointer;" onclick="onClick(this)" />
                                                    </div>

                                                    <!-- Test  -->
                                                    <div id="modal01" class="modal-ns" onclick="this.style.display='none'">
                                                        <span class="close">&times;</span>
                                                        <div class="modal-ns-content">
                                                            <img id="img01">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-8 event-info">
                                                        <ul>
                                                            <li>
                                                                <?php echo $description; ?>
                                                            </li>
                                                            <a target="_blank" href="../../website_admin/uploads/sdp/report/<?php echo $report_file ?>">
                                                                <button id="dwn-btn">
                                                                    <i class="fa fa-download"></i>
                                                                    Download Report</button>
                                                            </a>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                    }
                                }
                                ?>
                            </div>
                    </div>
                </div>
                </section>
                <!-- right bar start  -->
                <?php include '../include/importrightsidebar.php' ?>
                <!-- right bar end  -->
            </div>
        </div>
        <!-- left bar end  -->


    </div>
    </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->


    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->
    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>
    <script>
        //popup modal news slide js
        function onClick(element) {
            document.getElementById("img01").src = element.src;
            document.getElementById("modal01").style.display = "block";
        }
    </script>

</body>

</html>