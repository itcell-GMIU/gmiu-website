<?php
include "../../common/importwebsitefile.php"; ?>

<!--DOCTYPE html -->
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "About IRC Connection at GMIU | International Cell"; 
    $meta_description = "Learn about GMIU's International Relations Cell—building global connections, partnerships, and opportunities through student exchanges and collaboration.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include "../include/importhead.php"; ?>
    <?php include "../include/importcss.php"; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">

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

        .cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 250px;
            text-align: center;
            padding: 30px 10px 0px 10px;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card img {
            max-width: 160px;
            height: 30px;
            margin-bottom: 15px;
        }

        .card h3 {
            margin: 10px 0;
            font-size: 1.2em;
        }

        .card p {
            color: #777;
            font-size: 0.9em;
        }
        .card .logo-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .card .logo-container img {
            width: 40px;
            height: 20px;
            margin-right: 10px;
            margin-bottom: 0px;
        }
        .flag {
    position: absolute;
    bottom: 0;
    left: 0;
    z-index: 99;
    max-width: 50px;
}
.client img {
    height: 100px;
    object-fit: contain;
    object-position: center;
}
.flag img {
    height: auto;
}
/* Global styles */
.box_shadow {
    box-shadow: 0 0 30px rgba(40, 43, 64, 0.06);
    padding: 20px 25px;
    height: 100%;
    border-radius: 0 0 4px 4px;
    overflow: hidden;
}

.bg-white {
    background: #ffffff;
}

.client figure {
    margin: 0;
    overflow: hidden;
    border-radius: 4px 4px 0 0;
    transition: .5s all ease-in-out;
    display: inline-block;
    text-align: center;
}

.client .flag {
    position: absolute;
    top: 20px;
    left: 20px;
    width: 60px;
    height: 60px;
    overflow: hidden;
    border: 3px solid #f1f1f1;
    background: #f1f1f1;
    border-radius: 50%;
}

.client .flag img {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #ffffff;
}

.client h3 {
    font-size: 1rem;
    line-height: 1.3;
    color: #1d1e31;
    text-transform: capitalize;
    font-weight: 600;
    letter-spacing: 1px;
    margin: 0;
}

    </style>
</head>

