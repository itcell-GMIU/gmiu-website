<?php
include '../../common/importwebsitefile.php';

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php $pageTitle = "SSIP and IPR Program at Gyanmanjari Innovative University | GMIU"; 
        $meta_description = "Discover GMIU’s SSIP program offering funding, mentorship, and resources to help student startups transform innovative ideas into successful ventures.";
   ?>
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
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
            width: 225px;
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
        .ssip img{
            margin-bottom: 15px;
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
        padding: 0px 0px 0 0px;
            }
        }
        .row {
            margin-right: 10px;
            margin-left: -15px;
        }
          
@media (max-width: 992px) {
            img {
                width: 100%;
                height: auto;
                border-radius: 10px;
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

    <!-- box below image  -->
    <section class="hero">
        <div class="img"></div>
        <div class="container">
            <div class="cont">
                <div class="top">
                    <h1>About SSIP & IPR</h1>
                </div>
                <p style="margin-top:5px;">
                    <span><a href="https://gmiu.edu.in/gmiu/website/" style="color:#727272">Home</a> <i class='fa fa-angle-right'></i></span>
                    <span class="b-active">About SSIP & IPR</span>
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
                        <h4 class="gradText">SSIP</h4>
                        <p>Student Start-up and Innovation Policy of the state of Gujarat was launched by Education Department, Government of Gujarat.</p>
                        <p>SSIP aim is to help in building innovation and pre-incubation eco-system on campus. As part of the policy, we encourage, identify and support innovators in the Campus, and provide them support for creating Proof of Concepts (PoC), Industrial Design Rights and patents registration, and guidance through mentorship.</p>
                        <p>As a part of above mentioned policy of Government of Gujarat, a MoU is entered between Gyanmanjari Innovative University Bhavnagar and Gujarat Knowledge Society, central implementation nodal agency of policy, to create an innovation ecosystem in 2020. Gyanmanjari Institute of technology Bhavnagar has endured an opportunity to support innovation and ideas of young students and provide a conductive environment.</p>
                        <p>
                            Recently SSIP 2.0 is being launched with a vision of sustainable development and inclusive growth towards the realisation of Aatmanirbhar Gujarat.
                        </p>
                        <div class="ssip">
                            <button class="aaccordion">
                                <h4>SSIP-1</h4>
                            </button>
                            <div class="panel">
                                &nbsp;
                                <div>
                                    <h3 class="gradText">KEY GOALS:</h3>
                                </div>

                                <section class="about-cards">

                                    <!-- Motto of University card  -->
                                    <div class="about-card" style="display:flex;">
                                        <img class="logo" src="../../website_assets/images/ssip/1.webp" alt="Student-centric innovation and pre-incubation ecosystem development">
                                        <h3>Developing students centric Innovations and Pre-incubation Ecosystems.</h3>
                                    </div>
                                    <div class="about-card" style="display:flex;">
                                        <img class="logo" src="../../website_assets/images/ssip/2.webp" alt="Support system for creativity and innovation in education">
                                        <h3>Support to flourish creativity & innovation.</h3>
                                    </div>
                                    <div class="about-card" style="display:flex;">
                                        <img class="logo" src="../../website_assets/images/ssip/3.webp" alt="Inclusive innovation through sectoral and regional efforts">
                                        <h3>Creating and facilitating sectoral and regional inclusive innovation efforts.</h3>
                                    </div>
                                </section>
                                <div>
                                    <div>
                                        <h3 class="gradText">LEB FACILITIES:</h3>
                                    </div>
                                    <div>
                                       <img src="../../website_assets/images/ssip/lab1.webp" alt="Modern lab setup with computers and equipment at GMIU">
                                        <img src="../../website_assets/images/ssip/lab2.webp" alt="Students working in a collaborative lab environment">
                                        <img src="../../website_assets/images/ssip/lab3.webp" alt="Innovative tools and resources in the university laboratory">
                                        <img src="../../website_assets/images/ssip/lab4.webp" alt="Advanced laboratory equipment for engineering students">
                                        <img src="../../website_assets/images/ssip/lab5.webp" alt="Hands-on learning setup in GMIU lab facility">

                                    </div>
                                </div>
                                &nbsp;
                                <div>
                                    <h3 class="gradText">SSIP SCRUTINY COMMITTEE:</h3>
                                </div>
                                <div>
                                    <section class="events-list-03">
                                        <div class="row" class="card">
                                            <table>
                                                <thead class="red-background">
                                                    <tr>
                                                        <th style="border-radius: 25px 0px 0px 0px; width: 10%;">#</th>
                                                        <th style="width: 30%;">POST</th>
                                                        <th style="border-radius: 0px 25px 0px 0px; width: 60%;">DETAILS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Chair Person</td>
                                                        <td>Dr. H.M. Nimbark<br>
                                                            Executive Director Gyanmanjari Group of Colleges- Bhavnagar</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>Member Secretary</td>
                                                        <td>Mr. Sandeepsinh Vala<br>
                                                            SSIP-Coordinator Gyanmanjari Innovative University</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>Member-1 Industry expert</td>
                                                        <td>Mr. Yogesh Patel<br>
                                                            Managing Partner, Pramukhraj Steel Industries</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>Member-2 Industry expert</td>
                                                        <td>Mr. Dhaval D Trivedi<br>
                                                            Founder & Director, PRAGRATHAN : Rejuvenating Nature.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>Academic Expert 1</td>
                                                        <td>Prof. H.M.Gandhi<br>
                                                            Associate Professor, S.S.G.E.C, Bhavnagar.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td>Academic Expert 2</td>
                                                        <td>Dr. NikunjDomadiya<br>
                                                            Asst. Professor, Computer Department L.D.College of Engineering - Ahmedabad.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>7</td>
                                                        <td>Academic Expert 3</td>
                                                        <td> Prof. Anish H Vora<br>
                                                            Head of Electrical Engineering Department Gyanmanjari Innovative University Bhavnagar.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>8</td>
                                                        <td>Academic Expert 4</td>
                                                        <td>Prof. A D Kalani<br>
                                                            Assistant Professor, S.S.G.E.C- Bhavnagar</td>
                                                    </tr>
                                                    <tr>
                                                        <td>9</td>
                                                        <td>Academic Expert 5</td>
                                                        <td>Prof. KrunalKhiraiya <br>
                                                            Head of Mechanical Engineering Department Gyanmanjari Innovative University, Bhavnagar.</td>
                                                    </tr>
                                                    <tr>

                                                        <td style="border-radius: 0px 0px 0px 25px;">10</td>
                                                        <td>Finance Expert</td>
                                                        <td style="border-radius: 0px 0px 25px 0px;">Mr. Vivek Hakani <br>
                                                            Baxi & Company, Chartered Accountants, Bhavnagar.</td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </section>
                                </div>
                                &nbsp;
                                <div>
                                    <h3 class="gradText">IPR SCRUTINY COMMITTEE:</h3>
                                </div>
                                <div>
                                    <section class="events-list-03">
                                        <div class="row" class="card">
                                            <table>
                                                <thead class="red-background">
                                                    <tr>
                                                        <th style="border-radius: 25px 0px 0px 0px; width: 10%;">#</th>
                                                        <th style="width: 30%;">POST</th>
                                                        <th style="border-radius: 0px 25px 0px 0px; width: 60%;">DETAILS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Chair Person</td>
                                                        <td>Dr. H.M. Nimbark <br>
                                                            Executive Director Gyanmanjari Group of Colleges- Bhavnagar</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>Member Secretary</td>
                                                        <td>Mr. Sandeepsinh Vala <br>
                                                            SSIP-Coordinator Gyanmanjari Innovative University</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>Member-1 Industry expert</td>
                                                        <td>Mr. Yogesh Patelbr <br>
                                                            Managing Partner, Pramukhraj Steel Industries</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>Member-2 Industry expert</td>
                                                        <td>Mr. Dhaval D Trivedi <br>
                                                            Founder & Director, PRAGRATHAN : Rejuvenating Nature.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>Academic Expert 1</td>
                                                        <td>Prof. H.M.Gandhi <br>
                                                            Associate Professor, S.S.G.E.C, Bhavnagar.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td>Academic Expert 2</td>
                                                        <td>Dr. NikunjDomadiya <br>
                                                            Asst. Professor, Computer Department L.D.College of Engineering - Ahmedabad.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>7</td>
                                                        <td>Academic Expert 3</td>
                                                        <td> Prof. Anish H Vora <br>
                                                            Head of Electrical Engineering Department Gyanmanjari Innovative University Bhavnagar.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>8</td>
                                                        <td>Academic Expert 4</td>
                                                        <td>Prof. A D Kalani <br>
                                                            Assistant Professor, S.S.G.E.C- Bhavnagar</td>
                                                    </tr>

                                                    <tr>

                                                        <td style="border-radius: 0px 0px 0px 25px;">9</td>
                                                        <td>Academic Expert 5</td>
                                                        <td style="border-radius: 0px 0px 25px 0px;">Prof. KrunalKhiraiya <br>
                                                            Head of Mechanical Engineering Department Gyanmanjari Innovative University, Bhavnagar.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </section>
                                </div>
                                &nbsp;
                                <div>
                                    <h3 class="gradText">PHYSICAL OUTCOME:</h3>
                                </div>
                                <div>
                                    <div>
                                        <section class="events-list-03">
                                            <div class="row" class="card">
                                                <table>
                                                    <thead class="red-background">
                                                        <tr>
                                                            <th style="border-radius: 25px 0px 0px 0px; width: 10%;">#</th>
                                                            <th style="width: 40%;">DESCRIPTION</th>
                                                            <th style="width: 25%;">TARGET AS PER MOU</th>
                                                            <th style="border-radius: 0px 25px 0px 0px; width: 25%;">ACHIEVED</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Student Outreached</td>
                                                            <td>1000</td>
                                                            <td>700</td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>Innovative project Supported</td>
                                                            <td>150</td>
                                                            <td>35</td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>PoC Supported</td>
                                                            <td>10</td>
                                                            <td>35</td>
                                                        </tr>
                                                        <tr>
                                                            <td>4</td>
                                                            <td>Patent Filed</td>
                                                            <td>5</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>5</td>
                                                            <td>Student Startup Supported</td>
                                                            <td>24</td>
                                                            <td>0</td>
                                                        </tr>


                                                        <tr>

                                                            <td style="border-radius: 0px 0px 0px 25px;">6</td>
                                                            <td>Workshops/ Seminars/ Capacity Building Program</td>
                                                            <td>15</td>
                                                            <td style="border-radius: 0px 0px 25px 0px;">8</td>
                                                        </tr>


                                                    </tbody>
                                                </table>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ssip">
                            <button class="aaccordion">
                                <h4>SSIP-2</h4>
                            </button>
                            <div class="panel">
                                &nbsp;
                                <div>
                                    <h3 class="gradText">KEY GOALS:</h3>
                                </div>

                              <section class="about-cards">

                                    <!-- Motto of University card  -->
                                    <div class="about-card" style="display:flex;">
                                        <img class="logo" src="../../website_assets/images/ssip/1.webp" alt="Student-centric innovation and pre-incubation ecosystem development">
                                        <h3>Developing students centric Innovations and Pre-incubation Ecosystems.</h3>
                                    </div>
                                    <div class="about-card" style="display:flex;">
                                        <img class="logo" src="../../website_assets/images/ssip/2.webp" alt="Support system for creativity and innovation in education">
                                        <h3>Support to flourish creativity & innovation.</h3>
                                    </div>
                                    <div class="about-card" style="display:flex;">
                                        <img class="logo" src="../../website_assets/images/ssip/3.webp" alt="Inclusive innovation through sectoral and regional efforts">
                                        <h3>Creating and facilitating sectoral and regional inclusive innovation efforts.</h3>
                                    </div>
                                </section>
                                <div>
                                    <div>
                                        <h3 class="gradText">LEB FACILITIES:</h3>
                                    </div>
                                    <div>
                                        <img src="../../website_assets/images/ssip/lab1.webp" alt="Modern lab setup with computers and equipment at GMIU">
                                        <img src="../../website_assets/images/ssip/lab2.webp" alt="Students working in a collaborative lab environment">
                                        <img src="../../website_assets/images/ssip/lab3.webp" alt="Innovative tools and resources in the university laboratory">
                                        <img src="../../website_assets/images/ssip/lab4.webp" alt="Advanced laboratory equipment for engineering students">
                                        <img src="../../website_assets/images/ssip/lab5.webp" alt="Hands-on learning setup in GMIU lab facility">

                                    </div>
                                </div>
                                &nbsp;
                                <div>
                                    <h3 class="gradText">SSIP INSTITUTIONAL & IPR SCRUTINY COMMITTEE:</h3>
                                </div>
                                <div>
                                    <section class="events-list-03">
                                        <div class="row" class="card">
                                            <table>
                                                <thead class="red-background">
                                                    <tr>
                                                        <th style="border-radius: 25px 0px 0px 0px; width: 10%;">#</th>
                                                        <th style="width: 30%;">POST</th>
                                                        <th style="border-radius: 0px 25px 0px 0px; width: 60%;">DETAILS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Chairperson <br>(Education Institute Head)</td>
                                                        <td>Dr. H. M. Nimbark <br>
                                                            Provost<br> Gyanmanjari Innovative University, Bhavnagar</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>Member Secretary<br> (SSIP Co-Ordinator)</td>
                                                        <td>Mr. Anish Vora <br>
                                                            SSIP Co-ordinator <br>Gyanmanjari Innovative University, Bhavnagar</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>Member Secretary II<br> (SSIP Co-Ordinator)</td>
                                                        <td>Mr. Vedant Gaud <br>
                                                            SSIP Co-Ordinator <br> Gyanmanjari Innovative University, Bhavnagar</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>Member-2 <br>(Industrialist/Innovator/Investor)</td>
                                                        <td>Mr. Dhaval D Trivedi <br>
                                                            Founder & Director<br> Pragrathan: Rejuvenating Nature</td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>Member-3<br> (Industrialist/Alumni)</td>
                                                        <td>Mr. Shaktisinh Jadeja<br>
                                                            Assistant Manager - LSCM <br> Tenneco Automative India Ltd, Suzuki Motors</td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td>Member-4 <br>(Finance Expert/CA/CS)</td>
                                                        <td>Dr. NikunjDomadiya<br>
                                                            Mr. Jagdhish Pathak <br> CA</td>
                                                    </tr>
                                                    <tr>
                                                        <td>7</td>
                                                        <td>Member-5<br> (Academic Expert-Invited)</td>
                                                        <td>Prof. Dhvanit Chotaliya <br> Asst. Professor<br> Department of Instrumental and Control Engineering <br> Government Engineering College - Rajkot</td>
                                                    </tr>
                                                    <tr>
                                                        <td>8</td>
                                                        <td>Member-6 <br>(Technical & IPR Expert-Invited)</td>
                                                        <td>Mr. Amit Patel<br>
                                                            Patent Agent</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-radius: 0px 0px 0px 25px;">9</td>
                                                        <td>Member-7<br> (Startup Ecosystem Expert-Invited)</td>
                                                        <td style="border-radius: 0px 0px 25px 0px;">Mr. Yogesh Patel <br>
                                                            Managing Partner <br> Pramukhraj Steel Industries</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </section>
                                </div>
                                &nbsp;

                                <div>
                                    <h3 class="gradText">PHYSICAL OUTCOME</h3>
                                </div>
                                <div>
                                    <div>
                                        <section class="events-list-03">
                                            <div class="row" class="card">
                                                <table>
                                                    <thead class="red-background">
                                                        <tr>
                                                            <th style="border-radius: 25px 0px 0px 0px; width: 10%;">#</th>
                                                            <th style="width: 40%;">DESCRIPTION</th>
                                                            <th style="width: 25%;">TARGET AS PER MOU</th>
                                                            <th style="border-radius: 0px 25px 0px 0px; width: 25%;">ACHIEVED</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Total Number of Student to be Outreached and Sensitized</td>
                                                            <td>1000</td>
                                                            <td>900</td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>Total Number of Innovation to be Supported at PoC Stage </td>
                                                            <td>50</td>
                                                            <td>4</td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>Total Number of IPR to be Filed</td>
                                                            <td>3</td>
                                                            <td>3</td>
                                                        </tr>
                                                        <tr>
                                                            <td>4</td>
                                                            <td>Total Number of Student Startup Supported</td>
                                                            <td>5</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>5</td>
                                                            <td>Total Number of Workshop/Seminars/Capacity Building Program</td>
                                                            <td>15</td>
                                                            <td>10</td>
                                                        </tr>


                                                        <tr>

                                                            <td style="border-radius: 0px 0px 0px 25px;">6</td>
                                                            <td>Workshops/ Seminars/ Capacity Building Program</td>
                                                            <td>15</td>
                                                            <td style="border-radius: 0px 0px 25px 0px;">8</td>
                                                        </tr>


                                                    </tbody>
                                                </table>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            var acc = document.getElementsByClassName("aaccordion");
                            var i;

                            for (i = 0; i < acc.length; i++) {
                                acc[i].addEventListener("click", function() {
                                    this.classList.toggle("active");
                                    var panel = this.nextElementSibling;
                                    if (panel.style.maxHeight) {
                                        panel.style.maxHeight = null;
                                    } else {
                                        panel.style.maxHeight = panel.scrollHeight + "px";
                                    }
                                });
                            }
                        </script>
                        &nbsp;
                        <div>
                            <h3 class="gradText">IPR</h3>
                        </div>
                        <div class="row">
                            <div class="col-sm-6  m-0 p-0">
                                <div class="about-card">
                                    <h4 class="gradText">Patent 01</h4>
                                    <hr>
                                    <p>
                                        <b>Title of Invention:</b>Side Stand Lifting Trigger Mechanism for Two Wheel Vehicles <br>
                                        <b>Application Number:</b> 202121005807
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6  m-0 p-0" >
                                <div class="about-card">
                                    <h4 class="gradText">Patent 02</h4>
                                    <hr>
                                    <p>
                                    <b>Title of Invention:</b>Design of Haemometer Stand <br>
                                    <b>Application Number:</b> 202021022072 <br>
                                    &nbsp;
                                    </p> 
                                </div>
                            </div>
                        </div>
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
                                                <a href="ssip.php" class="active"><i class="fa-solid fa-arrow-right"></i>About SSIP & IPR </a>
                                            </li>
                                                <li>
                                                <a href="event.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Event list</a>
                                            </li>
                                            <li>
                                                <a href="startupclub.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Incubation and startup club policy </a>
                                            </li>
                                             <li>
                                                <a href="startup_gallery.php" class=""><i class="fa-solid fa-arrow-right"></i>GMSEC Gallery </a>
                                            </li>
                                            <!--  <li>-->
                                            <!--<a href="event_report.php" class=""><i class="fa-solid fa-arrow-right"></i> About Event Report </a>-->
                                            <!--  </li>-->
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