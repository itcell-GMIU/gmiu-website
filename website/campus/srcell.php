<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "SRCELL at Gyanmanjari Innovative University Campus | GMIU"; 
        $meta_description = "Explore GMIU's SRCELL – fostering student research, creativity, and innovation through specialized support, resources, and opportunities for academic growth.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include "../include/importhead.php"; ?>
    <?php include '../include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Verdana, sans-serif;
        }

        .mySlides {
            display: none;

        }

        img {
            vertical-align: middle;
        }

        /* Slideshow container */
        .slideshow-container {
            max-width: 1000px;
            position: relative;
            margin: auto;
        }

        /* Caption text */
        .text {
            color: #f2f2f2;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* The dots/bullets/indicators */
        .dot {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .aactive {
            background-color: #717171;
        }

        /* Fading animation */
        .fade {
            animation-name: fade;
            animation-duration: 1.5s;
        }

        @keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }

        /* On smaller screens, decrease text size */
        @media only screen and (max-width: 300px) {
            .text {
                font-size: 11px
            }
        }

        .about-card {
            margin: 50px 0;
            box-shadow: 0 0 10px #00000021;
            padding: 20px;
            border-radius: 10px;
            transition: all .3s ease-in-out;
        }

        /* Six columns side by side */
        .column {
            float: left;
            width: 16.66%;
            border-radius: 10px;
        }

        img {
            height: 400px;
            border-radius: 10px;

        }
        p{
            font-size: medium;
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
                    <h1>Social Responsive Cell</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>

                    <span class="b-active"><a href=" <?php echo $base_url_website ?>">Social Responsive Cell</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>


    <div class="flexContainer container">

        <section class="about-cards">
            <p>Every organization will have its function expressed and all the employees are expected to contribute to the goals of the organization by combined efforts. People gets so much involved in in the course of their official obligations that many times obligations of organization to the society in which its works are forgotten. Government has come up with mandates for the organizations to disburse their obligations towards the society. By making people resposible toward the need of the fellow human beings in one's surrounding is the first step to achieve the objective better tomorrow.

                By Realizing aspects of Social Responsibilty, The Organization Established Social Responsive Cell (SRC) with internal commettee to fulfill organization's obligations toward their own people like staff, students as well as the community surroung. Main goal of SRC is to respond the need of the socity in its surroundings and implement sustainable drives. The person of SRC done so on a purely voluntary basis without expecting any return.</p>
            <!-- Motto of University card  -->
            <div class="about-card">
                <div>
                    <h1 class="gradText">AREA OF WORK</h1>
                    <hr>
                </div>
                <p style="margin-left: 15px;">
                    &#x2022; Health <br>
                    &#x2022; Education <br>
                    &#x2022; Employment <br>
                    &#x2022; Gender Sensitivity <br>
                    &#x2022; Infrastructural Improvement <br>
                    &#x2022; Other Decided by the commettee <br>
                   
                </p>
        </section>
    </div>

    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->

    <?php include '../include/importjs.php'; ?>

</body>

</html>