<body class="courses">
    <?php include "../include/importheader.php"; ?>

    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>GLOBAL CONNECTIONS</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/gmiu/website/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active">GLOBAL CONNECTIONS</span>
                </p>
                <hr>
            </div>
        </div>
    </section>

    <div class="single-courses-area">
        <div class="container">
            <div class="row two-colum-section">
                <div class="col-sm-8 sidebar-left">
                    <div class="single-curses-contert">
                        <section class="about-cards">
                            <div class="about-card">
                                <!--<div class="row two-colum-section">-->
                                <div class="col-sm-12 about-card">
                                    <hr style="margin: 0;">
                                    <div>
                                        <h4 class="gradText">Global Connections</h4>
                                    </div>

                                    <hr>
                                    <div class="cards">
                                        <div class="card">
                                            <img src="../../website_admin/uploads/international_cell/laurentian.png" style="" alt="Frederick University">
                                            <div class="logo-container">
                                                <img src="../../website_admin/uploads/international_cell/canada.png" alt="Canada Flag">
                                            </div>
                                            <hr style="border: 2px solid red; width: 100%;">
                                            <h3>Laurentian University</h3>

                                        </div>
                                        
                                        <div class="card">
                                            <img src="../../website_admin/uploads/international_cell/10.jpg" alt="Bern University of Applied Sciences">
                                            <div class="logo-container">
                                                <img src="../../website_admin/uploads/international_cell/france.png" alt="France Flag">
                                            </div>
                                            <hr style="border: 2px solid red; width: 100%;">
                                            <h3>Collège de Paris</h3>
                                        </div>
                                         <div class="card">
                                            <img src="../../website_admin/uploads/international_cell/mmulogo.png" style="" alt="Frederick University">
                                            <div class="logo-container">
                                                <img src="../../website_admin/uploads/international_cell/Flag_of_Malaysia.png" alt="malaysia Flag">
                                            </div>
                                            <hr style="border: 2px solid red; width: 100%;">
                                            <h3>Multimedia University</h3>

                                        </div>
                                        
                                         <div class="card" style= "padding-top: 10px;">
                                            <img src="../../website_admin/uploads/international_cell/CU-LOGO.jpg" style="
                                              width: 100px !important;
                                                height:90px;  " alt="Frederick University">
                                            <div class="logo-container" style= "margin-top:-40px;" >
                                                <img src="../../website_admin/uploads/international_cell/Flag_of_Georgia.png" alt="malaysia Flag">
                                            </div>
                                            <hr style="border: 2px solid red; width: 100%;">
                                            <h3>Caucasus University</h3>
   
                                        </div>
                                        <div class="card">
                                            <img src="../../website_admin/uploads/international_cell/logo.png" style="" alt="BLOOMSBURY INSTITUTE">
                                            <div class="logo-container">
                                                <img src="../../website_admin/uploads/international_cell/UK.png" alt="UK Flag">
                                            </div>
                                            <hr style="border: 2px solid red; width: 100%;">
                                            <h3>BLOOMSBURY INSTITUTE</h3>

                                        </div>
                                         <!--   <div class="client bg-white box_shadow">-->
                            <!--    <figure class="figure" style="position: relative;"> -->
                                                
                            <!--        <div class="flag">-->
                            <!--            <img src="../../website_admin/uploads/international_cell/CU-LOGO.jpg" alt="Caucasus University" class="img-fluid">-->
                            <!--        </div>                       -->
                            <!--                                            <img src="../../website_admin/uploads/international_cell/Flag_of_Georgia.png" alt="Caucasus University" class="img-fluid" style="width:100%">-->
                            <!--    </figure>-->
                            <!--    <hr class="title-hr hr-center hr-pr-100">-->
                            <!--    <h3 class="h6 my-3">Caucasus University</h3>-->
                            <!--</div>-->
                                        
                                 
                                        <!-- <div class="row">
                                        <div class="col-sm-6 about-card" style="display: flex; align-items: center; justify-content: center;">
                                            <img style="border-radius: 8px; width: 100%; height:100%; margin-bottom: 23px;" src="../../website_admin/uploads/international_cell/laurentian.png" alt="irc connection">
                                        </div>
                                        <div class="col-sm-6 about-card" style="display: flex; align-items: center; justify-content: center;">
                                            <img style="border-radius: 8px; width: 100%; height:100%; margin-bottom: 23px;" src="../../website_admin/uploads/international_cell/10.jpg" alt="irc connection">
                                        </div>
                                    </div> -->

                                        <!-- <div class="col-sm-12 about-card" style="display: flex; align-items: center; justify-content: center;">
                                        <img style="border-radius: 8px; width: 100%; height:100%; margin-bottom: 23px;" src="../../website_admin/uploads/international_cell/laurentian.png" alt="irc connection">
                                    </div><br>
                                    <div class="col-sm-12 about-card" style="display: flex; align-items: center; justify-content: center;">
                                        <img style="border-radius: 8px; width: 100%; height:100%; margin-bottom: 23px;" src="../../website_admin/uploads/international_cell/10.jpg" alt="irc connection">
                                    </div><br> -->
                                        <div>

                                            <!--<p class="mu-blog-description" style="font-size: 18px; color:black;"><strong>Gyanmanjari Innovative University Forges International-->
                                            <!--        Partnerships with Laurentian University, Canada, and College De Paris, France</strong></p><br>-->
                                           
                                            <p style="font-size: 14px; color:black;"> This strategic collaboration opens doors to a plethora of benefits for students:</p>
                                            <p style="font-size: 14px; color:black;">
                                                <strong> 1. Cultural Enrichment:</strong> By studying abroad, students will immerse themselves in new cultures, languages, and perspectives, fostering a deeper understanding of global issues and diversity. <br> </li>
                                                <strong> 2. Academic Excellence:</strong> Access to world-class educational resources and faculty from partner institutions will enhance students' academic growth and broaden their knowledge base. <br> </li>
                                                <strong> 3. Professional Development:</strong> Participation in work-based internships abroad will provide students with hands-on experience in their respective fields, equipping them with essential skills and enhancing their employability. <br> </li>
                                                <strong> 4. Global Networking:</strong> Students will have the opportunity to build international networks, fostering connections that may prove invaluable in their future careers. <br> </li>
                                                <strong> 5. Personal Growth:</strong> Living and studying in a foreign country fosters independence, adaptability, and resilience, contributing to students' holistic development. <br></li>
                                            </p>
                                            <!--<p style="font-size: 14px; color:black;"> Commenting on the partnerships, Avinash Patel, President of Gyanmanjari Innovative University, stated, "We are delighted to establish these strategic partnerships with Laurentian University and College De Paris. These collaborations reflect our commitment to providing our students with world-class educational opportunities and preparing them to thrive in an increasingly interconnected world."</p>-->
                                            <!--<p style="font-size: 14px; color:black;"> The MoU between Gyanmanjari Innovative University, Laurentian University, and College De Paris mark the beginning of a transformative journey in global education, enriching the academic experiences of students and fostering international collaboration in research and innovation.</p>-->
                                            <!-- <p style="line-height: 2; font-size: 14px; color:black;">
                                                For more information, please contact:<br>
                                                International Relation Cell<br>
                                                Prof. Vinay Kanani<br>
                                                irc@gmiu.edu.in
                                                <hr><br>
                                            </p> -->
                                            <br>
                                        </div>
                                    </div>
                                    <!--</div>-->
                                </div>
                        </section>
                    </div>
                </div>
                <!-- right bar start  -->
                <div class="col-sm-4 sidebar-right">
                    <div class="sidebar-content">
                        <div class="sideBar">
                            <div class="sticky">
                                <ul>
                                    <li>INTERNATIONAL RELATIONS CELL</li>
                                    <li><a href="about_irc.php" class=""><i class="fa-solid fa-arrow-right"></i>GMIU International Relation Cell</a></li>
                                    <li><a href="about_icm.php" class=""><i class="fa-solid fa-arrow-right"></i>International Initiatives & Collaboration Modes</a></li>
                                    <li><a href="about_admission.php" class=""><i class="fa-solid fa-arrow-right"></i>International Admission </a></li>
                                    <li><a href="about_explosure.php" class=""><i class="fa-solid fa-arrow-right"></i>Global Exposure</a></li>
                                    <li><a href="about_irc_connection.php" class="active"><i class="fa-solid fa-arrow-right"></i>Global Connections</a></li>
                                    <li><a href="contact_us.php" class=""><i class="fa-solid fa-arrow-right"></i>Contact Us</a></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- right bar end  -->
            </div>
        </div>
    </div>

    <?php include "../include/importfooter.php"; ?>

    <?php include "../include/importjs.php"; ?>
</body>

</html>