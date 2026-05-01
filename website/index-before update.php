<?php
include '../database/connect.php';
include '../common/validation.php';
include '../common/globalvariable.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php
    $pageTitle = "Gyanmanjari Innovative University | Bhavnagar Private University";
    // $meta_description = 'Gyanmanjari Innovative University is a leading private university in Bhavnagar, Gujarat. Apply now for Admission 2025 to top engineering, BSc, and diploma programs.';
    $meta_description = 'Gyanmanjari Innovative University (GMIU), Bhavnagar is a leading private university offering Engineering, BSc, Diploma and Pharmacy programs with industry-focused Proficient Learning Method (PLM). Apply now for Admission 2026.';
    // $meta_keywords = 'University in Bhavnagar, College near Bhavnagar, Gyanmanjari University, Private University in Gujarat, Best University in Bhavnagar, Admission 2025 Bhavnagar, GUJCET College Bhavnagar, Engineering College Bhavnagar,  BSc College near Bhavnagar, GMIU Admission, Top College in Bhavnagar, Degree College Bhavnagar, Bhavnagar Education, University near Mahuva, University near Botad, University near Amreli, University near Palitana, University near Rajula';
    $meta_keywords = 'GMIU Bhavnagar, Gyanmanjari Innovative University, private university in Gujarat, university in Bhavnagar, PLM learning method, Proficient Learning Method GMIU, engineering college Bhavnagar, BSc college Bhavnagar, diploma college Gujarat, pharmacy college Bhavnagar, admission 2026 Gujarat, GUJCET college Bhavnagar, top university in Bhavnagar, best private university Gujarat, skill-based learning university, industry oriented education Gujarat, college near Mahuva Botad Amreli Palitana Rajula';
    ?>

    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
    <?php include 'include/importhead.php'; ?>
    <?php include 'include/indexcss.php'; ?>
    <?php include 'include/importcss.php'; ?>
    <link rel="stylesheet" href="../website_assets/css/home.css?v=1.0.1" media="print"
        onload="this.media='all'">
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


    <style>
        .snowflake {
            position: fixed;
            top: -20px;
            color: #ffffff;
            font-family: Arial, sans-serif;
            pointer-events: none;
            z-index: 9999;

            /* Realistic glow */
            text-shadow:
                0 0 5px rgba(255, 255, 255, 0.8),
                0 0 10px rgba(255, 255, 255, 0.6),
                0 0 20px rgba(255, 255, 255, 0.4);

            animation-name: fall;
            animation-timing-function: linear;
        }

        @keyframes fall {
            to {
                transform: translateY(110vh);
            }
        }

        /* Fade out on cleanup */
        .fade-out {
            animation: fadeOut 1.8s forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
            }
        }

        /* Disable on mobile */
        @media (max-width: 768px) {
            /*.snowflake { display: none; }*/
        }

        .swiper-pagination-bullet {
            background-color: #ba2a21;
        }

        .placement-swiper {
            padding: 30px 0;
        }

        .placement-swiper .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
            padding: 10px;
        }

        .placement-swiper .swiper-slide img {
            width: 100%;
            max-width: 200px;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        @media (max-width: 767px) {
            .placement-swiper .swiper-slide img {
                max-width: unset;
            }
        }

        .placement-swiper .swiper-slide img:hover {
            transform: scale(1.05);
        }

        #data-card {
            margin: 10px !important;
        }

        /* Adjust pagination alignment */
        .swiper-pagination {
            text-align: center;
            margin-top: 20px;
        }

        @media (max-width: 767px) {

            /* #workshop-popup {*/
            /*left: 55% !Important;*/
            /*top: 60% !Important;*/
            /* }*/
        }

        /*added for the new size of the banner */
        @media (min-width: 768px) {

            /*.info-card-header-row2{*/
            /*    top: 650px !important;*/
            /*    bottom: -60px;*/
            /*}*/
            .blog-area {
                margin-top: 80px !important;
            }
        }

        * {
            box-sizing: border-box;
        }

        .container,
        section {
            max-width: 100%;
            margin: 0 auto;
        }

        html,
        body {
            scroll-behavior: smooth;
            overflow-x: hidden;
            width: 100%;
        }

        .section-header h2 {
            font-size: 30px;
        }

        .unclickable {
            pointer-events: none;
        }

        #img-set {
            background-color: white;
        }

        #pad-remove {
            margin-top: 10px !important;
        }

        .info-card-header-row2 {
            position: absolute;
            width: 100%;
            background-color: #292929;
            /* transform: translateY(-100%); */
            z-index: 99;
            /*z-index: 999;*/
            margin: 0;
            /* top: 0; */
            /*bottom: 0;*/

        }


        .top1 {
            width: 100%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /*position: sticky; */
            /* Make the header fixed 
    top: 0; /* Position it at the top */
            left: 0;
            /* Position it at the left */
            right: 0;
            /* Ensure it spans the entire width */
            z-index: 1000;
            /* Ensure it is above other elements */
            background: rgb(255 255 255);
            /* Ensure background color covers content */
        }

        .acpc-rep p {
            margin: 0;
            font-weight: 600;
            padding: 10px;
            color: #333;
            text-align: center !important;
        }


        @keyframes highlight-blink {
            0% {
                background-color: red;
            }

            50% {
                background-color: transparent;
            }

            100% {
                background-color: red;
            }
        }

        .mega-menu {
            display: none;
            position: fixed;
            /*position: absolute;*/
            /* left: 0; */
            background-color: #fff;
            padding: 20px;
            right: 0%;
            width: 1000px;
            box-shadow: 0px 0px 8px rgb(0 0 0 / 84%);
            z-index: 9999;
        }

        .mega-menu {
            margin-right: 45px;
            width: 1200px;
            /* Adjust as needed */

        }

        /* dg d*/
        .mega-menu-column {
            position: relative;
            padding-right: 20px;
        }

        .mega-menu-column:not(:last-child) {
            border-right: 1px solid #ccc;
            padding-right: 20px;
        }

        .mega-menu-content {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            /* 3 columns */
            gap: 35px;
        }

        /*.mega-menu-column h4 {*/
        /*  font-size: 20px;*/
        /*    margin-bottom: 10px;*/
        /*    color: #ba2a21;*/
        /*    font-weight: 900;*/
        /*}*/

        .mega-menu-column ul {
            list-style: none;
            padding: 0;
        }

        .mega-menu-column ul li {
            margin-bottom: 5px;
        }

        .mega-menu-column ul li a {
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }

        .mega-menu-column ul li a:hover {
            color: #007bff;
        }

        /* Display the mega menu on hover */
        li:hover .mega-menu {
            display: block;
            padding: 25px 50px;
        }

        /* Style the dropdown parent anchor */
        /*li a {*/
        /*  color: #000;*/
        /*  text-decoration: none;*/
        /*  padding: 10px;*/
        /*  display: inline-block;*/
        /*  position: relative;*/
        /*}*/

        /*li a:hover {*/
        /*  color: #007bff;*/
        /*}*/

        /* Ensure the mega menu takes up the correct width */
        /*li {*/
        /*  position: relative;*/
        /*}*/
        header .header-body .is-sticky .edu-navbar .edu-nav .mega-menu li a {
            color: #000 !important;
        }

        header .header-body .edu-navbar .edu-nav .mega-menu li a:before {
            content: none !important;
        }

        header .header-body .edu-navbar .edu-nav .mega-menu li a {
            padding: 0 !important;
        }

        header .header-body .edu-navbar .edu-nav .mega-menu li a {
            font-family: "Open Sans", sans-serif;
            font-weight: normal;
            color: black;
            font-size: 12px;
            padding: 14px 0;
            margin-bottom: 15px;
            display: flex;
            transition: .3s;
            position: relative;
            text-decoration: none;
        }

        header .header-body .edu-navbar .edu-nav .mega-menu li a i {
            font-size: 10px;
            margin-right: 10px;
        }

        header .header-body .edu-navbar .edu-nav .mega-menu li {
            margin-left: 0px;
            position: relative;
        }

        .mega-men {
            border-right: 1px solid #66666654;
            padding-left: 10px;
            padding-right: 10px;
        }

        @media (max-width: 1024px) {
            .gmiu-cell {
                display: none !important;
            }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .header-top .container {
                flex-direction: column;
                gap: 10px;
            }

            .header-top ul {
                flex-direction: column;
                align-items: center;
                flex-direction: row;
                align-content: stretch;
            }

            .header-top li {
                justify-content: center;
            }


        }

        @media (max-width: 480px) {

            .header-top .container {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 20px;
                /* Adds space between elements */
            }

        }

        .header-top {
            background: #323a52 !important;
            /* Keeping the original black background */
            padding: 10px 0;
            width: 100%;
        }

        .header-top .container {
            /*display: flex;*/
            /*justify-content: center;*/
            align-items: center;
            /*flex-wrap: wrap;*/
            /*gap: 20px; */
            /* Adds space between elements */
            text-align: center;
        }

        .header-top ul {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
            margin: 0;
            width: 100%;
            gap: 15px;
            /* Space between list items */
        }



        .header-top li {
            display: flex;
            align-items: center;
        }

        .header-top a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        .header-top a:hover {
            color: #ba2a21;
            /* Change color on hover */
        }

        .top-icon {
            margin-right: 5px;
        }

        @media (max-width: 768px) {
            .header-top .container {
                flex-direction: column;
            }

            .header-top ul {
                display: grid;
                grid-template-columns: 1fr 1fr;
                /* 2 equal columns */
                gap: 10px;
                /* Space between items */
                width: 100%;
                padding: 0;
                margin: 0;
                list-style: none;
                justify-content: start;
                /* Start from the left */
            }

            .header-top ul li {
                text-align: left;
                /* Align text to the left */
                padding: 5px;
                width: 100%;
            }

            .header-top li {
                align-items: unset;
                justify-content: unset;
            }
        }

        @media (min-width: 1024px) {
            .gmiu-cel {
                display: none !important;
            }
        }

        .faculty-marquee {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
            width: 100%;
            background: #f8f9fa;
            padding: 10px 0;
        }

        .faculty-track {
            display: flex;
            width: max-content;
            animation: scroll 30s linear infinite;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .faculty-marquee:hover .faculty-track {
            animation-play-state: paused;
            /* Stop scrolling on hover */
        }

        .faculty-slide {
            display: flex;
            flex-direction: column;
            /* Ensures vertical stacking */
            align-items: center;
            /* Centers everything horizontally */
            justify-content: center;
            /*width: 160px;*/
            width: 250px;
            height: 250px;
            margin: 0 15px;
            text-align: center;
            padding: 15px 10px;
            background-color: #ffffff;
            border-radius: 12px;
            /*box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);*/
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.5);
        }

        .faculty-thumb {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ba2a21;
        }

        .faculty-name {
            max-width: 140px;
            text-align: center;
            margin-top: 8px;
            font-size: 16px;
            font-weight: bold;
            color: #ba2a21;
            /* Faculty name in red */
            white-space: normal;
            overflow-wrap: break-word;
            line-height: 1.2;
            display: flex;
            justify-content: center;
            align-items: center;
        }



        header .rev_slider_wrapper {
            position: unset;
        }

        .rev_slider_wrapper {
            width: 100vw;
            height: 75vh;
            /* Use 75% of the viewport height */
            max-width: 100%;
            overflow: hidden;
            position: relative;

        }

        .rev_slider .rev-slidebg {
            width: 100%;
            height: 100%;
            object-fit: contain;
            /*object-fit: cover; */
            /* Prevents cutting */
        }

        @media (max-width: 768px) {
            .rev_slider_wrapper {
                height: 50vh;
                /* Adjusted height for mobile */
            }

        }

        @media (min-width: 1200px) {
            .rev_slider_wrapper {
                height: 80vh;
                /* Bigger height for large screens */
            }
        }

        @media (max-width: 1199px) {
            .rev_slider_wrapper {
                height: 460px;
            }
        }

        @media (max-width: 390px) {

            .info-card-content p,
            .info-card-content h5 {
                font-size: 12px;
                /* example adjustment */

                /* add any other styles you want for very small screens */
            }
        }

        /*.info-card-header-row2 {*/
        /*    position: unset !Important;*/
        /*}*/
        .h1-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* Cyan blink – GIMCA */
        @keyframes blink-cyan {
            0% {
                background-color: transparent;
                box-shadow: none;
            }

            50% {
                background-color: #c62828;
                box-shadow: 0 0 14px rgba(198, 40, 40, 0.7);
            }

            100% {
                background-color: transparent;
                box-shadow: none;
            }
        }

        .blink-cyan {
            animation: blink-cyan 1.3s ease-in-out infinite;
            border-radius: 6px;
            padding: 6px 10px;
            color: #ffffff !important;
        }

        /* Amber blink – Admission */
        @keyframes blink-amber {
            0% {
                background-color: transparent;
                box-shadow: none;
            }

            50% {
                background-color: #f4b740;
                box-shadow: 0 0 12px rgba(244, 183, 64, 0.65);
            }

            100% {
                background-color: transparent;
                box-shadow: none;
            }
        }

        .blink-amber {
            animation: blink-amber 1.3s ease-in-out infinite;
            border-radius: 6px;
            padding: 6px 10px;
            color: #ffffff !important;
        }

        .circular-ticker {
            height: 350px;
            overflow: hidden;
            position: relative;
        }

        .ticker-list {
            list-style: none;
            padding: 0;
            margin: 0;
            animation: scrollUp 30s linear infinite;
        }

        .ticker-list li {
            padding: 10px 0;
            border-bottom: 1px dashed #ddd;
        }

        .ticker-list li a {
            color: #000;
            text-decoration: none;
            font-size: 14px;
            display: block;
        }

        .ticker-list li a:hover {
            color: #ba2a21;
        }

        @keyframes scrollUp {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-100%);
            }
        }

        @media only screen and (max-width: 767px) {
            #first-card {
                margin-top: 80px !important;
            }
        }

        .news-slider {
            background: #fdfdfd;
            padding: 50px 0;
            overflow: hidden;
        }

        .news-slider marquee {
            display: flex;
            align-items: center;
        }

        .news-card {
            width: 300px;
            height: 300px;
            /* background: #fff; */
            /* border: 1px solid #f0f0f0; */
            border-radius: 15px;
            overflow: hidden;
            margin: 20px 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            cursor: pointer;
            padding: 20px;
            position: relative;
        }

        .news-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: #ba2a21;
        }

        .news-card img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 5px;
        }
    </style>

