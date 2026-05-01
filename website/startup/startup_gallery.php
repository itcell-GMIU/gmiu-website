<?php
include '../../common/importwebsitefile.php';

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "Startup Gallery at Gyanmanjari Innovative University | Innovation Hub"; 
    $meta_description = "Explore GMIU’s Startup Gallery showcasing innovative student startups, entrepreneurial projects, and creative ventures driving change and business growth.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
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

        .logo {
            height: 40px;
            width: auto;
            margin-right: 20px;
        }

        .flexContainer {
            display: flex;
            flex-direction: row;
        }

        .flexContainer .cont {
            width: 100%;
        }

        .center-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            /* Ensure full height */
        }
    </style>

    <style>
        /* Existing CSS here */

        @media (max-width: 768px) {
            .single-gallery {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 10px;
                /* Adjust padding as needed */
                margin: 0 auto;
                /* Center the gallery container */
            }

            .single-gallery figure img {
                width: 100%;
                max-width: 100%;
                height: auto;
                object-fit: cover;
                border-radius: 5px;
            }

            .single-gallery figure {
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 0;
            }

            .gallery_img_wrapper {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-around;
                /* Ensure even spacing between gallery items */
            }
        }

            .row {
              margin-right: 0px;
              margin-left: 0px;
            }
      

        .btn-form a {
            padding: 15px;
            border-radius: 5px;
            color: #fff;
        }

        .mt-30 {
            margin-top: 30px;
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
                    <h1>GMSEC Gallery </h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/gmiu/website/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active">GMSEC Gallery </span>
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


                   
                   <div class="row">
                        <div id="img-slider" style="padding: 0px 0px 0px 0px;">
                            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff; padding-bottom:0;height: 400px;" class="swiper mySwipers">
                                <div class="swiper-wrapper">
                                    <?php
                                    // Fetch images from the database
                                    $cmd = "SELECT `file_name` as startup_gallery_image FROM `tbl_site_photos` WHERE is_active=1 AND is_delete=0 AND type='startup_gallery_image'";
                                    $stmt = $con->prepare($cmd);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if ($result->num_rows > 0) {
                                        // Loop through each image and display inside Swiper slide
                                        while ($row = $result->fetch_assoc()) {
                                            $gallery_img = $row['startup_gallery_image'];
                                            echo '<div class="swiper-slide">
                                                    <a href="' . $upload_website_admin_url . 'startup_gallery_image/' . $gallery_img . '" target="_blank" data-fancybox="gallery">
                    <img src="' . $upload_website_admin_url . 'startup_gallery_image/' . $gallery_img . '" class="d-block w-100" alt="...">
                </a>
                                                  </div>';
                                        }
                                    }
                                    ?>
                                </div>
                                <!-- Add navigation buttons -->
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
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
                                            <a href="about_startup.php" class=""><i class="fa-solid fa-arrow-right"></i> About GMSEC</a>
                                        </li>
                                        <li>
                                            <a href="our_startup.php" class=""><i class="fa-solid fa-arrow-right"></i>Our Startup</a>
                                        </li>
                                        <li>
                                            <a href="ssip.php"><i class="fa-solid fa-arrow-right"></i>About SSIP & IPR </a>
                                        </li>
                                        <li>
                                            <a href="event.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Event list</a>
                                        </li>
                                        <li>
                                            <a href="startupclub.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Incubation and startup club policy </a>
                                        </li>
                                        <li>
                                            <a href="startup_gallery.php" class="active"><i class="fa-solid fa-arrow-right"></i>GMSEC Gallery </a>
                                        </li>
                                        <!--  <li>-->
                                        <!--    <a href="event_report.php" class=""><i class="fa-solid fa-arrow-right"></i> About Event Report </a>-->
                                        <!--</li>-->
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
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper('.mySwipers', {
            loop: true, // Loop through slides
            autoplay: {
                delay: 3000, // 3 seconds delay
                disableOnInteraction: false, // Continue autoplay after user interaction
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>





    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->


</body>

</html>