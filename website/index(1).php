<?php
include '../database/connect.php';
include '../common/validation.php';
include '../common/globalvariable.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
 
    <?php include 'include/importhead.php'; ?>
    <?php include 'include/importcss.php'; ?>
    <link rel="stylesheet" href="<?php echo $website_assets_url; ?>css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <style>
        .swiper-pagination-bullet {
            background-color: #ba2a21;
        }

        html,
        body {
            scroll-behavior: smooth;
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
    z-index: 999;
    margin: 0;
    /* top: 0; */
    bottom: 0;
}

 .top1 {
    width: 100%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    /*position: sticky; */
    /* Make the header fixed 
    top: 0; /* Position it at the top */
    left: 0; /* Position it at the left */
    right: 0; /* Ensure it spans the entire width */
    z-index: 1000; /* Ensure it is above other elements */
    background : rgba(186, 42, 33, .1);/* Ensure background color covers content */
}

.acpc-rep p {
    margin: 0;
    font-weight :600 ;
    padding: 10px;
    color: #333;
    text-align: center !important;
}


 @keyframes highlight-blink {
        0% { background-color: red; }
        50% { background-color: transparent; }
        100% { background-color: red; }
    }
    .mega-menu {
  display: none;
    position: absolute;
    /* left: 0; */
    background-color: #fff;
    padding: 20px;
    right: 0%;
    width: 1000px;
    box-shadow: 0px 0px 8px rgb(0 0 0 / 84%);
    z-index: 9999;
}

.mega-menu-content {
  display: grid;
  grid-template-columns: repeat(4, 1fr); /* 3 columns */
  gap: 20px;
}

