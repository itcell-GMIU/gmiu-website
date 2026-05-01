<?php
include '../../common/importwebsitefile.php';

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
   <?php $pageTitle = "Startup at Gyanmanjari Innovative University | Startup Innovation GMIU"; 
    $meta_description = "Discover GMIU's startup ecosystem—featuring student-led ventures, innovation, and entrepreneurial initiatives that drive creativity and business growth.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
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
                    <h1>Our Startup</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/gmiu/website/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span>Startup<i class='fa fa-angle-right'></i> </span>
                    <span class="b-active">Our Startup</span>
                </p>
                <hr>
            </div>

        </div>

    </section>

    <div class="single-courses-area">
        <div class="container">
            <!-- <section class="placed-students">
                <div class="buttons-container-flex" style="padding: 10px;">

                </div>
            </section> -->
            <div style="padding: 20px 0;" class="row two-colum-section">
                <!-- left bar start  -->

                <div class="col-sm-8 sidebar-left">

                    <div class="single-curses-contert">
                        <!-- Faculty about  -->
                        <section class="events-list-03">
                            <div class="container">

                                <?php
                                $cmd = $con->prepare("SELECT startup.id as startup_id,startup.title as startup_title FROM tbl_our_startup as startup  WHERE  is_active=1 AND is_delete=0 ");
                                $cmd->execute();
                                $result = $cmd->get_result();
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $startup_title = $row['startup_title'];
                                        $startup_id = $row['startup_id'];
                                ?>
                                        <div class="col-sm-8 events-full-box">
                                            <div class="events-single-box">
                                                <div class="" style="display: flex; align-items:center;">
                                                    <h3 class="color-gmiu" style="padding-top:0; margin-left:20px;">
                                                        <?php echo $startup_title; ?>
                                                    </h3>
                                                </div>
                                                <hr style="margin: 0;">
                                                <div class="row">
                                                    <div id="img-slider" class="col-sm-12" style="padding-top: 0;">
                                                        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff; padding-bottom:0;" class="swiper swipermain mySwipers<?php echo $startup_id; ?>">
                                                            <div class="swiper-wrapper">
                                                                <?php
                                                             $type = "Startup";
                                                             $cmd1 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp  WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0 ");
                                                             $cmd1->bind_param("is", $startup_id, $type);
                                                             $cmd1->execute();
                                                             $result1 = $cmd1->get_result();

                                                                if ($result1->num_rows > 0) {
                                                                    while ($row1 = $result1->fetch_assoc()) {
                                                                        $file_name1 = $row1['sp_file_name'];
                                                                ?>
                                                                        <div class="swiper-slide">
                                                                            <img src="<?php echo $upload_website_admin_url . 'our_startup/image/' . $file_name1; ?>" alt="Startup - <?php echo htmlspecialchars($startup_title); ?> at GMIU">
                                                                        </div>
                                                                <?php }
                                                                } ?>
                                                            </div>
                                                        </div>
                                                        <!--<div style="height:100px" thumbsSlider="" class="swiper mySwiper<?php echo $startup_id; ?>">-->
                                                        <!--    <div class="swiper-wrapper">-->
                                                                <?php
                                                        //   $type = "Startup";
                                                        //   $cmd2 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp  WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0");
                                                        //   $cmd2->bind_param("is", $startup_id, $type);
                                                        //   $cmd2->execute();
                                                        //   $result2 = $cmd2->get_result();
                                                        //   if ($result2->num_rows > 0) {
                                                        //       while ($row2 = $result2->fetch_assoc()) {
                                                        //           $file_name2 = $row2['sp_file_name'];
                                                                ?>
                                                                        <!--<div class="swiper-slide">-->
                                                                        <!--    <img src="<?php //echo $upload_website_admin_url . 'our_startup/image/' . $file_name2; ?>">-->
                                                                        <!--</div>-->
                                                                <?php //}
                                                            //    } 
                                                            ?>
                                                        <!--    </div>-->
                                                        <!--</div>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                    }
                                }
                                ?>


                                <?php
                                // }
                                ?>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- left bar end  -->

                <!-- right bar start  -->
                <div class="col-sm-4 sidebar-right">
                    <div class="sidebar-content">
                        <div class="sideBar">
                            <div class="sticky">
                                <div>
                                    <ul>
                                        <li>
                                            STARTUP
                                        </li>
                                        <li>
                                                <a href="about_startup.php" class=""><i class="fa-solid fa-arrow-right"></i>About GMSEC</a>
                                            </li>
                                            <li>
                                                <a href="our_startup.php" class="active"><i class="fa-solid fa-arrow-right"></i>Our Startup</a>
                                            </li>
                                            <li>
                                                <a href="ssip.php" class=""><i class="fa-solid fa-arrow-right"></i>About SSIP & IPR </a>
                                            </li>
                                                <li>
                                                <a href="event.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Event list</a>
                                            </li>
                                            <li>
                                                <a href="startupclub.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Incubation and startup club policy </a>
                                            </li>
                                             <li>
                                                <a href="startup_gallery.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Gallery </a>
                                            </li>
                                              <!--<li>-->
                                              <!--      <a href="event_report.php" class=""><i class="fa-solid fa-arrow-right"></i> About Event Report </a>-->
                                              <!--   </li>-->
                                            <!--<li>-->
                                            <!--    <a href="about_ced.php" class=""><i class="fa-solid fa-arrow-right"></i> About CED</a>-->
                                            <!--</li>-->

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

    <?php
    $cmd = $con->prepare("SELECT startup.id as startup_id,startup.title as startup_title FROM tbl_our_startup as startup  WHERE  is_active=1 AND is_delete=0 ");
    $cmd->execute();
    $result = $cmd->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $startup_id = $row['startup_id'];

            echo '<script>
                                                        var swiper = new Swiper(".mySwiper' . $startup_id . '", {
                                                            loop: true,
                                                            spaceBetween: 10,
                                                            slidesPerView: 3,
                                                            freeMode: true,
                                                            watchSlidesProgress: true,
                                                        });
                                                        var swiper2 = new Swiper(".mySwipers' . $startup_id . '", {
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