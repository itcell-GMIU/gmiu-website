<?php
include '../../common/importwebsitefile.php';
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
 <?php $pageTitle = "WHPCell | Gyanmanjari Innovative University Campus | GMIU"; 
     $meta_description = "Learn about GMIU's WHP Cell – dedicated to promoting wellness, health, and personal development through support programs and initiatives for students and staff.";
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
            max-width: 100%;
            height: auto;
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
        @media only screen and (max-width: 768px) {
            .text {
                font-size: 13px;
            }
        }

        @media only screen and (max-width: 576px) {
            .text {
                font-size: 11px;
            }

            .column {
                width: 100%;
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

        .bullet-list {
            margin-left: 20px;
            /* Adjust the margin as needed */
        }

        .bullet-list {
            margin-left: 20px;
            /* Adjust the margin as needed */
        }

        .bullet {
            display: inline-block;
            width: 10px;
            /* Adjust the width as needed */
            text-align: center;
            margin-right: 5px;
            /* Adjust the margin as needed */
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
                    <h1>Women Harassment Prevention Cell</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>

                    <span class="b-active"><a href=" <?php echo $base_url_website ?>">Women Harassment Prevention Cell</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>


    <div class="flexContainer container">
        <div class="cont">
            <img src="../../website_assets/images/WHPCell.webp" alt="IMG Not Found">

        </div>


        <section class="about-cards">
            <h3>WE HERE AT GMIU HAVE ESTABLISHED -'WOMEN HARASSMENT PREVENTION CELL' TO STOP ALL TYPE OF HARASSMENT TO A WOMEN.</h3>
            <!-- Motto of University card  -->
            <div class="about-card">
                <div>
                    <h1 class="gradText">OBJECTIVES FOR THE CELL</h1>
                    <hr>
                </div>
                <p class="bullet-list">
                    <span class="bullet">&#x2022;</span>
                    <span>To prevent discrimination and sexual harassment against women.</span>
                    <br>
                    <span class="bullet">&#x2022;</span>
                    <span>Deal with cases of above harassment in a time-bound manner aiming to support victims.</span>
                    <br>
                    <span class="bullet">&#x2022;</span>
                    <span>We here many times arrange seminars for 'Women Empowerment' and 'Self Defense' so that they can fight back.</span>
                    <br>
                    <span class="bullet">&#x2022;</span>
                    <span>For that, we arranged 'HALLA BOL' session in our college.</span>
                    <br>
                </p>




        </section>
    </div>

    <!-- Footer Area section -->
    <?php include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->

    <?php include '../include/importjs.php'; ?>

</body>

</html>