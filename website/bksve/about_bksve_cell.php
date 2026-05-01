<?php
include '../../common/importwebsitefile.php';
?>
<html class="no-js" lang="zxx">

<head>
   <?php $pageTitle = "About BKSVE Cell at GMIU | Vision & Mission"; 
    $meta_description = "Learn about GMIU's IKSVE Cell—promoting Indian Knowledge Systems, values, and ethics to foster cultural understanding and enrich holistic education.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include '../include/importhead.php'; ?>
    <?php include "../include/importcss.php"; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/program.css">

    
    <style>
        
         hr {
            margin-bottom: 20px;
            border: 0;
            border-top-width: 0px;
            border-top-style: none;
            border-top-color: currentcolor;
            border-top: 1px solid #eee;
        }
        @media screen and (max-width: 768px) {
            .flexContainer .cont {
                flex-direction: column;
            }

            .flexContainer .cont .container {
                margin-left: 0;
            }

            /* .sideBar {
                width: 100%;
            } */
        }

        @media screen and (max-width: 480px) {
            .hero .container .cont .top {
                width: 100%;
                margin-left: 0;
                text-align: center;
            }

            .flexContainer .cont .container .mySlides img {
                width: 100%;
                height: auto;
            }

            .sticky {
                width: 330px;
                height: auto;
                justify-content: center;
                align-items: center;
            }

            .sideBar  {
                width: 370px;
                display: flex;
                padding-left : 20;
                padding-top: 20;
                justify-content: center;
                align-items: center;
            }
           
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
                    <h1>About BKSVE Cell</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/gmiu/website/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active">About BKSVE Cell</span>
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
                                <div class="text-center">
                                    <img src="../../website_assets/images/iksve_image/about.jpg" alt = "BKSVE Cell at GMIU" width="200" height="200">
                                </div>
                                <h4 class="gradText">About</h4>
                                <hr>
                                <ul class="paragraph-text">
                                    
                                        <p>The Bharat Knowledge System and Value Education (BKSVE) cell at Gyanmanjari Innovative University (GMIU) serves as a central body in the University for Activities related to Research and Education under Indian Knowledge System and imparting Value Education in the students of all the departments of the university. </p>
                                    
                                        <p>The cell consists of two domains – Indian Knowledge System and Value Education. Indian Knowledge System (IKS) focusses mainly on research and education related activities in the field of vedic science and culture and the  relating the contemporary modern science with the vedic sciences. IKS has been the field of prime focus for the Government of India (GoI) in the recent years. There are separate departments and cells established in all the government domains especially for IKS. The BKSVE cell at GMIU in alignment with the IKS division of the ministry of Education of GoI, aims at education and research related activities in the vedic scriptures which are immense treasure of scientific, cultural and behavioural knowledge.
                                        </p>
                                    
                                        <p>
                                        Another important domain of BKSVE cell is Value Education. This is another such field whose need has been realized in the recent times a lot. It has been implemented in the core education system in many countries across the globe. In India also, many institutions have implemented it and the GoI has given utmost attention and stress on implementation of it in the schools and educational institutions via New Education Policy (NEP) 2020. The cell focuses on carrying out the same in the higher education. The BKSVE cell activities are orientated around multiferous ways and means with a clear cut focus on imparting Value Education in each and every student of the University. 
                                        </p>
                                    
                                </ul>

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
                                    <li>BKSVE CELL</li>
                                    <li><a href="about_bksve_cell.php" class="active"><i class="fa-solid fa-arrow-right"></i>About</a></li>
                                    <li><a href="vision_mission.php" class=""><i class="fa-solid fa-arrow-right"></i>Vision And Mission</a></li>
                                    <li><a data-toggle="collapse" target="#collapse2" href="#collapse2" class="borAct collapsed" aria-expanded="false">
                                         <i class="fa fa-long-arrow-right"></i>Activities
                                         <span class="icon">
                                         <i class="fa fa-angle-down"> </i>
                                         </span>
                                         </a>  
                                         <div routerlinkactive="in" class="navSubDiv collapse"
                                            id="collapse2" aria-expanded="false" style="height: 0px;">
                                            <ul class="navSub">
                                               <li style="padding: 0px 0px;"><a href="fdp.php" ><i class="fa fa-long-arrow-right"></i>FDP</a></li>
                                               <li style="padding: 0px 0px;"><a href="sdp.php" ><i class="fa fa-long-arrow-right"></i>SDP</a></li>
                                               <li><a href="workshop_seminars.php"><i class="fa fa-long-arrow-right"></i>Workshop</a></li>
                                               <li><a href="other_activities.php" > <i class="fa fa-long-arrow-right"></i>Other Activity</a></li>
                                              </ul>
                                         </div>
                                    </li>     
                                    <li><a href="bksve_gallery_report.php" class=""><i class="fa-solid fa-arrow-right"></i>Gallery</a></li>
                                    <li><a href="contact_us_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Contact Us</a></li>
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