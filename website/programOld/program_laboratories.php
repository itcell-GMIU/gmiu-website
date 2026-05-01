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
                    <h1>Laboratories</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="program.php?program_id=<?php echo $program_id ?>&faculty_id=<?php echo $faculty_id ?>"><?php echo $program_name; ?></a>
                        <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#">Laboratories</a></span>
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
                        <section class="events-list-03">
                            <div class="container">
                                <div class="row event-body-content">
                                    <?php
                                    $cmd = $con->prepare("SELECT laboratories.id as laboratories_id,laboratories.title as laboratories_title, laboratories.description as laboratories_description FROM tbl_laboratories as laboratories  WHERE FIND_IN_SET(?,program_id) AND is_active=1 AND is_delete=0 ");
                                    $cmd->bind_param("i", $program_id);
                                    $cmd->execute();
                                    $result = $cmd->get_result();
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $laboratories_title = $row['laboratories_title'];
                                            $laboratories_description = $row['laboratories_description'];
                                            $laboratories_id = $row['laboratories_id'];
                                    ?>
                                            <div class="col-sm-8 events-full-box">
                                                <div class="events-single-box">
                                                    <div class="" style="display: flex; align-items:center;">
                                                        <h3 class="color-gmiu" style="padding-top:0; margin-left:20px;">
                                                            <?php echo $laboratories_title; ?>
                                                        </h3>
                                                    </div>
                                                    <hr style="margin: 0;">
                                                    <div class="row">
                                                        <div id="img-slider" class="col-sm-7" style="padding-top: 0;">
                                                            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff; padding-bottom:0;" class="swiper swipermain mySwipers<?php echo $laboratories_id; ?>">
                                                                <div class="swiper-wrapper">
                                                                    <?php
                                                                    $type = "lab";
                                                                    $cmd1 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp  WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0 ");
                                                                    $cmd1->bind_param("is", $laboratories_id, $type);
                                                                    $cmd1->execute();
                                                                    $result1 = $cmd1->get_result();
                                                                    if ($result1->num_rows > 0) {
                                                                        while ($row1 = $result1->fetch_assoc()) {
                                                                            $file_name1 = $row1['sp_file_name'];
                                                                    ?>
                                                                            <div class="swiper-slide">
                                                                                <img src="<?php echo $upload_website_admin_url . 'laboratory/' . $file_name1; ?>">
                                                                            </div>
                                                                    <?php }
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                            <div style="height:80px" thumbsSlider="" class="swiper mySwiper<?php echo $laboratories_id; ?>">
                                                                <div class="swiper-wrapper">
                                                                    <?php
                                                                    $type = "lab";
                                                                    $cmd2 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp  WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0 ");
                                                                    $cmd2->bind_param("is", $laboratories_id, $type);
                                                                    $cmd2->execute();
                                                                    $result2 = $cmd2->get_result();
                                                                    if ($result2->num_rows > 0) {
                                                                        while ($row2 = $result2->fetch_assoc()) {
                                                                            $file_name2 = $row2['sp_file_name'];
                                                                    ?>
                                                                            <div class="swiper-slide">
                                                                                <img src="<?php echo $upload_website_admin_url . 'laboratory/' . $file_name2; ?>">
                                                                            </div>
                                                                    <?php }
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-5 event-info">
                                                            <p class="events-time">
                                                                <?php echo htmlspecialchars_decode($laboratories_description); ?>
                                                            </p>
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
                        </section>
                    </div>
                </div>
                <!-- left bar end  -->
                <?php include '../include/importrightsidebar.php' ?>
            </div>
        </div>
    </div>

    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->

    <?php
    $cmd = $con->prepare("SELECT laboratories.id as laboratories_id,laboratories.title as laboratories_title, laboratories.description as laboratories_description FROM tbl_laboratories as laboratories  WHERE program_id=? AND is_active=1 AND is_delete=0 ");
    $cmd->bind_param("i", $program_id);
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $laboratories_id = $row['laboratories_id'];

            echo '<script>
                                                        var swiper = new Swiper(".mySwiper' . $laboratories_id . '", {
                                                            loop: true,
                                                            spaceBetween: 10,
                                                            slidesPerView: 3,
                                                            freeMode: true,
                                                            watchSlidesProgress: true,
                                                        });
                                                        var swiper2 = new Swiper(".mySwipers' . $laboratories_id . '", {
                                                            loop: true,
                                                            spaceBetween: 10,
                                                            navigation: {
                                                                nextEl: ".swiper-button-next",
                                                                prevEl: ".swiper-button-prev",
                                                            },
                                                            thumbs: {
                                                                swiper: swiper,
                                                            },
                                                        });
                                                        </script>';
        }
    }
    ?>




    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>
</body>

</html>