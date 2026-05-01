<?php
include '../../common/importwebsitefile.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
     <?php $pageTitle = "Academic System - Gyanmanjari Innovative University | GMIU"; 
         $meta_description = "Explore GMIU’s academic system with a comprehensive curriculum, flexible learning paths, and rigorous assessments to support student growth and success.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <?php include "../include/importhead.php"; ?>
    <?php include '../include/importcss.php'; ?>


    <style>
        .container .cont .about-cards .about-card img {
            width: 198px;
            height: 144px;
            border-radius: 10px;
        }

        .container .cont .about-cards .about-card {
            justify-content: space-between;
            position: relative;
        }

        .container .cont .about-cards .about-card h3 {
            color: #ba2a21;
            text-transform: uppercase;
            margin: 10px;
        }

        .container .cont .about-cards .about-card ul li {
            color: #727272;
        }

        .container .cont .about-cards .about-card ul {
            margin: 20px 20px 20px 40px;
            /* margin-left: 20px; */
        }

        .about-card {
            background-color: #f8e9e8;
            margin: 20px 0;
            box-shadow: 0 0 10px #00000021;
            padding: 20px;
            border-radius: 10px;
            transition: all .3s ease-in-out;
            display: flex;
        }

        .about-card:nth-child(even) {
            flex-direction: row-reverse;
        }

        .about-card:hover {
            box-shadow: 0 0 30px #f8e9e8;
        }

        .Mbtn {
            display: inline-block;
            padding: 5px 10px;
            border: none;
            position: relative;
            margin: 10px;
            background: #ba2a21;
            color: #fff;
            font-weight: 700;
            border-radius: 5px;
            text-transform: uppercase;
            transition: all .3s;
        }

        .Mbtn:hover {
            transform: translateY(-3px);
            color: #fff !important;
            background: #333333;
        }

        @media only screen and (max-width: 480px) {

            .container .cont .about-cards .about-card {
                flex-direction: column-reverse;
            }

            .container .cont .about-cards{
                width: 90%;
            }

            .flexContainer .cont {
                width: 100%;
                display: flex;
                justify-content: center;
            }

            .container .cont .about-cards .about-card img {
                width: 100%;
                height: auto;
            }
            

            .sticky {
                min-width: 70%;
                /*margin-right: 30px;*/
            }
            .sidebar .sticky {
                /*width: 80%;*/
            }

            

            .container .cont .about-cards .about-card div{
                justify-content: center;
                margin: auto;
                align-items: center;
                display: flex;
                flex-direction: column;
            }

            .container .cont .about-cards .about-card div h3{
                text-align: center;
            }
        }
    </style>

</head>

