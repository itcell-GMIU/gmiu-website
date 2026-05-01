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


        .row {
            margin-right: 10px;
            margin-left: -15px;
        }
        .btn-form a {
            padding: 15px;
            border-radius: 5px;
            color: #fff;
        }
        .mt-30{
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
                    <h1>Incubation and startup club policy </h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#">Incubation and startup club policy </a></span>
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
                        <!--<h4 class="gradText">SSIP</h4>-->
                        <h4>GMIU Startup Cell Registration Form</h4>
                      
                    </div>

                <div class="btn-form mt-30">
                    <a href="<?php echo $website_assets_url; ?>images/GMSEC Registration Form.pdf" target="_blank" rel="noopener noreferrer" class="rgsBtn red-background">View Form</a>
                    <br><br>
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
                                                <a href="startupclub.php" class="active"><i class="fa-solid fa-arrow-right"></i>GMSEC Incubation and startup club policy </a>
                                            </li>
                                             <li>
                                                <a href="startup_gallery.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Gallery </a>
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