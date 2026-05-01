<?php
include '../../common/importwebsitefile.php';
?>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "BKSVE Vision & Mission - Indian Knowledge System and Values | GMIU"; ?>
     <?php 
    $meta_description = "Discover the vision and mission of GMIU’s IKSVE Cell—promoting Indian Knowledge Systems and Value Education for holistic academic development.";
    ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include "../include/importhead.php"; ?>
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

            .sideBar {
                width: 100%;
            }
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

            .sideBar {
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
                    <h1>VISION AND MISSION </h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/gmiu/website/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active">Vision And Misiion For BKSVE Cell</span>
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

                                <h4 class="gradText">VISION:</h4>
                                <hr>
                                <ul class="paragraph-text">

                                    <p>1. To create a vibrant educational environment that harmoniously integrates contemporary
                                        fields of study with the profound insights of classical traditions.
                                    </p>


                                    <p>2.To lead in fostering a seamless connection between modern knowledge and ancient
                                        wisdom, encouraging a well-rounded and enlightened approach to learning.
                                    </p>

                                    <p>
                                        3. Inspiring students to value and apply timeless principles, enhancing their understanding
                                        and effectiveness in their chosen disciplines.
                                    </p>
                                    <P>
                                        4. To prepare students to excel both academically and professionally, while cultivating a deep
                                        appreciation for the enduring relevance of historical perspectives.
                                    </P>
                                    <p>
                                        5. To equip students with advanced skills and a profound respect for foundational knowledge
                                        that continues to influence and shape the world.
                                    </p>
                                </ul>

                                <br>
                                <br>


                                <h4 class="gradText">MISSION:</h4>
                                <hr>
                                <ul class="paragraph-text">

                                    <p>1. To deliver a comprehensive education that blends cutting-edge knowledge with the rich
                                        insights of classical traditions.
                                    </p>


                                    <p>2. To bridge the gap between modern disciplines and historical wisdom, illustrating the
                                        ongoing significance of ancient teachings.#
                                    </p>

                                    <p>
                                        3. To cultivate a thorough understanding of contemporary subjects while fostering an
                                        appreciation for historical contexts through an integrative approach.
                                    </p>
                                    <P>
                                        4.Empowering students with the expertise necessary for success, grounded in the timeless
                                        principles of classical thought.
                                    </P>
                                    <p>
                                        5. To inspire students to connect past and present, applying ancient wisdom to
                                        contemporary challenges and achieving excellence in their chosen fields.
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
                                    <li><a href="about_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>About</a></li>
                                    <li><a href="vision_mission.php" class="active"><i class="fa-solid fa-arrow-right"></i>Vision And Mission</a></li>
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