.mega-menu-column h4 {
  font-size: 20px;
    margin-bottom: 10px;
    color: #ba2a21;
    font-weight: 900;
}

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
  .gmiu-cell{
  display: none !important;
  }   
  }
  
 @media (min-width: 1024px) {
  .gmiu-cel{
   display: none !important;
  }   
}
        .faculty-marquee {
            display: flex;
            overflow: hidden;
            white-space: nowrap;
            width: 100%;
        }

        .faculty-slide {
            display: inline-block;
            background-color: #ffffff;
            padding: 20px 40px;
            margin: 10px;
            border-radius: 12px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .faculty-slide a {
            color: #d32f2f;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
        }

        .faculty-slide:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            background: linear-gradient(145deg, #ffffff, #f8f8f8);
        }

        .faculty-slide a:hover {
            color: #b71c1c;
        }

    </style>

</head>

<body class="courses">
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NMF9CJ96"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <!-- <div id="preloader">
        <div id="status">&nbsp;</div>
    </div> -->
        <!--<div class="top1">-->
        <!--    <div class="container">-->
        <!--        <div class="acpc-rep">-->
                    <!--<p>ડિપ્લોમા/ડિગ્રી એન્જિનિયરિંગ/ડિપ્લોમા ટુ ડિગ્રી એન્જિનિયરિંગ માં ACPDC/ACPC દ્વારા પ્રવેશ ફાળવેલ વિધાર્થીઓએ Reporting માટે સંસ્થાની રૂબરૂ મુલાકાત લેવી અથવા 9099951160, 7574949494 પર સંપર્ક કરવો.</p>-->
                    
                     <!--<p> B.Pharm અને M.Pharm માં ACPC દ્વારા પ્રવેશ ફાળવેલ વિધાર્થીઓએ Reporting માટે સંસ્થાની રૂબરૂ મુલાકાત લેવી અથવા 9099951160, 7574949494 પર સંપર્ક કરો.</p>-->
               
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->

    <header id="header">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 col-xs-12 header-top-left">
                        <ul class="list-unstyled">
                            <li><i class="fa fa-phone top-icon"></i>
                                <a style="color:white;" href="tel:+91 90999 51160">+91 90999 51160</a>
                            </li>
                            <li><i class="fa fa-envelope top-icon"></i>
                                <a style="color:white;" href="mailto:info@gmiu.edu.in"> info@gmiu.edu.in</a>
                            </li>
                        </ul>
                    </div>  
                    <div class="col-sm-8 col-xs-12 header-top-right">
                        <ul class="list-unstyled">
                            <li><a href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php"><i class="fa fa-street-view top-icon"></i>
                                    360 Virtual Tour</a>
                            </li>
                            <li><a href="<?php echo $base_url_admission; ?>" style="animation: highlight-blink 1s infinite;"><i class="fa fa-globe top-icon"></i> <span style="font-weight: bold;">Admission 2025-26</span></a></li>
                                <li><a href="https://gmiu.edu.in/gmiu/website/admission/phd_notification.php"><i class="fa fa-globe top-icon"></i>Ph.D Admission</a></li>
                                 <!--<li><a href="https://gmiu.edu.in/gmiu/website/admission/uni_transfer.php"><i class="fa fa-graduation-cap top-icon"></i>University Transfer</a></li>-->
                                <li><a href=""><i class="fa fa-graduation-cap top-icon"></i>University Transfer</a></li>



                            <!--  <li><a href="login.html"><i class="fa fa-lock top-icon"></i>Login</a></li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div><!-- Ends: .header-top -->

        <div class="header-body" style="background: none; z-index:2;">
            <nav class="navbar edu-navbar">
                <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img id="nav-logo" src="<?php echo $website_assets_url;?>images/gmiulogo.png" alt="">
                </div>

                <div class="collapse navbar-collapse edu-nav main-menu" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav pull-right">
                        <li class="active"><a data-scroll="" href="<?php echo $base_url_website;?>">Home</a></li>
                        <li><a data-scroll="" href="<?php echo $base_url_website_about;?>about_university.php">About</a>
                            <!-- dropdwon start -->
                            <ul class="dropdown list-unstyled">
                                <li><a href="<?php echo $base_url_website_about;?>about_university.php">About
                                        University</a></li>
                                <li><a
                                        href="<?php echo $base_url_website_about;?>about_gyanmudra_education_foundation.php">About
                                        Gyanmudra Education Foundation</a></li>
                                <li><a href="<?php echo $base_url_website_about;?>about_leadership.php">Leadership</a>
                                </li>
                                <!--                    <li><a href="<?php /* echo $base_url_website_about; */?>about_chairman_message.php">Chairman
                                        Message</a></li> -->
                                <li><a href="<?php echo $base_url_website_about;?>about_chairman_message.php">President
                                        Message</a></li>
                                <li><a href="<?php echo $base_url_website_about;?>about_provost_message.php">Provost
                                        Message</a></li>
                                <li><a href="<?php echo $base_url_website_about;?>about_recognition.php">Recognition</a>
                                </li>
                            </ul>
                            <!-- dropdown end -->
                        </li>
                            <li><a data-scroll href="#">Faculty</a>
                            <!-- dropdwon start -->
                            <ul class="dropdown list-unstyled scroll-y-faculty">
                                <?php
                                $cmd = "SELECT `name` as faculty_name,`id` as faculty_id,faculty_slug FROM `tbl_faculty` Where is_active=1 AND is_delete=0";
                                $stmt = $con->prepare($cmd);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                <li><a href="<?php echo $base_url_website_faculty?><?php echo $row['faculty_slug']; ?>"><?php echo strtoupper($row['faculty_name']); ?></a>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>


                            <!-- dropdown end -->
                        </li>
                        <li><a data-scroll href="<?php echo $base_url_admission;?>">Admission</a>
                            <ul class="list-unstyled dropdown">
                                <li><a href="<?php echo $base_url_admission;?>">Apply Online</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>why_gmiu.php">Why GMIU</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>courses_offered.php ">Courses
                                        Offered</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>admission_brochure.php">e-Brochure
                                        &
                                        Scope Documents</a></li><li class="dropdown-list-box-02">
                                            <a href="#">Model Paperset<i class="fa fa-angle-right menu-icon"></i></a>
                                        <ul class="dropdown-list_2 list-unstyled">
                                            <li><a href="../modal_question_paper/gseb/">Gujarat Board paperset</a>
                                            </li>
                                        </ul>
                                    </li>
                                        
                                <li><a href="<?php echo $base_url_website_admission; ?>importantlink.php">Important Links</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>education_loan.php">Education Loan
                                        Facilities</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>scholarships.php">Scholarship</a></li>
                                <li><a href="<?php echo $base_url_website_admission; ?>transportation.php">Transportation Facilities</a>
                                </li>
                            </ul>
                        </li>
                        <li><a data-scroll href="<?php echo $base_url_website_placement; ?>training_and_placement_cell.php">Placement</a>
                            <!-- dropdwon start -->
                            <ul class="dropdown list-unstyled">
                                <li><a href="<?php echo $base_url_website_placement; ?>training_and_placement_cell.php">Training and Placement Cell</a></li>
                                <li><a href="<?php echo $base_url_website_placement; ?>placement_overview_and_statistics.php">Placement Overview & Statistics</a></li>
                                <li><a href="placement/geps.php">GMIU Employability Performance Scale</a></li>
                                <li><a href="<?php echo $base_url_website_placement; ?>student_testimonial.php">Student Testimonial</a>
                                <li><a href="<?php echo $base_url_website_placement; ?>corporate_testimonial.php">Corporate Testimonial</a></li>
                                <!--<li><a href="https://gmiu.edu.in/placement/innovation-and-research">Innovation &-->
                                <!--        Research</a></li>-->
                            </ul>
                            <!-- dropdown end -->
                        </li>
                        <li><a data-scroll href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php">Campus</a>
                            <!-- dropdwon start -->
                            <ul class="dropdown list-unstyled">
                                <li><a href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php">360 Virtual Tour</a></li>
                                <li><a href="<?php echo $base_url_website_campus; ?>gallery.php">Gallery</a></li>
                                <li class="dropdown-list-box-02"><a href="#">Infrastructure<i
                                            class="fa fa-angle-right menu-icon"></i></a>
                                    <ul class="dropdown-list_2 list-unstyled">
                                        <li><a href="<?php echo $base_url_website_campus; ?>modern_class_room.php">Modern Class Room</a>
                                        </li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>advance-laboratories.php">Advance
                                                Laboratories</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>library.php">Library</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-list-box-02"><a href="">Facilities<i
                                            class="fa fa-angle-right menu-icon"></i></a>
                                    <ul class="dropdown-list_2 list-unstyled">
                                        <li><a href="<?php echo $base_url_website_campus; ?>wi-fi_campus.php">Wi-Fi Campus</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>cafeteria.php">Cafeteria & First Aid
                                                Room</a></li>
                                         <li><a href="<?php echo $base_url_website_campus; ?>box-cricket.php">Box Cricket</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>transportation.php">Transportation
                                                Facilities</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-list-box-02"><a href="">Curriculum Activities<i
                                            class="fa fa-angle-right menu-icon"></i></a>
                                    <ul class="dropdown-list_2 list-unstyled">
                                        <li><a href="<?php echo $base_url_website_campus; ?>industryvisit.php">Industry Visit</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>experttalk.php">Expert Talk</a></li>
                                        <!--<li><a href="https://gmiu.edu.in/campus/internship-program">Internship-->
                                        <!--        Program</a></li>-->
                                        <li><a href="<?php echo $base_url_website_campus; ?>iepprogram.php">IEP Program</a></li>
                                        <!--<li><a href="https://gmiu.edu.in/campus/projectexhibition">Project-->
                                        <!--        Exhibition</a></li>-->
                                        <!--<li><a href="https://gmiu.edu.in/campus/sdp">Skill development Program (SDP)</a>-->
                                        <!--</li>-->
                                    </ul>
                                </li>
                                <li class="dropdown-list-box-02"><a href="">Extra Curriculum Activities<i
                                            class="fa fa-angle-right menu-icon"></i></a>
                                    <ul class="dropdown-list_2 list-unstyled">
                                        <!--<li><a href="https://gmiu.edu.in/campus/studentclub">Student Club</a></li>-->
                                        <!--<li><a href="https://gmiu.edu.in/campus/socialconnect">Social Connect</a></li>-->
                                        <!--<li><a href="https://gmiu.edu.in/campus/mastermind">Mastermind</a></li>-->
                                        <li><a href="<?php echo $base_url_website_campus; ?>sports.php">Sport Activities</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>culture.php">Cultural Program</a></li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>fdp.php">Faculty Development Program</a>
                                        </li>
                                        <li><a href="<?php echo $base_url_website_campus; ?>cwp.php">Connect With Parents</a></li>
                                    </ul>
                                </li>
                                <!--<li><a href="https://gmiu.edu.in/campus/nationalinternationalactivities">National /-->
                                <!--        International Association</a></li>-->
                                <!--<li><a href="<?php //echo $base_url_website_campus?>about_nss.php">NSS</a></li>-->
                                <li><a href="<?php echo $base_url_website_campus; ?>academic_system.php">Academic System</a></li>
                            </ul>
                            <!-- dropdown end -->
                        </li>
                        <!--<li><a data-scroll href="<?php //echo $base_url_website ?>startup/about_startup.php">Startup</a>-->
                            <!-- dropdwon start -->
                        <!--    <ul class="dropdown list-unstyled">-->
                                <!--<li><a href="startup/about_startup.php">About Startup</a></li>-->
                        <!--        <li><a href="startup/about_startup.php">About GMSEC</a></li>-->
                        <!--        <li><a href="startup/our_startup.php">Our Startup</a></li>-->
                        <!--        <li><a href="<?php //echo $base_url_website ?>startup/ssip.php">About SSIP & IPR</a></li>-->
                        <!--        <li><a href="<?php //echo $base_url_website ?>startup/event.php">GMSEC Event list</a></li>-->
                        <!--        <li><a href="<?php //echo $base_url_website ?>startup/startupclub.php">GMSEC Incubation and startup club policy</a></li>-->
                        <!--         <li><a href="<?php //echo $base_url_website ?>startup/startup_gallery.php">GMSEC Gallery</a></li>-->
                        <!--         <li><a href="<?php //echo $base_url_website ?>startup/event_report.php">GMGC Event Report </a><li>-->
                                 <!--<li><a href="<?php //echo $base_url_website ?>startup/about_ced.php">About CED</a></li>-->
                                <!--<li><a href="https://gmiu.edu.in/startup/about-ced">About CED</a></li>-->
                        <!--    </ul>-->
                            <!-- dropdown end -->
                        <!--</li>-->
                        <!-- <li><a data-scroll href="international_cell/about_irc.php">International</a>-->
                            <!-- dropdwon start -->
                        <!--    <ul class="dropdown list-unstyled">-->
                        <!--        <li><a href="international_cell/about_irc.php">GMIU International Relation Cell</a></li>-->
                        <!--        <li><a href="international_cell/about_icm.php">International Initiatives & Collaboration Modes</a></li>-->
                        <!--        <li><a href="international_cell/about_admission.php">International Admission</a></li>-->
                        <!--         <li><a href="international_cell/about_irc_connection.php">Global Connection</a></li>-->
                        <!--        <li><a href="international_cell/about_explosure.php">Global Exposure</a></li>-->
                        <!--        <li><a data-scroll href="international_cell/contact_us.php">Contact us</a></li>-->
                        <!--    </ul>-->
                            <!-- dropdown end -->
                        <!--</li>-->
                        <!--<li><a data-scroll href="https://gmiu.edu.in/alumni">Alumni</a></li>-->
                        
                         <li class="gmiu-cel">
                            <a data-scroll href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php">GMIU Cell</a>
                            <ul class="dropdown list-unstyled">
                            <li class="dropdown-list-box-02"><a href="<?php echo $base_url_website_campus; ?>gallery.php">Startup</a>
                                <ul class="dropdown-list_2 list-unstyled">
                                    <li><a href="<?php echo $base_url_website ?>startup/about_startup.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> About GMSEC</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/our_startup.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Our Startup</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/ssip.php"> <i class="fa fa-dot-circle-o" aria-hidden="true"></i>About SSIP & IPR</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/event.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> GMSEC Event list</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/startupclub.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> GMSEC Incubation and startup club policy</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/startup_gallery.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> GMSEC Gallery</a></li>
                                    <!--<li>-->
                                    <!--    <a href="<?php //echo $base_url_website ?>startup/event_report.php"> <i class="fa fa-dot-circle-o" aria-hidden="true"></i>GMGC Event Report</a></li>-->
                                </ul>
                            </li>
                           
                            <li class="dropdown-list-box-02"><a href="<?php echo $base_url_website_campus; ?>gallery.php">International</a>
                                <ul class="dropdown-list_2 list-unstyled">
                                    <li><a href="international_cell/about_irc.php"><i class="fa fa-arrow-right" aria-hidden="true"></i> GMIU International Relation Cell</a></li>
                                    <li><a href="international_cell/about_icm.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> International Initiatives & Collaboration Modes</a></li>
                                    <li><a href="international_cell/about_admission.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> International Admission</a></li>
                                    <li><a href="international_cell/about_irc_connection.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Global Connection</a></li>
                                    <li><a href="international_cell/about_explosure.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Global Exposure</a></li>
                                    <li><a href="international_cell/contact_us.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Contact us</a></li>
                                </ul>
                             </li>
                            <li class="dropdown-list-box-02"><a href="<?php echo $base_url_website_campus; ?>gallery.php">NSS</a>
                                <ul class="dropdown-list_2 list-unstyled">
                                <li><a href="campus/about_nss.php"><i class="fa fa-long-arrow-right"></i>About NSS</a> </li>
                                <li><a href="campus/nss_unit.php"><i class="fa fa-long-arrow-right"></i>NSS Units and Program Officers </a></li>
                                <li><a href="campus/nss_advisory.php"><i class="fa fa-long-arrow-right"></i> Advisory committe </a></li>
                                <li> <a href="campus/nss.php"><i class="fa fa-long-arrow-right">  </i> Activities</a></li>
                                <li> <a href="campus/nss-gallary.php"><i class="fa fa-long-arrow-right"></i>NSS Gallery</a></li>
                                <li><a href="campus/contact_us.php"><i class="fa fa-long-arrow-right"></i>Contact Us</a></li>
                                </ul>
                                </li>
                            <li class="dropdown-list-box-02"><a href="<?php echo $base_url_website_campus; ?>gallery.php">BKSVE</a>
                                <ul class="dropdown-list_2 list-unstyled">
                                <li><a href="bksve/about_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>About</a></li>
                                <li><a href="bksve/vision_mission.php" class=""><i class="fa-solid fa-arrow-right"></i>Vision And Mission</a></li>
                                <li><a href="bksve/about_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Activities</a></li>
                                <li><a href="bksve/bksve_gallery_report.php" class=""><i class="fa-solid fa-arrow-right"></i>Gallery</a></li>
                                <li><a href="bksve/contact_us_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Contact Us</a></li>
                                </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="gmiu-cell">
                            <a data-scroll href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php">GMIU Cell</a>
                            
                            <!-- dropdown start -->
                            <div class="mega-menu">
                                <div class="mega-menu-content">
                                <!-- Column 1: Startup Menu -->
                                <div class="mega-menu-column mega-men">
                                    <h4>Startup</h4>
                                    <ul>
                                    <li><a href="<?php echo $base_url_website ?>startup/about_startup.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> About GMSEC</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/our_startup.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Our Startup</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/ssip.php"> <i class="fa fa-dot-circle-o" aria-hidden="true"></i>About SSIP & IPR</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/event.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> GMSEC Event list</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/startupclub.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> GMSEC Incubation and startup club policy</a></li>
                                    <li><a href="<?php echo $base_url_website ?>startup/startup_gallery.php"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> GMSEC Gallery</a></li>
                                    <!--<li><a href="<?php //echo $base_url_website ?>startup/event_report.php"> <i class="fa fa-dot-circle-o" aria-hidden="true"></i>GMGC Event Report</a></li>-->
                                    </ul>
                                </div>
                                
                                <!-- Column 2: International Menu -->
                                <div class="mega-menu-column mega-men">
                                    <h4>International</h4>
                                    <ul>
                                    <li><a href="international_cell/about_irc.php"><i class="fa fa-arrow-right" aria-hidden="true"></i> GMIU International Relation Cell</a></li>
                                    <li><a href="international_cell/about_icm.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> International Initiatives & Collaboration Modes</a></li>
                                    <li><a href="international_cell/about_admission.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> International Admission</a></li>
                                    <li><a href="international_cell/about_irc_connection.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Global Connection</a></li>
                                    <li><a href="international_cell/about_explosure.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Global Exposure</a></li>
                                    <li><a href="international_cell/contact_us.php"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Contact us</a></li>
                                    </ul>
                                </div>
                                
                                <!-- Column 3: NSS and bksve -->
                                 <div class="mega-menu-column mega-men">
                                    <h4>NSS</h4>
                                    <ul>  
                                    <li><a href="campus/about_nss.php"><i class="fa fa-long-arrow-right"></i>About NSS</a></li>
                                    <li><a href="campus/nss_unit.php"><i class="fa fa-long-arrow-right"></i>NSS Units and Program Officers</a></li>
                                    <li><a href="campus/nss_advisory.php"><i class="fa fa-long-arrow-right"></i>Advisory committe</a></li>
                                    <li><a href="campus/nss.php"><i class="fa fa-long-arrow-right"></i>Activities </a></li>
                                    <li><a href="campus/nss-gallary.php"><i class="fa fa-long-arrow-right"></i> NSS Gallery </a> </li>
                                    <li><a href="campus/contact_us.php"><i class="fa fa-long-arrow-right"> </i> Contact Us </a> </li>     
                                    </ul>
                                </div>
                                <div class="mega-menu-column">
                                    <h4>BKSVE</h4>
                                    <ul>
                                    <li><a href="bksve/about_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>About</a></li>
                                    <li><a href="bksve/vision_mission.php" class=""><i class="fa-solid fa-arrow-right"></i>Vision And Mission</a></li>
                                    <li><a href="bksve/about_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Activities</a></li>
                                    <li><a href="bksve/bksve_gallery_report.php" class=""><i class="fa-solid fa-arrow-right"></i>Gallery</a></li>
                                    <li><a href="bksve/contact_us_bksve_cell.php" class=""><i class="fa-solid fa-arrow-right"></i>Contact Us</a></li>
                                    </ul>
                                </div>
                                </div>
                            </div>
                            <!-- dropdown end -->
                        </li>

                        
                        
                        <li><a data-scroll href="<?php echo $base_url_website_common; ?>website_contact_us.php">Contact Us</a>
                       
                         </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
            </nav>
            <!--==================
        Slider 
    ===================-->
            <div class="rev_slider_wrapper">
                <div id="rev_slider_1" class="rev_slider">
                    <!-- BEGIN SLIDES LIST -->
                    <ul>
                        <?php
                        $cmd = "SELECT `file_name` as slider_image_name FROM `tbl_site_photos` Where is_active=1 AND is_delete=0 AND type ='slider_image' LIMIT 5";
                        $stmt = $con->prepare($cmd);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $slider_img = $row['slider_image_name'];
                                echo '<li data-transition="boxfade" data-title="Slide Title" data-param1="Additional Text" data-thumb="' . $upload_document_url . 'slider_image/' . $slider_img . '">
                                <img src="' . $upload_website_admin_url . 'slider_image/' . $slider_img . '" alt="Sky" class="rev-slidebg">
                            </li>';
                            }
                        }
                        ?>
                    </ul><!-- END SLIDES LIST -->

                </div><!-- END SLIDER CONTAINER -->

                <!--  End header section-->
            </div>
            <div class="row info-card-header-row2">
                <div class="col-xs-4">
                    <a href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php">
                        <div class="info-card-header">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <div class="info-card-content">
                                <p>VIRTUAL</p>
                                <h5>CAMPUS TOUR</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="<?php echo $base_url_website_admission; ?>admission_brochure.php">
                        <div class="info-card-header">
                            <i class="fa-solid fa-book-open"></i>
                            <div class="info-card-content">
                                <p>DOWNLOAD</p>
                                <h5>E-BROCHURES</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="<?php echo $base_url_admission; ?>">
                        <div class="info-card-header">
                            <i class="fa-regular fa-circle-question"></i>
                            <div class="info-card-content">
                                <p>ADMISSION</p>
                                <h5>INQUIRY</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div><!-- END SLIDER CONTAINER WRAPPER -->


    </header>
    <!--  End header section-->
    </section>
    <!--  End header section-->
    <a href="https://api.whatsapp.com/send?phone=917574949494&text=Hello%20I%20Am%20Interested%20in%20Admission" class="float" target="_blank">
        <i class="fa-brands fa-whatsapp my-float"></i>
    </a>
    <!-- Info Page -->
    <section class="blog-area">
        <div class="container">
            <div class="row">
                <!--<div id="first-card" class="col-sm-4 latest-news-single">-->
                <!--    <div class="blog-single-box">-->
                <!--        <h3 id="head-design">PROGRAMS OFFERED</h3>-->
                <!--        <div class="blog-content">-->
                            <?php
                            // $cmd = "SELECT `name` as faculty_name,`id` as faculty_id FROM `tbl_faculty` Where is_active=1 AND is_delete=0 LIMIT 4";
                            // $stmt = $con->prepare($cmd);
                            // $stmt->execute();
                            // $result = $stmt->get_result();
                            // $icon = 0;
                            // while ($row = $result->fetch_assoc()) {
                            ?>
                                <!--<div class="row">-->
                                <!--    <div class="event-headbox">-->
                                <!--        <div id="img-set" class="col-sm-3 event-img">-->
                                            <?php
                                            // switch ($icon) {
                                            //     case 0:
                                            //         echo "<i class='fa-solid fa-gear' style='color: black; font-size: 29px;'></i>";
                                            //         break;
                                            //     case 1:
                                            //         echo "<i class='fa-solid fa-prescription-bottle' style='color: black; font-size: 29px;'></i>";
                                            //         break;
                                            //     case 2:
                                            //         echo "<i class='fa-solid fa-flask' style='color: black; font-size: 29px;'></i>";
                                            //         break;
                                            //     case 3:
                                            //         echo "<i class='fa-solid fa-chart-line' style='color: black; font-size: 29px;'></i>";
                                            //         break;
                                            //     default:
                                            //         echo "<i class='fa fa-graduation-cap' style='color: black; font-size: 29px;'></i>";
                                            // }
                                            // $icon = $icon + 1;
                                            ?>
                                <!--        </div>-->
                                <!--        <div class="col-sm-9 event-content">-->
                                <!--            <p id="pad-remove">-->
                                <!--                <a href="<?php //echo $base_url_website_faculty; ?>faculty.php?id=<?php //echo $row['faculty_id']; ?>"><?php //echo strtoupper($row['faculty_name']); ?></a>-->
                                <!--            </p>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                            <?php
                            // }
                            ?>
                <!--            <div class="content-bottom">-->
                <!--                <ul class="list-unstyled">-->
                <!--                    <li class="first-item"><a href="<?php //echo $base_url_website_admission; ?>courses_offered.php">Know-->
                <!--                            More<i class="fa fa-long-arrow-right blog-btn-icon"></i></a></li>-->
                <!--                </ul>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <div id="first-card" class="col-sm-4 latest-news-single">
                    <div class="blog-single-box">
                        <h3 id="head-design">PROGRAMS OFFERED</h3>
                        <div class="blog-content">
                            <?php
                            $programs = [
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
                                            <i class="fa <?php echo $program['icon']; ?>" style="color: black; font-size: 29px;"></i>
                                        </div>
                                        <div class="col-sm-9 event-content">
                                            <p id="pad-remove">
                                                <a href="<?php echo $base_url_website_admission; ?>courses_offered.php"><?php echo $program['name']; ?></a>
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
                            <!-- <div class="row">
                                <div class="col-sm-12" id="li-decoration">
                                    <li><a href="https://gmiu.edu.in/">
                                            IEP
                                        </a>
                                    </li>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-sm-12" id="li-decoration">
                                    <li><a href="<?php echo $base_url_website; ?>home/sdp.php">
                                            SDP
                                        </a>
                                    </li>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-sm-12" id="li-decoration">
                                    <li><a href="https://gmiu.edu.in/">
                                            Mastermind
                                        </a>
                                    </li>
                                </div>
                            </div> -->
                            <!-- <div class="row">
                                <div class="col-sm-12" id="li-decoration">
                                    <li><a href="https://gmiu.edu.in/">
                                            Sports
                                        </a>
                                    </li>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12" id="li-decoration">
                                    <li><a href="https://gmiu.edu.in/">
                                            Parent Contact
                                        </a>
                                    </li>
                                </div>
                            </div> -->
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

                                        $cmd1 = $con->prepare("SELECT daily_post.file_type as dp_file_type,daily_post.id as dp_id, daily_post.date as dp_date, daily_post.file as dp_file FROM tbl_daily_post as daily_post WHERE daily_post.is_active=1 AND daily_post.is_delete=0 AND date = '$date' LIMIT 4");
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
                                                        echo '<img src="' . $upload_website_admin_url . 'daily_post/' . $file_name . '"
                                                     alt="daily post" class="home-daily-post-content" onclick="onClick(this)">';
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
                        <h2><span style="color: #ba2a21;">FACULTY</span></h2>
                    </div><!-- ends: .section-header -->
                </div>
            </div>
            <marquee class="faculty-marquee" onMouseOver="this.stop()" onMouseOut="this.start()" direction="left"
                scrollamount="15">
                <?php
                $cmd = "SELECT `name` as faculty_name, `id` as faculty_id, `faculty_slug` FROM `tbl_faculty` WHERE is_active=1 AND is_delete=0";
                $stmt = $con->prepare($cmd);
                $stmt->execute();
                $result = $stmt->get_result();
    
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="faculty-slide">
                        <a href="<?php echo $base_url_website_faculty . $row['faculty_slug']; ?>">
                            <?php echo strtoupper($row['faculty_name']); ?>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </marquee>
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
                                <a href="https://gmiu.edu.in/gmiu/website/placement/placement_overview_and_statistics.php">read more<i class="fa fa-long-arrow-right"></i></a>
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
                                <a href="https://gmiu.edu.in/gmiu/website/startup/about_startup.php">read more<i class="fa fa-long-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3  wel-ful-box-2">
                    <div class="wel-text-box">
                        <div class="wel-icon">
                            <!-- <img src="<?php echo $website_assets_url; ?>images/index-02/welcome-03.png" alt=""> -->
                            <i class="fa fa-graduation-cap" style="font-size: 4rem; color:white;"></i>
                        </div>
                        <div class="wel-text">
                            <h3>EXCELLENT ACADEMIC SYSTEM</h3>
                            <p>providing excellent teaching learning process by highly qualified faculties. GMIU is
                                known for the outstanding calibre of its students, well qualified faculty dedicated to
                                teaching and research and excellent infrastructure.</p>
                            <div class="center-button-text">
                                <a href="https://gmiu.edu.in/campus/academic-system">read more<i class="fa fa-long-arrow-right"></i></a>
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
                                <a href="https://gmiu.edu.in/placement/innovation-and-research">read more<i class="fa fa-long-arrow-right"></i></a>
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
                        <h2>PLACEMENT HIGHLIGHTS</h2>
                    </div><!-- ends: .section-header -->
                </div>
                <div class="row" style="margin: 0px 0px;">
                    <div class="col-sm-4">
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
                                    <div id="content-know">
                                        <button class="btn btn-center">
                                            <a href="<?php echo $base_url_website_placement; ?>placement_overview_and_statistics.php">More
                                                Details</a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="swiper-container2 swiper2">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="card-std">
                                        <img src="<?php echo $website_assets_url; ?>images/placement-student/megha.jpg" alt="Avatar">
                                        <div class="container-std">
                                            <h4>MEGHA PARMAR</h4>
                                            <p>
                                                <img class="comp-std" src="<?php echo $website_assets_url; ?>images/placement-student/tcs (1).jpg" alt="Avatar">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card-std">
                                        <img src="<?php echo $website_assets_url; ?>images/placement-student/ishan.jpg" alt="Avatar">
                                        <div class="container-std">
                                            <h4>ISHAN PANDYA</h4>
                                            <p>
                                                <img class="comp-std" src="<?php echo $website_assets_url; ?>images/placement-student/tcs (1).jpg" alt="Avatar">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card-std">
                                        <img src="<?php echo $website_assets_url; ?>images/placement-student/hetu.jpg" alt="Avatar">
                                        <div class="container-std">
                                            <h4>HETU BHAVSAR</h4>
                                            <p>
                                                <img class="comp-std" src="<?php echo $website_assets_url; ?>images/placement-student/cg.jpg" alt="Avatar">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card-std">
                                        <img src="<?php echo $website_assets_url; ?>images/placement-student/deep.jpg" alt="Avatar">
                                        <div class="container-std">
                                            <h4>DEEP ANDHARIYA</h4>
                                            <p>
                                                <img class="comp-std" src="<?php echo $website_assets_url; ?>images/placement-student/tcs (1).jpg" alt="Avatar">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card-std">
                                        <img src="<?php echo $website_assets_url; ?>images/placement-student/milan.jpg" alt="Avatar">
                                        <div class="container-std">
                                            <h4>MILAN MIYANI</h4>
                                            <p>
                                                <img class="comp-std" src="<?php echo $website_assets_url; ?>images/placement-student/tcs (1).jpg" alt="Avatar">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card-std">
                                        <img src="<?php echo $website_assets_url; ?>images/placement-student/hasti.jpg" alt="Avatar">
                                        <div class="container-std">
                                            <h4>HASTI BHADIYADRA</h4>
                                            <p>
                                                <img class="comp-std" src="<?php echo $website_assets_url; ?>images/placement-student/lixil.jpg" alt="Avatar">
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="card-std">
                                        <img src="<?php echo $website_assets_url; ?>images/placement-student/krina.jpg" alt="Avatar">
                                        <div class="container-std">
                                            <h4>KRINA OZA</h4>
                                            <p>
                                                <img class="comp-std" src="<?php echo $website_assets_url; ?>images/placement-student/odoo.jpg" alt="Avatar">
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination2"></div>
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
            <a href="<?php echo $base_url_website_campus; ?>360_virtual_tour.php"">
                TAKE A TOUR GMIU CAMPUS
            </a>
        </div>

    </div>
      <div class="row" id="media_coverage">
        <div class="col-sm-12 section-header-box">
            <div class="section-header">
                <h2>SHORTS COVERAGE</h2>
            </div>
            <!-- ends: .section-header -->
        </div>
    </div>
    
       <div class="swiper3 mySwiper" style="margin: 0 10%; overflow:hidden;">
            <div class="swiper-wrapper">
                <?php
                $cmd = "SELECT `file_type`, `file` FROM `tbl_media_coverage` WHERE file_type = 'reel' AND is_active = 1 AND is_delete = 0 ORDER BY id DESC 
                LIMIT 5 ";
    
                $stmt = $con->prepare($cmd);
                $stmt->execute();
                $result = $stmt->get_result();
    
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="swiper-slide">' ?>
                    <iframe width="280px" height="250px" style="border-radius: 10px;" src="<?php echo $row['file']; ?>"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope"
                        allowfullscreen 
                        
                        style="border-radius: 10px;" style="border:1px solid black;"></iframe>
                    <?php echo '</div>';
                }
                ?>
    
            </div>
            <div class="swiper-pagination3"></div>
    
        </div>
        <div style="text-align: center; margin-top: 10px;">
            <a href="media/reel.php" class="view-more-button"
                style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; border-radius: 5px; text-decoration: none; transition: background-color 0.3s;">
                View More
            </a>
        </div>

    <br><br>

    <div class="row" id="media_coverage">
        <div class="col-sm-12 section-header-box">
            <div class="section-header">
                <h2>MEDIA COVERAGE</h2>
            </div><!-- ends: .section-header -->
        </div>
    </div>
    <div class="swiper3 mySwiper" style="margin: 0 10%; overflow:hidden;">
        <div class="swiper-wrapper">
            <?php
            $cmd = "SELECT `file_type`, `file` FROM `tbl_media_coverage` WHERE file_type = 'video' AND is_active = 1 AND is_delete = 0 ORDER BY id DESC LIMIT 5 ";
            $stmt = $con->prepare($cmd);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                if ($row['file_type'] == "video") {
                    echo '<div class="swiper-slide">'

            ?>
                    <iframe width="280px" height="250px" src="<?php echo $row['file']; ?>" title="YouTube video player" frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope" allowfullscreen 
                    style="border-radius: 10px;" style="border:1px solid black;"></iframe>
            <?php
                    echo '</div>';
                }
            }
            ?>
        </div>
        <div class="swiper-pagination3"></div>
    </div>
     <div style="text-align: center; margin-top: 10px;">
        <a href="media/video.php" class="view-more-button"
            style="display: inline-block; padding: 10px 20px; background-color: #007BFF; color: white; border-radius: 5px; text-decoration: none; transition: background-color 0.3s;">
            View More
        </a>
    </div>

    </div>
    <!-- news slider  -->
    <!-- news slider  -->
    <div class="news-slider">
        <marquee onMouseOver="this.stop()" onMouseOut="this.start()" direction="left" scrollamount="20" loop="infinite">
            <?php
            $cmd = "SELECT `file_type`, `file`, `alt_text` FROM `tbl_media_coverage` WHERE is_active = 1 AND is_delete = 0 ORDER BY id DESC";
            $stmt = $con->prepare($cmd);
            $stmt->execute();
            $result = $stmt->get_result();

            $images = []; // Array to store the images

            while ($row = $result->fetch_assoc()) {
                if ($row['file_type'] == "image") {
                    // $images[] = $row['file']; // Add image to the array
                     $images[] = [
                        'file' => $row['file'], 
                        'alt_text' => $row['alt_text']
                    ]; // Add image and alt text to the array
                }
            }

            if (!empty($images)) {
                $numImages = count($images); // Total number of images
                $repeatTimes = ceil(100 / $numImages); // Number of times to repeat the images to fill 100% width

                // Repeat the images
                for ($i = 0; $i < $repeatTimes; $i++) {
                    foreach ($images as $imageData) {
            ?>
                       <img 
                    src="<?php echo $upload_website_admin_url; ?>media_coverage/<?php echo $imageData['file']; ?>" 
                    alt="<?php echo htmlspecialchars($imageData['alt_text'], ENT_QUOTES, 'UTF-8'); ?>" 
                    onclick="onClick(this)" 
                    class="modal-ns-hover-opacity">
            <?php
                    }
                }
            }
            ?>
        </marquee>

    </div>
    <!-- End news slider -->
    <!-- Test  -->
    <div id="modal01" class="modal-ns" onclick="this.style.display='none'">
        <span class="close">&times;</span>
        <div class="modal-ns-content">
            <img id="img01">
        </div>
    </div>

    <!-- End news slider  -->

    <section class="mt-s">
        <div class="row">
            <div class="col-sm-12 section-header-box">
                <div class="section-header">
                    <h2>TESTIMONIAL</h2>
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
                        <img src="<?php echo $upload_website_admin_url . "testimonial/";
                                    echo $file_name; ?>" alt="">
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
                $cmd = "SELECT `testimonial_type`, `file`, `file_type`, `name`, `description` ,`is_active`, `is_delete`, `created_by` FROM `tbl_testimonial` WHERE is_active = 1 AND is_delete = 0 ORDER BY `id` DESC";
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
                        <img src="<?php echo $upload_website_admin_url . "testimonial/";
                                    echo $file_name; ?>" alt="">
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
        <marquee class="ass-marquee" onMouseOver="this.stop()" onMouseOut="this.start()" direction="left" scrollamount="15">
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

            if (!empty($imagePaths)) {
                $numImages = count($imagePaths); // Total number of images
                $repeatTimes = ceil(100 / $numImages); // Number of times to repeat the images to fill 100% width

                // Repeat the images
                for ($i = 0; $i < $repeatTimes; $i++) {
                    foreach ($imagePaths as $imagePath) {
            ?>
                        <div class="ass-slide"><img src="<?php echo $imagePath; ?>"></div>
            <?php
                    }
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
    </script>
</body>

</html>