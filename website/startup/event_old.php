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
            width: 100% !important;
            /* Make table width 100% */
            border-radius: 10px;
            /* Apply border radius of 10% */
            padding: 10px;
            /*margin-left: 10px;*/
            margin-bottom: 50px;

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
 .single-courses-area .tit-event {
                font-size: 25px;
                font-weight: 500;
                margin-top: 50px;
                margin-left: 20px;
        }
        @media (max-width: 992px) {
            .over-flow {
                overflow-x: auto;
            }
        }
        @media (max-width: 992px) {
            td {
                border: none;
        padding: 8px;
        text-align: unset;
        height: 50px;
        width: 0px;
        font-size: 7px;
        padding: 0px 0px 0 7px;
            }
        }
        @media (max-width: 992px) {
           th {
                       /* border: none; */
        padding: 8px;
        text-align: unset;
        height: 50px;
        width: 0px;
        font-size: 7px;
        /*padding: 0px 0px 0 0px;*/
            }
        }
        

        /*.row {*/
        /*    margin-right: 10px;*/
        /*    margin-left: -15px;*/
        /*}*/
        /*.single-courses-area .tit-event {*/
        /*        font-size: 25px;*/
        /*        font-weight: 500;*/
        /*        margin-top: 50px;*/
        /*        margin-left: 20px;*/
        /*}*/
        /*@media (max-width: 992px) {*/
        /*    .over-flow {*/
        /*        overflow-x: auto;*/
        /*    }*/
        /*}*/
        /*@media (max-width: 992px) {*/
        /*    td, th {*/
        /*        border: none;*/
        /*padding: 8px;*/
        /*text-align: unset;*/
        /*height: 50px;*/
        /*width: 0px;*/
        /*font-size: 9px;*/
        /*padding: 0px 0px;*/
        /*    }*/
        /*}*/
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
                    <h1>GMSEC Event list</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active"><a href="#">GMSEC Event list</a></span>
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
            
            <!--<h3 style="font-size: 25px; font-weight: 500;">GMSEC Event list</h3>-->
             <!--<h4 class="gradText" style="margin-bottom: 10px;">GMSEC Event list</h4>-->
            
            <div class="row two-colum-section">
                <!-- left bar start  -->

                <div class="col-sm-8">
                     <!--<div> <h4 class="gradText" style="margin-bottom: 10px;">GMSEC Event list</h4></div>-->
                      <div> <h4 class="gradText" style="margin-bottom: 10px;"> GMSEC Event Completion Report</h4></div>
                    
                <div class="over-flow">
                
                    <!--<table>-->
                    <!--        <thead class="red-background">-->
                    <!--            <tr>-->
                    <!--                <th style="border-radius: 25px 0px 0px 0px;">Sr. No </th>-->
                    <!--                <th style="border-radius: 0px 0px 0px 0px;">Event Name </th>-->
                    <!--                <th style="border-radius: 0px 0px 0px 0px;">Type of Event</th>-->
                    <!--                <th style="border-radius: 0px 0px 0px 0px;">Month</th>-->
                    <!--                <th style="border-radius: 0px 25px 0px 0px;">Dept.</th>-->
                    <!--            </tr>-->
                    <!--        </thead>-->
                    <!--        <tbody>-->
                    <!--    <tr>-->
                    <!--    <td>1</td>-->
                    <!--        <td>GMSEC Orientation</td>-->
                    <!--        <td>Introduction and Activities-->
                    <!--            related startup cell/ Earn-->
                    <!--            while learn</td>-->
                    <!--        <td>03-July-2024 Wednesday</td>-->
                    <!--        <td>All</td>-->
                    <!--    </tr>-->
                    <!--    <tr>-->
                    <!--    <td>2</td>-->
                    <!--        <td>Vichar-Vimarsh: Hackathon 2024</td>-->
                    <!--        <td>Pitch Competition </td>-->
                    <!--        <td>10-July-2024-->
                    <!--        Wednesday</td>-->
                    <!--        <td>All</td>-->
                    <!--    </tr>-->
                    <!--    <tr>-->
                    <!--    <td>3</td>-->
                    <!--        <td>My Story – Motivational Session by-->
                    <!--        Successful Entrepreneur/Startup Founder </td>-->
                    <!--        <td>Expert Talk</td>-->
                    <!--        <td>25-July-2024 Thursday </td>-->
                    <!--        <td>All</td>-->
                    <!--    </tr>-->
                    <!--    <tr>-->
                    <!--    <td>4</td>-->
                    <!--        <td>Function for Formulations </td>-->
                    <!--        <td>Competition</td>-->
                    <!--        <td>14-August-2024 Wednesday</td>-->
                    <!--        <td>Chemistry/Chemical/-->
                    <!--            Pharmacy/Biotech/microbi-->
                    <!--            ology/Food Tech/Forensic-->
                    <!--            Science</td>-->
                    <!--    </tr>-->
                    <!--    <tr>-->
                    <!--    <td>5</td>-->
                    <!--        <td>Entrepreneur Skills for Engineers </td>-->
                    <!--        <td>prototype-->
                    <!--        development/Workshop </td>-->
                    <!--        <td>5-Sept-2024 Thursday</td>-->
                    <!--        <td>Mech/Ele/Civil/Chemical</td>-->
                    <!--    </tr>-->
                    <!--    <tr>-->
                    <!--    <td>6</td>-->
                    <!--        <td>Convert art & Science into Business </td>-->
                    <!--        <td>prototype development</td>-->
                    <!--        <td>5-Sept-2024 Thursday</td>-->
                    <!--        <td>Arts, Science & Fashion-->
                    <!--        Design</td>-->
                    <!--    </tr>-->
                    <!--    <tr style="box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);">-->
                    <!--    <td>7</td>-->
                    <!--        <td>Fintech Fiesta</td>-->
                    <!--        <td>Idea Competition related-->
                    <!--        finance </td>-->
                    <!--        <td>09-October-2024 Wednesday</td>-->
                    <!--        <td>Commerce, Mgmt, Comp.,-->
                    <!--            IT, B.SC. M.SC. Maths-->
                    <!--            /Phy</td>-->
                    <!--    </tr>-->
                    
                    <!--    </tbody>-->

                    <!--</table>-->

                    <!--<div class="tit-event"> <h4 class="gradText" style="margin-bottom: 10px;">GMSEC Event Completion Report <h4></div>-->


                    <table>
                            <thead class="red-background">
                                <tr>
                                    <th style="border-radius: 25px 0px 0px 0px;">Sr. No </th>
                                    <th style="border-radius: 0px 0px 0px 0px;">Event Name </th>
                                    <th style="border-radius: 0px 0px 0px 0px;">Company/Institute Name</th>
                                    <th style="border-radius: 0px 0px 0px 0px;">Location of Event</th>
                                    <th style="border-radius: 0px 0px 0px 0px;">Date</th>
                                    <th style="border-radius: 0px 25px 0px 0px;">Report</th>
                                </tr>
                            </thead>
                            <tbody>
                        <tr>
                        <td>1</td>
                            <td>MoU</td>
                            <td>Venture Centre Pune</td>
                            <td>Cofernece Room</td>
                            <td>10/6/2024</td>
                            <td></td>
                        </tr>
                        <tr>
                        <td>2</td>
                            <td>Project presentation</td>
                            <td>Venture Centre Pune </td>
                            <td>FF-16</td>
                            <td>10/6/2024</td>
                            <td></td>
                        </tr>
                        <tr>
                        <td>3</td>
                            <td>Orientation Program</td>
                            <td>CED, Bhavnagar</td>
                            <td>GF-28 </td>
                            <td>15/7/2024</td>
                            <td><a href="<?php echo $website_assets_url; ?>images/Report_Seminar.pdf" target="_blank" rel="noopener noreferrer" >Download</a></td>
                        </tr>
                        <tr>
                        <td>4</td>
                            <td>iCreate Visit </td>
                            <td>Interntional centre for Entrepreneurship & Technology</td>
                            <td>Deo Dholera</td>
                            <td>25/7/2024</td>
                            <td><a href="<?php echo $website_assets_url; ?>images/icreate_visit_report.pdf" target="_blank" rel="noopener noreferrer" >Download</a></td>
                        </tr>
                        <tr style="box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);">
                        <td>5</td>
                            <td>Innovation Ignite-Pitch Competition </td>
                            <td>GMSEC </td>
                            <td>GF-28</td>
                            <td>22/8/2024</td>
                            <td></td>
                        </tr>
                    
                    
                        </tbody>

                    </table>

                    </div>

                </div>

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
                                                <a href="ssip.php" class=><i class="fa-solid fa-arrow-right"></i>About SSIP & IPR </a>
                                            </li>
                                                <li>
                                                <a href="event.php" class="active"><i class="fa-solid fa-arrow-right"></i>GMSEC Event list</a>
                                            </li>
                                            <li>
                                                <a href="startupclub.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Incubation and startup club policy </a>
                                            </li>
                                             <li>
                                                <a href="startup_gallery.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Gallery </a>
                                            </li>
                                             <li>
                                                 <a href="event_report.php" class=""><i class="fa-solid fa-arrow-right"></i> About Event Report </a>
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
            
            <!-- <div class="tit-event">GMSEC Event Completion Report</div>
            
             <div style="padding: 20px 0;" class="row two-colum-section">
               
                <table>
                        <thead class="red-background">
                            <tr>
                                <th style="border-radius: 25px 0px 0px 0px;">Sr. No </th>
                                <th style="border-radius: 0px 0px 0px 0px;">Event Name </th>
                                <th style="border-radius: 0px 0px 0px 0px;">Company/Institute Name</th>
                                <th style="border-radius: 0px 0px 0px 0px;">Location of Event</th>
                                <th style="border-radius: 0px 0px 0px 0px;">Date</th>
                                <th style="border-radius: 0px 25px 0px 0px;">Report</th>
                            </tr>
                        </thead>
                        <tbody>
                    <tr>
                    <td>1</td>
                        <td>MoU</td>
                        <td>Venture Centre Pune</td>
                        <td>Cofernece Room</td>
                        <td>10/6/2024</td>
                        <td></td>
                    </tr>
                    <tr>
                    <td>2</td>
                        <td>Project presentation</td>
                        <td>Venture Centre Pune </td>
                        <td>FF-16</td>
                        <td>10/6/2024</td>
                        <td></td>
                    </tr>
                    <tr>
                    <td>3</td>
                        <td>Orientation Program</td>
                        <td>CED, Bhavnagar</td>
                        <td>GF-28 </td>
                        <td>15/7/2024</td>
                        <td><a href="<?php echo $website_assets_url; ?>Report_Seminar.pdf" target="_blank" rel="noopener noreferrer" >Download</a></td>
                    </tr>
                    <tr>
                    <td>4</td>
                        <td>iCreate Visit </td>
                        <td>Interntional centre for Entrepreneurship & Technology</td>
                        <td>Deo Dholera</td>
                        <td>25/7/2024</td>
                        <td></td>
                    </tr>
                    <tr>
                    <td>5</td>
                        <td>GyanTank-Pitch Competition </td>
                        <td>GMSEC </td>
                        <td>GF-28</td>
                        <td>22/8/2024</td>
                        <td></td>
                    </tr>
                
                
                    </tbody>

                </table>
                
            </div> -->
            
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