<body class="courses">
    <!-- Preloader
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> -->
    <?php include '../include/importheader.php'; ?>


    <!-- academic system start  -->

    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>Academic System</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="<?php echo $base_url_website; ?>" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="https://gmiu.edu.in/gmiu/website/campus/nss.php">Academic System</a></span>
                </p>
                <hr>
            </div>
        </div>
    </section>


    <div class="flexContainer container">
        <div class="cont">
            <section class="about-cards">
                <div class="about-card" style="display:flex;">
                    <div>
                        <h3>Theoretical Knowledge Environment :</h3>
                        <ul>
                            <li>100 % syllabus coverage in the class</li>
                            <li>Regular Interval evaluation by test</li>
                            <li>Attendance monitoring</li>
                            <li>Class work evaluation system</li>
                        </ul>
                    </div>
                    <img class="logo" src="../../website_assets/images/academic-system-img/1.webp" alt="Theoretical Knowledge Environment at GMIU">
                </div>
                
                <div class="about-card" style="display:flex;">
                    <div>
                        <h3>Practical Approach with Skill development:</h3>
                        <ul>
                            <li>100 % Practical performance in laboratory</li>
                            <li>Individual Practical Performance Methodology</li>
                            <li>Linkage of Practical with real Industrial application</li>
                        </ul>
                    </div>
                    <img class="logo" src="../../website_assets/images/academic-system-img/2.webp" alt="Practical Skill Development Environment at GMIU">
                </div>
                
                <div class="about-card" style="display:flex;">
                    <div>
                        <h3>Technical Skill Enhancement Program :</h3>
                        <ul>
                            <li>Various activities to develop innovative skills of students</li>
                            <li>Tech fax every year</li>
                            <li>Advance technology learning</li>
                        </ul>
                    </div>
                    <img class="logo" src="../../website_assets/images/academic-system-img/3.webp" alt="Technical Skill Enhancement Program at GMIU">
                </div>
                
                <div class="about-card" style="display:flex;">
                    <div>
                        <h3>Industrial Exposure :</h3>
                        <ul>
                            <li>Frequent Industrial visits</li>
                            <li>Vocational training</li>
                            <li>Expert lectures from industry professionals</li>
                        </ul>
                    </div>
                    <img class="logo" src="../../website_assets/images/academic-system-img/4.webp" alt="Industrial Exposure Program at GMIU">
                </div>
                
                <div class="about-card" style="display:flex;">
                    <div>
                        <h3>Personality Development:</h3>
                        <ul>
                            <li>English speaking</li>
                            <li>Communication skill</li>
                            <li>Paper presentation</li>
                            <li>Seminar & workshop</li>
                            <li>Preparing for interview</li>
                        </ul>
                    </div>
                    <img class="logo" src="../../website_assets/images/academic-system-img/5.webp" alt="Personality Development Activities at GMIU">
                </div>
                
                <div class="about-card" style="display:flex;">
                    <div>
                        <h3>Extra Curricular Development :</h3>
                        <ul>
                            <li>Music learning</li>
                            <li>Dancing / stage performance learning</li>
                            <li>Drama & individual performance learning</li>
                        </ul>
                    </div>
                    <img class="logo" src="../../website_assets/images/academic-system-img/6.webp" alt="Extra Curricular Development at GMIU">
                </div>
                
                <div class="about-card" style="display:flex;">
                    <div>
                        <h3>Further Study Corner:</h3>
                        <ul>
                            <li>GATE preparation & guidance</li>
                            <li>CAT/CMET for MBA entrance</li>
                            <li>IELTS/GRE/TOEFL preparation</li>
                            <li>Foreign language learning facilities</li>
                            <li>Civil services & competitive exam preparation</li>
                            <li>Teaching skill development</li>
                            <li>Career counselling</li>
                        </ul>
                    </div>
                    <img class="logo" src="../../website_assets/images/academic-system-img/7.webp" alt="Further Study and Career Preparation at GMIU">
                </div>
                
                <div class="about-card" style="display:flex;">
                    <div>
                        <h3>Entrepreneurship Centre :</h3>
                        <ul>
                            <li>Entrepreneurship training</li>
                            <li>Experience sharing with young entrepreneurs</li>
                            <li>Creative idea exchange</li>
                        </ul>
                    </div>
                    <img class="logo" src="../../website_assets/images/academic-system-img/8.webp" alt="Entrepreneurship Centre at GMIU">
                </div>
                
                <div class="about-card" style="display:flex;">
                    <div>
                        <h3>Student Exchange Program :</h3>
                        <ul>
                            <li>Visit of other institutes</li>
                            <li>Inter-institute exchange program</li>
                            <li>Interstate exchange program</li>
                            <li>Inter-country exchange program</li>
                        </ul>
                    </div>
                    <img class="logo" src="../../website_assets/images/academic-system-img/9.webp" alt="Student Exchange Program at GMIU">
                </div>
                
                <div class="about-card" style="display:flex;">
                    <div>
                        <h3>Women Development Cell</h3>
                        <ul>
                            <li>To prevent discrimination and sexual harassment against women</li>
                            <li>Support victims in a time-bound manner</li>
                            <li>Co-ordinator: Prof. Dhvani Trivedi</li>
                            <a class="Mbtn" href="<?php echo $base_url_website_campus; ?>academic_system.php">Click Here for More Info</a>
                        </ul>
                    </div>
                    <img class="logo" src="../../website_assets/images/academic-system-img/WHPCell.webp" alt="Women Development Cell at GMIU">
                </div>
                
                <div class="about-card" style="display:flex;">
                    <div>
                        <h3>Social Responsive Cell :</h3>
                        <ul>
                            <li>Commitment to health, infrastructure, and entrepreneurship support for society</li>
                        </ul>
                        <a class="Mbtn" href="<?php echo $base_url_website_campus; ?>academic_system.php">Click Here for More Info</a>
                    </div>
                    <img class="logo" src="../../website_assets/images/academic-system-img/soc.webp" alt="Social Responsive Cell at GMIU">
                </div>

            </section>
        </div>
        <div>
         <!-- right ber start -->
         <?php include "../campus/campussidebar.php"; ?>
        </div>
        <!--  right bar end -->
    </div>

           

    <!-- Footer Area section -->
    <?php //include '../include/importfooter.php' ?>
    <!-- ./ End Footer Area -->
    <!-- ============================
        JavaScript Files
        ============================= -->
    <!-- jQuery -->
    <?php include '../include/importjs.php'; ?>



    <?php include '../include/importfooter.php'?>






</body>

</html>