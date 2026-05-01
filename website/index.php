<?php
include '../database/connect.php';
include '../common/validation.php';
include '../common/globalvariable.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php
    $pageTitle = 'Gyanmanjari Innovative University | Bhavnagar Private University';
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
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/home.css?v=1.0.1" media="print"
        onload="this.media='all'">
    <!-- ✅ Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


    <style>
        .snowflake {
            position: fixed;
            top: -20px;
            color: #ffffff;
            font-family: 'Montserrat', sans-serif;
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

        .swiper-slide {
            background: none !important;
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
                max-width: 150px;
            }
        }

        /* Protect Icons */
        .fa,
        .fas,
        .far,
        .fab,
        .fa-brands,
        .fa-solid,
        .glyphicon,
        [class^="fa-"],
        [class*=" fa-"] {
            font-family: 'FontAwesome' !important;
        }

        .fa-brands {
            font-family: "Font Awesome 6 Brands" !important;
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
                margin-top: 140px !important;
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
            background-color: #1F2A44;
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
            background: #1F2A44 !important;
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
            height: 80vh;
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
                height: 35vh !important;
                /* Reduced height to prevent excessive zoom/blur */
            }

            .rev_slider .rev-slidebg {
                object-fit: cover !important;
                /* Keep cover but with less zoom due to height change */
                object-position: center !important;
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


        /* Amber blink – Admission */
        @keyframes blink-amber {
            0% {
                background-color: transparent;
                box-shadow: none;
            }

            50% {
                background-color: #f4b740;
                box-shadow: 0 0 12px rgba(15, 14, 11, 0.65);
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

        /* Professional Global Enhancements */
        :root {
            --brand-red: #ba2a21;
            --brand-navy: #323a52;
            --soft-gray: #f8f9fa;
        }

        .section-header h2 {
            font-size: 32px;
            font-weight: 800;
            color: var(--brand-navy);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .section-header h2 span {
            color: var(--brand-red);
        }

        /* --- Unified Floating Buttons Styling --- */

        /* WhatsApp Floating Button */
        .float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 55px;
            height: 55px;
            background-color: #25d366;
            color: #fff !important;
            border-radius: 50px;
            text-align: center;
            font-size: 28px;
            box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .float:hover {
            transform: scale(1.1);
            background-color: #128c7e;
        }

        /* GMAP (Admission Portal) Toggle */
        #float-card-toggle {
            position: fixed;
            bottom: 95px;
            /* Offset from bottom to sit above WhatsApp */
            right: 30px;
            width: 55px;
            height: 55px;
            background: #ba2a21;
            color: #fff;
            border-radius: 50%;
            display: none;
            /* Controlled by JS */
            align-items: center;
            justify-content: center;
            font-size: 22px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(186, 42, 33, 0.3);
            z-index: 10000;
            transition: all 0.3s ease;
            animation: pulse-red 2s infinite;
        }

        #float-card-toggle:hover {
            transform: scale(1.1);
            background: #323a52;
            animation: none;
        }

        /* Admission Portal Popup Card */
        #admission-float-card {
            position: fixed;
            bottom: 95px;
            /* Aligned with its toggle */
            right: 30px;
            width: 320px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            z-index: 10001;
            overflow: hidden;
            display: none;
            flex-direction: column;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transform: translateY(20px);
            opacity: 0;
        }

        #admission-float-card.active {
            display: flex;
            transform: translateY(0);
            opacity: 1;
        }

        .float-card-header {
            background: linear-gradient(135deg, #ba2a21, #8b1f18);
            padding: 15px 20px;
            color: #fff;
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .float-card-header .icon-box {
            width: 38px;
            height: 38px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .float-card-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
        }

        .float-card-header p {
            margin: 0;
            font-size: 11px;
            opacity: 0.9;
            color: #fff;
        }

        .close-float-card {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
            transition: 0.3s;
            z-index: 10;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .close-float-card:hover {
            background: #fff;
            color: #ba2a21;
        }

        .float-card-body {
            padding: 20px;
            color: #444;
        }

        .float-card-body p {
            margin: 0 0 15px;
            font-size: 13px;
            line-height: 1.5;
        }

        .float-card-cta {
            background: #ba2a21;
            color: #fff !important;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
        }

        .float-card-cta:hover {
            background: #323a52;
            transform: translateY(-2px);
        }

        /* Animations */
        @keyframes pulse-red {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(186, 42, 33, 0.7);
            }

            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(186, 42, 33, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(186, 42, 33, 0);
            }
        }

        @media (max-width: 768px) {
            .float {
                width: 50px;
                height: 50px;
                bottom: 20px;
                right: 20px;
                font-size: 24px;
            }

            #float-card-toggle,
            #admission-float-card {
                bottom: 80px;
                right: 20px;
            }

            #float-card-toggle {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }

            #admission-float-card {
                width: calc(100% - 40px);
            }
        }

        /* Welcome Box Alignments */
        .wel-ful-box-2 {
            display: flex;
            margin-bottom: 30px;
        }

        .wel-text-box {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .wel-text-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(186, 42, 33, 0.1);
        }

        .wel-text {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            padding: 0 20px;
        }

        .wel-text h3 {
            min-height: 55px;
            /* align headers with 1 vs 2 lines */
            display: flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            color: var(--brand-navy);
            margin-bottom: 15px;
        }

        .wel-text p {
            text-align: center;
            flex-grow: 1;
            margin-bottom: 20px;
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        .center-button-text {
            margin-top: auto;
            text-align: center;
        }

        .center-button-text a {
            font-weight: 700;
            color: var(--brand-navy);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 13px;
        }

        .center-button-text a i {
            margin-left: 5px;
            transition: transform 0.3s ease;
        }

        .center-button-text a:hover i {
            transform: translateX(5px);
        }

        .news-slider {
            background: #fdfdfd;
            padding: 50px 0;
            overflow: hidden;
        }

        /* Modern CSS Infinite Slider */
        .slider-track {
            display: flex;
            align-items: center;
            width: fit-content;
            animation: scroll 40s linear infinite;
        }

        .slider-track:hover {
            animation-play-state: paused;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
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

        .institute-section {
            background-color: #ffffff;
            background-image:
                radial-gradient(at 0% 0%, rgba(186, 42, 33, 0.03) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(31, 42, 68, 0.03) 0px, transparent 50%),
                radial-gradient(#e5e7eb 0.5px, transparent 0.5px);
            background-size: 50% 50%, 50% 50%, 20px 20px;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .institute-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('<?php echo $website_assets_url; ?>images/backdrop.png') no-repeat;
            background-size: cover;
            opacity: 0.03;
            pointer-events: none;
            z-index: 0;
        }

        .institute-section .container {
            position: relative;
            z-index: 1;
        }

        .institute-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            /* margin-top: 50px; */
        }

        .institute-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px 15px;
            text-align: center;
            border: 1px solid #f0f0f0;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none !important;
            box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        /* Decorative circles */
        .institute-card::before,
        .institute-card::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            z-index: -1;
            transition: all 0.4s ease;
            /* box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.1); */
        }


        .institute-card:hover::before {
            transform: scale(1.3) translate(15px, 15px);
            background: rgba(31, 42, 68, 0.12);
        }

        .institute-card:hover::after {
            transform: scale(1.3) translate(-15px, -15px);
            background: rgba(186, 42, 33, 0.12);
        }

        .institute-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transform: translateY(-8px);
            /* border-color: #ba2a21; */
            box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.1);
        }

        .institute-card-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 15px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;
            background: rgba(186, 42, 33, 0.06);
            /* light red background */

            font-size: 26px;
            color: #ba2a21;

            transition: all 0.3s ease;
        }

        .institute-card:hover .institute-card-icon {
            color: #ba2a21;
        }

        .institute-card-divider {
            width: 25px;
            height: 2px;
            background: #ba2a21;
            /* Solid red line as per image */
            margin: 10px auto;
        }

        .institute-card-title {
            font-size: 14px;
            font-weight: 800;
            color: #1F2A44;
            max-width: 180px;
            margin-bottom: 20px;
            text-transform: uppercase;
            line-height: 1.4;
            flex-grow: 1;
            /* display: flex; */
            align-items: center;
            justify-content: center;
        }

        .institute-card-explore {
            color: #ba2a21;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: auto;
        }

        .institute-card-explore i {
            font-size: 14px;
            transition: transform 0.3s ease;
        }

        .institute-card:hover .institute-card-explore i {
            transform: translateX(5px);
        }

        /* Header subtitle style */
        .section-subtitle {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            color: #ba2a21;
            font-weight: 700;
            letter-spacing: 2px;
            font-size: 13px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .section-subtitle::before,
        .section-subtitle::after {
            content: '';
            width: 40px;
            height: 1px;
            background-color: #ba2a21;
        }

        @media (max-width: 1199px) {
            .institute-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 991px) {
            .institute-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 767px) {
            .institute-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .institute-card {
                padding: 30px 15px;
            }
        }

        @media (max-width: 480px) {
            .institute-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .institute-card {
                padding: 15px 8px;
                /* Slightly reduced padding */
            }

            .institute-card-title {
                font-size: 10px;
                /* Reduced from 11px */
                margin-bottom: 8px;
            }

            .institute-card-icon {
                width: 45px;
                /* Reduced from 50px */
                height: 45px;
                font-size: 18px;
                margin-bottom: 10px;
            }

            .institute-card-divider {
                margin: 8px auto;
            }
        }

        @media (max-width: 370px) {
            .institute-card-title {
                font-size: 9px;
                line-height: 1.3;
            }

            .institute-grid {
                gap: 8px;
            }

            .institute-section {
                padding-bottom: 150px !important;
                /* Increase bottom space for floating buttons */
            }
        }



        .section-header-diamond {
            margin: 5px auto 20px;
            width: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.6;
        }

        .section-header-diamond hr {
            flex-grow: 1;
            border-top: 1px solid #1F2A44;
            margin: 0 10px;
        }

        .section-header-diamond i {
            font-size: 8px;
            color: #1F2A44;
        }

        .section-header:before,
        .section-header-l:before {
            display: none;
        }

        .section-header,
        .section-header-l {
            padding-top: 25px;
            padding-bottom: unset !important;
        }

        /* New Custom Card UI CSS */
        .custom-cards-row {
            display: flex;
            flex-wrap: wrap;
        }

        /* Why Choose GMIU Section */
        .why-choose-grid {
            margin-top: 20px;
        }

        .why-choose-img-wrapper {
            position: relative;
            height: 100%;
            min-height: 500px;
            padding: 20px 20px 40px 0;
            display: block;
        }

        .why-choose-main-img {
            width: 85%;
            max-width: 100%;
            height: 480px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            z-index: 1;
            position: relative;
            margin-top: 10px;
        }

        .why-choose-sub-img {
            position: absolute;
            bottom: 30px;
            right: 0;
            width: 55%;
            max-width: 320px;
            height: 300px;
            object-fit: cover;
            border-radius: 15px;
            border: 8px solid #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            z-index: 2;
        }

        .why-choose-card {
            display: flex;
            align-items: flex-start;
            background: #ffffff;
            border-radius: 15px;
            padding: 25px 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            border: 1px solid #eaeaea;
            transition: all 0.3s ease;
        }

        .why-choose-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transform: translateX(-5px);
            border-color: #d0d0d0;
        }

        .why-choose-icon-box {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 2px solid #e0e8f0;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;
            margin-right: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
            transition: 0.3s;
        }

        .why-choose-card:hover .why-choose-icon-box {
            border-color: #ba2a21;
        }

        .why-choose-icon-box i {
            font-size: 32px;
            color: #ba2a21;
        }

        .why-choose-text-box h4 {
            font-size: 18px;
            color: #1F2A44;
            font-weight: 700;
            margin: 0 0 10px;
        }

        .why-choose-text-box .dash {
            width: 25px;
            height: 3px;
            background: #ba2a21;
            margin-bottom: 12px;
            border-radius: 2px;
        }

        .why-choose-text-box p {
            font-size: 13px;
            color: #555;
            line-height: 1.6;
            margin: 0;
        }

        @media (max-width: 1199px) {

            /* Tablet landscape and small desktop */
            .why-choose-main-img {
                height: 380px;
                width: 90%;
            }

            .why-choose-sub-img {
                height: 240px;
                width: 70%;
            }

            .why-choose-img-wrapper {
                min-height: 400px;
                padding: 20px 20px 40px 0;
            }
        }

        @media (max-width: 991px) {

            /* Tablet portrait and below */
            .why-choose-content-col {
                margin-top: 30px;
            }

            .why-choose-img-wrapper {
                min-height: auto;
                padding: 0;
                margin-bottom: 40px;
                display: block;
                /* Disable flex to handle absolute smoothly */
                text-align: center;
            }

            .why-choose-main-img {
                height: 400px;
                width: 80%;
                display: inline-block;
                margin: 0 auto;
            }

            .why-choose-sub-img {
                bottom: -20px;
                right: 5%;
                width: 60%;
                height: 260px;
            }
        }

        @media (max-width: 767px) {

            /* Mobile */
            .why-choose-card {
                flex-direction: column;
                text-align: center;
                align-items: center;
                padding: 30px 20px;
            }

            .why-choose-icon-box {
                margin: 0 0 20px 0;
            }

            .why-choose-text-box .dash {
                margin: 0 auto 12px;
            }

            .why-choose-main-img {
                height: 300px;
                width: 90%;
            }

            .why-choose-sub-img {
                height: 200px;
                width: 70%;
                right: 0;
                bottom: -15px;
            }

            .custom-cards-row {
                margin-top: 80px;
            }

            .custom-cards-row>div[class*="col-"] {
                width: 100%;
            }

        }

        /* New Custom Card UI CSS */
        .custom-cards-row {
            display: flex;
            flex-wrap: wrap;
        }

        .custom-cards-row>div[class*="col-"] {
            display: flex;
        }

        .custom-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            padding: 20px 20px 30px;
            height: 100%;
            width: 100%;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border: 1px solid #f0f0f0;
            margin-bottom: 30px;
        }

        .custom-card-decor {
            position: absolute;
            top: -15px;
            right: -15px;
            width: 50px;
            height: 50px;
            border-radius: 15px;
            transform: rotate(45deg);
        }

        .custom-card-decor.red {
            background-color: #ba2a21;
        }

        .custom-card-decor.blue {
            background-color: #1F2A44;
        }

        .custom-card-header {
            display: inline-flex;
            align-items: center;
            border-radius: 30px;
            color: #fff;
            padding: 5px 20px 5px 5px;
            margin-left: -5px;
            margin-bottom: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 2;
        }

        .custom-card-header::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 15px;
            width: 40px;
            height: 3px;
        }

        .custom-card-header.red {
            background-color: #ba2a21;
        }

        .custom-card-header.red::after {
            background-color: #ba2a21;
        }

        .custom-card-header.blue {
            background-color: #1F2A44;
        }

        .custom-card-header.blue::after {
            background-color: #1F2A44;
        }

        .custom-card-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 2px solid white;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 12px;
            font-size: 16px;
            background: transparent;
        }

        .custom-card-title {
            font-size: 14px !important;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin: 0;
            text-transform: uppercase;
            color: white;
        }

        .custom-card-body {
            flex-grow: 1;
        }

        .academic-list-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .academic-list-item a {
            color: #333;
            text-decoration: none;
        }

        .academic-list-icon {
            width: 35px;
            height: 35px;
            background-color: #faeaea;
            color: #ba2a21;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 16px;
            margin-right: 15px;
        }

        .academic-list-text {
            font-size: 17px;
            color: black;
            font-weight: 500;
        }

        .latest-update-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .latest-update-list li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 15px;
            font-size: 17px;
            color: black;
            font-weight: 500;
        }

        .latest-update-list li::before {
            content: "\2022";
            position: absolute;
            left: 0;
            color: #1F2A44;
            font-size: 20px;
            line-height: 1;
            top: -2px;
        }

        .latest-update-list li a {
            color: #333;
            text-decoration: none;
        }

        .daily-post-item {
            margin-bottom: 15px;
        }

        .daily-post-date {
            font-size: 13px;
            color: #666;
            margin-bottom: 5px;
        }

        .daily-post-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .daily-post-img-wrapper {
            flex: 1 1 calc(50% - 10px);
            min-width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            display: block;
        }

        .daily-post-img-wrapper img,
        .daily-post-img-wrapper iframe {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: none;
        }

        .custom-card-footer {
            text-align: center;
            margin-top: 15px;
            display: flex;
            justify-content: center;
        }

        .custom-card-footer-btn {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            background: transparent;
            border: none;
            padding: 0;
        }

        .custom-card-footer-btn.red {
            color: #ba2a21;
        }

        .custom-card-footer-btn.blue {
            color: #1F2A44;
        }

        .custom-card-footer-btn i {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: 1px solid #eaeaea;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: 10px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
            color: #ba2a21;
        }

        .custom-card-footer-btn.blue i {
            color: #1F2A44;
        }

        .custom-card-footer-btn:hover i {
            transform: translateX(5px);
        }

        .placement-img {
            width: 100% !important;
            height: auto !important;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            transition: transform 0.3s, box-shadow 0.3s;
            display: inline-block;
        }

        .placement-img:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 767px) {
            .placement-images-row {
                padding-left: 15px;
                padding-right: 15px;
                display: flex;
                flex-wrap: wrap;
            }

            .placement-images-row>div {
                width: 50% !important;
                padding: 0 10px !important;
            }

            .placement-img {
                margin-bottom: 25px;
            }
        }

        .btn-view-more {
            display: inline-block;
            background-color: #ba2a21;
            color: #fff;
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(186, 42, 33, 0.3);
            margin-bottom: 30px;
        }

        .btn-view-more:hover {
            background-color: #1F2A44;
            color: #fff;
            box-shadow: 0 6px 20px rgba(31, 42, 68, 0.3);
            transform: translateY(-2px);
        }

        /* Glance Section CSS */
        .glance-section {
            /* padding: 60px 0 80px; */
            background-color: #fcfcfc;
        }

        .glance-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .glance-subtitle {
            color: #ba2a21;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .glance-subtitle hr {
            width: 30px;
            border-top: 2px solid #ba2a21;
            margin: 0 10px;
        }

        .glance-subtitle .blue-hr {
            width: 15px;
            border-top: 2px solid #1F2A44;
            margin: 0 10px 0 0;
        }

        .glance-title {
            color: #1F2A44;
            font-size: 30px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .glance-title span {
            color: #ba2a21;
        }

        .glance-desc {
            color: #666;
            font-size: 14px;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .glance-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .glance-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
            padding: 40px 20px;
            text-align: center;
            width: 250px;
            position: relative;
            transition: 0.3s;
            border: 1px solid #f2f2f2;
        }

        .glance-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .glance-icon-wrap {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 1px dashed #ba2a21;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 30px;
            padding: 5px;
            position: relative;
        }

        .glance-icon-inner {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #ba2a21, #d64036);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 30px;
            box-shadow: inset 0 -3px 10px rgba(0, 0, 0, 0.15);
        }

        .glance-counter {
            font-size: 28px;
            font-weight: 800;
            color: #1F2A44;
            margin-bottom: 5px;
        }

        .glance-card-title {
            font-size: 13px;
            font-weight: 700;
            color: #1F2A44;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 10px;
        }

        .glance-card-dash {
            width: 30px;
            height: 2px;
            background: #ba2a21;
            margin: 15px auto;
        }

        @media (min-width: 992px) {
            .glance-card:not(:last-child)::after {
                content: '';
                position: absolute;
                top: 50%;
                right: -14px;
                width: 6px;
                height: 6px;
                background-color: #ba2a21;
                border-radius: 50%;
                transform: translateY(-50%);
            }
        }

        @media (max-width: 767px) {
            .glance-grid {
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
                padding: 0 10px;
            }

            .glance-card {
                flex: 0 0 calc(50% - 5px);
                width: calc(50% - 5px);
                max-width: none;
                margin-bottom: 5px;
                padding: 20px 5px;
            }

            .glance-icon-wrap {
                width: 55px;
                height: 55px;
                margin-bottom: 12px;
            }

            .glance-icon-inner {
                font-size: 20px;
            }

            .glance-counter {
                font-size: 20px;
            }

            .glance-card-title {
                font-size: 10px;
                letter-spacing: 0;
            }

            .glance-card-dash {
                margin: 6px auto;
            }
        }

        /* Tour Section CSS */
        .tour-section {
            padding: 50px 0;
            background-color: #fff;
        }

        .tour-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .tour-subtitle {
            color: #ba2a21;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
            display: block;
        }

        .tour-main-title {
            font-size: 34px;
            font-weight: 800;
            color: #1F2A44;
            margin-bottom: 20px;
        }

        .tour-main-title span {
            color: #ba2a21;
        }

        .tour-header-line {
            width: 80px;
            height: 3px;
            background: linear-gradient(to right, #ba2a21 50%, #1F2A44 50%);
            margin: 0 auto 25px;
        }

        .tour-header-desc {
            color: #666;
            font-size: 16px;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.8;
            text-align: center !important;
        }

        .tour-photo-wrapper {
            position: relative;
            /* border-radius: 20px; */
            overflow: hidden;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .tour-photo-img {
            width: 100%;
            display: block;
            transition: transform 0.8s ease;
        }

        .tour-photo-wrapper:hover .tour-photo-img {
            transform: scale(1.03);
        }

        .tour-photo-overlay-text {
            position: absolute;
            top: 40px;
            left: 40px;
            z-index: 10;
        }

        .tour-photo-overlay-text h3 {
            font-size: 42px;
            font-weight: 500;
            color: #ba2a21;
            margin: 0;
            line-height: 1.2;
        }

        .tour-photo-overlay-text h3 strong {
            font-weight: 900;
            display: block;
        }

        .tour-floating-btn {
            position: absolute;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: #ba2a21;
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            box-shadow: 0 10px 20px rgba(186, 42, 33, 0.4);
            transition: 0.3s;
            z-index: 10;
            text-decoration: none;
        }

        .tour-floating-btn:hover {
            transform: scale(1.1);
            background-color: #1F2A44;
            color: white;
        }

        @media (max-width: 767px) {
            .tour-section {
                padding: 60px 0;
            }

            .tour-main-title {
                font-size: 26px;
            }

            .tour-photo-overlay-text {
                top: 20px;
                left: 20px;
            }

            .tour-photo-overlay-text h3 {
                font-size: 24px;
            }

            .tour-floating-btn {
                width: 50px;
                height: 50px;
                bottom: 20px;
                right: 20px;
                font-size: 20px;
            }

            .btn-plm-excellence {
                padding: 12px 30px;
                font-size: 14px;
            }
        }

        /* Shorts Coverage Redesign */
        .shorts-section {
            padding: 40px 0;
            background-color: #fcfcfc;
        }

        .shorts-subtitle-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .shorts-subtitle-line {
            width: 40px;
            height: 1px;
            background-color: #ba2a21;
        }

        .shorts-subtitle {
            color: #ba2a21;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 2px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
        }

        .shorts-subtitle i {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 1px solid #ba2a21;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 10px;
        }

        .shorts-title {
            text-align: center;
            font-size: 38px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #1F2A44;
            text-transform: uppercase;
        }

        .shorts-title span {
            color: #ba2a21;
        }

        .shorts-desc {
            text-align: center;
            color: #666;
            font-size: 15px;
            margin-bottom: 50px;
        }

        .shorts-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            background: #000;
            cursor: pointer;
            width: 100%;
            aspect-ratio: 4/5;
            max-width: 260px;
            margin: 0 auto;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .shorts-thumb {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.9;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .shorts-card:hover .shorts-thumb {
            transform: scale(1.1);
            opacity: 1;
            filter: brightness(1.1);
        }

        .media-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            background: #000;
            cursor: pointer;
            width: 100%;
            aspect-ratio: 16/9;
            max-width: 100%;
            margin: 0 auto;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .media-card:hover .shorts-thumb {
            transform: scale(1.05);
            opacity: 1;
        }

        .media-card:hover .shorts-play-btn {
            background: #ba2a21;
            border-color: #ba2a21;
            transform: translate(-50%, -50%) scale(1.1);
        }

        .shorts-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 5px 12px;
            border-radius: 6px;
            color: white;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            backdrop-filter: blur(4px);
            z-index: 5;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .shorts-badge.festival {
            background: rgba(186, 42, 33, 0.85);
        }

        .shorts-badge i {
            font-size: 12px;
        }

        .shorts-duration {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            font-size: 10px;
            padding: 3px 8px;
            border-radius: 4px;
            z-index: 5;
        }

        .shorts-play-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 18px;
            backdrop-filter: blur(2px);
            z-index: 5;
            transition: 0.3s;
        }

        .shorts-card:hover .shorts-play-btn {
            background: #ba2a21;
            border-color: #ba2a21;
            transform: translate(-50%, -50%) scale(1.1);
        }

        .shorts-overlay-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 30px 15px 15px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.95) 0%, transparent 100%);
            color: white;
            z-index: 5;
            text-align: left;
        }

        .shorts-card-title {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 3px;
            display: block;
            color: white;
        }

        .shorts-card-desc {
            font-size: 12px;
            opacity: 0.8;
            margin-bottom: 12px;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .shorts-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            opacity: 0.7;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 10px;
        }

        .shorts-card-footer .dots {
            font-size: 16px;
            cursor: pointer;
        }

        .btn-view-shorts {
            background-color: #ba2a21;
            color: white !important;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
            margin-top: 20px;
        }

        .btn-view-shorts:hover {
            background-color: #1F2A44;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 767px) {
            .shorts-title {
                font-size: 28px;
            }

            .shorts-desc {
                font-size: 14px;
                margin-bottom: 30px;
            }

            .shorts-card,
            .media-card {
                width: 100%;
                max-width: 280px;
            }
        }

        /* PLM CTA Section */
        .plm-cta-section {
            background: linear-gradient(135deg, #7f1d1d, #1e3a8a);
            padding: 80px 0;
            text-align: center;
            color: white;
            /* padding-bottom: 20px; */
        }

        .plm-cta-title {
            font-size: 50px;
            font-weight: 800;
            margin-bottom: 25px;
            letter-spacing: 1px;
            color: #fff;
        }

        .plm-cta-desc {
            font-size: 18px;
            font-weight: 500;
            max-width: 800px;
            margin: 0 auto 30px;
            line-height: 1.6;
            opacity: 0.9;
            color: white;
            text-align: center !important;
        }

        .btn-plm-excellence {
            display: inline-block;
            background-color: #fff;
            color: #ba2a21 !important;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            text-transform: uppercase;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            letter-spacing: 1px;
        }

        .btn-plm-excellence:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            background-color: #f8f9fa;
        }

        .btn-plm-excellence i {
            margin-left: 10px;
        }

        @media (max-width: 767px) {
            .plm-cta-title {
                font-size: 28px;
            }

            .plm-cta-desc {
                font-size: 15px;
                padding: 0 15px;
            }

            .plm-cta-section {
                padding: 60px 0;
            }
        }

        /* New Premium Welcome Section */
        .welcome-premium {
            padding: 100px 0;
            background: #fdfdfd;
            position: relative;
            overflow: hidden;
        }

        .welcome-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #ba2a21;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .welcome-title {
            font-size: 54px;
            font-weight: 900;
            color: #1e293b;
            line-height: 1.1;
            margin-bottom: 30px;
        }

        .welcome-title span {
            color: #ba2a21;
            display: block;
        }

        .welcome-text {
            font-size: 16px;
            color: #64748b;
            line-height: 1.8;
            margin-bottom: 40px;
            max-width: 550px;
        }

        @media (max-width: 767px) {
            .welcome-image-wrap img {
                height: auto !important;
                /* Reset height on mobile */
            }

            .btn-welcome-link {
                display: block;
                margin-left: 0 !important;
                margin-top: 20px;
            }
        }

        .welcome-image-wrap {
            padding-top: 30px;
            position: relative;
            border-radius: 30px;
            overflow: visible;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .welcome-main-img {
            width: 100%;
            height: 480px;
            /* Desktop Height */
            object-fit: cover;
            border-radius: 30px;
            display: block;
        }

        @media (max-width: 767px) {
            .welcome-main-img {
                height: auto !important;
                /* Original small size on mobile */
            }

            .btn-welcome-link {
                display: block;
                margin-left: 0 !important;
                margin-top: 20px;
            }
        }

        /* Comprehensive Fix for Mobile Header & Sticky Gap */
        @media (max-width: 991px) {

            /* Fix the mobile menu bar */
            .mean-container .mean-bar {
                z-index: 99999 !important;
            }

            /* Prevent duplicate sticky headers/overlapping */
            #header.is-sticky {
                position: relative !important;
                box-shadow: none !important;
            }

            /* Ensure the logo container doesn't create a blank void */
            .header-body {
                position: relative !important;
                background: #fff !important;
                padding-top: 0 !important;
            }

            /* Fix the 'blank page' jump when scrolling */
            body.mean-container {
                padding-top: 0 !important;
            }

            /* Neutralize the JS-injected sticky-wrapper height on mobile */
            .sticky-wrapper,
            #sticky-wrapper {
                height: auto !important;
            }

            /* Prevent the 'mean-push' div from adding unwanted space */
            .mean-push {
                display: none !important;
                height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Force the mobile logo area to be clean */
            .navbar-header {
                padding: 10px 0 !important;
                background: #fff;
            }

            #nav-logo {
                max-height: 50px !important;
                width: auto !important;
            }
        }

        .welcome-floating-info {
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            padding: 20px 30px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 40px;
            width: 90%;
            justify-content: space-around;
            z-index: 10;
        }

        .info-item {
            text-align: center;
        }

        .info-item i {
            font-size: 20px;
            color: #ba2a21;
            margin-bottom: 8px;
            display: block;
        }

        .info-item span {
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
            display: block;
            line-height: 1.2;
        }

        @media (max-width: 767px) {
            .welcome-floating-info {
                padding: 15px 10px;
                gap: 10px;
                bottom: -40px;
            }

            .info-item i {
                font-size: 16px;
                margin-bottom: 5px;
            }

            .info-item span {
                font-size: 9px;
                font-weight: 800;
            }
        }

        .stats-strip {
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.04);
            margin-top: 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #f1f5f9;
        }

        .stat-box {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
            justify-content: center;
            border-right: 1px solid #f1f5f9;
        }

        .stat-box:last-child {
            border-right: none;
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            background: #fceceb;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ba2a21;
            font-size: 18px;
        }

        .stat-info h4 {
            font-size: 22px;
            font-weight: 800;
            color: #1e293b;
            margin: 0;
        }

        .stat-info p {
            font-size: 12px;
            color: #64748b;
            margin: 0;
            text-transform: uppercase;
            font-weight: 600;
        }

        .btn-welcome-red {
            background: #ba2a21;
            color: #fff !important;
            padding: 15px 35px;
            border-radius: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 20px rgba(186, 42, 33, 0.2);
            transition: 0.3s;
        }

        .btn-welcome-link {
            color: #1e293b !important;
            font-weight: 700;
            margin-left: 30px;
            font-size: 15px;
            text-decoration: none;
        }

        @media (max-width: 991px) {
            .welcome-title {
                font-size: 42px;
            }

            .welcome-image-wrap {
                margin-top: 50px;
            }

            .stats-strip {
                flex-wrap: wrap;
                gap: 30px;
            }

            .stat-box {
                border-right: none;
                min-width: 45%;
                justify-content: flex-start;
            }

            .welcome-floating-info {
                padding: 15px;
                gap: 15px;
            }

            .info-item span {
                /* font-size: 9px; */
            }
        }

        /* Media & Newspaper Grid */
        .media-image-grid {
            display: flex;
            flex-wrap: nowrap;
            justify-content: flex-start;
            gap: 20px;
            padding: 30px 15px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .media-image-grid::-webkit-scrollbar {
            height: 6px;
        }

        .media-image-grid::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .media-image-grid::-webkit-scrollbar-thumb {
            background: #ba2a21;
            border-radius: 10px;
        }

        .media-image-col {
            flex: 0 0 calc(20% - 16px);
            min-width: 250px;
        }

        .media-image-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid #eee;
            transition: 0.3s;
            cursor: pointer;
            height: 350px;
        }

        .media-image-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }

        .media-image-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .media-image-card:hover img {
            transform: scale(1.1);
        }



        /* Mobile Refinement for 2-Column Grids */
        @media (max-width: 767px) {
            .shorts-badge {
                font-size: 9px !important;
                padding: 3px 6px !important;
            }

            .tour-info-box {
                padding: 10px 5px !important;
            }

            .tour-info-box span {
                font-size: 10px !important;
            }

            .tour-info-box i {
                font-size: 14px !important;
            }

            .shorts-title {
                font-size: 24px !important;
            }

            .shorts-subtitle {
                font-size: 12px !important;
            }
        }

        /* =========================
           HERO SECTION
        ========================= */
        .hero-premium {
            height: 85vh;
            min-height: 650px;
            background: linear-gradient(rgba(30, 38, 74, 0.7), rgba(30, 38, 74, 0.4)), url('https://gmiu.edu.in/gmiu/website_assets/images/campus.webp');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            color: #fff;
            text-align: left;
        }

        .hero-content {
            max-width: 900px;
            margin: 0;
        }

        .hero-content h4 {
            color: #ba2a21;
            text-transform: uppercase;
            letter-spacing: 4px;
            font-weight: 800;
            font-size: 15px;
            margin-bottom: 25px;
        }

        .hero-content h1 {
            font-size: 64px;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 30px;
            color: #fff !important;
        }

        .hero-content h1 span {
            color: #ba2a21;
        }

        .hero-content p {
            font-size: 19px;
            color: rgba(255, 255, 255, 0.9);
            margin: 0 0 45px;
            max-width: 700px;
            font-weight: 400;
        }

        .hero-btns {
            display: flex;
            gap: 20px;
            justify-content: flex-start;
        }

        .btn-premium {
            padding: 16px 35px;
            border-radius: 8px;
            font-weight: 700;
            text-transform: uppercase;
            transition: 0.3s;
            display: inline-block;
            text-decoration: none !important;
            letter-spacing: 1px;
            font-size: 14px;
        }

        .btn-red {
            background: #ba2a21;
            color: #fff !important;
            box-shadow: 0 8px 20px rgba(186, 42, 33, 0.25);
        }

        .btn-red:hover {
            background: #96221a;
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(186, 42, 33, 0.35);
        }

        .btn-outline {
            border: 2px solid #fff;
            color: #fff !important;
            background: transparent;
        }

        .btn-outline:hover {
            background: #fff;
            color: #1e264a !important;
            transform: translateY(-3px);
        }

        /* =========================
           QUICK ACTION CARDS
        ========================= */
        .floating-actions {
            margin-top: -80px;
            position: relative;
            z-index: 20;
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            border-bottom: 5px solid #ba2a21;
        }

        .action-item {
            padding: 35px 15px;
            text-align: center;
            text-decoration: none !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05);
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .action-item:hover {
            background: #fff;
            transform: translateY(-8px);
        }

        .action-icon {
            font-size: 32px;
            color: #ba2a21;
            margin-bottom: 15px;
        }

        .action-item h5 {
            font-size: 14px;
            font-weight: 800;
            color: #1e264a;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .action-item p {
            font-size: 11px;
            color: #64748b;
            margin: 0;
            font-weight: 600;
            text-align: center !Important;
        }

        @media (max-width: 991px) {
            .hero-premium {
                height: 80vh !important;
                min-height: auto !important;
            }

            .hero-content h1 {
                font-size: 48px;
            }

            .action-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 576px) {
            .hero-premium {
                height: 80vh !important;
            }

            .hero-content h1 {
                font-size: 36px;
            }

            .action-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero-btns {
                flex-direction: column;
            }
        }

        @media (max-width: 991px) {
            .media-image-grid {
                justify-content: flex-start;
                /* Ensures proper scrolling from the left */
            }

            .media-image-col {
                flex: 0 0 250px;
                max-width: 250px;
            }
        }

        /* =========================
   TESTIMONIAL SECTION
========================= */

        .section-backdrop {
            background-image: url('<?php echo $website_assets_url; ?>images/backdrop.png') !important;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .section-padding {
            padding: 50px 0 !important;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .section-header {
            margin-bottom: 60px !important;
        }

        .section-header h2 {
            font-size: 36px !important;
            font-weight: 800 !important;
            color: #1F2A44;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
        }

        .section-header h2 span {
            color: #ba2a21;
        }

        .section-header h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: #ba2a21;
            border-radius: 2px;
        }

        .section-header-diamond {
            display: none !important;
            /* Hide the old diamond lines in favor of the new underline */
        }

        .testimonial-section {
            /* background: #fdfdfd; */
        }

        .testimonial-swiper {
            /* padding: 40px 80px; */
            max-width: 1100px;
            margin: 0 auto;
            overflow: visible !important;
            /* Allow ribbon tails to be visible */
            min-height: 400px;
            padding: 0 40px;
            /* Horizontal padding to safeguard ribbon ends */
        }

        .testimonial-swiper .row {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            /* Allowed wrapping to enable stacking */
            align-items: center !important;
            justify-content: center !important;
        }

        .testimonial-swiper .col-md-6:first-child {
            flex: 0 0 30% !important;
            max-width: 30% !important;
            width: 30% !important;
            position: relative;
            padding-bottom: 30px;
            /* Space for the banner */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .testimonial-swiper .col-md-6:last-child {
            flex: 0 0 68% !important;
            max-width: 68% !important;
            width: 68% !important;
            text-align: left !important;
            padding-left: 30px;
        }

        .testimonial-img {
            width: 100% !important;
            max-width: 250px !important;
            height: auto !important;
            object-fit: cover;
            margin: 0 !important;
            display: block !important;
        }

        .testimonial-banner {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: #ba2a21;
            color: white;
            padding: 8px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: auto;
            min-width: 280px;
            white-space: nowrap;
            z-index: 10;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .testimonial-banner::before,
        .testimonial-banner::after {
            content: "";
            position: absolute;
            top: 0;
            width: 15px;
            height: 100%;
            background: #ba2a21;
        }

        .testimonial-banner::before {
            left: -15px;
            clip-path: polygon(100% 0, 0 50%, 100% 100%);
        }

        .testimonial-banner::after {
            right: -15px;
            clip-path: polygon(0 0, 100% 50%, 0 100%);
        }

        .testimonial-banner .testimonial-name {
            margin: 0 !important;
            font-size: 16px !important;
            color: #fff !important;
            text-transform: none !important;
            font-weight: 700 !important;
        }

        .testimonial-banner .testimonial-course {
            margin: 0 !important;
            font-size: 11px !important;
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500 !important;
            margin-left: 10px !important;
            white-space: nowrap;
        }

        .testimonial-text {
            font-size: 22px !important;
            line-height: 1.8 !important;
            color: #444 !important;
            font-style: italic !important;
            margin-bottom: 25px !important;
            max-width: 850px;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .testimonial-name {
            font-size: 28px !important;
            font-weight: 800 !important;
            color: #1F2A44 !important;
            margin-bottom: 5px !important;
            text-transform: uppercase !important;
        }

        .testimonial-course {
            font-size: 18px !important;
            color: #ba2a21 !important;
            font-weight: 700 !important;
            letter-spacing: 1px !important;
        }

        /* Swiper customization */


        .testimonial-swiper .swiper-pagination {
            display: block !important;
            position: relative !important;
            bottom: 0 !important;
            margin-top: 30px !important;
        }

        .testimonial-swiper .swiper-pagination-bullet {
            background: #ccc !important;
            opacity: 1 !important;
            width: 10px !important;
            height: 10px !important;
            margin: 0 5px !important;
        }

        .testimonial-swiper .swiper-pagination-bullet-active {
            background: #ba2a21 !important;
            width: 25px !important;
            /* Elongated active dot for modern look */
            border-radius: 5px !important;
        }

        @media (max-width: 767px) {
            .testimonial-text {
                font-size: 13px !important;
                line-height: 1.4 !important;
                margin-bottom: 10px !important;
            }

            .testimonial-name {
                font-size: 14px !important;
            }

            .testimonial-course {
                font-size: 11px !important;
            }

            .testimonial-swiper .col-md-6:first-child {
                flex: 0 0 100% !important;
                /* Stack on mobile to give more room for long text */
                max-width: 100% !important;
                width: 100% !important;
                border-right: none !important;
                padding-right: 0;
                margin-bottom: 40px;
            }

            .testimonial-swiper .row {
                flex-direction: column !important;
                align-items: center !important;
                text-align: center !important;
            }

            .testimonial-swiper .col-md-6:last-child {
                flex: 0 0 100% !important;
                max-width: 100% !important;
                width: 100% !important;
                padding-left: 0;
                text-align: center !important;
                margin-top: 20px;
            }

            .testimonial-banner {
                width: auto;
                min-width: 250px;
                max-width: 90%;
            }

            .testimonial-swiper {
                min-height: 600px;
                padding: 0 20px;
            }

            .testimonial-swiper .row {
                align-items: center !important;
            }
        }

        /* Remove unintended background from style.css */
        .courses header .header-body {
            background: none !important;
            min-height: auto !important;
        }

        /* =========================
       PREMIUM TOUR SECTION
    ========================= */
        .tour-premium {
            background: radial-gradient(circle at 10% 20%, rgba(220, 38, 38, 0.03) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(30, 41, 59, 0.05) 0%, transparent 40%),
                #ffffff;
            position: relative;
            overflow: hidden;
        }

        .tour-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background: url('<?php echo $website_assets_url; ?>images/backdrop.png') no-repeat;
            background-size: cover;
            opacity: 0.4;
            filter: blur(50px);
            z-index: 0;
        }

        .tour-premium .container {
            position: relative;
            z-index: 1;
        }

        .tour-card-premium {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(30, 41, 59, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            height: calc(100% - 30px);
        }

        .tour-card-premium:hover {
            transform: translateY(-12px);
            box-shadow: 0 25px 50px rgba(220, 38, 38, 0.15);
            border-color: rgba(220, 38, 38, 0.2);
        }

        .tour-img-wrap {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .tour-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .tour-card-premium:hover .tour-img-wrap img {
            transform: scale(1.1);
        }

        .tour-info-box {
            padding: 20px;
            text-align: center;
            background: #fff;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .tour-info-box i {
            font-size: 20px;
            color: #dc2626;
            margin-bottom: 8px;
            display: block;
        }

        .tour-info-box span {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-tour-premium {
            background: linear-gradient(135deg, #dc2626, #991b1b);
            color: #fff !important;
            padding: 16px 45px;
            border-radius: 50px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border: none;
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.3);
            transition: all 0.3s ease;
            display: inline-block;
            margin-top: 40px;
            position: relative;
            overflow: hidden;
        }

        .btn-tour-premium::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .btn-tour-premium:hover::after {
            left: 100%;
        }

        .btn-tour-premium:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(220, 38, 38, 0.4);
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        @media (max-width: 767px) {
            .tour-card-premium {
                max-width: 300px;
                margin-left: auto;
                margin-right: auto;
            }

            .tour-img-wrap {
                height: 140px;
                /* Reduced height for mobile */
            }

            .tour-info-box {
                padding: 12px 10px;
            }

            .tour-info-box i {
                font-size: 16px;
                margin-bottom: 5px;
            }

            .tour-info-box span {
                font-size: 11px;
            }
        }

        /* Refined Placement Dashboard Styles */
        .placement-refined-section {
            background-color: #fcfcfc;
        }

        .refined-split-box {
            display: flex;
            gap: 30px;
            margin-top: 40px;
        }

        .refined-left {
            flex: 1;
        }

        .refined-right {
            flex: 1;
        }

        /* Stats Card (Left) */
        .stats-report-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            border: 1px solid #f0f0f0;
        }

        .stats-report-header {
            background: #ba2a21;
            padding: 15px 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
        }

        .stats-report-header i {
            font-size: 18px;
        }

        .stats-report-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #fff;
        }

        .stats-table-wrap {
            padding: 25px;
        }

        .refined-stats-table {
            width: 100%;
            border-collapse: collapse;
        }

        .refined-stats-table th {
            text-align: left;
            padding: 15px 10px;
            font-size: 14px;
            font-weight: 700;
            color: #1F2A44;
            border-bottom: 1px solid #f0f0f0;
        }

        .refined-stats-table th.year-col {
            text-align: center;
            color: #ba2a21;
        }

        .refined-stats-table td {
            padding: 15px 10px;
            font-size: 14px;
            border-bottom: 1px solid #f9f9f9;
        }

        .dept-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dept-icon {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .dept-icon.comp {
            background: #fceceb;
            color: #ba2a21;
        }

        .dept-icon.civil {
            background: #e6f4ea;
            color: #1e7e34;
        }

        .dept-icon.it {
            background: #e8f0fe;
            color: #1a73e8;
        }

        .dept-icon.mech {
            background: #fff4e5;
            color: #f29900;
        }

        .dept-name-text {
            font-weight: 600;
            color: #444;
            line-height: 1.2;
        }

        .stat-val {
            text-align: center;
            font-weight: 700;
            color: #444;
            /* Neutral as requested */
        }

        .detailed-report-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px;
            background: #fff;
            border-top: 1px solid #f0f0f0;
            color: #ba2a21;
            font-weight: 700;
            font-size: 13px;
            text-decoration: none;
            text-transform: uppercase;
        }

        .detailed-report-link:hover {
            background: #fcfcfc;
        }

        /* Success Cards (Right) */
        .professional-card-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .student-prof-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
            position: relative;
        }

        .prof-package-tag {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 2;
        }

        .prof-package-tag .lpa-val {
            font-size: 20px;
            font-weight: 800;
            color: #ba2a21;
            display: block;
            line-height: 1;
        }

        .prof-package-tag .lpa-val span {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .prof-package-tag .annum-text {
            font-size: 9px;
            color: #666;
            font-weight: 700;
            text-transform: uppercase;
        }

        .prof-photo-box {
            height: 200px;
            background: #f8f9fa;
            /* Uniform subtle background */
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .prof-photo-box img {
            height: 100%;
            width: auto;
            object-fit: contain;
        }

        .prof-info-footer {
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f5f5f5;
        }

        .prof-company-logo img {
            height: 22px;
            max-width: 80px;
            object-fit: contain;
        }

        .prof-student-name {
            text-align: right;
            font-size: 12px;
            font-weight: 800;
            color: #1F2A44;
            text-transform: uppercase;
            line-height: 1.1;
        }

        /* Pagination Dots */
        .carousel-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
        }

        .p-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #ddd;
        }

        .p-dot.active {
            background: #ba2a21;
            width: 20px;
            border-radius: 10px;
        }

        .view-more-red-btn {
            display: inline-block;
            padding: 15px 40px;
            background: #ba2a21;
            color: #fff;
            font-weight: 800;
            border-radius: 30px;
            text-decoration: none;
            margin-top: 40px;
            box-shadow: 0 10px 20px rgba(186, 42, 33, 0.2);
            transition: all 0.3s ease;
        }

        .view-more-red-btn:hover {
            box-shadow: 0 15px 30px rgba(186, 42, 33, 0.3);
            background: #a1241c;
            color: #fff;
        }

        /* Standardized Section Headers */
        .standard-section-header {
            margin-bottom: 50px;
            text-align: center;
        }

        .header-subtitle-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .h-line {
            width: 40px;
            height: 1.5px;
            background: #ba2a21;
            display: inline-block;
        }

        .h-subtitle {
            color: #ba2a21;
            font-weight: 700;
            letter-spacing: 2px;
            font-size: 14px;
            text-transform: uppercase;
        }

        .h-title {
            font-size: 48px !important;
            color: #1F2A44;
            font-weight: 900 !important;
            margin: 10px 0 !important;
            text-transform: uppercase;
        }

        .h-highlight {
            color: #ba2a21;
        }

        .h-seo-text {
            color: #666;
            font-size: 16px;
            max-width: 650px;
            margin: 15px auto !important;
            line-height: 1.6;
            text-align: center !important;
        }

        .h-bottom-dash {
            width: 50px;
            height: 3px;
            background: #ba2a21;
            margin: 25px auto 0;
        }

        @media (max-width: 768px) {
            .h-title {
                font-size: 32px !important;
            }

            .h-seo-text {
                font-size: 14px;
                padding: 0 15px;
            }
        }

        @media (max-width: 1200px) {
            .refined-split-box {
                flex-direction: column;
            }
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
        <i class="fa-brands fa-whatsapp"></i>
    </a>
    <h1 class="h1-hidden">Gyanmanjari Innovative University – Bhavnagar, Gujarat</h1>
    <section aria-hidden="false" style="position: absolute; left: -9999px;">
        Gyanmanjari University is the best university in Bhavnagar and a top choice for students searching for a private
        university in Gujarat. Apply now for Admission 2025 Bhavnagar and explore our BSc College near Bhavnagar and
        Engineering College Bhavnagar. As a leading university in Bhavnagar, we are committed to providing quality
        Education. Bhavnagar Education
    </section>



    <!-- HERO SECTION -->
    <section class="hero-premium">
        <div class="container">
            <div class="hero-content">
                <h4>ESTABLISHED IN 2015</h4>
                <h1>Empowering <span>Minds.</span><br>Shaping The Future.</h1>
                <p>Experience the transformation of higher education through our unique Proficient Learning Method (PLM), preparing you for global industry challenges.</p>
                <div class="hero-btns">
                    <a href="faculty/all_programs.php" class="btn-premium btn-red">Explore Programs</a>
                    <a href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php" class="btn-premium btn-outline">Take Virtual Tour</a>
                </div>
            </div>
        </div>
    </section>

    <!-- QUICK ACTION CARDS -->
    <section class="floating-actions">
        <div class="container">
            <div class="action-grid">
                <a href="https://admission.gmiu.edu.in/key-features-of-plm" class="action-item">
                    <i class="fa fa-crown action-icon"></i>
                    <h5>PLM</h5>
                    <p>21st Century Method</p>
                </a>
                <a href="https://erp.gmiu.edu.in/admission/student-registration" class="action-item">
                    <i class="fa fa-edit action-icon"></i>
                    <h5>Apply Online</h5>
                    <p>Admissions 2026 Open</p>
                </a>
                <a href="https://ggc.gmiu.edu.in/" class="action-item">
                    <i class="fa fa-university action-icon"></i>
                    <h5>GGC</h5>
                    <p>Girls' College</p>
                </a>
                <a href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php" class="action-item">
                    <i class="fa fa-street-view action-icon"></i>
                    <h5>Virtual Tour</h5>
                    <p>Explore Infrastructure</p>
                </a>
                <a href="https://gmiu.edu.in/gmiu/website/admission/admission_brochure.php" class="action-item">
                    <i class="fa fa-download action-icon"></i>
                    <h5>Downloads</h5>
                    <p>Brochure & Prospectus</p>
                </a>
                <a href="<?php echo $base_url_website; ?>home/circular.php" class="action-item">
                    <i class="fa fa-calendar-alt action-icon"></i>
                    <h5>Circulars</h5>
                    <p>Campus Circulars & News</p>
                </a>
            </div>
        </div>
    </section>
    <!-- PREMIUM WELCOME SECTION -->
    <section class="welcome-premium">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Content -->
                <div class="col-lg-5">
                    <div class="welcome-badge">
                        <i class="fa fa-sparkles"></i> WELCOME TO GMIU <i class="fa fa-sparkles"></i>
                    </div>
                    <h1 class="welcome-title">Welcome to <span>GMIU Bhavnagar</span></h1>
                    <p class="welcome-text">
                        Discover your path to success at <strong>Gyanmanjari Innovative University (GMIU)</strong>, a premier private university in Gujarat. We offer industry-aligned programs in <strong>Engineering, BSc, Diploma, and Pharmacy</strong> through our innovative <strong>Premium Learning Method (PLM)</strong>.<br><br>
                        As you explore the best college in Bhavnagar, take the next step towards your career with <strong>Admission 2026-27</strong> now open for aspiring students.
                    </p>
                    <div class="welcome-btns">
                        <a href="https://erp.gmiu.edu.in/admission/student-registration" class="btn-welcome-red">
                            <i class="fa fa-paper-plane"></i> Apply Now 2026-27
                        </a>
                        <a href="faculty/all_programs.php" class="btn-welcome-link">
                            Explore Programs <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="col-lg-7">
                    <div class="welcome-image-wrap">
                        <img src="https://gmiu.edu.in/gmiu/website_assets/images/college.png" onerror="this.onerror=null;this.src='https://gmiu.edu.in/gmiu/website/assets/images/placeholder_student.png'" alt="GMIU College" class="welcome-main-img">
                        <div class="welcome-floating-info shadow">
                            <div class="info-item">
                                <i class="fa fa-graduation-cap"></i>
                                <span>Industry-Aligned<br>Programs</span>
                            </div>
                            <div class="info-item">
                                <i class="fa fa-building"></i>
                                <span>AI Enabled<br>Infrastructure</span>
                            </div>
                            <div class="info-item">
                                <i class="fa fa-users"></i>
                                <span>Expert<br>Faculty</span>
                            </div>
                            <div class="info-item">
                                <i class="fa fa-briefcase"></i>
                                <span>Strong<br>Placements</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- OUR INSTITUTES REDESIGNED -->
    <section class="institute-section section-backdrop">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="standard-section-header">
                        <div class="header-subtitle-wrap">
                            <span class="h-line"></span>
                            <span class="h-subtitle">EXPLORE EXCELLENCE</span>
                            <span class="h-line"></span>
                        </div>
                        <h2 class="h-title">OUR <span class="h-highlight">INSTITUTES</span></h2>
                        <p class="h-seo-text">Discover a wide range of disciplines to shape your future and build a successful career.</p>
                        <div class="h-bottom-dash"></div>
                    </div>
                </div>
            </div>

            <div class="institute-grid">
                <!-- Institute 1: Diploma -->
                <a href="https://admission.gmiu.edu.in/engineering" class="institute-card">
                    <div class="institute-card-icon">
                        <i class="fa-regular fa-graduation-cap"></i>
                    </div>
                    <div class="institute-card-divider"></div>
                    <div class="institute-card-title">INSTITUTE OF ENGINEERING & TECHNOLOGY <br><span style="color:#ba2a21;">(DIPLOMA)</span></div>
                    <div class="institute-card-explore">
                        Explore <i class="fa fa-arrow-right"></i>
                    </div>
                </a>

                <?php
                $cmd = 'SELECT `name` AS faculty_name, `id` AS faculty_id, `faculty_slug` FROM `tbl_faculty` 
                WHERE is_active=1 AND is_delete=0 AND id NOT IN (11,12,15,16,19,22,27)';
                $stmt = $con->prepare($cmd);
                $stmt->execute();
                $result = $stmt->get_result();
                $faculty_links = [
                    'engineering' => 'https://admission.gmiu.edu.in/engineering',
                    'law' => 'https://admission.gmiu.edu.in/law',
                    'pharmacy' => 'https://admission.gmiu.edu.in/pharmacy',
                    'management' => 'https://admission.gmiu.edu.in/management',
                    'commerce' => 'https://admission.gmiu.edu.in/commerce',
                    'arts' => 'https://admission.gmiu.edu.in/arts',
                    'science' => 'https://admission.gmiu.edu.in/science',
                    'computer' => 'https://admission.gmiu.edu.in/computer-application',
                    'phd' => 'https://phd.gmiu.edu.in/',
                    'design' => 'https://design.gmiu.edu.in/'
                ];

                while ($row = $result->fetch_assoc()) {
                    $raw_name = strtoupper($row['faculty_name']);

                    $fac_lower = strtolower($row['faculty_name']);
                    $faculty_url = '#'; // fallback

                    foreach ($faculty_links as $key => $link) {
                        if (strpos($fac_lower, $key) !== false) {
                            $faculty_url = $link;
                            break;
                        }
                    }

                    // Format Name
                    $display_name = str_replace('FACULTY', 'INSTITUTE', $raw_name);
                    if ($row['faculty_id'] == 1) {  // Engineering Degree
                        $display_name = 'INSTITUTE OF ENGINEERING & TECHNOLOGY <br><span style="color:#ba2a21;">(DEGREE)</span>';
                    } else if (strpos($raw_name, 'COMPUTER') !== false) {
                        $display_name = 'INSTITUTE OF COMPUTER APPLICATION ';
                    } else {
                        // Keep it simple as per image
                        $display_name = $display_name;
                    }

                    // Icons mapping
                    $icon = 'fa-university';
                    if (strpos($fac_lower, 'computer') !== false) $icon = 'fa-desktop';
                    elseif (strpos($fac_lower, 'design') !== false) $icon = 'fa-pen-nib';
                    elseif (strpos($fac_lower, 'law') !== false) $icon = 'fa-scale-balanced';
                    elseif (strpos($fac_lower, 'engineering') !== false) $icon = 'fa-graduation-cap';
                    elseif (strpos($fac_lower, 'management') !== false) $icon = 'fa-users';
                    elseif (strpos($fac_lower, 'commerce') !== false) $icon = 'fa-handshake';
                    elseif (strpos($fac_lower, 'science') !== false) $icon = 'fa-flask-vial';
                    elseif (strpos($fac_lower, 'arts') !== false) $icon = 'fa-book-open';
                    elseif (strpos($fac_lower, 'pharmacy') !== false) $icon = 'fa-pills';

                    // Using fa-regular for outline icons
                ?>
                    <a href="<?php echo $faculty_url; ?>" class="institute-card">
                        <div class="institute-card-icon">
                            <i class="fa-regular <?php echo $icon; ?>"></i>
                        </div>
                        <div class="institute-card-divider"></div>
                        <div class="institute-card-title"><?php echo $display_name; ?></div>
                        <div class="institute-card-explore">
                            Explore <i class="fa fa-arrow-right"></i>
                        </div>
                    </a>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
    <!--End .row-->
    <section class="Welcome-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="standard-section-header">
                        <div class="header-subtitle-wrap">
                            <span class="h-line"></span>
                            <span class="h-subtitle">EXPLORE EXCELLENCE</span>
                            <span class="h-line"></span>
                        </div>
                        <h2 class="h-title">WHY <span class="h-highlight">CHOOSE GMIU?</span></h2>
                        <p class="h-seo-text">Discover a wide range of disciplines to shape your future and build a successful career.</p>
                        <div class="h-bottom-dash"></div>
                    </div>
                </div>
            </div>

            <div class="row why-choose-grid">
                <!-- Left Column with Images -->
                <div class="col-md-5 col-sm-12">
                    <div class="why-choose-img-wrapper">
                        <!-- Demo images as requested -->
                        <img loading="lazy" src="https://admission.gmiu.edu.in/assets/common/plm-image.webp" alt="Demo Image 1" class="why-choose-main-img" onerror="this.src='https://via.placeholder.com/600x500/1F2A44/FFFFFF?text=Demo+Image+1'">
                        <img loading="lazy" src="https://admission.gmiu.edu.in/assets/home/images/activities/15.webp" alt="Demo Image 2" class="why-choose-sub-img" onerror="this.src='https://via.placeholder.com/400x300/ba2a21/FFFFFF?text=Demo+Image+2'">
                    </div>
                </div>

                <!-- Right Column with Features -->
                <div class="col-md-7 col-sm-12 why-choose-content-col">
                    <!-- Feature 1 -->
                    <div class="why-choose-card">
                        <div class="why-choose-icon-box">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="why-choose-text-box">
                            <h4>HIGHEST PLACEMENT</h4>
                            <div class="dash"></div>
                            <p>Placement process GMIU is robust and transparent process which ensures that all student got equal chance in any placement drive according to their eligibility and skills expertise which match est with recruiters.</p>
                            <a href="https://gmiu.edu.in/gmiu/placement.php" style="color: #ba2a21; font-weight: 600; text-decoration: none; font-size: 14px; display: inline-block; margin-top: 5px;">Read More <i class="fa fa-arrow-right" style="margin-left: 5px;"></i></a>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="why-choose-card">
                        <div class="why-choose-icon-box">
                            <i class="fa fa-rocket"></i>
                        </div>
                        <div class="why-choose-text-box">
                            <h4>Support To Start Up</h4>
                            <div class="dash"></div>
                            <p>A startup or start-up is a company or project undertaken by an entrepreneur to seek, develop, and validate a scalable business model. While entrepreneurship refers to all new businesses, including self-employment...</p>
                            <a href="/gmiu/website/startup/about_startup.php" style="color: #ba2a21; font-weight: 600; text-decoration: none; font-size: 14px; display: inline-block; margin-top: 5px;">Read More <i class="fa fa-arrow-right" style="margin-left: 5px;"></i></a>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="why-choose-card">
                        <div class="why-choose-icon-box">
                            <i class="fa fa-globe"></i>
                        </div>
                        <div class="why-choose-text-box">
                            <h4>International Relations Cell</h4>
                            <div class="dash"></div>
                            <p>The International Relations Cell at Gyanmanjari Innovative University is the central coordinating body for all international engagements involving students, faculty, and global partners such as foreign universities and organizations.</p>
                            <a href="/gmiu/website/international_cell/about_irc.php" style="color: #ba2a21; font-weight: 600; text-decoration: none; font-size: 14px; display: inline-block; margin-top: 5px;">Read More <i class="fa fa-arrow-right" style="margin-left: 5px;"></i></a>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="why-choose-card">
                        <div class="why-choose-icon-box">
                            <i class="fa fa-lightbulb-o"></i>
                        </div>
                        <div class="why-choose-text-box">
                            <h4>Research & Innovation (R&I)</h4>
                            <div class="dash"></div>
                            <p>Research and innovation (R&I) plays an essential role in triggering smart and sustainable growth and job creation. Research is an intrinsic aspect of the idea development process. Research helps guide numerous decisions that turn an idea into an innovation.</p>
                            <a href="/gmiu/website/research/gmrdc.php" style="color: #ba2a21; font-weight: 600; text-decoration: none; font-size: 14px; display: inline-block; margin-top: 5px;">Read More <i class="fa fa-arrow-right" style="margin-left: 5px;"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PLM CTA Section -->
    <section class="plm-cta-section">
        <div class="container">
            <h2 class="plm-cta-title">रट्टा अभ्यास छोडो, कौशल्यलक्षी शिक्षा से जुडो ।</h2>
            <p class="plm-cta-desc">Experience the Proficient Learning Method (PLM) at Gyanmanjari Innovative University — where skills meet opportunity.</p>
            <a href="https://admission.gmiu.edu.in/key-features-of-plm" class="btn-plm-excellence">
                DISCOVER PLM EXCELLENCE <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </section>
    <!--======================
            GMIU At A Glance
    ========================== -->
    <section class="glance-section section-padding bg-light section-backdrop" style="padding:100px 0 !important;">
        <div class="container">
            <div class="standard-section-header">
                <div class="header-subtitle-wrap">
                    <span class="h-line"></span>
                    <span class="h-subtitle">BUILDING THE FUTURE</span>
                    <span class="h-line"></span>
                </div>
                <h2 class="h-title">GMIU <span class="h-highlight">AT A GLANCE</span></h2>
                <p class="h-seo-text">Discover a wide range of disciplines to shape your future and build a successful career.</p>
                <div class="h-bottom-dash"></div>
            </div>

            <div class="glance-grid">
                <!-- Card 1 -->
                <div class="glance-card">
                    <div class="glance-icon-wrap">
                        <div class="glance-icon-inner">
                            <i class="fa fa-book"></i>
                        </div>
                    </div>
                    <div class="glance-counter">208+</div>
                    <div class="glance-card-dash"></div>
                    <div class="glance-card-title">SUBJECTS</div>
                </div>

                <!-- Card 2 -->
                <div class="glance-card">
                    <div class="glance-icon-wrap">
                        <div class="glance-icon-inner">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                    <div class="glance-counter">3000+</div>
                    <div class="glance-card-dash"></div>
                    <div class="glance-card-title">STUDENTS SHOWN<br>FAITH IN US</div>
                </div>

                <!-- Card 3 -->
                <div class="glance-card">
                    <div class="glance-icon-wrap">
                        <div class="glance-icon-inner">
                            <i class="fa fa-flask"></i>
                        </div>
                    </div>
                    <div class="glance-counter">65+</div>
                    <div class="glance-card-dash"></div>
                    <div class="glance-card-title">LABORATORIES</div>
                </div>

                <!-- Card 4 -->
                <div class="glance-card">
                    <div class="glance-icon-wrap">
                        <div class="glance-icon-inner">
                            <i class="fa fa-television"></i> <!-- Equivalent of teacher board icon -->
                        </div>
                    </div>
                    <div class="glance-counter">300+</div>
                    <div class="glance-card-dash"></div>
                    <div class="glance-card-title">FACULTIES</div>
                </div>
            </div>
        </div>
    </section>

    <!--======================
            Refined Placement Dashboard
    ========================== -->
    <section class="placement-refined-section section-padding">
        <div class="container">
            <div class="standard-section-header">
                <div class="header-subtitle-wrap">
                    <span class="h-line"></span>
                    <span class="h-subtitle">OUR SUCCESS STORY</span>
                    <span class="h-line"></span>
                </div>
                <h2 class="h-title">PLACEMENT <span class="h-highlight">HIGHLIGHTS</span></h2>
                <p class="h-seo-text">Discover a wide range of disciplines to shape your future and build a successful career.</p>
                <div class="h-bottom-dash"></div>
            </div>

            <div class="refined-split-box">
                <!-- Left: Branch Statistics Table Card -->
                <div class="refined-left">
                    <div class="stats-report-card">
                        <div class="stats-report-header">
                            <i class="fa fa-bar-chart"></i>
                            <h4>PLACEMENT STATISTICS</h4>
                        </div>
                        <div class="stats-table-wrap">
                            <table class="refined-stats-table">
                                <thead>
                                    <tr>
                                        <th>Branch / Passing Year</th>
                                        <th class="year-col">2023</th>
                                        <th class="year-col">2024</th>
                                        <th class="year-col">2025</th>
                                        <th class="year-col">2026</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="dept-info">
                                                <div class="dept-icon comp"><i class="fa fa-laptop"></i></div>
                                                <span class="dept-name-text">Computer<br>Engineering</span>
                                            </div>
                                        </td>
                                        <td class="stat-val">98%</td>
                                        <td class="stat-val">87%</td>
                                        <td class="stat-val">98%</td>
                                        <td class="stat-val">98%</td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="dept-info">
                                                <div class="dept-icon it"><i class="fa fa-code"></i></div>
                                                <span class="dept-name-text">Information<br>Technology</span>
                                            </div>
                                        </td>
                                        <td class="stat-val">94%</td>
                                        <td class="stat-val">94%</td>
                                        <td class="stat-val">93%</td>
                                        <td class="stat-val">94%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="dept-info">
                                                <div class="dept-icon mech"><i class="fa fa-cog"></i></div>
                                                <span class="dept-name-text">Mechanical<br>Engineering</span>
                                            </div>
                                        </td>
                                        <td class="stat-val">100%</td>
                                        <td class="stat-val">100%</td>
                                        <td class="stat-val">100%</td>
                                        <td class="stat-val">100%</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="dept-info">
                                                <div class="dept-icon civil"><i class="fa fa-building-o"></i></div>
                                                <span class="dept-name-text">Civil<br>Engineering</span>
                                            </div>
                                        </td>
                                        <td class="stat-val">—</td>
                                        <td class="stat-val">83%</td>
                                        <td class="stat-val">76%</td>
                                        <td class="stat-val">70%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="https://gmiu.edu.in/gmiu/placement.php" class="detailed-report-link">
                            <i class="fa fa-file-text-o"></i> VIEW DETAILED PLACEMENT REPORT
                        </a>
                    </div>
                </div>

                <!-- Right: Student Highlights Grid -->
                <div class="refined-right">
                    <div class="professional-card-grid">
                        <!-- Student 1 -->
                        <div class="student-prof-card">
                            <div class="prof-photo-box">
                                <img src="https://admission.gmiu.edu.in/assets/engineering/images/placements/1.webp" alt="Dhaval Limbani" onerror="this.onerror=null;this.src='https://gmiu.edu.in/gmiu/website/assets/images/placeholder_student.png'">
                            </div>
                        </div>

                        <!-- Student 2 -->
                        <div class="student-prof-card">
                            <div class="prof-photo-box">
                                <img src="https://admission.gmiu.edu.in/assets/engineering/images/placements/2.webp" alt="Ishan Vaghani" onerror="this.onerror=null;this.src='https://gmiu.edu.in/gmiu/website/assets/images/placeholder_student.png'">
                            </div>
                        </div>

                        <!-- Student 3 -->
                        <div class="student-prof-card">
                            <div class="prof-photo-box">
                                <img src="https://admission.gmiu.edu.in/assets/engineering/images/placements/3.webp" alt="Darshan Zalavadiya" onerror="this.onerror=null;this.src='https://gmiu.edu.in/gmiu/website/assets/images/placeholder_student.png'">
                            </div>
                        </div>

                        <!-- Student 4 -->
                        <div class="student-prof-card">
                            <div class="prof-photo-box">
                                <img src="https://admission.gmiu.edu.in/assets/engineering/images/placements/4.webp" alt="Meha Bhalodiya" onerror="this.onerror=null;this.src='https://gmiu.edu.in/gmiu/website/assets/images/placeholder_student.png'">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="https://gmiu.edu.in/gmiu/placement.php" class="view-more-red-btn">
                    VIEW MORE PLACEMENTS <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!--======================
            GMIU Tour Section (Premium Redesign)
    ========================== -->
    <section class="tour-premium section-padding">
        <div class="container">
            <div class="standard-section-header">
                <div class="header-subtitle-wrap">
                    <span class="h-line"></span>
                    <span class="h-subtitle">VISUAL JOURNEY</span>
                    <span class="h-line"></span>
                </div>
                <h2 class="h-title">CAMPUS <span class="h-highlight">Virtual TOUR</span></h2>
                <p class="h-seo-text">Discover a wide range of disciplines to shape your future and build a successful career.</p>
                <div class="h-bottom-dash"></div>
            </div>

            <div class="row" style="margin-top: 50px;">
                <!-- Library -->
                <div class="col-md-3 col-xs-6">
                    <div class="tour-card-premium">
                        <div class="tour-img-wrap">
                            <img loading="lazy" src="https://gmiu.edu.in/gmiu/website_assets/images/360_virtual_tour-img/cc1.webp" alt="Library">
                        </div>
                        <div class="tour-info-box">
                            <i class="fa fa-book"></i>
                            <span>Campus Enterance</span>
                        </div>
                    </div>
                </div>
                <!-- Labs -->
                <div class="col-md-3 col-xs-6">
                    <div class="tour-card-premium">
                        <div class="tour-img-wrap">
                            <img loading="lazy" src="https://gmiu.edu.in/gmiu/website_assets/images/360_virtual_tour-img/cc2.webp" alt="Labs">
                        </div>
                        <div class="tour-info-box">
                            <i class="fa fa-flask"></i>
                            <span>College Surrounding</span>
                        </div>
                    </div>
                </div>
                <!-- Infrastructure -->
                <div class="col-md-3 col-xs-6">
                    <div class="tour-card-premium">
                        <div class="tour-img-wrap">
                            <img loading="lazy" src="https://gmiu.edu.in/gmiu/website_assets/images/360_virtual_tour-img/sl3.webp" alt="Infrastructure">
                        </div>
                        <div class="tour-info-box">
                            <i class="fa fa-building"></i>
                            <span>computer Lab</span>
                        </div>
                    </div>
                </div>
                <!-- Cafeteria -->
                <div class="col-md-3 col-xs-6">
                    <div class="tour-card-premium">
                        <div class="tour-img-wrap">
                            <img loading="lazy" src="https://gmiu.edu.in/gmiu/website_assets/images/cafeteria/1.jpeg" alt="Cafeteria">
                        </div>
                        <div class="tour-info-box">
                            <i class="fa fa-coffee"></i>
                            <span>Campus Cafe</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php" class="btn-tour-premium">
                    Take a Tour <i class="fa fa-arrow-right" style="margin-left: 10px;"></i>
                </a>
            </div>
        </div>
    </section>
    <!--======================
            Shorts Coverage Section
    ========================== -->
    <section class="shorts-section section-padding">
        <div class="container">

            <div class="standard-section-header">
                <div class="header-subtitle-wrap">
                    <span class="h-line"></span>
                    <span class="h-subtitle">SOCIAL BUZZ</span>
                    <span class="h-line"></span>
                </div>
                <h2 class="h-title">SHORTS <span class="h-highlight">COVERAGE</span></h2>
                <p class="h-seo-text">Discover a wide range of disciplines to shape your future and build a successful career.</p>
                <div class="h-bottom-dash"></div>
            </div>

            <div class="row shorts-grid text-center" style="padding: 20px 0;">
                <?php
                $cmd = "SELECT `file_type`, `file`, `alt_text` FROM `tbl_media_coverage` WHERE file_type = 'reel' AND is_active = 1 AND is_delete = 0 AND faculty_id='0' ORDER BY id DESC LIMIT 4";
                $stmt = $con->prepare($cmd);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    // Extract the YouTube video ID
                    preg_match('/embed\/([^?]+)/', $row['file'], $matches);
                    $video_id = isset($matches[1]) ? $matches[1] : '';

                    if (!empty($video_id)) {
                        $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg";
                        $title = !empty($row['alt_text']) ? $row['alt_text'] : 'GMIU Campus Highlights';
                ?>
                        <div class="col-md-3 col-xs-6" style="margin-bottom: 20px;">
                            <a href="<?php echo htmlspecialchars($row['file']); ?>" target="_blank" style="text-decoration: none;">
                                <div class="shorts-card">
                                    <div class="shorts-badge festival shadow-sm">
                                        <i class="fa fa-play-circle"></i> SHORTS
                                    </div>
                                    <!-- <div class="shorts-duration">0:45</div> -->
                                    <div class="shorts-play-btn">
                                        <i class="fa fa-play"></i>
                                    </div>
                                    <img loading="lazy" src="<?php echo $thumbnail_url; ?>" alt="Shorts Thumbnail" class="shorts-thumb">

                                </div>
                            </a>
                        </div>
                <?php
                    }
                }
                ?>
            </div>

            <div class="text-center">
                <a href="media/reel.php" class="btn-view-more">
                    View More Shorts <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!--======================
            Media Coverage Section
    ========================== -->
    <section class="shorts-section section-padding bg-light" id="media_coverage">
        <div class="container">
            <div class="section-header text-center">
                <h2><span>MEDIA</span> COVERAGE</h2>
                <div class="section-header-diamond">
                    <hr>
                    <i class="fa fa-diamond"></i>
                    <hr>
                </div>
            </div>

            <div class="row shorts-grid text-center" style="padding: 20px 0;">
                <?php
                // Selecting video type for Media Coverage, matching Shorts section style
                $cmd_media = "SELECT `file_type`, `file`, `alt_text` FROM `tbl_media_coverage` WHERE file_type = 'video' AND is_active = 1 AND is_delete = 0 ORDER BY id DESC LIMIT 4";
                $stmt_media = $con->prepare($cmd_media);
                $stmt_media->execute();
                $result_media = $stmt_media->get_result();

                while ($row_media = $result_media->fetch_assoc()) {
                    preg_match('/embed\/([^?]+)/', $row_media['file'], $matches);
                    $video_id = isset($matches[1]) ? $matches[1] : '';
                    if (!empty($video_id)) {
                        $thumbnail_url = "https://img.youtube.com/vi/{$video_id}/hqdefault.jpg";
                        $title = !empty($row_media['alt_text']) ? $row_media['alt_text'] : 'GMIU Media Coverage';
                ?>
                        <div class="col-md-3 col-xs-6" style="margin-bottom: 20px;">
                            <a href="<?php echo htmlspecialchars($row_media['file']); ?>" target="_blank" style="text-decoration: none;">
                                <div class="media-card">
                                    <div class="shorts-badge festival shadow-sm">
                                        <i class="fa fa-play-circle"></i> MEDIA
                                    </div>
                                    <div class="shorts-play-btn">
                                        <i class="fa fa-play"></i>
                                    </div>
                                    <img loading="lazy" src="<?php echo $thumbnail_url; ?>" alt="Media Thumbnail" class="shorts-thumb">
                                </div>
                            </a>
                        </div>
                <?php
                    }
                }
                ?>
            </div>

            <div class="text-center" style="margin-top: 15px;">
                <a href="media/video.php" class="btn-view-more">
                    View More Media <i class="fa fa-arrow-right" style="margin-left: 8px;"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- NEWSPAPER CLIPPINGS SECTION -->
    <div class="container">
        <div class="section-header text-center" style="margin-top: 60px; margin-bottom: 30px;">
            <h2><span>NEWSPAPER</span> CLIPPINGS</h2>
            <div class="section-header-diamond">
                <hr>
                <i class="fa fa-diamond"></i>
                <hr>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="media-image-grid container">
                <?php
                $cmd = "SELECT `file_type`, `file`, `alt_text` FROM `tbl_media_coverage` WHERE file_type= 'image' AND is_active = 1 AND is_delete = 0 AND faculty_id = 0 ORDER BY id DESC LIMIT 4";
                $stmt = $con->prepare($cmd);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                ?>
                    <div class="media-image-col">
                        <div class="media-image-card" onclick="onClick(this.querySelector('img'))">
                            <img loading="lazy"
                                src="<?php echo $upload_website_admin_url; ?>media_coverage/<?php echo $row['file']; ?>"
                                alt="<?php echo htmlspecialchars($row['alt_text'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <!-- View More Button -->
            <div style="display: flex; justify-content: center; margin-top: 5px; margin-bottom: 50px;">
                <a href="media/newspaper.php" class="btn-view-more">
                    View More Coverage <i class="fa fa-arrow-right" style="margin-left: 8px;"></i>
                </a>
            </div>
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

    <!-- =========================
    TESTIMONIAL SECTION
========================= -->
    <section class="testimonial-section section-padding section-backdrop">
        <div class="container">

            <div class="section-header text-center">
                <h2><span>WHAT</span> OUR STUDENTS SAY</h2>
                <div class="section-header-diamond">
                    <hr>
                    <i class="fa fa-diamond"></i>
                    <hr>
                </div>
            </div>

            <div class="swiper testimonial-swiper">
                <div class="swiper-wrapper">

                    <!-- Sparsh -->
                    <div class="swiper-slide">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <img src="<?php echo $website_assets_url; ?>images/testimonials/sparsh-nimbark.png" class="testimonial-img">
                                <div class="testimonial-banner">
                                    <h4 class="testimonial-name">Sparsh Nimbark</h4>
                                    <span class="testimonial-course">CSE Hons. AI & ML</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="testimonial-text">
                                    “Here, we have adopted the Proficient Learning Method and eliminated all rote-learning theory examinations. My career has gained true momentum through the university’s strong association with international universities.”
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Mann -->
                    <div class="swiper-slide">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <img src="<?php echo $website_assets_url; ?>images/testimonials/mann-punjabi.png" class="testimonial-img">
                                <div class="testimonial-banner">
                                    <h4 class="testimonial-name">Mann Punjabi</h4>
                                    <span class="testimonial-course">CSE Hons. AI & ML</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="testimonial-text">
                                    “All the theory is converted into case studies, and all faculties teach us with a research and practical-oriented approach aligned with future industrial demands.”
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Piyush -->
                    <div class="swiper-slide">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <img src="<?php echo $website_assets_url; ?>images/testimonials/piyush-kumar.png" class="testimonial-img">
                                <div class="testimonial-banner">
                                    <h4 class="testimonial-name">Piyush Kumar</h4>
                                    <span class="testimonial-course">CSE Hons. AI & ML</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="testimonial-text">
                                    “Here we have 2 hours of practical classes. There is no hard bifurcation between theory and practical classes. We do case studies and practicals directly in the classroom.”
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Salot -->
                    <div class="swiper-slide">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <img src="<?php echo $website_assets_url; ?>images/testimonials/salot-hitanga.png" class="testimonial-img">
                                <div class="testimonial-banner">
                                    <h4 class="testimonial-name">Salot Hitanga</h4>
                                    <span class="testimonial-course">BBA Hons. IE</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="testimonial-text">
                                    “My experience at GMIU has been truly enriching. The university provides a supportive learning environment with knowledgeable faculties who are always ready to guide and motivate students.”
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Himesh -->
                    <div class="swiper-slide">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <img src="<?php echo $website_assets_url; ?>images/testimonials/satramani-himesh.png" class="testimonial-img">
                                <div class="testimonial-banner">
                                    <h4 class="testimonial-name">Satramani Himesh</h4>
                                    <span class="testimonial-course">BBA Hons. IE</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="testimonial-text">
                                    “In the Proficient Learning Method, module-wise exams were well-structured and concept-based. It encourages practical thinking and real-world business applications.”
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Dhruv -->
                    <div class="swiper-slide">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <img src="<?php echo $website_assets_url; ?>images/testimonials/katariya-dhruv.png" class="testimonial-img">
                                <div class="testimonial-banner">
                                    <h4 class="testimonial-name">Katariya Dhruv</h4>
                                    <span class="testimonial-course">BBA Hons. IE</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="testimonial-text">
                                    “The BBA Entrepreneurship and Innovation course through PLM is a remarkable initiative that goes beyond traditional learning. The curriculum is case-study based and highly engaging.”
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Devangi -->
                    <div class="swiper-slide">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <img src="<?php echo $website_assets_url; ?>images/testimonials/devangi-gadhvi.png" class="testimonial-img">
                                <div class="testimonial-banner">
                                    <h4 class="testimonial-name">Devangi Gadhavi</h4>
                                    <span class="testimonial-course">M.Sc. Clinical Embryology</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="testimonial-text">
                                    “The practical exposure is incredible — case-based learning, lab experiments, mock diagnostics, and hands-on embryology work give us real-world experience.”
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Reeva -->
                    <div class="swiper-slide">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <img src="<?php echo $website_assets_url; ?>images/testimonials/reeva-sutariya.png" class="testimonial-img">
                                <div class="testimonial-banner">
                                    <h4 class="testimonial-name">Reeva Sutaria</h4>
                                    <span class="testimonial-course">B.Sc. Clinical Embryology</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="testimonial-text">
                                    “Embryology at this institute is an industry-oriented program designed to provide advanced theoretical knowledge and practical exposure in human developmental biology.”
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Heer -->
                    <div class="swiper-slide">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <img src="<?php echo $website_assets_url; ?>images/testimonials/dhanani-heer.png" class="testimonial-img">
                                <div class="testimonial-banner">
                                    <h4 class="testimonial-name">Khimani Heer</h4>
                                    <span class="testimonial-course">B.Sc. Forensic Science</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="testimonial-text">
                                    “This type of teaching through well-organised conferences, seminars, and academic events allows us to interact with professionals and gain practical insights into the field of Forensic Science.”
                                </p>
                            </div>
                        </div>
                    </div>

                </div>



                <div class="swiper-pagination"></div>

            </div>
        </div>
    </section>
    <!--=============================================================
                             TRAINING & PLACEMENT ASSOCIATES 
        ================================================================-->
    <section class="section-padding bg-light">
        <div class="row">
            <div class="col-sm-12 section-header-box">
                <div class="section-header">
                    <h2><span>OUR</span> PLACEMENT ASSOCIATES</h2>
                </div><!-- ends: .section-header -->
            </div>
        </div>
        <div style="overflow: hidden; padding: 20px 0;">
            <div class="slider-track" style="animation-duration: 25s;">
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
                    'Top recruiter associated with GMIU Bhavnagar for student placement',
                    'Corporate partner of GMIU for training and internships',
                    'Gyanmanjari University placement company associate logo',
                    "Industry tie-up for GMIU students' job opportunities",
                    "GMIU's official training and placement collaboration brand",
                    'Recruitment partner helping GMIU students secure careers',
                    'Training associate working with GMIU Bhavnagar',
                    'Company providing internship support to GMIU students',
                    'GMIU Bhavnagar recruitment partner for final year students',
                    'Industry collaboration logo for GMIU placement support'
                ];

                if (!empty($imagePaths)) {
                    // Display the images twice for infinite loop
                    for ($loop = 0; $loop < 2; $loop++) {
                        foreach ($imagePaths as $index => $imagePath) {
                            $alt = htmlspecialchars($altTexts[$index % count($altTexts)], ENT_QUOTES);
                ?>
                            <div class="ass-slide" style="min-width: 200px; height: 100px; display: flex; align-items: center; justify-content: center; background: #fff; margin: 0 15px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); padding: 15px;">
                                <img loading="lazy" src="<?php echo $imagePath; ?>" alt="<?php echo $alt; ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                            </div>
                <?php
                        }
                    }
                }
                ?>
            </div>
        </div>

    </section>



    <!-- End training & placement associates -->
    <!-- Footer Area section -->
    <?php
    include 'include/importfooter.php';
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
        var testimonialSwiper = new Swiper(".testimonial-swiper", {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            speed: 800,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            watchSlidesProgress: true,
            preventInteractionOnTransition: true,
            pagination: {
                el: ".testimonial-swiper .swiper-pagination",
                clickable: true,
            },
            grabCursor: true,
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


    <!-- Admission Portal Floating Card -->
    <div id="float-card-toggle" title="Open Admission Portal">
        <i class="fa fa-graduation-cap"></i>
    </div>

    <div id="admission-float-card">
        <div class="close-float-card" id="closeAdmissionCard">
            <i class="fa fa-times"></i>
        </div>
        <div class="float-card-header">
            <div class="icon-box">
                <i class="fa fa-id-card-o"></i>
            </div>
            <div>
                <h4>Admission Portal</h4>
                <p>Gyanmanjari Admission Portal</p>
            </div>
        </div>
        <div class="float-card-body">
            <p>Start your journey at GMIU — apply online through our simple and digital admission process.</p>
            <a href="https://erp.gmiu.edu.in/admission/student-registration" class="float-card-cta" target="_blank">
                <i class="fa fa-sign-in"></i> Open GMAP Portal
            </a>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const card = document.getElementById('admission-float-card');
            const toggle = document.getElementById('float-card-toggle');
            const closeBtn = document.getElementById('closeAdmissionCard');

            // Show toggle by default, card is off
            toggle.style.display = 'flex';

            closeBtn.addEventListener('click', () => {
                card.classList.remove('active');
                setTimeout(() => {
                    card.style.display = 'none';
                    toggle.style.display = 'flex';
                }, 400);
                sessionStorage.setItem('admission_card_dismissed', 'true');
            });

            toggle.addEventListener('click', () => {
                toggle.style.display = 'none';
                card.style.display = 'flex';
                setTimeout(() => {
                    card.classList.add('active');
                }, 10);
            });
        });
    </script>


</body>
<!-- Other HTML content -->

</html>