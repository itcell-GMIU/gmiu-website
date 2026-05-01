<?php
include '../../common/importwebsitefile.php';

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php include '../include/importhead.php'; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">


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

        h4.gradText {
            color: #ba2a21;
        }

        .aaccordion {
            background-color: #eee;
            color: #ba2a21;
            cursor: pointer;
            padding: 10px;
            width: 100%;
            border: 0.5px;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
            border-radius: 10px;


        }


        .aaccordion:hover {
            background-color: #ccc;
        }

        .panel {
            padding: 0 10px;
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;


        }

        .logo {
            height: 90px;
            width: auto;
            margin-right: 20px;
        }

        .about-card {
            margin: 20px 0;
            box-shadow: 0 0 10px #00000021;
            padding: 20px;
            border-radius: 10px;
            transition: all .3s ease-in-out;
        }

        .ssip {
            border: 1px solid #eee;
            border-radius: 10px;
            margin: 10px;
        }

        img {
            width: 250px;
            height: auto;
            border-radius: 10px;
        }

        .red-background {
            background-color: #ba2a21;
            color: white;
        }

        /* Add CSS for the table */
        table {
            border-collapse: collapse;
            /* Collapse border spacing */
            width: 100%;
            /* Make table width 100% */
            border-radius: 10px;
            /* Apply border radius of 10% */
            padding: 10px;
            margin-left: 10px;

        }

        /* Style table headers */
        th {
            background-color: #ba2a21;
            /* Apply background color to header cells */
            color: white;
            /* Set text color for header cells */

        }

        /* Style table rows */
        tr:nth-child(even) {
            background-color: #ba2a2126;
            /* Apply alternate background color to even rows */
        }

        /* Style table cells */
        td,
        th {
            border: none;
            /* Remove borders from table cells */
            padding: 8px;
            /* Add padding to table cells */
            text-align: left;
            /* Align text to left in table cells */
            height: 50px;
            width: auto;
            font-size: 15px;
            padding: 15px;


        }

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
            margin-right: 10px;
            margin-left: -15px;
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
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#">GMSEC Gallery </a></span>
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


                    <div class="section-paddings gallery-images event-01" style="padding-top: 0px;">
                        <!--<div class="container">-->
                        <div class="row gallery_img_wrapper">
                        <div class="row gallery_img_wrapper">
                                            <?php
                                            $cmd = "SELECT `file_name` as startup_gallery_image FROM `tbl_site_photos` Where is_active=1 AND is_delete=0 AND type ='startup_gallery_image' ";
                                            $stmt = $con->prepare($cmd);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $gallery_img = $row['startup_gallery_image'];
                                                    echo '<div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                                            <div class="single-gallery">
                                                                <figure>
                                                                    <img style="height: 245px;width: 345px;" src="' . $upload_website_admin_url . 'startup_gallery_image/' . $gallery_img . '" alt="gallery">
                                                                    <figcaption>
                                                                        <a href="' . $upload_website_admin_url . 'startup_gallery_image/' . $gallery_img . '" title=""><i class="fa fa-eye"></i></a>
                                                                    </figcaption>
                                                                </figure>
                                                            </div>
                                                        </div>';
                                                }
                                            }
                                            ?>
                                        </div>
                         
                        </div>
                        <!--</div>-->

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





    <!-- ============================
    JavaScript Files
    ============================= -->
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>

</body>

</html>