</head>

<body class="courses">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NMF9CJ96" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php include 'include/importheader.php'; ?>

    <!--  End header section-->
    </section>
    <!--  End header section-->
    <a href="https://api.whatsapp.com/send?phone=917574949494&text=Hello%20I%20Am%20Interested%20in%20Admission"
        class="float" target="_blank">
        <i class="fa-brands fa-whatsapp my-float"></i>
    </a>
    <h1 class="h1-hidden">Gyanmanjari Innovative University – Bhavnagar, Gujarat</h1>
    <section aria-hidden="false" style="position: absolute; left: -9999px;">
        Gyanmanjari University is the best university in Bhavnagar and a top choice for students searching for a private
        university in Gujarat. Apply now for Admission 2025 Bhavnagar and explore our BSc College near Bhavnagar and
        Engineering College Bhavnagar. As a leading university in Bhavnagar, we are committed to providing quality
        Education. Bhavnagar Education
    </section>



    <!-- Info Page -->
    <section class="blog-area">
        <div class="container">
            <div class="row">
                <div id="first-card" class="col-sm-4 latest-news-single">
                    <div class="blog-single-box">
                        <h3 id="head-design">ACADEMIC TRACK</h3>
                        <div class="blog-content">
                            <?php
                            $programs = [
                                ["name" => "PLM", "icon" => "fa-crown"],
                                ["name" => "Regular", "icon" => "fa-graduation-cap"],
                                ["name" => "Dual Degree", "icon" => "fa-exchange-alt"],
                                ["name" => "Minor", "icon" => "fa-book"],
                                ["name" => "Honours", "icon" => "fa-star"]
                            ];
                            foreach ($programs as $program) {
                            ?>
                                <div class="row">
                                    <div class="event-headbox">
                                        <div id="img-set" class="col-sm-3 event-img">
                                            <i class="fa <?php echo $program['icon']; ?>"
                                                style="color: black; font-size: 29px;"></i>
                                        </div>
                                        <div class="col-sm-9 event-content">
                                            <p id="pad-remove">
                                                <a
                                                    href="<?php echo $base_url_website_admission; ?>courses_offered.php"><?php echo $program['name']; ?></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="content-bottom">
                                <ul class="list-unstyled">
                                    <li class="first-item">
                                        <a href="<?php echo $base_url_website_admission; ?>courses_offered.php">
                                            View More <i class="fa fa-long-arrow-right blog-btn-icon"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 latest-news-single">
                    <div class="blog-single-box">
                        <h3 id="head-design">LATEST UPDATE</h3>
                        <div class="blog-content">
                            <div class="row">
                                <div class="col-sm-12" id="li-decoration">
                                    <li><a href="<?php echo $base_url_website; ?>home/circular.php">
                                            Circular / Event
                                        </a>
                                    </li>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12" id="li-decoration">
                                    <li><a href="#media_coverage">
                                            News & Media Coverage
                                        </a>
                                    </li>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12" id="li-decoration">
                                    <li><a href="<?php echo $base_url_website; ?>home/workshop.php">
                                            Seminar / Workshop
                                        </a>
                                    </li>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12" id="li-decoration">
                                    <li><a href="<?php echo $base_url_website; ?>home/project.php">
                                            Project - Social Impact Project
                                        </a>
                                    </li>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12" id="li-decoration">
                                    <li><a href="<?php echo $base_url_website; ?>home/placement.php">
                                            Regular Update Of Placement
                                        </a>
                                    </li>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12" id="li-decoration">
                                    <li><a href="<?php echo $base_url_website; ?>home/industrial_visit.php">
                                            Industrial Visit
                                        </a>
                                    </li>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12" id="li-decoration">
                                    <li><a href="<?php echo $base_url_website; ?>home/sdp.php">
                                            SDP
                                        </a>
                                    </li>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-4 latest-news-single">
                    <div class="blog-single-box">
                        <h3 id="head-design">DAILY POST</h3>
                        <div class="blog-content" style="padding-top:0;">
                            <div class="daily-post-index">
                                <!-- dynamic daily post  -->
                                <?php
                                $cmd = $con->prepare("SELECT daily_post.id as dp_id, daily_post.date as dp_date, daily_post.file_type as dp_file_type FROM tbl_daily_post as daily_post WHERE daily_post.is_active=1 AND daily_post.is_delete=0 GROUP BY daily_post.date DESC LIMIT 2 ");
                                $cmd->execute();
                                $result = $cmd->get_result();
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {

                                        $date = $row['dp_date'];
                                        echo '<div class="row" style="margin-left: 0px;">
                                        <p>Date : ' . $date . '</p>
                                        </div>
                                        <div class="dp-index">';

                                        $cmd1 = $con->prepare("SELECT daily_post.file_type as dp_file_type,daily_post.id as dp_id, daily_post.date as dp_date, daily_post.file as dp_file FROM tbl_daily_post as daily_post WHERE daily_post.is_active=1 AND daily_post.is_delete=0 AND date = '$date' AND daily_post.faculty_id = '0' LIMIT 4");
                                        $cmd1->execute();
                                        $result1 = $cmd1->get_result();
                                        if ($result->num_rows > 0) {
                                            while ($row1 = $result1->fetch_assoc()) {
                                                $file_type =  $row1['dp_file_type'];
                                                $dp_id =  $row1['dp_id'];

                                                // for video 
                                                if ($file_type == "video") {

                                                    $file = $row1['dp_file'];
                                                    echo '
                                                         <a href="' . $file . '" target="_blank">
                                                            <iframe src="' . $file . '"  frameborder="0" class="home-daily-post-content unclickable"></iframe>
                                                        </a>';
                                                }
                                                //for image
                                                if ($file_type == "image") {
                                                    $type = "daily_post";
                                                    $cmd2 = $con->prepare("SELECT sp.id as sp_id,sp.file_name as sp_file_name FROM tbl_site_photos as sp  WHERE type_id=? AND type=? AND is_active=1 AND is_delete=0 ");
                                                    $cmd2->bind_param("is", $dp_id, $type);
                                                    $cmd2->execute();
                                                    $result2 = $cmd2->get_result();
                                                    // if ($result2->num_rows > 0) {
                                                    while ($row2 = $result2->fetch_assoc()) {
                                                        $file_name = $row2['sp_file_name'];
                                                        // <source srcset="' . $upload_website_admin_url . 'daily_post/small_' . $file_name . '" type="image/webp">
                                                        echo '<picture>
                                                              <source srcset="' . $upload_website_admin_url . 'daily_post/' . $file_name . '" type="image/webp">
                                                              <img 
                                                                loading="lazy" 
                                                                src="' . $upload_website_admin_url . 'daily_post/' . $file_name . '" 
                                                                alt="daily post" 
                                                                class="home-daily-post-content" 
                                                                onclick="onClick(this)">
                                                            </picture>';
                                                    }
                                                }
                                            }
                                        }

                                        echo '
                            </div>';
                                    }
                                }
                                ?>
                                <!-- dynamic daily post : END -->

                                <!-- static code  -->
                                <!-- <div class="row" style="margin-left: 0px;">
                                    <p>Date : 1/1/1</p>
                                </div>
                                <div class="dp-index">
                                    <img src="../website_assets/images/media/12.webp" alt="" class="home-daily-post-content" onclick="onClick(this)">
                                    <img src="<?php echo $website_assets_url; ?>images/media/12.webp" alt="" class="home-daily-post-content" onclick="onClick(this)">
                                    <iframe src="https://www.youtube.com/embed/PM1I57PwAYk" frameborder="0" class="home-daily-post-content"></iframe>
                                    <iframe src="https://www.youtube.com/embed/PM1I57PwAYk" frameborder="0" class="home-daily-post-content"></iframe>
                                </div> -->
                            </div>
                            <div class="content-bottom">
                                <ul class="list-unstyled">
                                    <li class="first-item"><a href="../website/home/daily_post.php">Know
                                            More<i class="fa fa-long-arrow-right blog-btn-icon"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </div>
        </div>
        </div>
    </section>
    <section class="mt-s">
        <div class="row">
            <div class="col-sm-12 section-header-box">
                <div class="section-header">
                    <h2><span style="color: #ba2a21;">OUR</span> INSTITUTE</h2>
                </div><!-- ends: .section-header -->
            </div>
        </div>
        <div class="faculty-marquee">
            <div class="faculty-track">
                <div class="faculty-slide">
                    <a href="https://gmiu.edu.in/gmiu/website/faculty/faculty-of-engineering-amp-technology-diploma"
                        target="_blank">
                        <img loading="lazy"
                            src="https://gmiu.edu.in/gmiu/website_assets/images/DEPARTMENT-THUMBNAIL/diploma.jpg"
                            alt="Diploma Faculty" class="faculty-thumb">
                        <div class="faculty-name">INSTITUTE OF ENGINEERING & TECHNOLOGY (DIPLOMA)</div>
                    </a>
                </div>
                <?php
                $cmd = "SELECT `name` AS faculty_name, `id` AS faculty_id, `faculty_slug` FROM `tbl_faculty` 
                WHERE is_active=1 AND is_delete=0 AND id NOT IN (11,12,15,16,19,22,27)";
                $stmt = $con->prepare($cmd);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $faculty_name = ($row['faculty_id'] == 1) ? strtoupper($row['faculty_name']) . " (DEGREE)" : strtoupper($row['faculty_name']);

                    $thumbnail =  "https://gmiu.edu.in/gmiu/website_assets/images/DEPARTMENT-THUMBNAIL/{$row['faculty_id']}.jpg";
                    // URL condition
                    if ($row['faculty_id'] == 9) {
                        $faculty_url = "https://design.gmiu.edu.in/";
                    } else {
                        $faculty_url = $base_url_website_faculty . $row['faculty_slug'];
                    }
                ?>
                    <div class="faculty-slide">
                        <a href="<?php echo $faculty_url; ?>" target="_blank">
                            <img loading="lazy" src="<?php echo $thumbnail; ?>"
                                alt="<?php echo strtoupper($row['faculty_name']); ?>" class="faculty-thumb">
                            <div class="faculty-name"> <?php echo $faculty_name; ?> </div>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
    <!--End .row-->
    <section class="Welcome-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 section-header-box">
                    <div class="section-header">
                        <h2><span style="color: #ba2a21;">WHY</span> STUDY AT GMIU?</h2>
                    </div><!-- ends: .section-header -->
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 wel-ful-box-2">
                    <div class="wel-text-box">
                        <div class="wel-icon">
                            <!-- <img src="<?php echo $website_assets_url; ?>images/index-02/welcome-01.png" alt=""> -->
                            <i class="fa fa-users" style="font-size: 4rem; color:white;"></i>
                        </div>
                        <div class="wel-text">
                            <h3>HIGHEST PLACEMENT</h3>
                            <p>Placement process GMIU is robust and transparent process which ensures that all student
                                got equal chance in any placement drive according to their eligibility and skills
                                expertise which match est with recruiters.</p>
                            <div class="center-button-text">
                                <a
                                    href="https://gmiu.edu.in/gmiu/website/placement/placement_overview_and_statistics.php">read
                                    more<i class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 wel-ful-box-2">
                    <div class="wel-text-box">
                        <div class="wel-icon">
                            <!-- <img src="<?php echo $website_assets_url; ?>images/index-02/welcome-02.png" alt=""> -->
                            <i class="fa fa-rocket" style="font-size: 4rem; color:white;"></i>
                        </div>
                        <div class="wel-text">
                            <h3>SUPPORT TO START UP</h3>
                            <p>A startup or start-up is a company or project undertaken by an entrepreneur to seek,
                                develop, and validate a scalable business model. While entrepreneurship refers to all
                                new businesses, including self-employment...</p>
                            <div class="center-button-text">
                                <a href="https://gmiu.edu.in/gmiu/website/startup/about_startup.php">read more<i
                                        class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 wel-ful-box-2">
                    <div class="wel-text-box">
                        <div class="wel-icon">
                            <i class="fa fa-globe" style="font-size: 4rem; color:white;"></i>
                        </div>
                        <div class="wel-text">
                            <h3 class="text-uppercase">International Relations Cell</h3>
                            <p>
                                The International Relations Cell at Gyanmanjari Innovative University is the central coordinating body for all international engagements involving students, faculty, and global partners such as foreign universities and organizations.
                            </p>
                            <div class="center-button-text">
                                <a href="https://gmiu.edu.in/gmiu/website/international_cell/about_irc.php">
                                    read more <i class="fa fa-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3  wel-ful-box-2">
                    <div class="wel-text-box">
                        <div class="wel-icon">
                            <!-- <img src="<?php echo $website_assets_url; ?>images/index-02/welcome-04.png" alt=""> -->
                            <i class="fa fa-lightbulb-o" style="font-size: 4rem; color:white;"></i>
                        </div>
                        <div class="wel-text">
                            <h3>RESEARCH & INNOVATION (R&I)</h3>
                            <p>Research and innovation (R&I) plays an essential role in triggering smart and sustainable
                                growth and job creation. Research is an intrinsic aspect of the idea development
                                process. Research helps guide numerous decisions that turn an idea into an innovation.
                            </p>
                            <div class="center-button-text">
                                <a href="https://gmiu.edu.in/gmiu/website/research/patent&ibr.php">read more<i
                                        class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="achievment-area">
        <div class="container">

            <div class="row">
                <div class="col-sm-2 counters-item">
                    <div class="section counter-box">
                        <i class="fa fa-book" style="font-size: 3em; 
  color: rgb(255, 255, 255);"></i>
                        <div class="project-count counter">208+</div>
                        <span>Subjects</span>
                    </div>
                </div>
                <div class="col-sm-1 vl"></div>
                <div class="col-sm-2 counters-item">
                    <div class="section counter-box">
                        <i class="fa fa-users" style="font-size: 3em; 
  color: rgb(255, 255, 255);"></i>
                        <div class="project-count counter">2000+</div>
                        <span>Students Shown Faith In Us</span>
                    </div>
                </div>
                <div class="col-sm-1 vl"></div>
                <div class="col-sm-2 counters-item">
                    <div class="section counter-box">
                        <i class="fa fa-flask" style="font-size: 3em; 
  color: rgb(255, 255, 255);"></i>
                        <div class="project-count counter">50+</div>
                        <span>Laboratories</span>
                    </div>
                </div>
                <div class="col-sm-1 vl"></div>
                <div class="col-sm-2 counters-item">
                    <div class="section counter-box">
                        <i class="fa-solid fa-person-chalkboard" style="font-size: 3em; 
  color: rgb(255, 255, 255);"></i>
                        <div class="project-count counter">125+</div>
                        <span>Faculties</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!--===============================
            Placement Highlights
    =================================== -->
    <div class="Welcome-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 section-header-box">
                    <div class="section-header">
                        <h2><span style="color: #ba2a21;">PLACEMENT</span> HIGHLIGHTS</h2>
                    </div><!-- ends: .section-header -->
                </div>
                <div class="row" style="margin: 0px 0px;">
                    <div class="col-sm-5">
                        <div class="placement-card">
                            <div class="plc-card-header">
                                <h3>PLACEMENT STATISTICS</h3>
                            </div>
                            <div class="plc-card-container">
                                <div class="w3-container" id="data-card">
                                    <table class="table">
                                        <thead style="color: #ba2a21;">
                                            <tr>
                                                <th>Year</th>
                                                <th>2015</th>
                                                <th>2016</th>
                                                <th>2017</th>
                                                <th>2018</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="font-weight: 600;">Computer Engineering</td>
                                                <td>100%</td>
                                                <td>100%</td>
                                                <td>96%</td>
                                                <td>98%</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: 600;">Civil Engineering</td>
                                                <td>98%</td>
                                                <td>81%</td>
                                                <td>57%</td>
                                                <td>57%</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: 600;">Electrical Engineering</td>
                                                <td>82%</td>
                                                <td>84%</td>
                                                <td>76%</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: 600;">Information Technology</td>
                                                <td>100%</td>
                                                <td>98%</td>
                                                <td>96%</td>
                                                <td>94%</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: 600;">Mechanical Engineering</td>
                                                <td>66%</td>
                                                <td>71%</td>
                                                <td>66%</td>
                                                <td>88%</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <div id="content-know" style="padding: 0px;">
                                        <button class="btn btn-center">
                                            <a
                                                href="<?php echo $base_url_website_placement; ?>placement_overview_and_statistics.php">More
                                                Details</a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <br>
                        <div class="swiper placement-swiper">
                            <div class="swiper-wrapper">
                                <?php
                                $customOrder = [3, 7, 4, 8, 15, 9, 2, 5, 1]; // your custom order
                                foreach ($customOrder as $i) { ?>
                                    <div class="swiper-slide">
                                        <img loading="lazy"
                                            src="https://www.gmiu.edu.in/gmiu/website_assets/images/associates/p<?php echo $i; ?>.jpg"
                                            alt="Placed Student <?php echo $i; ?>">
                                    </div>
                                <?php } ?>

                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!--======================
            parallax gmiu
    ========================== -->
    <div class="parallax">

        <div class="img-text">
            <a href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php">
                TAKE A TOUR GMIU CAMPUS
            </a>
        </div>

    </div>
    <div class="row" id="media_coverage">
        <div class="col-sm-12 section-header-box">
            <div class="section-header">
                <h2><span style="color: #ba2a21;">SHORTS</span> COVERAGE</h2>
            </div>
            <!-- ends: .section-header -->
        </div>
    </div>

    <div class="swiper3 mySwiper" style="margin: 0 10%; overflow:hidden;">
        <div class="swiper-wrapper">
            <?php
            $cmd = "SELECT `file_type`, `file` FROM `tbl_media_coverage` WHERE file_type = 'reel' AND is_active = 1 AND is_delete = 0 AND faculty_id='0' ORDER BY id DESC LIMIT 10";
            $stmt = $con->prepare($cmd);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                if ($row['file_type'] === "reel") {
                    // Extract the YouTube video ID from the URL.
                    // This regex works for URLs containing 'embed/'
                    preg_match('/embed\/([^?]+)/', $row['file'], $matches);
                    $video_id = isset($matches[1]) ? $matches[1] : '';

                    if (!empty($video_id)) {
                        $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg";
                        echo '<div class="swiper-slide">';
                        echo '<a href="' . htmlspecialchars($row['file']) . '" target="_blank">';
                        echo '<img loading="lazy" src="' . $thumbnail_url . '" alt="YouTube Thumbnail" style="width:280px; height:250px; border-radius: 10px; border:1px solid black; object-fit: cover;">';
                        echo '</a>';
                        echo '</div>';
                    } else {
                        // Optional: Handle cases where the video ID couldn't be extracted.
                        echo '<div class="swiper-slide"><p>Invalid video URL</p></div>';
                    }
                }
            }
            ?>
        </div>
        <div class="swiper-pagination3"></div>
    </div>

    <div style="display: flex; justify-content: center; margin-top: 25px;">
        <a href="media/reel.php" class="view-more-btn" style="
            display: inline-block; 
            padding: 12px 30px; 
            background-color: #ba2a21; 
            color: #fff; 
            border-radius: 5px; 
            text-decoration: none; 
            font-weight: bold;
            text-align: center;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(186, 42, 33, 0.2);">
            View More
        </a>
    </div>
    <br><br>

    <div class="row" id="media_coverage">
        <div class="col-sm-12 section-header-box">
            <div class="section-header">
                <h2><span style="color: #ba2a21;">MEDIA</span> COVERAGE</h2>
            </div><!-- ends: .section-header -->
        </div>
    </div>

    <div class="swiper3 mySwiper" style="margin: 0 10%; overflow:hidden;">
        <div class="swiper-wrapper">
            <?php
            $cmd = "SELECT `file_type`, `file` FROM `tbl_media_coverage` WHERE file_type = 'video' AND is_active = 1 AND is_delete = 0 ORDER BY id DESC LIMIT 10";
            $stmt = $con->prepare($cmd);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                if ($row['file_type'] === "video") {
                    // Extract the YouTube video ID from the URL (assuming the URL contains 'embed/')
                    preg_match('/embed\/([^?]+)/', $row['file'], $matches);
                    $video_id = isset($matches[1]) ? $matches[1] : '';
                    if (!empty($video_id)) {
                        $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg";
                        echo '<div class="swiper-slide">';
                        echo '<a href="' . htmlspecialchars($row['file']) . '" target="_blank">';
                        echo '<img loading="lazy" src="' . $thumbnail_url . '" alt="YouTube Thumbnail" style="width:280px; height:250px; border-radius: 10px; border:1px solid black; object-fit: cover;">';
                        echo '</a>';
                        echo '</div>';
                    } else {
                        // Optional: handle cases where the video ID couldn't be extracted.
                        echo '<div class="swiper-slide"><p>Invalid video URL</p></div>';
                    }
                }
            }
            ?>
        </div>
        <div class="swiper-pagination3"></div>
    </div>



    <div class="news-slider">
        <marquee onMouseOver="this.stop()" onMouseOut="this.start()" direction="left" scrollamount="10" loop="infinite">
            <?php
            $cmd = "SELECT `file_type`, `file`, `alt_text` FROM `tbl_media_coverage` WHERE file_type= 'image' AND is_active = 1 AND is_delete = 0 AND faculty_id = 0 ORDER BY id DESC LIMIT 15";
            $stmt = $con->prepare($cmd);
            $stmt->execute();
            $result = $stmt->get_result();

            $images = []; // Array to store the images

            while ($row = $result->fetch_assoc()) {
                if ($row['file_type'] == "image") {
                    $images[] = [
                        'file' => $row['file'],
                        'alt_text' => $row['alt_text']
                    ];
                }
            }

            if (!empty($images)) {
                $numImages = count($images);
                $repeatTimes = ceil(100 / $numImages);

                for ($i = 0; $i < $repeatTimes; $i++) {
                    foreach ($images as $imageData) {
            ?>
                        <div class="news-card" onclick="onClick(this.querySelector('img'))">
                            <img loading="lazy"
                                src="<?php echo $upload_website_admin_url; ?>media_coverage/<?php echo $imageData['file']; ?>"
                                alt="<?php echo htmlspecialchars($imageData['alt_text'], ENT_QUOTES, 'UTF-8'); ?>"
                                class="modal-ns-hover-opacity">
                        </div>
            <?php
                    }
                }
            }
            ?>
        </marquee>

        <!-- View More Button -->
        <div style="display: flex; justify-content: center; margin-top: 25px;">
            <a href="media/newspaper.php" class="view-more-btn" style="
            display: inline-block; 
            padding: 12px 30px; 
            background-color: #ba2a21; 
            color: #fff; 
            border-radius: 5px; 
            text-decoration: none; 
            font-weight: bold;
            text-align: center;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(186, 42, 33, 0.2);">
                View More Coverage
            </a>
        </div>
    </div>

    <!-- Modal for Image Viewing -->
    <div id="modal01" class="modal-ns" onclick="this.style.display='none'">
        <span class="close">&times;</span>
        <div class="modal-ns-content">
            <img id="img01" style="width:100%; max-width:1200px; border-radius:10px;">
        </div>
    </div>

    <script>
        function onClick(element) {
            document.getElementById("img01").src = element.src;
            document.getElementById("modal01").style.display = "block";
        }
    </script>

    <section class="mt-s">
        <div class="row">
            <div class="col-sm-12 section-header-box">
                <div class="section-header">
                    <h2><span style="color: #ba2a21;">OUR</span> TESTIMONIALS</h2>
                </div><!-- ends: .section-header -->
            </div>
        </div>
        <div class="row-testi">
            <button class="button-testi" onclick="showStd()">STUDENT</button>
            <button class="button-testi" onclick="showAlu()">ALUMNI</button>
        </div>
        <!-- Swiper -->
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <!-- students  -->
                <?php
                $cmd = "SELECT `testimonial_type`, `file`, `file_type`, `name`, `description` ,`is_active`, `is_delete`, `created_by` FROM `tbl_testimonial` WHERE is_active = 1 AND is_delete = 0 ORDER BY `id` DESC";
                $stmt = $con->prepare($cmd);
                $stmt->execute();
                $result = $stmt->get_result();
                echo '<div id="stdDiv">
                            <div class="swiper-container swiper1">
                            <div class="swiper-wrapper">';
                while ($row = $result->fetch_assoc()) {
                    if ($row['testimonial_type'] == 'student') {
                        $file_name = $row['file'];
                        echo '<div class="swiper-slide">
                                                <div class="testi-card">
                                                ';
                ?>
                        <img loading="lazy" src="<?php echo $upload_website_admin_url . "testimonial/";
                                                    echo $file_name; ?>" alt="<?php echo $row['name']; ?>">
                <?php
                        echo  '<h4>', $row['name'], '</h4>';
                        echo '<p>';
                        echo $row['description'];
                        echo  '</p>';
                        echo ' </div>
                            </div>';
                    }
                }
                echo '</div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination1"></div>
                    <!-- Add Arrows -->
                </div>
            </div>';
                ?>
                <!-- students  -->
                <?php
                $cmd = "SELECT `testimonial_type`, `file`, `file_type`, `name`, `description` ,`is_active`, `is_delete`, `created_by` FROM `tbl_testimonial` WHERE is_active = 1 AND is_delete = 0 ORDER BY id DESC LIMIT 15";
                $stmt = $con->prepare($cmd);
                $stmt->execute();
                $result = $stmt->get_result();
                echo '<div id="aluDiv" style="display:none;">
                            <div class="swiper-container swiper1">
                            <div class="swiper-wrapper">';
                while ($row = $result->fetch_assoc()) {
                    if ($row['testimonial_type'] == 'alumni') {
                        $file_name = $row['file'];

                        echo '<div class="swiper-slide">
                                                <div class="testi-card">
                                                ';
                ?>
                        <img loading="lazy" src="<?php echo $upload_website_admin_url . "testimonial/";
                                                    echo $file_name; ?>" alt="<?php echo $row['name']; ?>">
                <?php
                        echo  '<h4>', $row['name'], '</h4>';
                        echo '<p>';
                        echo $row['description'];
                        echo  '</p>';
                        echo ' </div>
                            </div>';
                    }
                }
                echo '</div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination1"></div>
                    <!-- Add Arrows -->
                </div>
            </div>';
                ?>

                <!-- alumni -->
    </section>

    <!--=============================================================
                             TRAINING & PLACEMENT ASSOCIATES 
        ================================================================-->
    <section class="mt-s">
        <div class="row">
            <div class="col-sm-12 section-header-box">
                <div class="section-header">
                    <h2>TRAINING & PLACEMENT ASSOCIATES</h2>
                </div><!-- ends: .section-header -->
            </div>
        </div>
        <marquee class="ass-marquee" onMouseOver="this.stop()" onMouseOut="this.start()" direction="left"
            scrollamount="15">
            <?php
            $imagePaths = [
                $website_assets_url . 'images/associates/1.png',
                $website_assets_url . 'images/associates/2.png',
                $website_assets_url . 'images/associates/3.png',
                $website_assets_url . 'images/associates/4.png',
                $website_assets_url . 'images/associates/6.png',
                $website_assets_url . 'images/associates/7.png',
                $website_assets_url . 'images/associates/8.png',
                $website_assets_url . 'images/associates/9.png',
                $website_assets_url . 'images/associates/11.png',
                $website_assets_url . 'images/associates/12.jpg'
            ];

            $altTexts = [
                "Top recruiter associated with GMIU Bhavnagar for student placement",
                "Corporate partner of GMIU for training and internships",
                "Gyanmanjari University placement company associate logo",
                "Industry tie-up for GMIU students' job opportunities",
                "GMIU's official training and placement collaboration brand",
                "Recruitment partner helping GMIU students secure careers",
                "Training associate working with GMIU Bhavnagar",
                "Company providing internship support to GMIU students",
                "GMIU Bhavnagar recruitment partner for final year students",
                "Industry collaboration logo for GMIU placement support"
            ];

            if (!empty($imagePaths)) {
                // Display the images once
                foreach ($imagePaths as $index => $imagePath) {
                    $alt = htmlspecialchars($altTexts[$index % count($altTexts)], ENT_QUOTES);
            ?>
                    <div class="ass-slide"><img loading="lazy" src="<?php echo $imagePath; ?>" alt="<?php echo $alt; ?>"></div>
            <?php
                }
            }
            ?>
        </marquee>

    </section>



    <!-- End training & placement associates -->
    <!-- Footer Area section -->
    <?php include 'include/importfooter.php';
    include 'include/importjs.php';
    ?>



    <!--<div id="workshop-popup">-->
    <!--    <a href="https://gmiu.edu.in/gmiu/website/forms/hr-conclave.php" target="_blank">-->
    <!--        <img src="./forms/img/hr-conclave-banner.jpg" alt="HR Conclave 1.0">-->
    <!--    </a>-->
    <!--    <p>-->
    <!--        <b>📢 HR Conclave 1.0</b><br>-->
    <!--        Register Now: <a href="https://gmiu.edu.in/gmiu/website/forms/hr-conclave.php" target="_blank">Click Here</a>-->
    <!--    </p>-->
    <!--    <button onclick="hidePopup()">Close</button>-->
    <!--</div>-->
    <!-- <button id="show-popup-btn" style="position: fixed; bottom: 5px; margin-right: auto; padding: 8px 15px; background: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer;">-->
    <!--    Show Popup-->
    <!--</button>-->
    <script>
        function showPopup() {
            let popup = document.getElementById("workshop-popup");
            if (popup) {
                popup.style.display = "block";

                // ⏱ Auto hide after 15 seconds
                setTimeout(function() {
                    popup.style.display = "none";
                }, 5000); // 15000 ms = 15 sec
            }
        }

        function hidePopup() {
            let popup = document.getElementById("workshop-popup");
            if (popup) {
                popup.style.display = "none";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Add event listener to Show Popup button
            showPopup();
            document.getElementById("show-popup-btn").addEventListener("click", showPopup);
        });
    </script>

    <!--<div id="workshop-popup" style="display:none; position:fixed; bottom:10px; right:10px; height: fit-content;width:300px; background:#fff; padding:10px; box-shadow:0px 0px 10px rgba(0,0,0,0.3); border-radius:8px; text-align:center;">-->
    <!--    <a href="https://forms.gle/Vtqqs5bF74nZuXzy9" target="_blank">-->
    <!--    <a href="https://admission.gmiu.edu.in/admission/diploma.php" target="_blank">-->
    <!--        <img src="https://admission.gmiu.edu.in/admission/premium.jpeg" alt="Workshop" style="width:100%; height: auto; object-fit: cover; border-radius:8px;">-->
    <!--    </a>-->
    <!--    <p style="font-size:14px;"><b>📢 Resume & Interview Workshop</b><br> Register Now: <a href="https://forms.gle/Vtqqs5bF74nZuXzy9" target="_blank">Click Here</a></p>-->
    <!--    <button onclick="hidePopup()" style="border:none; background:#f44336; color:white; padding:5px 10px; border-radius:5px; cursor:pointer;">Close</button>-->
    <!--</div>-->

    <!-- <button id="show-popup-btn" style="position: fixed; bottom: 5px; margin-right: auto; padding: 8px 15px; background: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer;">-->
    <!--    Show Popup-->
    <!--</button>-->

    <!--<div id="fdp-popup">-->
    <!--       <button onclick="hideFdpPopup()">✕</button>-->
    <!--       <p><b>📢 AICTE FDP: Artificial Intelligence & Its Applications</b></p>-->
    <!--       <p>Organized by: Gyanmanjari Institute of Technology</p>-->

    <!--       <a href="https://gmiu.edu.in/gmiu/website/FDP.php" target="_blank" class="cta-btn">-->
    <!--           Register Now-->
    <!--       </a>-->
    <!--   </div>-->

    <!-- HOME PAGE ALERT  -->
    <?php
    // include 'common/home-page-alert.php';
    ?>

    <!-- ./ End Footer Area -->
    <!-- JavaScript Files -->
    <!-- jQuery -->
    <!-- Bootstrap JS -->
    <?php

    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {

    ?>

        <script>
            swal({
                title: "<?php echo $_SESSION['status']; ?>",
                // text: "You clicked the button!",
                icon: "<?php echo $_SESSION['status_code']; ?>",
                // button: "Ok!",
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const parentLi = document.querySelector('li');
                const megaMenu = document.querySelector('.mega-menu');

                parentLi.addEventListener('mouseenter', function() {
                    megaMenu.style.display = 'block';
                });

                parentLi.addEventListener('mouseleave', function() {
                    megaMenu.style.display = 'none';
                });
            });
        </script>


    <?php
        unset($_SESSION['status']);
    }
    ?>
    <script src="<?php echo $website_assets_url; ?>js/custom.js"></script>
    <script src="<?php echo $website_assets_url; ?>js/home.js"></script>
    <script>
        function showAlu() {
            document.getElementById('aluDiv').style.display = "block";
            document.getElementById('stdDiv').style.display = "none";
        }

        function showStd() {
            document.getElementById('aluDiv').style.display = "none";
            document.getElementById('stdDiv').style.display = "block";
        }
        var swiper1 = new Swiper('.swiper1', {
            spaceBetween: 30,
            centeredSlides: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination1',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        var swiper2 = new Swiper('.swiper2', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            autoplay: {
                delay: 3000,
            },
            pagination: {
                el: '.swiper-pagination2',
                clickable: true,
            },
            // Default parameters
            // slidesPerView: 1,
            spaceBetween: 10,
            loop: true,
            //parameter for center active slide 
            centeredSlides: true,
            // Responsive breakpoints
            breakpoints: {
                // when window width is >= 320px
                320: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                // when window width is >= 480px
                480: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                // when window width is >= 640px
                640: {
                    slidesPerView: 3,
                    spaceBetween: 10
                }
            }
        });
        var swiper3 = new Swiper('.swiper3', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination3',
                clickable: true,
            },
            autoplay: {
                delay: 3000,
            },
            // Default parameters
            // slidesPerView: 1,
            spaceBetween: 10,
            loop: true,
            // Parameter for center active slide 
            centeredSlides: true,
            // Responsive breakpoints
            breakpoints: {
                // when window width is >= 320px
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    initialSlide: 1,
                    loopedSlides: 3
                },
                // when window width is >= 480px
                480: {
                    slidesPerView: 3,
                    spaceBetween: 0,
                    initialSlide: 1,
                    loopedSlides: 3
                },
                // when window width is >= 640px
                640: {
                    slidesPerView: 3,
                    spaceBetween: 0,
                    initialSlide: 1,
                    loopedSlides: 3
                }
            },
            on: {
                init: function() {
                    this.slideToLoop(1, 0);
                }
            }
        });
        var swiper = new Swiper('.placement-swiper', {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 3000,
            },
            // Default parameters
            // slidesPerView: 1,
            spaceBetween: 10,
            loop: true,
            // Parameter for center active slide 
            centeredSlides: true,
            // Responsive breakpoints
            breakpoints: {
                // when window width is >= 320px
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    initialSlide: 1,
                    loopedSlides: 3
                },
                // when window width is >= 480px
                480: {
                    slidesPerView: 3,
                    spaceBetween: 0,
                    initialSlide: 1,
                    loopedSlides: 3
                },
                // when window width is >= 640px
                640: {
                    slidesPerView: 3,
                    spaceBetween: 0,
                    initialSlide: 1,
                    loopedSlides: 3
                }
            },
            on: {
                init: function() {
                    this.slideToLoop(1, 0);
                }
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const track = document.querySelector(".faculty-track");
            const slides = Array.from(track.children);

            // Duplicate slides to create an infinite effect
            slides.forEach(slide => {
                const clone = slide.cloneNode(true);
                track.appendChild(clone);
            });
        });
    </script>


</body>
<!-- Other HTML content -->

</html>